/**
 * Toon een melding rechtsonderin
 * @param {string} title - De titel van de melding
 * @param {string} message - De tekst van de melding
 * @param {'success'|'error'} type - Type melding
 */
function showFriendNotification(title, message, type = 'success') {
    // Verwijder bestaande notificatie als die er is
    const existing = document.querySelector('.friend-notification');
    if (existing) existing.remove();

    // Maak de container
    const notif = document.createElement('div');
    notif.classList.add('friend-notification', type);
    notif.innerHTML = `
        <h4>${title}</h4>
        <p>${message}</p>
    `;

    // Klik = naar vriendenpagina
    notif.addEventListener('click', () => {
        window.location.href = 'friends.php';
    });

    document.body.appendChild(notif);

    // Kleine vertraging zodat CSS-transition werkt
    setTimeout(() => notif.classList.add('show'), 10);

    // Na 5 seconden weer laten verdwijnen
    setTimeout(() => {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 500);
    }, 5000);
}
