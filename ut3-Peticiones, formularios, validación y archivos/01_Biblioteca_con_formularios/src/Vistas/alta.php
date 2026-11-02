<?php

declare(strict_types=1);

$escapar = static fn(string $texto): string => htmlspecialchars(
    $texto,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
$errorCampo = static fn(string $campo): string => isset($errores[$campo])
    ? '<span role="alert">' . $escapar($errores[$campo]) . '</span>'
    : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $ficha === null ? 'Alta de libro' : 'Libro dado de alta' ?></title>
</head>
<body>
    <?php if ($ficha === null): ?>
        <h1>Alta de libro</h1>
        <?php if (isset($errores['general'])): ?>
            <p role="alert"><?= $escapar($errores['general']) ?></p>
        <?php endif; ?>

        <form action="alta.php" method="post">
            <p>
                <label for="tipo">Tipo de libro</label>
                <select name="tipo" id="tipo">
                    <option value="" <?= $valores['tipo'] === '' ? 'selected' : '' ?>>Selecciona un tipo</option>
                    <option value="papel" <?= $valores['tipo'] === 'papel' ? 'selected' : '' ?>>Papel</option>
                    <option value="digital" <?= $valores['tipo'] === 'digital' ? 'selected' : '' ?>>Digital</option>
                </select>
                <?= $errorCampo('tipo') ?>
            </p>

            <p>
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" maxlength="120" value="<?= $escapar($valores['titulo']) ?>">
                <?= $errorCampo('titulo') ?>
            </p>

            <p>
                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor" maxlength="100" value="<?= $escapar($valores['autor']) ?>">
                <?= $errorCampo('autor') ?>
            </p>

            <p>
                <label for="paginas">Páginas</label>
                <input type="text" id="paginas" name="paginas" value="<?= $escapar($valores['paginas']) ?>">
                <?= $errorCampo('paginas') ?>
            </p>

            <p>
                <label for="genero">Género</label>
                <select id="genero" name="genero">
                    <option value="" <?= $valores['genero'] === '' ? 'selected' : '' ?>>Selecciona un género</option>
                    <option value="ciencia" <?= $valores['genero'] === 'ciencia' ? 'selected' : '' ?>>Ciencia</option>
                    <option value="fantasia" <?= $valores['genero'] === 'fantasia' ? 'selected' : '' ?>>Fantasía</option>
                    <option value="terror" <?= $valores['genero'] === 'terror' ? 'selected' : '' ?>>Terror</option>
                </select>
                <?= $errorCampo('genero') ?>
            </p>

            <p>
                <label for="unidades">Unidades</label>
                <input type="text" id="unidades" name="unidades" value="<?= $escapar($valores['unidades']) ?>">
                <?= $errorCampo('unidades') ?>
            </p>

            <p>
                <label for="fechaAlta">Fecha de alta</label>
                <input type="text" id="fechaAlta" name="fechaAlta" value="<?= $escapar($valores['fechaAlta']) ?>">
                <?= $errorCampo('fechaAlta') ?>
            </p>

            <p>
                <input type="checkbox" id="destacado" name="destacado" value="1" <?= $valores['destacado'] ? 'checked' : '' ?>>
                <label for="destacado">Destacado</label>
                <?= $errorCampo('destacado') ?>
            </p>

            <p>
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones" maxlength="300" placeholder="Escribe aquí..."><?= $escapar($valores['observaciones']) ?></textarea>
                <?= $errorCampo('observaciones') ?>
            </p>

            <p>
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" required value="<?= $escapar($valores['correo']) ?>">
                <?= $errorCampo('correo') ?>
            </p>

            <button type="submit">Dar de alta</button><br>
            <a href="index.php">Volver al catálogo</a>
        </form>
    <?php else: ?>
        <h1>Libro dado de alta correctamente</h1>
        <p>Correo de quien lo registra: <?= $escapar($ficha['correo']) ?></p>

        <h2>Ficha del libro</h2>
        <dl>
            <dt>Título</dt>
            <dd><?= $escapar($ficha['titulo']) ?></dd>
            <dt>Autor</dt>
            <dd><?= $escapar($ficha['autor']) ?></dd>
            <dt>Tipo</dt>
            <dd><?= $escapar(ucfirst($ficha['tipo'])) ?></dd>
            <dt>Género</dt>
            <dd><?= $escapar(ucfirst($ficha['genero'])) ?></dd>
            <dt>Páginas</dt>
            <dd><?= $ficha['paginas'] ?></dd>
            <dt>Unidades</dt>
            <dd><?= $ficha['unidades'] ?></dd>
            <dt>Fecha</dt>
            <dd><?= $escapar($ficha['fechaAlta']) ?></dd>
            <dt>Destacado</dt>
            <dd><?= $ficha['destacado'] ? 'Sí' : 'No' ?></dd>
            <dt>Observaciones</dt>
            <dd><?= $ficha['observaciones'] !== '' ? $escapar($ficha['observaciones']) : 'Sin observaciones' ?></dd>
            <dt>Coste de reposición</dt>
            <dd><?= number_format($ficha['costeCentimos'] / 100, 2, ',', '.') ?> €</dd>
        </dl>

        <h2>Catálogo</h2>
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

        <h2>Totales</h2>
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
        <a href="index.php">Volver al catálogo</a>
    <?php endif; ?>
</body>
</html>
