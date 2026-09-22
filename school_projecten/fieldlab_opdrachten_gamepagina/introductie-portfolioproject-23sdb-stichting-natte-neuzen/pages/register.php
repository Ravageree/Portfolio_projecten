<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registratie - ClanBase 2.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php include '../php/navbar.php'; ?>

    <div class="container mt-5 registratie" style="max-width: 600px;">
        <h2 class="text-center mb-4">Registratie</h2>

        <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="../php/register_user.php" class="w-100">
            <div class="mb-3 w-100">
                <label>Gebruikersnaam <span class="required">*</span></label>
                <input type="text" class="form-control" name="username" maxlength="16" required>
            </div>

            <div class="mb-3 w-100">
                <label>E-mail <span class="required">*</span></label>
                <input type="email" class="form-control" name="email" maxlength="30" required>
            </div>

            <div class="mb-3 w-100">
                <label>Wachtwoord <span class="required">*</span></label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3 w-100">
                <label>Naam</label>
                <input type="text" class="form-control" name="name" maxlength="10">
            </div>

            <div class="mb-3 w-100">
                <label for="birth_date">Geboortedatum <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="birth_date" id="birth_date" required>
            </div>

            <!-- Spelvoorkeuren -->
            <div class="mb-3 w-100">
                <label>Spelvoorkeuren</label>
                <div class="checkbox-grid">
                    <label><input type="checkbox" name="game_preferences[]" value="CS:GO"> CS:GO</label>
                    <label><input type="checkbox" name="game_preferences[]" value="Call of Duty"> Call of Duty</label>
                    <label><input type="checkbox" name="game_preferences[]" value="Battlefield"> Battlefield</label>
                    <label><input type="checkbox" name="game_preferences[]" value="Overwatch"> Overwatch</label>

                    <label class="rainbow-six-label">
                        <input type="checkbox" name="game_preferences[]" value="Rainbow Six Siege" id="rainbowSixCheckbox">
                        Rainbow Six Siege
                    </label>

                    <div id="r6-gif-container">
                        <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExZXo0MGYzdjUyMTB2eG9lMHRyMTI5Nm50enh3OW5sZTU5NTg2djRsMyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/TlrhFMDDLb3iHC18Vj/giphy.gif"
                            alt="Rainbow Six Yippee">
                    </div>

                    <label><input type="checkbox" name="game_preferences[]" value="World of Warcraft"> World of Warcraft</label>
                    <label><input type="checkbox" name="game_preferences[]" value="League of Legends"> League of Legends</label>
                    <label><input type="checkbox" name="game_preferences[]" value="Dota 2"> Dota 2</label>

                    <label class="fortnite-label">
                        <input type="checkbox" name="game_preferences[]" value="Fortnite"> Fortnite
                    </label>

                    <label><input type="checkbox" name="game_preferences[]" value="Apex Legends"> Apex Legends</label>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="button">Registreren</button>
            </div>
        </form>
    </div>

    <?php include '../php/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rainbowSixLabel = document.querySelector('.rainbow-six-label');
            const rainbowSixCheckbox = document.getElementById('rainbowSixCheckbox');
            const fortniteLabel = document.querySelector('.fortnite-label');
            const fortniteCheckbox = fortniteLabel.querySelector('input');
            const r6GifContainer = document.getElementById('r6-gif-container');

            if (!rainbowSixCheckbox || !r6GifContainer) return;

            // Rainbow Six checkbox
            rainbowSixCheckbox.addEventListener('change', () => {
                rainbowSixLabel.classList.toggle('selected-rainbow-six', rainbowSixCheckbox.checked);
                if (rainbowSixCheckbox.checked) {
                    r6GifContainer.style.display = 'flex';
                    r6GifContainer.style.animation = 'fadeOut 1s forwards';
                    setTimeout(() => {
                        r6GifContainer.style.display = 'none';
                    }, 1000);
                } else {
                    r6GifContainer.style.display = 'none';
                }
            });

            // Fortnite checkbox
            fortniteCheckbox.addEventListener('change', () => {
                fortniteLabel.classList.toggle('selected-fortnite', fortniteCheckbox.checked);
            });
        });
    </script>

</body>

</html>