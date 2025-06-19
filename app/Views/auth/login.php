<?php include '../layouts/header.php'; ?>
<form method="POST" action="/login">
    <input type="text" name="email" placeholder="Correo">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar sesión</button>
</form>
<?php include '../layouts/footer.php'; ?>

