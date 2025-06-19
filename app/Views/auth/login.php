<?php include '../layouts/header.php'; ?>
<div class="bg-amber-400 min-h-screen flex items-center justify-center">
<form method="POST" action="/login">
    <input type="text" name="email" placeholder="Correo">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar sesión</button>
</form>
</div>
<?php include '../layouts/footer.php'; ?>

