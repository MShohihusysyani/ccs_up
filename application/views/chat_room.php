<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room - <?= html_escape($ccs_data->no_tiket) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'zenith-darker': '#0f172a',
                        'zenith-dark': '#1e293b',
                        'zenith-medium': '#334155',
                        'zenith-light': '#94a3b8',
                        'zenith-accent': '#2dd4bf',
                        'zenith-accent-dark': '#14b8a6'
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

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

        .date-separator {
            text-align: center;
            margin: 16px 0;
        }

        .date-separator span {
            background-color: #334155;
            color: #94a3b8;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .message-bubble {
            position: relative;
        }

        .reply-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.2);
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .flex.justify-start .reply-btn {
            right: -40px;
        }

        .flex.justify-end .reply-btn {
            left: -40px;
        }

        .message-container:hover .reply-btn {
            opacity: 1;
        }

        .quoted-message {
            background-color: rgba(0, 0, 0, 0.2);
            border-left: 2px solid #2dd4bf;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 6px;
            font-size: 0.875rem;
        }

        .quoted-message p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }

        #replying-to-banner {
            display: none;
        }

        /* --- BLOK CSS YANG DIPERBARUI --- */
        .message-container {
            margin-top: 12px;
            /* Jarak standar antar GRUP pesan */
        }

        .is-consecutive {
            margin-top: 3px;
            /* Jarak kecil antar pesan dalam SATU GRUP */
        }

        /* Sisi Penerima (Kiri) */
        .is-consecutive .flex.justify-start .message-bubble {
            border-top-left-radius: 4px;
            /* Sudut kiri atas dibuat lebih tajam */
        }

        /* Sisi Pengirim (Kanan) */
        .is-consecutive .flex.justify-end .message-bubble {
            border-top-right-radius: 4px;
            /* Sudut kanan atas dibuat lebih tajam */
        }

        /* ------------------------------ */
    </style>
    <!-- <style>
        html {
            scroll-behavior: smooth;
        }

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

        .date-separator {
            text-align: center;
            margin: 16px 0;
        }

        .date-separator span {
            background-color: #334155;
            color: #94a3b8;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .message-bubble {
            position: relative;
        }

        .reply-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.2);
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .flex.justify-start .reply-btn {
            right: -40px;
        }

        .flex.justify-end .reply-btn {
            left: -40px;
        }

        .message-container:hover .reply-btn {
            opacity: 1;
        }

        .quoted-message {
            background-color: rgba(0, 0, 0, 0.2);
            border-left: 2px solid #2dd4bf;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 6px;
            font-size: 0.875rem;
        }

        .quoted-message p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }

        #replying-to-banner {
            display: none;
        }

        /* Tambahkan ini di dalam tag <style> Anda */

        .message-container {
            margin-bottom: 8px;
            /* Jarak standar antar pesan */
        }

        /* GAYA UNTUK PESAN BERURUTAN */
        .is-consecutive {
            margin-top: -12px;
            /* Tarik pesan ke atas agar lebih menempel */
        }

        /* Sisi Penerima (Kiri) */
        .is-consecutive .flex.justify-start .message-bubble {
            border-top-left-radius: 4px;
            /* Sudut kiri atas dibuat lebih tajam */
        }

        /* Sisi Pengirim (Kanan) */
        .is-consecutive .flex.justify-end .message-bubble {
            border-top-right-radius: 4px;
            /* Sudut kanan atas dibuat lebih tajam */
        }
    </style> -->
</head>

<body class="bg-zenith-darker">
    <div class="container mx-auto p-4 lg:p-8 h-screen">
        <div class="flex h-full bg-zenith-dark rounded-2xl shadow-2xl overflow-hidden border border-slate-700">
            <main class="flex-1 flex flex-col bg-zenith-darker">
                <header class="bg-zenith-dark p-4 border-b border-slate-700 flex items-center shadow-md z-10">
                    <div class="relative">
                        <div class="w-11 h-11 bg-zenith-medium rounded-full flex items-center justify-center text-zenith-accent font-bold text-xl mr-4">
                            <i class="fas fa-hashtag"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white"><?= html_escape($ccs_data->judul) ?></h2>
                        <p class="text-sm text-zenith-light">No Tiket : <?= html_escape($ccs_data->no_tiket) ?></p>
                    </div>
                </header>

                <div id="chat-body" class="flex-1 p-6 md:p-8 overflow-y-auto">
                </div>

                <footer class="bg-zenith-dark p-4 border-t border-slate-700">
                    <div id="replying-to-banner" class="bg-zenith-medium p-3 rounded-t-lg border-b border-slate-600">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-zenith-accent font-semibold">Membalas kepada <span id="reply-to-name"></span></p>
                                <p id="reply-to-text" class="text-sm text-slate-300 truncate"></p>
                            </div>
                            <button id="cancel-reply-btn" class="text-slate-400 hover:text-white">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form id="send-message-form" class="flex items-center gap-3">
                        <input type="text" id="message-input" class="flex-1 p-3 px-5 rounded-full bg-zenith-medium border-transparent text-slate-200 placeholder-zenith-light focus:outline-none focus:ring-2 focus:ring-zenith-accent transition" placeholder="Ketik pesan..." autocomplete="off">
                        <button type="submit" class="bg-zenith-accent text-white rounded-full w-12 h-12 flex-shrink-0 flex items-center justify-center hover:bg-zenith-accent-dark transition-all duration-200 ease-in-out transform hover:scale-110">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            // --- VARIABEL KONTROL ---
            const myId = <?= $this->session->userdata('id_user'); ?>;
            const myName = '<?= $this->session->userdata("nama_user") ?>';
            const ccsId = '<?= $ccs_data->id_pelaporan ?>';
            const baseUrl = '<?= base_url(); ?>';

            let lastDisplayedDate = null;
            let replyingToMessage = null;
            let lastSenderId = null; // <-- BARU: Variabel untuk melacak pengirim terakhir

            // --- KONEKSI PUSHER ---
            const pusher = new Pusher('<?= PUSHER_APP_KEY ?>', {
                cluster: '<?= PUSHER_APP_CLUSTER ?>',
                encrypted: true
            });
            const channelName = `chat-room-${ccsId}`;
            const channel = pusher.subscribe(channelName);
            channel.bind('new-message', function(data) {
                if (data.sender_id != myId) {
                    appendMessage(data);
                    scrollToBottom();

                    let notifTitle = `Pesan Baru dari ${data.nama_user}`;
                    let notifBody = data.message;
                    if (data.reply_to) {
                        if (data.reply_to.sender_id == myId) {
                            notifTitle = `${data.nama_user} membalas Anda`;
                        } else {
                            notifTitle = `${data.nama_user} membalas ${data.reply_to.nama_user}`;
                        }
                        let originalSnippet = data.reply_to.message.substring(0, 25);
                        if (data.reply_to.message.length > 25) originalSnippet += '...';
                        notifBody = `"${originalSnippet}"\n${data.message}`;
                    }
                    const notifOptions = {
                        body: notifBody,
                        icon: 'https://cdn-icons-png.flaticon.com/512/134/134914.png',
                        tag: `chat-notif-${ccsId}`,
                        renotify: true
                    };
                    showDesktopNotification(notifTitle, notifOptions);
                }
            });

            // --- FUNGSI NOTIFIKASI ---
            function requestNotificationPermission() {
                /* ... kode tidak berubah ... */
            }

            function showDesktopNotification(title, options) {
                /* ... kode tidak berubah ... */
            }

            // --- FUNGSI-FUNGSI UTAMA LAINNYA ---
            function scrollToBottom(isInstant = false) {
                /* ... kode tidak berubah ... */
            }

            function formatDateSeparator(dateString) {
                /* ... kode tidak berubah ... */
            }

            // --- FUNGSI APPENDMESSAGE DIMODIFIKASI ---
            function appendMessage(msg) {
                // Cek apakah pengirim sama dengan sebelumnya
                const isConsecutive = msg.sender_id === lastSenderId;

                // Logika Tanggal (tidak berubah)
                const messageDate = new Date(msg.created_at || new Date());
                const messageDateString = messageDate.toISOString().split('T')[0];
                if (messageDateString !== lastDisplayedDate) {
                    /* ... kode tidak berubah ... */
                }

                // Persiapan Variabel (tidak berubah)
                const isSent = msg.sender_id == myId;
                let time = messageDate.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // MODIFIKASI: Hanya tampilkan nama jika pesan tidak berurutan
                const senderNameHtml = !isSent && !isConsecutive ? `<p class="text-xs text-zenith-accent font-semibold mb-1 ml-2">${msg.nama_user || '...'}</p>` : '';

                // ... sisa kode appendMessage tidak berubah ...
                const justifyClass = isSent ? 'justify-end' : 'justify-start';
                const bubbleClass = isSent ? 'bg-zenith-accent-dark text-white rounded-br-none' : 'bg-zenith-medium text-slate-200 rounded-bl-none';
                let quotedMessageHtml = '';
                if (msg.reply_to && msg.reply_to.message) {
                    quotedMessageHtml = `<a href="#message-${msg.reply_to.id}" class="quoted-message block"><p class="font-semibold text-zenith-accent">${msg.reply_to.nama_user}</p><p class="text-slate-300">${msg.reply_to.message}</p></a>`;
                }
                const replyButtonHtml = `<button class="reply-btn"><i class="fas fa-reply"></i></button>`;

                // MODIFIKASI: Tambahkan class 'is-consecutive' jika pesan berurutan
                const html = `
            <div class="message-container ${isConsecutive ? 'is-consecutive' : ''}" id="message-${msg.id}" data-message='${JSON.stringify(msg)}'>
                ${senderNameHtml}
                <div class="flex ${justifyClass}">
                    <div class="max-w-xl ${bubbleClass} rounded-2xl py-2 px-4 shadow-lg message-bubble">
                        ${quotedMessageHtml}
                        <p style="word-wrap: break-word;">${msg.message}</p>
                        <span class="block text-xs text-slate-300 text-right mt-1">${time}</span>
                        ${replyButtonHtml}
                    </div>
                </div>
            </div>`;
                $(html).appendTo('#chat-body').addClass('message-enter');

                // BARU: Update pengirim terakhir setelah pesan ditambahkan
                lastSenderId = msg.sender_id;
            }

            function loadMessages() {
                $.get(`${baseUrl}chat/get_ccs_messages/${ccsId}`, function(data) {
                    const messages = JSON.parse(data);
                    lastDisplayedDate = null;
                    lastSenderId = null; // <-- BARU: Reset pengirim terakhir saat load
                    $('#chat-body').empty();
                    messages.forEach(msg => appendMessage(msg));
                    setTimeout(() => scrollToBottom(true), 100);
                });
            }

            // ... sisa fungsi dan event handler tidak perlu diubah ...
            // (Salin-tempel dari kode lengkap Anda sebelumnya agar tidak ada yang hilang)
            function requestNotificationPermission() {
                if (!("Notification" in window)) {
                    console.log("Browser ini tidak mendukung notifikasi desktop");
                } else if (Notification.permission !== "denied") {
                    Notification.requestPermission().then(permission => {
                        if (permission === "granted") {
                            console.log("Izin notifikasi diberikan!");
                        }
                    });
                }
            }

            function showDesktopNotification(title, options) {
                if (Notification.permission !== "granted") {
                    return;
                }
                if (document.hidden) {
                    const notification = new Notification(title, options);
                    notification.onclick = function() {
                        window.focus();
                        this.close();
                    };
                }
            }

            function scrollToBottom(isInstant = false) {
                const chatBody = $('#chat-body');
                const duration = isInstant ? 0 : 500;
                chatBody.animate({
                    scrollTop: chatBody[0].scrollHeight
                }, duration);
            }

            function formatDateSeparator(dateString) {
                const today = new Date();
                const yesterday = new Date();
                yesterday.setDate(yesterday.getDate() - 1);
                const messageDate = new Date(dateString);
                today.setHours(0, 0, 0, 0);
                yesterday.setHours(0, 0, 0, 0);
                messageDate.setHours(0, 0, 0, 0);
                if (messageDate.getTime() === today.getTime()) return 'Hari Ini';
                if (messageDate.getTime() === yesterday.getTime()) return 'Kemarin';
                return messageDate.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }

            function appendMessage(msg) {
                const messageDate = new Date(msg.created_at || new Date());
                const messageDateString = messageDate.toISOString().split('T')[0];
                if (messageDateString !== lastDisplayedDate) {
                    const formattedDate = formatDateSeparator(messageDate);
                    $('#chat-body').append(`<div class="date-separator"><span>${formattedDate}</span></div>`);
                    lastDisplayedDate = messageDateString;
                }
                const isSent = msg.sender_id == myId;
                let time = messageDate.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const justifyClass = isSent ? 'justify-end' : 'justify-start';
                const bubbleClass = isSent ? 'bg-zenith-accent-dark text-white rounded-br-none' : 'bg-zenith-medium text-slate-200 rounded-bl-none';
                const senderNameHtml = !isSent ? `<p class="text-xs text-zenith-accent font-semibold mb-1 ml-2">${msg.nama_user || '...'}</p>` : '';
                let quotedMessageHtml = '';
                if (msg.reply_to && msg.reply_to.message) {
                    quotedMessageHtml = `<a href="#message-${msg.reply_to.id}" class="quoted-message block"><p class="font-semibold text-zenith-accent">${msg.reply_to.nama_user}</p><p class="text-slate-300">${msg.reply_to.message}</p></a>`;
                }
                const replyButtonHtml = `<button class="reply-btn"><i class="fas fa-reply"></i></button>`;
                const html = `<div class="message-container" id="message-${msg.id}" data-message='${JSON.stringify(msg)}'>${senderNameHtml}<div class="flex ${justifyClass}"><div class="max-w-xl ${bubbleClass} rounded-2xl py-2 px-4 shadow-lg message-bubble">${quotedMessageHtml}<p style="word-wrap: break-word;">${msg.message}</p><span class="block text-xs text-slate-300 text-right mt-1">${time}</span>${replyButtonHtml}</div></div></div>`;
                $(html).appendTo('#chat-body').addClass('message-enter');
            }

            function setReplyMode(msg) {
                replyingToMessage = msg;
                $('#reply-to-name').text(msg.nama_user);
                $('#reply-to-text').text(msg.message);
                $('#replying-to-banner').slideDown(200);
                $('#message-input').focus();
            }

            function cancelReplyMode() {
                replyingToMessage = null;
                $('#replying-to-banner').slideUp(200);
            }
            $('#send-message-form').on('submit', function(e) {
                e.preventDefault();
                const messageText = $('#message-input').val();
                if (messageText.trim() === '') return;
                const messageData = {
                    id: `temp-${Date.now()}`,
                    sender_id: myId,
                    nama_user: myName,
                    message: messageText,
                    created_at: new Date().toISOString(),
                    reply_to: replyingToMessage
                };
                appendMessage(messageData);
                scrollToBottom();
                $('#message-input').val('');
                $.post(`${baseUrl}chat/send_ccs_message`, {
                    tiket_id: ccsId,
                    message: messageText,
                    reply_to_id: replyingToMessage ? replyingToMessage.id : null
                });
                cancelReplyMode();
            });
            $('#chat-body').on('click', '.reply-btn', function() {
                const messageContainer = $(this).closest('.message-container');
                const messageData = messageContainer.data('message');
                setReplyMode(messageData);
            });
            $('#cancel-reply-btn').on('click', cancelReplyMode);
            $('#chat-body').on('click', '.quoted-message', function(e) {
                e.preventDefault();
                const targetId = $(this).attr('href');
                const targetElement = $(targetId);
                if (targetElement.length) {
                    $('#chat-body').animate({
                        scrollTop: $('#chat-body').scrollTop() + targetElement.offset().top - 100
                    }, 500);
                    targetElement.addClass('bg-zenith-medium').delay(1000).queue(function(next) {
                        $(this).removeClass('bg-zenith-medium');
                        next();
                    });
                }
            });

            // --- INISIALISASI ---
            loadMessages();
            requestNotificationPermission();
        });
    </script>
    <!-- <script>
        $(document).ready(function() {
            // --- VARIABEL KONTROL ---
            const myId = <?= $this->session->userdata('id_user'); ?>;
            const myName = '<?= $this->session->userdata("nama_user") ?>';
            const ccsId = '<?= $ccs_data->id_pelaporan ?>';
            const baseUrl = '<?= base_url(); ?>';

            let lastDisplayedDate = null;
            let replyingToMessage = null;

            // --- KONEKSI PUSHER (DENGAN LOGIKA NOTIFIKASI) ---
            const pusher = new Pusher('<?= PUSHER_APP_KEY ?>', {
                cluster: '<?= PUSHER_APP_CLUSTER ?>',
                encrypted: true
            });
            const channelName = `chat-room-${ccsId}`;
            const channel = pusher.subscribe(channelName);
            channel.bind('new-message', function(data) {
                // console.log("------------------------------------");
                // console.log("Pesan baru diterima dari Pusher jam:", new Date().toLocaleTimeString());
                // console.log("Isi data pesan:", data);
                // console.log("ID saya (penerima):", myId);
                // console.log("ID pengirim:", data.sender_id);

                if (data.sender_id != myId) {
                    // console.log("Kondisi 1: Pesan dari orang lain -> TERPENUHI.");
                    appendMessage(data);
                    scrollToBottom();

                    const notifTitle = `Pesan Baru dari ${data.nama_user}`;
                    const notifOptions = {
                        body: data.message,
                        icon: 'https://cdn-icons-png.flaticon.com/512/134/134914.png',
                        tag: `chat-notif-${ccsId}`,
                        renotify: true
                    };

                    // console.log("Mencoba memanggil fungsi showDesktopNotification...");
                    showDesktopNotification(notifTitle, notifOptions);
                } else {
                    // console.log("Kondisi 1: Pesan dari saya sendiri -> GAGAL (Ini normal jika Anda mengirim pesan).");
                }
                // console.log("------------------------------------");
            });


            // channel.bind('new-message', function(data) {
            //     if (data.sender_id != myId) {
            //         appendMessage(data);
            //         scrollToBottom();

            //         // Panggil fungsi notifikasi saat ada pesan baru dari orang lain
            //         const notifTitle = `Pesan Baru dari ${data.nama_user}`;
            //         const notifOptions = {
            //             body: data.message,
            //             icon: 'https://cdn-icons-png.flaticon.com/512/134/134914.png', // Ganti dengan URL ikon Anda
            //             tag: `chat-notif-${ccsId}`
            //         };
            //         showDesktopNotification(notifTitle, notifOptions);
            //     }
            // });

            // --- BAGIAN FUNGSI NOTIFIKASI DESKTOP (BARU) ---
            function requestNotificationPermission() {
                if (!("Notification" in window)) {
                    // console.log("Browser ini tidak mendukung notifikasi desktop");
                } else if (Notification.permission !== "denied") {
                    Notification.requestPermission().then(permission => {
                        if (permission === "granted") {
                            // console.log("Izin notifikasi diberikan!");
                        }
                    });
                }
            }

            // Ganti juga fungsi showDesktopNotification yang lama dengan ini
            function showDesktopNotification(title, options) {
                // console.log("Fungsi showDesktopNotification berhasil dipanggil.");

                if (Notification.permission !== "granted") {
                    // console.log("Kondisi 2: Izin notifikasi -> GAGAL. Status saat ini:", Notification.permission);
                    return;
                }
                // console.log("Kondisi 2: Izin notifikasi 'granted' -> TERPENUHI.");

                if (document.hidden) {
                    // console.log("Kondisi 3: Tab tidak aktif -> TERPENUHI. SEHARUSNYA NOTIFIKASI MUNCUL SEKARANG!");
                    const notification = new Notification(title, options);
                    notification.onclick = function() {
                        window.focus();
                        this.close();
                    };
                } else {
                    // console.log("Kondisi 3: Tab tidak aktif -> GAGAL. Halaman chat sedang Anda lihat.");
                }
            }
            // function showDesktopNotification(title, options) {
            //     if (Notification.permission !== "granted") {
            //         return; // Jangan tampilkan jika belum diizinkan
            //     }
            //     // Hanya tampilkan notifikasi jika tab chat tidak sedang aktif
            //     if (document.hidden) {
            //         const notification = new Notification(title, options);
            //         notification.onclick = function() {
            //             window.focus();
            //             this.close();
            //         };
            //     }
            // }

            // --- FUNGSI-FUNGSI UTAMA LAINNYA ---
            function scrollToBottom(isInstant = false) {
                const chatBody = $('#chat-body');
                const duration = isInstant ? 0 : 500;
                chatBody.animate({
                    scrollTop: chatBody[0].scrollHeight
                }, duration);
            }

            function formatDateSeparator(dateString) {
                const today = new Date();
                const yesterday = new Date();
                yesterday.setDate(yesterday.getDate() - 1);
                const messageDate = new Date(dateString);
                today.setHours(0, 0, 0, 0);
                yesterday.setHours(0, 0, 0, 0);
                messageDate.setHours(0, 0, 0, 0);
                if (messageDate.getTime() === today.getTime()) return 'Hari Ini';
                if (messageDate.getTime() === yesterday.getTime()) return 'Kemarin';
                return messageDate.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }

            function appendMessage(msg) {
                const messageDate = new Date(msg.created_at || new Date());
                const messageDateString = messageDate.toISOString().split('T')[0];
                if (messageDateString !== lastDisplayedDate) {
                    const formattedDate = formatDateSeparator(messageDate);
                    $('#chat-body').append(`<div class="date-separator"><span>${formattedDate}</span></div>`);
                    lastDisplayedDate = messageDateString;
                }
                const isSent = msg.sender_id == myId;
                let time = messageDate.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const justifyClass = isSent ? 'justify-end' : 'justify-start';
                const bubbleClass = isSent ? 'bg-zenith-accent-dark text-white rounded-br-none' : 'bg-zenith-medium text-slate-200 rounded-bl-none';
                const senderNameHtml = !isSent ? `<p class="text-xs text-zenith-accent font-semibold mb-1 ml-2">${msg.nama_user || '...'}</p>` : '';
                let quotedMessageHtml = '';
                if (msg.reply_to && msg.reply_to.message) {
                    quotedMessageHtml = `<a href="#message-${msg.reply_to.id}" class="quoted-message block"><p class="font-semibold text-zenith-accent">${msg.reply_to.nama_user}</p><p class="text-slate-300">${msg.reply_to.message}</p></a>`;
                }
                const replyButtonHtml = `<button class="reply-btn"><i class="fas fa-reply"></i></button>`;
                const html = `<div class="message-container" id="message-${msg.id}" data-message='${JSON.stringify(msg)}'>${senderNameHtml}<div class="flex ${justifyClass}"><div class="max-w-xl ${bubbleClass} rounded-2xl py-2 px-4 shadow-lg message-bubble">${quotedMessageHtml}<p style="word-wrap: break-word;">${msg.message}</p><span class="block text-xs text-slate-300 text-right mt-1">${time}</span>${replyButtonHtml}</div></div></div>`;
                $(html).appendTo('#chat-body').addClass('message-enter');
            }

            function loadMessages() {
                $.get(`${baseUrl}chat/get_ccs_messages/${ccsId}`, function(data) {
                    const messages = JSON.parse(data);
                    lastDisplayedDate = null;
                    $('#chat-body').empty();
                    messages.forEach(msg => appendMessage(msg));
                    setTimeout(() => scrollToBottom(true), 100);
                });
            }

            function setReplyMode(msg) {
                replyingToMessage = msg;
                $('#reply-to-name').text(msg.nama_user);
                $('#reply-to-text').text(msg.message);
                $('#replying-to-banner').slideDown(200);
                $('#message-input').focus();
            }

            function cancelReplyMode() {
                replyingToMessage = null;
                $('#replying-to-banner').slideUp(200);
            }

            // --- EVENT HANDLERS ---
            $('#send-message-form').on('submit', function(e) {
                e.preventDefault();
                const messageText = $('#message-input').val();
                if (messageText.trim() === '') return;
                const messageData = {
                    id: `temp-${Date.now()}`,
                    sender_id: myId,
                    nama_user: myName,
                    message: messageText,
                    created_at: new Date().toISOString(),
                    reply_to: replyingToMessage
                };
                appendMessage(messageData);
                scrollToBottom();
                $('#message-input').val('');
                $.post(`${baseUrl}chat/send_ccs_message`, {
                    tiket_id: ccsId,
                    message: messageText,
                    reply_to_id: replyingToMessage ? replyingToMessage.id : null
                });
                cancelReplyMode();
            });

            $('#chat-body').on('click', '.reply-btn', function() {
                const messageContainer = $(this).closest('.message-container');
                const messageData = messageContainer.data('message');
                setReplyMode(messageData);
            });

            $('#cancel-reply-btn').on('click', cancelReplyMode);

            $('#chat-body').on('click', '.quoted-message', function(e) {
                e.preventDefault();
                const targetId = $(this).attr('href');
                const targetElement = $(targetId);
                if (targetElement.length) {
                    $('#chat-body').animate({
                        scrollTop: $('#chat-body').scrollTop() + targetElement.offset().top - 100
                    }, 500);
                    targetElement.addClass('bg-zenith-medium').delay(1000).queue(function(next) {
                        $(this).removeClass('bg-zenith-medium');
                        next();
                    });
                }
            });

            // --- INISIALISASI ---
            loadMessages();
            requestNotificationPermission(); // Minta izin notifikasi saat halaman dimuat
        });
    </script> -->
</body>

</html>