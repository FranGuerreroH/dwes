<h2>Iniciar Sesión</h2>
<?php if ($error !== null):?>
    <p><? \App\Soporte\e($error) ?> </p>
<?php endif; ?>

<form method="post">

    <label for="email">Correo</label>
    <input id="email" name="email"  type="email" required>

    <br>

    <label for="clave"> Contraseña</label>
    <input  id="clave" name="clave" type="password" required>

    <button> Iniciar sesión </button>

</form>