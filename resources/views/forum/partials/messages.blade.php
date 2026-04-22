<div class="text-center mb-6">
    <span class="bg-white border border-gray-200 text-gray-500 text-xs px-3 py-1 rounded-full font-medium shadow-sm">
        Forum dibuat pada {{ \Carbon\Carbon::parse($course->created_at)->format('d M Y') }}
    </span>
</div>

@forelse($messages as $msg)
    @php
        $isMe = $msg->user_id == Auth::id();
        $isTeacherMsg = $msg->user->id == $course->teacher_id;
    @endphp

    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} w-full mb-6">
        <div class="max-w-[75%] md:max-w-[60%] flex gap-3 {{ $isMe ? 'flex-row-reverse' : 'flex-row' }}">
            
            <div class="shrink-0 mt-auto">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm
                    {{ $isTeacherMsg ? 'bg-indigo-600' : ($isMe ? 'bg-teal-600' : 'bg-gray-400') }}">
                    {{ strtoupper(substr($msg->user->name, 0, 1)) }}
                </div>
            </div>

            <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-xs font-bold {{ $isTeacherMsg ? 'text-indigo-600' : 'text-gray-600' }}">
                        {{ $isMe ? 'Anda' : $msg->user->name }}
                    </span>
                    @if($isTeacherMsg)
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded font-black tracking-wider uppercase">Guru</span>
                    @endif
                    <span class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($msg->created_at)->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                </div>
                
                <div class="px-5 py-3 rounded-2xl text-sm md:text-base shadow-sm break-words
                    {{ $isMe ? 'bg-teal-600 text-white rounded-br-none' : 'bg-white border border-gray-100 text-gray-800 rounded-bl-none' }}">
                    {!! nl2br(e($msg->message)) !!}
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center text-gray-500 mt-10">
        <p>Belum ada diskusi. Jadilah yang pertama menyapa!</p>
    </div>
@endforelse