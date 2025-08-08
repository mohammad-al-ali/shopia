<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Assistant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col">

<div class="p-4 bg-white shadow text-xl font-bold">🤖 AI Assistant</div>

<div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-2">
    <!-- رسائل المساعد والمستخدم -->
</div>

<form id="chat-form" class="flex p-4 bg-white shadow" onsubmit="sendMessage(event)">
    <input id="user-input" type="text" placeholder="Type your message..."
           class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none" required>
    <button type="submit"
            class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Send</button>
</form>

<script>
    const chatBox = document.getElementById('chat-box');
    const userInput = document.getElementById('user-input');

    function appendMessage(sender, text) {
        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'text-right'
            : 'text-left';

        bubble.innerHTML = `
                <div class="inline-block px-4 py-2 rounded-lg max-w-lg ${
            sender === 'user' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'
        }">
                    ${text}
                </div>
            `;

        chatBox.appendChild(bubble);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    async function sendMessage(event) {
        event.preventDefault();

        const message = userInput.value.trim();
        if (!message) return;

        appendMessage('user', message);
        userInput.value = '';

        appendMessage('ai', 'Typing...');

        const res = await fetch('/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        });

        const data = await res.json();

        // إزالة "Typing..."
        chatBox.removeChild(chatBox.lastChild);

        appendMessage('ai', data.reply || 'Something went wrong.');
    }
</script>

</body>
</html>
