<div class="relative">
    <div class="text-xl font-bold">
        {{ $data['title'] }}
    </div>
    <div class="absolute top-0 right-0">
        <svg id="notificationBell" class="w-7 h-7 font-extralight text-gray-800 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.4V3m0 2.4a5.3 5.3 0 0 1 5.1 5.3v1.8c0 2.4 1.9 3 1.9 4.2 0 .6 0 1.2-.5 1.2h-13c-.5 0-.5-.6-.5-1.2 0-1.2 1.9-1.8 1.9-4.2v-1.8A5.3 5.3 0 0 1 12 5.4Zm-8.1 5.3c0-2 .8-4.1 2.2-5.7m14 5.7c0-2-.8-4.1-2.2-5.7M8.5 18a3.5 3.5 0 0 0 7 0h-7Z"/>
        </svg>
        <span id="notificationIndicator" class="absolute -top-1 -right-1 animate-pulse w-3 h-3 bg-blue-800 rounded-full hidden"></span>
    </div>
</div>
<div id="notificationContainer" class="absolute hidden z-10 overflow-y-auto max-h-60 right-10 bg-white border border-gray-200 rounded-md p-4 mt-2 shadow-md">
    <!-- Notification content will be dynamically appended here -->
</div>