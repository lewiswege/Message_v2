import Echo from 'laravel-echo';

console.log('Echo import:', Echo);

import Pusher from 'pusher-js';

console.log('Pusher import:', Pusher);

window.Pusher = Pusher;

try {
    window.Echo = new Echo({
        broadcaster: 'reverb',

        key: import.meta.env.VITE_REVERB_APP_KEY,

        wsHost: import.meta.env.VITE_REVERB_HOST,

        wsPort: Number(import.meta.env.VITE_REVERB_PORT),

        wssPort: Number(import.meta.env.VITE_REVERB_PORT),

        forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',

        enabledTransports: ['ws', 'wss'],
    });

    console.log('Echo instance:', window.Echo);

} catch (e) {
    console.error('Echo failed:', e);
}
window.Echo
    .channel('conversations.test')
    .listen('.message.created', (event) => {
        console.log('Message received:', event);
    });
