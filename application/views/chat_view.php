<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <script>
        // --- KONFIGURASI WARNA TEMA "ZENITH" ---
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'zenith-darker': '#0f172a', // slate-900
                        'zenith-dark': '#1e293b', // slate-800
                        'zenith-medium': '#334155', // slate-700
                        'zenith-light': '#94a3b8', // slate-400
                        'zenith-accent': '#2dd4bf', // teal-400
                        'zenith-accent-dark': '#14b8a6', // teal-500
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-enter {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
</head>

<body class="bg-zenith-darker">

    <div class="container mx-auto p-4 lg:p-8 h-screen">
        <div class="flex h-full bg-zenith-dark rounded-2xl shadow-2xl overflow-hidden border border-slate-700">

            <aside class="w-[360px] bg-zenith-dark/50 border-r border-slate-700 flex flex-col">
                <div class="p-5 border-b border-slate-700">
                    <h2 class="text-2xl font-bold text-white">Pesan</h2>
                    <form class="mt-4">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-zenith-light"></i>
                            <input type="text" id="search-contact" placeholder="Cari kontak..." class="w-full bg-zenith-medium text-slate-200 placeholder-zenith-light pl-10 pr-4 py-2 rounded-lg border-transparent focus:outline-none focus:ring-2 focus:ring-zenith-accent">
                        </div>
                    </form>
                </div>

                <div id="contact-list" class="flex-grow overflow-y-auto">
                    <div class="flex justify-center items-center h-full">
                        <div class="w-8 h-8 border-4 border-dashed rounded-full animate-spin border-zenith-accent"></div>
                    </div>
                </div>

                <div class="p-4 border-t border-slate-700 mt-auto">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-zenith-accent rounded-full flex items-center justify-center font-bold text-zenith-dark">
                            <?= strtoupper(substr($this->session->userdata('nama_user'), 0, 1)); ?>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-white"><?= $this->session->userdata('nama_user'); ?></p>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="flex-1 flex flex-col bg-zenith-darker">
                <div id="chat-window" class="hidden w-full h-full flex-col">
                    <header class="bg-zenith-dark p-4 border-b border-slate-700 flex items-center shadow-md z-10">
                        <div class="relative">
                            <div class="w-11 h-11 bg-zenith-medium rounded-full flex items-center justify-center text-zenith-accent font-bold text-xl mr-4" id="chat-avatar-initial">?</div>
                        </div>
                        <div>
                            <h2 id="chat-with-name" class="text-lg font-semibold text-white"></h2>
                        </div>
                    </header>

                    <div id="chat-body" class="flex-1 flex flex-col p-6 md:p-8 overflow-y-auto">
                        <div id="message-list" class="space-y-4">
                        </div>
                        <div id="seen-indicator" class="flex justify-end pr-2 hidden pt-2">
                            <span class="text-sm text-zenith-light font-semibold">Dilihat</span>
                        </div>
                    </div>

                    <footer class="bg-zenith-dark p-4 border-t border-slate-700">
                        <form id="send-message-form" class="flex items-center gap-3">
                            <input type="text" id="message-input" class="flex-1 p-3 px-5 rounded-full bg-zenith-medium border-transparent text-slate-200 placeholder-zenith-light focus:outline-none focus:ring-2 focus:ring-zenith-accent transition" placeholder="Ketik pesan..." autocomplete="off" disabled>
                            <button type="submit" class="bg-zenith-accent text-white rounded-full w-12 h-12 flex-shrink-0 flex items-center justify-center hover:bg-zenith-accent-dark transition-all duration-200 ease-in-out disabled:opacity-40 disabled:cursor-not-allowed transform hover:scale-110" disabled>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </footer>
                </div>

                <div id="chat-placeholder" class="flex flex-col items-center justify-center h-full text-slate-500 text-center p-8">
                    <i class="fas fa-comments fa-5x text-slate-700"></i>
                    <h4 class="mt-6 text-2xl font-semibold text-slate-400">Pilih Percakapan</h4>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            const myId = <?= $this->session->userdata('id_user'); ?>;
            const baseUrl = '<?= base_url(); ?>';
            let activePartnerId = null;

            const pusher = new Pusher('<?= PUSHER_APP_KEY ?>', {
                cluster: '<?= PUSHER_APP_CLUSTER ?>',
                encrypted: true
            });

            function setupPusherListener() {
                const myChannelName = `new-message-${myId}`;
                const myChannel = pusher.subscribe(myChannelName);
                myChannel.bind('new-message', function(data) {
                    $('#seen-indicator').addClass('hidden');
                    if (data.sender_id == activePartnerId) {
                        appendMessage(data);
                        scrollToBottom();
                        $.post(`${baseUrl}chat/mark_as_read/${activePartnerId}`);
                    } else {
                        updateContactItem(data.sender_id, data.message, data.unread_count, data.created_at);
                    }
                });

                const readReceiptChannelName = `read-receipt-channel-${myId}`;
                const readReceiptChannel = pusher.subscribe(readReceiptChannelName);
                readReceiptChannel.bind('messages-read', function(data) {
                    if (data.reader_id == activePartnerId) {
                        $('#seen-indicator').removeClass('hidden');
                        scrollToBottom();
                    }
                });
            }

            function formatTime(isoString) {
                if (!isoString) return '';
                const date = new Date(isoString);
                if (isNaN(date.getTime())) return '';
                return date.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function formatTimeForContactList(isoString) {
                if (!isoString) return '';
                const date = new Date(isoString);
                if (isNaN(date.getTime())) return '';
                const today = new Date();
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                today.setHours(0, 0, 0, 0);
                yesterday.setHours(0, 0, 0, 0);
                const msgDate = new Date(isoString);
                msgDate.setHours(0, 0, 0, 0);

                if (msgDate.getTime() === today.getTime()) {
                    return new Date(isoString).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                } else if (msgDate.getTime() === yesterday.getTime()) {
                    return 'Kemarin';
                } else if ((today.getTime() - msgDate.getTime()) < (7 * 24 * 60 * 60 * 1000)) {
                    return new Date(isoString).toLocaleDateString('id-ID', {
                        weekday: 'long'
                    });
                } else {
                    return new Date(isoString).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                }
            }

            function scrollToBottom() {
                const chatBody = $('#chat-body');
                chatBody.animate({
                    scrollTop: chatBody[0].scrollHeight
                }, 500);
            }

            function appendMessage(msg) {
                const isSent = msg.sender_id == myId;
                let time = formatTime(msg.created_at || new Date().toISOString());

                const justifyClass = isSent ? 'justify-end' : 'justify-start';
                const bubbleClass = isSent ? 'bg-zenith-accent-dark text-white rounded-br-none' : 'bg-zenith-medium text-slate-200 rounded-bl-none';
                const timeColorClass = isSent ? 'text-slate-300' : 'text-zenith-light';

                const html = `
                <div class="flex ${justifyClass} message-container">
                    <div class="max-w-xl ${bubbleClass} rounded-2xl py-2 px-4 shadow-lg">
                        <p style="word-wrap: break-word;">${msg.message}</p>
                        <span class="block text-xs ${timeColorClass} text-right mt-1">${time}</span>
                    </div>
                </div>`;

                const messageElement = $(html).appendTo('#message-list');
                messageElement.addClass('message-enter');
                setTimeout(() => {
                    messageElement.removeClass('message-enter');
                }, 400);
            }

            function updateContactItem(contactId, message, unreadCount, createdAt = null) {
                const contactItem = $(`#contact-item-${contactId}`);
                const safeMessage = message.length > 30 ? message.substring(0, 30) + '...' : message;
                const timeLabel = formatTimeForContactList(createdAt);
                if (contactItem.length > 0) {
                    contactItem.find('.contact-last-message').text(`${safeMessage}`);
                    contactItem.find('.contact-last-time').text(timeLabel);
                    const badge = contactItem.find('.unread-badge');
                    if (unreadCount > 0) badge.text(unreadCount).removeClass('hidden');
                    else badge.text('0').addClass('hidden');
                    $('#contact-list').prepend(contactItem);
                } else {
                    loadContacts();
                }
            }

            function loadContacts() {
                $.get(`${baseUrl}chat/get_contacts`, function(data) {
                    const contacts = JSON.parse(data);
                    const contactList = $('#contact-list');
                    contactList.html('');
                    if (contacts.length > 0) {
                        contacts.forEach(contact => {
                            const unreadVisibility = contact.unread_count > 0 ? '' : 'hidden';
                            const lastMessage = contact.last_message ? (contact.last_message.length > 30 ? contact.last_message.substring(0, 30) + '...' : contact.last_message) : 'Belum ada pesan';
                            const contactInitial = contact.nama_user.charAt(0).toUpperCase();
                            const lastMessageTime = formatTimeForContactList(contact.last_message_time);
                            const html = `
                            <a href="#" class="contact-item flex items-center p-4 hover:bg-zenith-medium/50 cursor-pointer transition-colors duration-200 border-b border-slate-700" 
                                id="contact-item-${contact.id_user}"
                                data-id_user="${contact.id_user}" 
                                data-nama_user="${contact.nama_user}">
                                <div class="relative w-12 h-12 flex-shrink-0">
                                    <div class="w-12 h-12 bg-zenith-medium rounded-full flex items-center justify-center text-zenith-accent font-bold text-xl">
                                        ${contactInitial}
                                    </div>
                                </div>
                                <div class="flex-grow ml-4 overflow-hidden">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-semibold text-slate-200 truncate">${contact.nama_user}</h3>
                                        <span class="text-xs text-zenith-light flex-shrink-0 contact-last-time">${lastMessageTime}</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-sm text-zenith-light truncate contact-last-message">${lastMessage}</p>
                                        <span class="unread-badge bg-zenith-accent text-zenith-darker text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center flex-shrink-0 ${unreadVisibility}">
                                            ${contact.unread_count}
                                        </span>
                                    </div>
                                </div>
                            </a>`;
                            contactList.append(html);
                        });
                    } else {
                        contactList.html('<p class="text-center text-slate-500 p-4">Tidak ada kontak ditemukan.</p>');
                    }
                });
            }

            $('#search-contact').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('#contact-list .contact-item').each(function() {
                    const contactName = $(this).data('nama_user').toLowerCase();
                    if (contactName.includes(searchTerm)) {
                        $(this).css('display', 'flex');
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#contact-list').on('click', '.contact-item', function(e) {
                e.preventDefault();
                $('#contact-list .contact-item').removeClass('bg-zenith-medium');
                $(this).addClass('bg-zenith-medium');
                activePartnerId = $(this).data('id_user');
                const partnerName = $(this).data('nama_user');

                // [PERBAIKAN FINAL] Cek dulu apakah ada pesan belum dibaca sebelum mengirim 'mark_as_read'
                const unreadBadge = $(this).find('.unread-badge');
                if (!unreadBadge.hasClass('hidden')) {
                    // Hanya kirim 'mark_as_read' jika badge-nya terlihat (artinya ada pesan belum dibaca)
                    $.post(`${baseUrl}chat/mark_as_read/${activePartnerId}`);
                }

                // Tetap sembunyikan badge setelah diklik
                unreadBadge.text('0').addClass('hidden');

                $('#chat-window').removeClass('hidden').addClass('flex');
                $('#chat-placeholder').addClass('hidden');
                $('#message-input, #send-message-form button').prop('disabled', false);
                $('#chat-with-name').text(partnerName);
                $('#chat-avatar-initial').text(partnerName.charAt(0).toUpperCase());

                const spinnerHtml = `<div class="flex justify-center items-center h-full"><div class="w-8 h-8 border-4 border-dashed rounded-full animate-spin border-zenith-accent"></div></div>`;
                $('#message-list').html(spinnerHtml);
                $('#seen-indicator').addClass('hidden');

                $.get(`${baseUrl}chat/get_messages/${activePartnerId}`, function(data) {
                    const messageList = $('#message-list');
                    messageList.html('');
                    const messages = JSON.parse(data);
                    messages.forEach(msg => appendMessage(msg));

                    const lastMessage = messages[messages.length - 1];
                    if (lastMessage && lastMessage.sender_id == myId && lastMessage.status === 'read') {
                        $('#seen-indicator').removeClass('hidden');
                    } else {
                        $('#seen-indicator').addClass('hidden');
                    }

                    setTimeout(scrollToBottom, 100);
                });
            });

            $('#send-message-form').on('submit', function(e) {
                e.preventDefault();
                $('#seen-indicator').addClass('hidden');

                const messageText = $('#message-input').val();
                if (messageText.trim() === '' || !activePartnerId) return;

                const messageData = {
                    sender_id: myId,
                    message: messageText,
                    created_at: new Date().toISOString(),
                };
                appendMessage(messageData);
                scrollToBottom();
                $('#message-input').val('');
                updateContactItem(activePartnerId, "Anda: " + messageText, 0, messageData.created_at);

                $.post(`${baseUrl}chat/send_message`, {
                        receiver_id: activePartnerId,
                        message: messageText
                    }, null, 'json')
                    .fail(function() {
                        console.error("Pesan gagal terkirim ke server.");
                    });
            });

            // INISIALISASI
            loadContacts();
            setupPusherListener();
        });
    </script>

</body>

</html>