<x-app-layout>
    <div class="bg-gray-100 min-h-screen flex flex-col" style="height: calc(100vh - 64px);">
        
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm z-10 shrink-0">
            <div class="flex items-center gap-4">
                @php
                    $backUrl = Auth::user()->role == 'guru' ? route('courses.show', $course->id) : route('student.corridor', $course->id);
                @endphp
                <a href="{{ $backUrl }}" class="p-2 bg-gray-50 text-gray-500 hover:bg-teal-50 hover:text-teal-600 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        Forum Diskusi
                        <span class="bg-teal-100 text-teal-700 text-xs px-2 py-0.5 rounded-full flex items-center">
                            <span class="w-2 h-2 rounded-full bg-teal-500 mr-1 animate-pulse"></span> Live
                        </span>
                    </h1>
                    <p class="text-sm text-gray-500">Kelas: {{ $course->title }}</p>
                </div>
            </div>
        </div>

        <div id="chatBox" class="flex-1 overflow-y-auto p-6 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] custom-scrollbar">
            <div id="chatMessages">
                @include('forum.partials.messages')
            </div>
        </div>

        <div class="bg-white border-t border-gray-200 p-4 shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
            <form id="chatForm" action="{{ route('forum.store', $course->id) }}" method="POST" class="max-w-7xl mx-auto flex gap-3">
                @csrf
                <textarea id="messageInput" name="message" rows="1" class="flex-1 bg-gray-50 border-gray-200 rounded-full px-6 py-3 text-sm focus:ring-teal-500 focus:border-teal-500 resize-none shadow-inner custom-scrollbar" placeholder="Ketik pesan Anda di sini..." required autocomplete="off"></textarea>
                <button type="submit" id="btnSend" class="bg-teal-600 text-white rounded-full h-12 w-12 flex items-center justify-center hover:bg-teal-700 transition shadow-md shrink-0 transform hover:scale-105">
                    <svg class="w-5 h-5 -ml-1 mr-1 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/></svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chatBox');
            const chatMessages = document.getElementById('chatMessages');
            const chatForm = document.getElementById('chatForm');
            const messageInput = document.getElementById('messageInput');
            const btnSend = document.getElementById('btnSend');

            // Fungsi untuk scroll ke paling bawah
            function scrollToBottom() {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
            
            // Scroll ke bawah saat pertama kali dibuka
            scrollToBottom();

            // 1. FUNGSI AUTO REFRESH (Ambil Pesan Setiap 3 Detik)
            function fetchMessages() {
                fetch("{{ route('forum.fetch_messages', $course->id) }}")
                    .then(response => response.text())
                    .then(html => {
                        // Cek apakah user sedang scroll ke atas (kalau iya, jangan paksa turun saat ada pesan baru)
                        let isScrolledToBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 50;
                        
                        chatMessages.innerHTML = html; // Timpa pesan dengan yang baru
                        
                        if (isScrolledToBottom) {
                            scrollToBottom();
                        }
                    })
                    .catch(error => console.error('Error fetching messages:', error));
            }

            // Jalankan Auto-Refresh setiap 3000ms (3 Detik)
            setInterval(fetchMessages, 3000);

            // 2. FUNGSI KIRIM PESAN TANPA RELOAD (AJAX SUBMIT)
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah form melakukan refresh halaman
                
                let formData = new FormData(chatForm);
                btnSend.disabled = true; // Matikan tombol sementara

                fetch("{{ route('forum.store', $course->id) }}", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if(response.ok) {
                        messageInput.value = ''; // Kosongkan input
                        fetchMessages(); // Panggil fungsi refresh langsung untuk melihat pesan sendiri
                        setTimeout(scrollToBottom, 100); // Pastikan layar turun
                    }
                })
                .finally(() => {
                    btnSend.disabled = false; // Nyalakan tombol lagi
                    messageInput.focus();
                });
            });

            // Tekan Enter untuk mengirim (Shift+Enter untuk baris baru)
            messageInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (this.value.trim() !== "") {
                        chatForm.dispatchEvent(new Event('submit'));
                    }
                }
            });
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</x-app-layout>