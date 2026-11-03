<?php

$titulo = $_SERVER[strtolower(trim(' <Dune> & "edición" '))];

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <p><? e($titulo)           ?></p>
    <input name="titulo" value="<?' . e($titulo) . '?>">
    
</body>
</html>
