<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Alta de un material</title></head>
<body>
<h1>Alta de un material</h1>
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

    <form method="post" action="alta.php" enctype="multipart/form-data">
        <label for="nombre" maxlength="120"><b>Nombre:</b></label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="fabricante" maxlength="100"><b>Fabricante:</b></label>
        <input type="text" name="fabricante" id="fabricante" required>
        <br>
        <label for="unidades" min="1" max="3000"><b>Unidades:</b></label>
        <input type="number" name="unidades" id="unidades">
        <br>
        <label for="categoria"><b>Categoría:</b></label>
        <select name="categoria" id="categoria">
            <option value="" disabled selected>-- Selecciona una categoría --</option>
            <option value="colectivo">Colectivo</option>
            <option value="raqueta">Raqueta</option>
            <option value="fitness">Fitness</option>
        </select>
        <br>
        <label for="fechaAlta"><b>Fecha de alta (opcional)</b></label>
        <input type="text" placeholder="YYYY-MM-DD"> 
        <br>
        <label for="imagen"><b>Imagen (jpeg, png o webp):</b></label>
        <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png,.gif">
        <br><br>
        <button type="submit">Guardar material</button>

    
<?php else: ?>
    <!-- Confirmación proporcionada. Solo aparece cuando asignas $creado. -->
    <h2>Material registrado</h2>
    <dl>
        <dt>Nombre</dt><dd><?= e($creado->nombre()) ?></dd>
        <dt>Fabricante</dt><dd><?= e($creado->fabricante()) ?></dd>
        <dt>Unidades</dt><dd><?= $creado->unidades() ?></dd>
        <dt>Categoría</dt><dd><?= e($creado->categoria()) ?></dd>
        <dt>Fecha de alta</dt><dd><?= e($creado->fechaAlta()?->format('Y-m-d') ?? 'Sin fecha') ?></dd>
    </dl>
    <p>La colección de este envío contiene <?= count($inventario->todos()) ?> materiales.</p>
    <?php if ($creado->imagen() !== null): ?>
        <img src="imagen.php?nombre=<?= e($creado->imagen()) ?>"
             alt="Imagen del material creado" width="180">
    <?php else: ?>
        <p>Sin imagen</p>
    <?php endif; ?>
    <p><a href="alta.php">Nueva alta</a></p>
<?php endif; ?>
<p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
