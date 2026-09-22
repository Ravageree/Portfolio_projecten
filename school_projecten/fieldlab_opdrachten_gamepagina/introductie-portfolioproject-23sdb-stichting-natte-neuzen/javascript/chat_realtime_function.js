let currentChatUser = null;

function openChat(friendId) {
    currentChatUser = friendId;
    document.getElementById('chatWith').innerText = "Chat met gebruiker " + friendId;
    loadMessages();
}

function loadMessages() {
    if (!currentChatUser) return;
    fetch('php/load_messages.php?friend_id=' + currentChatUser)
        .then(res => res.json())
        .then(data => {
            const chatBox = document.getElementById('chatMessages');
            chatBox.innerHTML = '';
            data.forEach(msg => {
                chatBox.innerHTML += `<p><strong>${msg.username}</strong> [${msg.sent_at}]: ${msg.content}</p>`;
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

// Polling elke 2 seconden
setInterval(loadMessages, 2000);

function sendMessage() {
    const content = document.getElementById('messageContent').value;
    if (!content || !currentChatUser) return;
    fetch('php/send_message.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({receiver_id: currentChatUser, content})
    }).then(() => {
        document.getElementById('messageContent').value = '';
        loadMessages();
    });
}
