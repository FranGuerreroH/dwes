<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo del inventario</title></head>
<body>
<h1>Catálogo del inventario</h1>
<p><a href="alta.php">Dar de alta un material</a></p>
<!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<!-- COMPLETAR 1. Formulario GET con controles HTML estáticos. -->
<form method="get" action="index.php">

    <label for="q"><b>Introduzca un nombre o fabricante:</b></label>
    <input type="text" name="nombre" id="q">
    <br>
    <select name="categoria" id="categoria">
        <option value="" disabled selected>-- Selecciona una categoría --</option>
        <option value="colectivo">Colectivo</option>
        <option value="raqueta">Raqueta</option>
        <option value="fitness">Fitness</option>

    </select>
    
    <button type="submit">Buscar</button>

<?php if ($errores === []): ?>
    <!-- COMPLETAR 3. Tabla de materiales o mensaje si no hay coincidencias. -->
        <?php 
        if ($materiales !== [])
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fabricante</th>
                        <th>Unidades</th>
                        <th>Categoría</th>
                        <th>Fecha de alta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($materiales as $material): ?>
                        <tr>
                            <td><?= e($material->nombre()) ?></td>
                            <td><?= e($material->fabricante()) ?></td>
                            <td><?= e($material->unidades()) ?></td>
                            <td><?= e($material->categoria()) ?></td>
                            <td><?= $material->fechaAlta() ? $material->fechaAlta()->format("Y-m-d") : "Sin fecha" ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay materiales que coincidan.</p>
        <?php endif; ?> 

<p><a href="index.php">Limpiar filtros</a></p>
</body>
</html>
