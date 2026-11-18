<?php use function App\Soporte\e; ?>
<h2>Catálogo</h2>

<form method="post" action="">
    <label for="espaciado">Espaciado</label>
    <select id="espaciado" name="espaciado">
        <option value="compacto" <?= $espaciado === 'compacto' ? 'selected' : '' ?>>Compacto</option>
        <option value="ampliado" <?= $espaciado === 'ampliado' ? 'selected' : '' ?>>Ampliado</option>
    </select>
    <button type="submit">Guardar Espaciado</button>
</form>

<form method="post" action="preferencias.php">
    <label for="tema">Tema</label>
    <select id="tema" name="tema">
        <option value="claro" <?= $tema === 'claro' ? 'selected' : '' ?>>Claro</option>
        <option value="oscuro" <?= $tema === 'oscuro' ? 'selected' : '' ?>>Oscuro</option>
    </select>
    <button type="submit">Guardar Tema</button>
</form>
<br>

<form method="get" action="index.php">
    <label for="q">Buscar por título</label>
    <input id="q" name="q" value="<?= e($q) ?>">
    <button>Buscar</button>
    <a href="index.php">Ver todos</a>
</form>
<?php if ($libros === []): ?>
    <p>Sin resultados.</p>
<?php else: ?>
    <ul class="libros">
        <?php foreach ($libros as $libro): ?>
            <li><?= e($libro->titulo) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
