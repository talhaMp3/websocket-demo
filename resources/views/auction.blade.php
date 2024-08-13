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
        <h1>Auction</h1>
        <input type="text" id="price" placeholder="Enter message" value="">
        <button onclick="sendMessage()">Send</button>
        {{-- <div id="chat-messages"></div> --}}

<div id="result">
    @foreach ($messages as $message)
        <p>{{ $message->price }}</p>
    @endforeach
</div>
    </div>

    <script>
        function sendMessage() {
            const price = document.getElementById('price').value;
            fetch('/auction-submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ price: price })
            });
            document.getElementById('price').value = '';
        }
        
        </script>
</body>
</html>


