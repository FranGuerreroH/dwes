<?php

declare(strict_types=1);

$escapar = static fn (string $texto): string => htmlspecialchars(
    $texto,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de la biblioteca</title>
</head>

<body>
    <h1>Catálogo de la biblioteca</h1>

    <form action="index.php" method="get">
        <p>
            <label for="q">Título o autor</label>
            <input type="text" id="q" name="q" value="">
        </p>
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                <option value="ciencia">Ciencia</option>
                <option value="fantasia">Fantasía</option>
                <option value="terror">Terror</option>
            </select>
        </p>
        <p>
            <label for="tipo">Tipo de libro</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="papel">Papel</option>
                <option value="digital">Digital</option>
            </select>
        </p>
        <p>
            <input type="checkbox" id="destacados" name="destacados" value="1">
            <label for="destacados">Solo destacados</label>
        </p>
        <button type="submit">Buscar</button><br>
        <a href="alta.php">Ir a alta</a>
    </form>

    <h2>Libros</h2>
    <?php if ($filas === []): ?>
        <p>No hay libros que coincidan</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Género</th>
                    <th>Tipo</th>
                    <th>Páginas</th>
                    <th>Unidades</th>
                    <th>Coste de reposición</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filas as $fila): ?>
                    <tr>
                        <td><?= $escapar($fila['titulo']) ?></td>
                        <td><?= $escapar($fila['autor']) ?></td>
                        <td><?= $escapar($fila['genero']) ?></td>
                        <td><?= $escapar(ucfirst($fila['tipo'])) ?></td>
                        <td><?= $fila['paginas'] ?></td>
                        <td><?= $fila['unidades'] ?></td>
                        <td><?= number_format($fila['costeCentimos'] / 100, 2, ',', '.') ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Resumen</h2>
    <dl>
        <dt>Número de títulos</dt>
        <dd><?= $resumen['titulos'] ?></dd>
        <dt>Unidades</dt>
        <dd><?= $resumen['unidades'] ?></dd>
        <dt>Páginas</dt>
        <dd><?= $resumen['paginas'] ?></dd>
        <dt>Coste total</dt>
        <dd><?= number_format($resumen['costeCentimos'] / 100, 2, ',', '.') ?> €</dd>
    </dl>

</body>

</html>
