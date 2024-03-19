<script>
    function fetchNotifications() {
        $.get('{{ route('notification') }}', function(notifications) {
            var unreadCount = notifications.length;
            if (unreadCount > 0) {
                $('#notificationIndicator').show().text(unreadCount);
                $('#notificationContainer').empty();
                var displayedNotifications = 0;
                notifications.forEach(function(notification, index) {
                    if (index < 3) { 
                        const createdAt = new Date(notification.created_at).toLocaleString();
                        const notificationElement = $(`
                            <div class="flex items-start justify-between cursor-pointer notification-item hover:bg-gray-200 rounded-lg p-2" data-notification-id="${notification.id}">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-800 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <div>
                                        <span class="font-bold">${createdAt}</span>
                                        <p class="text-sm">${notification.message}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        notificationElement.click(function() {
                            $.get('{{ route('notification.update') }}', { id: notification.id }, function(response) {
                                alert(response);
                            });
                        });
                        $('#notificationContainer').append(notificationElement);
                        displayedNotifications++;
                    } else {
                        const createdAt = new Date(notification.created_at).toLocaleString();
                        const notificationElement = $(`
                            <div class="flex items-start justify-between cursor-pointer hidden notification-item hover:bg-gray-200 rounded-lg p-2" data-notification-id="${notification.id}">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-800 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <div>
                                        <span class="font-bold">${createdAt}</span>
                                        <p class="text-sm">${notification.message}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        $('#notificationContainer').append(notificationElement);
                    }
                });
            } else {
                $('#notificationIndicator').hide();
                $('#notificationContainer').html('<p class="text-sm">Tidak ada notifikasi</p>');
            }
        });
    }
    
    $('#notificationBell').on('click', function() {
        $('#notificationContainer').toggleClass('hidden');
    });

    fetchNotifications();
    setInterval(fetchNotifications, 5000);
</script>