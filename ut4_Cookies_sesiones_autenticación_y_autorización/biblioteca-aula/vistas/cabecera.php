<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca de aula</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body class="<?= $tema ?> <?= $espaciado ?>">
<header>
    <h1>Biblioteca de aula</h1>
    <nav>
        <a href="index.php">Catálogo</a>
        <?php if ($usuarioActual === null): ?>
            <a href="registro.php">Crear cuenta</a>
            <a href="login.php">Iniciar sesión</a>
        <?php else: ?>
            <a href="cuenta.php">Mi cuenta</a>
            <a href="crearLibro.php"> Crear Libro </a>
            <form method="post"  action="logout.php">
                <button>Cerrar sesión</button>
            </form>
        <?php endif; ?>
    </nav>
</header>
<?php if ($aviso !== null): ?>
    <p class="aviso"><?= \App\Soporte\e($aviso) ?></p>
<?php endif; ?>    
<main>