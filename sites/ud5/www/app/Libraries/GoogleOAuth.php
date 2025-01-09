<?php

declare(strict_types=1);

namespace Com\Daw2\Libraries;

use Com\Daw2\Core\BaseController;
use Google\Service\OAuth2\Userinfo;
use Google_Client;
use Google_Service_Oauth2;

class GoogleOAuth
{
    private static ?self $instance = null;
    private Google_Client $client;
    private Google_Service_Oauth2 $google_oauth;
    private ?UserInfo $userInfo;

    private function __construct(string $redirectUri)
    {
        //Datos de nuestro client
        $google_oauth_client_id = $_ENV['google.oauth_client_id'];
        $google_oauth_client_secret = $_ENV['google.oauth_client_secret'];
        $google_oauth_redirect_uri = $redirectUri;
        $google_oauth_version = 'v3';
        // Create the Google Client object
        $this->client = new Google_Client();
        $this->client->setClientId($google_oauth_client_id);
        $this->client->setClientSecret($google_oauth_client_secret);
        $this->client->setRedirectUri($google_oauth_redirect_uri);
        $this->client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $this->client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $this->userInfo = null;
    }

    private function setRedirectUri(string $uri)
    {
        if (filter_var($uri, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException("Invalid url provided");
        }
        $this->client->setRedirectUri($uri);
    }

    public static function getInstance(string $redirectUri): GoogleOAuth
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($redirectUri);
        } else {
            self::$instance->setRedirectUri($redirectUri);
        }
        return self::$instance;
    }

    /**
     * Se encarga de recoger la información del usuario de los servicios de Google
     * @return Userinfo Información del usuario
     * @throws \Google\Service\Exception
     * @throws \OAuthException Si encontramos un problema en el intento de validación del usuario
     */
    public function getUserInfo(): UserInfo
    {
        if ($this->userInfo === null) {
            // If the captured code param exists and is valid
            if (!empty($_GET['code'])) {
                // Exchange the one-time authorization code for an access token
                $accessToken = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
                $this->client->setAccessToken($accessToken);
                // Make sure access token is valid
                if (!empty($accessToken['access_token'])) {
                    // Now that we have an access token, we can fetch the user's profile data
                    $this->google_oauth = new \Google_Service_Oauth2($this->client);
                    $this->userInfo = $this->google_oauth->userinfo->get();
                    // Make sure the profile data exists
                    if (isset($this->userInfo->email)) {
                        return $this->userInfo;
                    } else {
                        throw new \OAuthException(
                            'No se ha podido obtener la información solicitada! Por favor, inténtalo de nuevo!'
                        );
                    }
                } else {
                    throw new \OAuthException('Invalid access token! Please try again later!');
                }
            } else {
                // Redirect to Google Authentication page
                $authUrl = $this->client->createAuthUrl();
                header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
                exit;
            }
        } else {
            return $this->userInfo;
        }
    }
}
