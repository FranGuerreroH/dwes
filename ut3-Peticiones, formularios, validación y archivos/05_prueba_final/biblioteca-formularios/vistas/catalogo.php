<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo de la biblioteca</title></head>
<body>
<h1>Catálogo de la biblioteca</h1>
<p><a href="alta.php">Dar de alta un libro</a></p>
<!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<!-- COMPLETAR 1. Formulario GET con controles HTML estáticos. -->

<form action="index.php" method="get"></form>
<label for="q">Título</label>
<input type="text" id="q" name="q">
<br>

<label for="">Autor</label>
<select type="text" id="genero" name="genero">
    <option value="">Todos</option>
    <option value="ciencia">Ciencia</option>
    <option value="fantasia">Fantasía</option>
    <option value="terror">Terror</option>
</select>

<br>

<button type="submit">Buscar</button>

<?php if ($errores === []): ?>
    <!-- COMPLETAR 3. Tabla de libros o mensaje si no hay coincidencias. -->
    <?php if ($libros !== []) ?>
    <table border="1">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Páginas</th>
                <th>Género</th>
                <th>Fecha de alta</th>
            </tr>
        </thead>

        <?php foreach($libros as $libro) ?>
        <tbody>
            <tr>
                <td><?php e($libro->titulo()); ?></td>
                <td><?php e($libro->autor()); ?></td>
                <td><?php e($libro->paginas()); ?></td>
                <td><?php e($libro->genero()); ?></td>
                <td><?php e($libro->fechaAlta()->format(("Y-m-d"))); ?></td>
            </tr>
        </tbody>
    </table>

    <?php  else: ?>
        <p> No hay libros que coincidan</p>    
    
<?php endif; ?>
<p><a href="index.php">Limpiar filtros</a></p>
</body>
</html>
