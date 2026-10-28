<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

    <form action="/libros.php" method="GET">
        <label for="buscar">Buscar libro:</label>
        <input type="text" name="q" id="buscar" value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">Buscar</button>
    </form>

    <p><?$q ?></p>

<body>
    
</body>
</html>