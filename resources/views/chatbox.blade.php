<div id="chatApp">
    <div class="fixed transition-all duration-300 transform bottom-10 right-12 h-60 w-80" id="chatBox">
        <div class="mt-2">
            <button id="toggleButton" type="button" class="w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm bg-red-600 text-white  hover:bg-red-400 dark:bg-indigo-600 dark:hover:bg-indigo-400">
                Chat
                <svg id="openIcon" class="ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5"></path>
                </svg>
                <svg id="closeIcon" class="ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" style="">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                </svg>
            </button>
        </div>
        <div class="w-full h-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 overflow-auto flex flex-col px-2 py-4">
            <div id="messages" class="flex-1 p-4 text-sm flex flex-col gap-y-1">
                <!-- Messages will be dynamically added here -->
            </div>
            <div>
                <form id="msgForm" class="flex gap-2">
                    <input id="msgText" type="text" name="message" class="block w-full border px-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let open = true;

        $('#toggleButton').on('click', function () {
            open = !open;
            $('#chatBox').toggleClass('-translate-y-0', open)
                .toggleClass('translate-y-full', !open);
            $('#openIcon').toggle(!open);
            $('#closeIcon').toggle(open);
        });

        // Handle form submission
        $('#msgForm').on('submit', function (e) {
            e.preventDefault();
            let message = $('#msgText').val();
            $.post('/message-sent', {_token: '{{ csrf_token() }}',message: message}, (resp) => {
                console.log(resp);
                $('#msgText').val('');
            }).catch((err) => {
                console.error(err);
            });
        });

        window.Echo.channel('chats')
            .listen('MessageSent', (e) => {
                console.log(e);
                $('#messages').append(`<div><span class="text-indigo-600">${e.name}:</span> <span class="dark:text-white">${e.text}</span></div>`);
            });

    });
</script>
