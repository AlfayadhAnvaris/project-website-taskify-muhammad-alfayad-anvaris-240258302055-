    <div
        x-data="{ show: false, message: '', type: 'success' }"
        x-on:toast.window="
            message = $event.detail.message;
            type = $event.detail.type || 'success';
            show = true;
            setTimeout(() => show = false, 3000);
        "
        x-show="show"
        x-transition
        class="fixed top-5 right-5 z-50"
    >
        <div
            :class="{
                'bg-green-600 text-white': type === 'success',
                'bg-red-600 text-white': type === 'error',
                'bg-yellow-500 text-white': type === 'warning'
            }"
            class="px-4 py-2 rounded-lg shadow-lg"
        >
            <span x-text="message"></span>
        </div>
    </div>
