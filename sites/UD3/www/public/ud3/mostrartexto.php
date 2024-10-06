<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3.1</title>
</head>
<body>
<?php
$s="lara";
echo '<p>Comillas simples: '.$s.'_user</p>';
echo "<p>Comillas dobles: ${s}_user</p>";
printf("<p>Printf: %s_user</p>", $s);
?>
</body>
</html>

<!--alternativa sin hacer el html
<?php
#$s="lara";
#echo 'Comillas simples: '.$s.'_user';
#echo "Comillas dobles: {$s}_user";
#printf("Printf: %s_user", $s);
?>
-->
