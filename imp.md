Certainly! I'll guide you through setting up Laravel WebSockets (by BeyondCode) with Laravel Echo and Pusher in Laravel 10. This approach allows you to use WebSockets without relying on external services like Pusher.

Here's a step-by-step guide:

1. Create a new Laravel 10 project:
```bash
composer create-project laravel/laravel websocket-demo
cd websocket-demo
```

2. Install required packages:
```bash
composer require beyondcode/laravel-websockets
npm install --save-dev laravel-echo pusher-js
```

3. Publish the WebSocket configuration file:
```bash
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
```

4. Update your `.env` file:
```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=12345
PUSHER_APP_KEY=your-websocket-key
PUSHER_APP_SECRET=your-websocket-secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```

5. Update `config/broadcasting.php`:
```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'host' => env('PUSHER_HOST', '127.0.0.1'),
        'port' => env('PUSHER_PORT', 6001),
        'scheme' => env('PUSHER_SCHEME', 'http'),
        'encrypted' => true,
        'useTLS' => env('PUSHER_SCHEME') === 'https',
    ],
],
```

6. Create an event:
```bash
php artisan make:event NewMessage
```

7. Edit `app/Events/NewMessage.php`:
```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }
}
```

8. Create a controller:
```bash
php artisan make:controller ChatController
```

9. Edit `app/Http/Controllers/ChatController.php`:
```php
<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        broadcast(new NewMessage($message))->toOthers();
        return response()->json(['status' => 'Message Sent!']);
    }
}
```

10. Add routes in `routes/web.php`:
```php
use App\Http\Controllers\ChatController;

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/send-message', [ChatController::class, 'sendMessage']);
```

11. Create a view `resources/views/chat.blade.php`:
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Demo</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <h1>Chat Demo</h1>
        <input type="text" id="message" placeholder="Enter message">
        <button onclick="sendMessage()">Send</button>
        <div id="chat-messages"></div>
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
            document.getElementById('message').value = '';
        }
    </script>
</body>
</html>
```

12. Update `resources/js/bootstrap.js`:
```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});
```

13. Update `resources/js/app.js`:
```javascript
import './bootstrap';

Echo.channel('chat')
    .listen('NewMessage', (e) => {
        const messagesDiv = document.getElementById('chat-messages');
        messagesDiv.innerHTML += `<p>${e.message}</p>`;
    });
```

14. Update `vite.config.js`:
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

15. Run database migrations:
```bash
php artisan migrate
```

16. Start the WebSocket server:
```bash
php artisan websockets:serve
```

17. In a separate terminal, start the Laravel development server:
```bash
php artisan serve
```

18. In another terminal, compile assets:
```bash
npm run dev
```

Now, you can visit `http://localhost:8000/chat` in multiple browser windows to test the real-time chat functionality.

This setup provides a basic implementation of WebSockets with Laravel WebSockets, Laravel Echo, and Pusher client. You can expand on this to build more complex real-time features in your application.