<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Alta de un libro</title></head>
<body>
<h1>Alta de un libro</h1>
<?php if ($creado === null): ?>
    <!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
    <!-- COMPLETAR 4. Formulario POST multipart con controles HTML estáticos. -->

     <form  action="alta.php" enctype="multipart/form-data" method="post">

            <label for="titulo">Título</label>
            <input name="titulo" id="titulo" type="text" maxlength="120" required>
            <br>

            <label for="autor">Autor</label>
            <input name="autor" id="autor" type="text" maxlength="100" required>
            <br>

            <label for="paginas">Páginas</label>
            <input name="paginas" id="paginas" type="text" min=1 max="3000">
            <br>

            <label for="genero">Género</label>
            <select name="genero" id="genro" type="text" min=1 max="3000">
                <option value="">Todos</option>
                <option value="ciencia">Ciencia</option>
                <option value="fantasia">Fantasía</option>
                <option value="terror">Terror</option>
            </select>
            <br>

            <label for="fechaAlta">Fecha de alta</label>
            <input name="fechaAlta" id="fechaAlta" type="date">
            <br>

            <label for="portada">Portada</label>
            <input name="portada" id="portada" type="file">
            <br>

            <button type="submit">Guardar libro</button>

     </form>            
    
<?php else: ?>
    <!-- Confirmación proporcionada. Solo aparece cuando asignas $creado. -->
    <h2>Libro creado</h2>
    <dl>
        <dt>Título</dt><dd><?= e($creado->titulo()) ?></dd>
        <dt>Autor</dt><dd><?= e($creado->autor()) ?></dd>
        <dt>Páginas</dt><dd><?= $creado->paginas() ?></dd>
        <dt>Género</dt><dd><?= e($creado->genero()) ?></dd>
        <dt>Fecha de alta</dt><dd><?= e($creado->fechaAlta()?->format('Y-m-d') ?? 'Sin fecha') ?></dd>
    </dl>
    <p>La colección de este envío contiene <?= count($biblioteca->todos()) ?> libros.</p>
    <?php if ($creado->portada() !== null): ?>
        <img src="portada.php?nombre=<?= e($creado->portada()) ?>"
             alt="Portada del libro creado" width="180">
    <?php else: ?>
        <p>Sin portada</p>
    <?php endif; ?>
    <p><a href="alta.php">Nueva alta</a></p>
<?php endif; ?>
<p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
