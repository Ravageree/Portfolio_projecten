<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: landing_page.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - ClanBase 2.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../php/navbar.php'; ?>

    <div class="container mt-5">
        <h1>Welkom!</h1>
        <?php include '../php/body.php'; ?>
    </div>

    <?php include '../php/footer.php'; ?>
</body>
<?php
    // Notificaties tonen na acties
    if (isset($_GET['accepted'])) {
        echo "<script>showFriendNotification('Vriendschap geaccepteerd 🎉','Je bent nu vrienden!','success');</script>";
    } elseif (isset($_GET['removed'])) {
        echo "<script>showFriendNotification('Verzoek geweigerd ❌','Het verzoek is verwijderd.','error');</script>";
    }
    ?>

</html>