import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher


window.Echo = new Echo({
    broadcaster: 'reverb',

    key: import.meta.env.VITE_REVERB_APP_KEY,

    wsHost: import.meta.env.VITE_REVERB_HOST,

    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,

    forceTLS: false,

    enabledTransports: ['ws', 'wss'],
})


/*
|--------------------------------------------------------------------------
| Sync Progress Listener
|--------------------------------------------------------------------------
*/

window.Echo.channel('sync')
    .listen('.sync.progress', (e) => {
        console.log('EVENT RECEIVED:', e);

        Livewire.dispatch('sync-progress', {
            entity: e.entity,
            processed: e.processed,
            runId: e.runId,
            completed: e.completed
        });
    });
