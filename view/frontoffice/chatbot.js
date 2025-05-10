function toggleChat() {
    const chat = document.getElementById('chatContainer');
    chat.style.display = chat.style.display === 'none' ? 'flex' : 'none';
}

function sendMessage() {
    const input = document.getElementById("chat-input");
    const msg = input.value.trim();
    if (!msg) return;

    addMessage("user", msg);
    input.value = "";

    // Show typing indicator
    const typingHTML = `
        <div class="typing-wrapper typing">  <!-- Added 'typing' class here -->
            <div class="typing-indicator typing">  <!-- Added 'typing' class here -->
                <span></span><span></span><span></span>
            </div>
        </div>
    `;
    const typingId = addMessage("bot", typingHTML);

    // Wait 3 seconds and then replace typing indicator with real bot reply
    setTimeout(() => {
        fetch('/urbanisme/controller/chatbotcontroller.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'message=' + encodeURIComponent(msg)
        })
        .then(response => response.text())
        .then(data => {
            const typingDiv = document.getElementById(typingId);
            if (typingDiv) {
                // Remove 'typing' class to expand back to the normal size and replace with actual message
                typingDiv.querySelector('.typing-wrapper').classList.remove('typing');
                typingDiv.querySelector('.typing-indicator').classList.remove('typing');
                typingDiv.innerHTML = data.replace(/\n/g, "<br>");
            }
        });
    }, 3000);  // Wait for 3 seconds
}

function addMessage(type, text) {
    const chat = document.getElementById("chat-messages");
    const msgDiv = document.createElement("div");
    const uniqueId = "msg-" + Date.now() + Math.random().toString(36).substr(2, 5);
    msgDiv.id = uniqueId;
    msgDiv.className = type;
    msgDiv.innerHTML = text.replace(/\n/g, '<br>');
    chat.appendChild(msgDiv);
    chat.scrollTop = chat.scrollHeight;
    return uniqueId;
}

function handleKeyDown(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
}
