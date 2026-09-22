function uploadProfilePicture() {
    var input = document.getElementById('profilePicture');
    var previewContainer = document.getElementById('previewContainer');
    var previewImage = document.getElementById('previewImage');

    var file = input.files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        // Geen bestand geselecteerd
        previewContainer.style.display = 'none';
    }
}

function submitForm() {
    var name = document.getElementById('name').value;
    var username = document.getElementById('username').value;
    var birthdate = document.getElementById('birthdate').value;
    var password = document.getElementById('password').value;
    var profilePicture = document.getElementById('profilePicture').value;

    // Voer hier verdere logica uit met de ingevoerde gegevens

    console.log('Naam:', name);
    console.log('Gebruikersnaam:', username);
    console.log('Geboortedatum:', birthdate);
    console.log('Wachtwoord:', password);
    console.log('Profielfoto:', profilePicture);
}

