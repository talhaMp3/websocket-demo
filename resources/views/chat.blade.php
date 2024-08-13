<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Demo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <h1>Chat Demo</h1>
        <input type="text" id="message" placeholder="Enter message" value="fafsefasefasf">
        <button onclick="sendMessage()">Send</button>
        {{-- <div id="chat-messages"></div> --}}

<div id="chat-messages">
    @foreach ($messages as $message)
        <p>{{ $message->message }}</p>
    @endforeach
</div>
    </div>

    <script>
        function sendMessage() {
            const message = document.getElementById('message').value;
            fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });
            document.getElementById('message').value = 'fafsefasefasf';
        }
        
        </script>
</body>
</html>


