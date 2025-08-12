<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Assistant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col">

<div class="p-4 bg-white shadow text-xl font-bold">🤖 AI Assistant</div>

<div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-2">
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

    // إعداد خيارات marked
    marked.setOptions({
        breaks: true,
        mangle: false,
        headerIds: false
    });

    // تخصيص طريقة عرض الروابط
    const renderer = new marked.Renderer();
    renderer.link = function (href, title, text) {
        return `<a href="${href}" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline">${text}</a>`;
    };

    // تحميل سجل المحادثة عند فتح الصفحة
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const res = await fetch('/chat/history');
            if (!res.ok) throw new Error('Failed to fetch history');

            const messages = await res.json();
            messages.forEach(msg => {
                appendMessage(msg.sender, msg.message);
            });
        } catch (error) {
            console.error('Failed to load conversation:', error);
            appendMessage('ai', 'Could not load conversation history.');
        }
    });

    /**
     * إضافة رسالة للصندوق
     */
    /**
     * Appends a message to the chat box, processing it for safety and formatting.
     * This version manually creates links to avoid external library timing issues.
     */
    function appendMessage(sender, text) {
        const bubbleContainer = document.createElement('div');
        bubbleContainer.className = sender === 'user' ? 'text-right' : 'text-left';

        const bubble = document.createElement('div');
        bubble.className = `prose prose-sm inline-block px-4 py-2 rounded-lg max-w-xl ${
            sender === 'user' ? 'bg-blue-500 text-white prose-invert' : 'bg-gray-200 text-black'
        }`;

        // --- NEW, SIMPLIFIED RENDERING LOGIC ---
        if (sender === 'ai') {
            // Manually find and replace Markdown-style links like [text](url)
            // This is a simplified parser that is robust against timing issues.
            bubble.innerHTML = text.replace(
                /\[([^\]]+)\]\(([^)]+)\)/g,
                '<a href="$2" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">$1</a>'
            );
        } else {
            // For user messages, always treat as plain text to prevent XSS.
            bubble.textContent = text;
        }
        // --- END OF LOGIC ---

        bubbleContainer.appendChild(bubble);
        chatBox.appendChild(bubbleContainer);
        chatBox.scrollTop = chatBox.scrollHeight;
    }


    /**
     * إرسال الرسالة للخادم
     */
    async function sendMessage(event) {
        event.preventDefault();

        const message = userInput.value.trim();
        if (!message) return;

        appendMessage('user', message);
        userInput.value = '';

        // رسالة "Typing..."
        const typingBubble = document.createElement('div');
        typingBubble.className = 'text-left';
        typingBubble.innerHTML = `
            <div class="inline-block px-4 py-2 rounded-lg max-w-lg bg-gray-200 text-black">
                Typing...
            </div>
        `;
        chatBox.appendChild(typingBubble);
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const res = await fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            });
            if (!res.ok) throw new Error('Network response was not ok');

            const data = await res.json();

            chatBox.removeChild(typingBubble);

            appendMessage('ai', data.reply || 'Sorry, something went wrong.');

        } catch (error) {
            console.error('Error sending message:', error);
            chatBox.removeChild(typingBubble);
            appendMessage('ai', 'Failed to get a response from the server.');
        }
    }
</script>

</body>
</html>
