<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Formulario Post</h1>
    <form action="alta.php" method="post">
        <p>
            <label for="tipo"> Tipo de libro </label>
            <select name="tipo" id="tipo">
                <option value="papel">Papel</option>
                <option value="digital">Digital</option>
            </select>
        </p>

        <p>
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" maxlength="120">
        </p>

        <p>
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" maxlength="100">
        </p>

        <p>
            <label for="paginas">Páginas</label>
            <input type="paginas" id="paginas" name="paginas" min="1" max="3000">
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
            <label for="unidades">Unidades</label>
            <input type="unidades" id="unidades" name="unidades" min="1" max="50">
        </p>

        <p>
            <label for="fechaAlta">Fecha de Alta</label>
            <input type="fechaAlta" id="fechaAlta" name="fechaAlta">
        </p>

        <p>
            <input type="checkbox" id="destacados" name="destacados" value="1" >
            <label for="destacados">Destacados</label>
        </p>

        <p>
            <label for="observaciones">Observaciones </label>
            <textarea id="observaciones" name="observaciones" maxlength="300" placeholder="Escribe aquí..."></textarea>
        </p>

        <p>
            <input type="email" id="correo" name="correo"  required>
            <label for="correo">Correo</label>
        </p>
        <button type="submit">Dar de alta</button><br>
        <a href="index.php">Volver al catálogo</a>

    </form>
    
</body>
</html>