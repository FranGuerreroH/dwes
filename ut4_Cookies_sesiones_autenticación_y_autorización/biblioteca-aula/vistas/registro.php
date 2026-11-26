<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Crear cuenta</h2>

    <?php if ($error !== null): ?>
     <p> <?= $error ?> </p>
    <?php endif; ?>

    <form method="post" action="registro.php">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre">

        <label for="email">Correo</label>
        <input id="email" name="email">

        <label for="clave">Contraseña</label>
        <input id="clave" name="clave" type="password">

        <button>Crear cuenta</button>
    </form>
    
</body>
</html>