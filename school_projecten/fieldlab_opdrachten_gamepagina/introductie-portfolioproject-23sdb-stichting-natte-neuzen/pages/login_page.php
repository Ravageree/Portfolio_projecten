<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Login - ClanBase 2.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>

<body>
    <?php include '../php/navbar.php'; ?>

    <div class="container mt-5" style="max-width: 400px;">
        <h2>Login</h2>

        <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="../php/login.php" class="login">
            <div class="mb-3">
                <label for="username" class="form-label">Gebruikersnaam <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Wachtwoord <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
                <i class="bi bi-eye" id="togglepassword"></i>
            </div>

            <button type="submit" class="button">Login</button>
        </form>

        <p class="mt-3">Nog geen account? <a href="register.php">Registreren</a></p>
    </div>


    <?php include '../php/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
<script>
    const togglepassword = document.querySelector('#togglepassword');
    const password = document.querySelector('#password');
    togglepassword.addEventListener('click', (e) => {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        e.target.classList.toggle('bi-eye');
        e.target.classList.toggle('bi-eye-slash');
    });
</script>

</html>