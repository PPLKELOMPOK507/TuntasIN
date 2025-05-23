// In your chat.js or similar file
function sendMessage() {
    const messageInput = document.querySelector('#message-input');
    const priceInput = document.querySelector('[name="price_offer"]');
    const jasa_id = document.querySelector('[name="jasa_id"]').value;
    const receiver_id = document.querySelector('[name="receiver_id"]').value;

    fetch('/messages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            message: messageInput.value,
            price_offer: priceInput.value,
            jasa_id: jasa_id,
            receiver_id: receiver_id
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        messageInput.value = ''; // Clear input
        priceInput.value = ''; // Clear price
        // Refresh messages
        getMessages(jasa_id);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function getMessages(jasa_id) {
    fetch(`/messages/${jasa_id}`)
        .then(response => response.json())
        .then(messages => {
            // Update your chat UI here
            const chatContainer = document.querySelector('.chat-messages');
            chatContainer.innerHTML = messages.map(message => `
                <div class="message ${message.sender_id === currentUserId ? 'sent' : 'received'}">
                    <p>${message.message}</p>
                    ${message.price_offer ? `<span class="price">Rp ${message.price_offer}</span>` : ''}
                </div>
            `).join('');
        });
}

// Poll for new messages every 5 seconds
setInterval(() => {
    const jasa_id = document.querySelector('[name="jasa_id"]').value;
    getMessages(jasa_id);
}, 5000);

document.querySelector('.chat-input button').addEventListener('click', function(e) {
    e.preventDefault();
    sendMessage();
});