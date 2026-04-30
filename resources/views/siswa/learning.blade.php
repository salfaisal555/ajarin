<x-app-layout>
    <div class="flex flex-col lg:flex-row h-screen bg-gray-100 overflow-hidden">
        
        <div class="w-full lg:w-80 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col h-full z-20">
            <div class="p-4 border-b border-gray-200 bg-teal-600 text-white">
                <a href="{{ route('student.dashboard') }}" class="text-xs font-bold text-teal-100 hover:text-white flex items-center mb-2 transition">
                    &larr; Kembali ke Dashboard
                </a>
                <h2 class="font-bold text-lg leading-tight">{{ $course->title }}</h2>
                
                @php
                    $totalMats = $course->chapters->sum(fn($c) => $c->materials->count());
                    $doneMats = count($completedMaterialIds);
                    $percent = $totalMats > 0 ? ($doneMats / $totalMats) * 100 : 0;
                @endphp
            
                <div class="mt-3 w-full bg-teal-800 rounded-full h-1.5">
                    <div id="progressBar" class="bg-yellow-400 h-1.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                </div>
                <p id="progressText" class="text-[10px] mt-1 text-teal-200 text-right">{{ round($percent) }}% Selesai</p>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-6 custom-scrollbar bg-white">
                @php 
                    $isLocked = false; 
                @endphp 
                
                @foreach($course->chapters as $chapter)
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 sticky top-0 bg-white py-1 z-10">
                            {{ $chapter->title }}
                        </h3>
                        <div class="space-y-1">
                            @foreach ($chapter->materials as $material)
                                @php
                                    $isCompleted = in_array($material->id, $completedMaterialIds);
                                    $isActive = $currentMaterial && $currentMaterial->id == $material->id;
                                    
                                    $renderLock = $isLocked && !$isCompleted && !$isActive;
                                @endphp

                                @if($renderLock)
                                    <div class="flex items-center p-3 rounded-lg text-sm text-gray-400 bg-gray-50 border border-transparent cursor-not-allowed select-none opacity-60">
                                        <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        <span class="line-clamp-2 text-xs">{{ $material->title }}</span>
                                    </div>
                                @else
                                    <a href="{{ route('student.learning', ['course' => $course->id, 'material' => $material->id]) }}" 
                                       class="flex items-center p-3 rounded-lg text-sm transition-all duration-200 group
                                              {{ $isActive ? 'bg-teal-50 text-teal-800 border border-teal-200 font-bold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }}">
                                        
                                        <span class="mr-3 flex-shrink-0">
                                            @if($isCompleted)
                                                <div class="bg-green-100 text-green-600 rounded-full p-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                                            @elseif($isActive)
                                                <span class="relative flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-teal-500"></span></span>
                                            @else
                                                <div class="w-3 h-3 rounded-full border-2 border-gray-300 group-hover:border-gray-400"></div>
                                            @endif
                                        </span>
                                        <span class="line-clamp-2 {{ $isActive ? 'text-sm' : 'text-xs' }}">{{ $material->title }}</span>
                                    </a>
                                @endif

                                @php
                                    if (!$isCompleted) {
                                        $isLocked = true;
                                    }
                                @endphp
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="h-20"></div>
            </div>
        </div>

        <div class="flex-1 flex flex-col h-full overflow-hidden bg-gray-50 relative">
            @if($currentMaterial)
                <div id="contentContainer" class="flex-1 overflow-y-auto scroll-smooth">
                    <div class="max-w-4xl mx-auto min-h-full flex flex-col">
                        
                        <div class="pt-8 px-6 lg:px-12 pb-4">
                            
                            <nav class="flex text-sm font-medium text-gray-500 mb-6" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center hover:text-teal-600 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            Kelas Saya
                                        </a>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            <a href="{{ route('student.corridor', $course->id) }}" class="hover:text-teal-600 transition-colors line-clamp-1 max-w-[120px] sm:max-w-xs">
                                                {{ $course->title }}
                                            </a>
                                        </div>
                                    </li>
                                    <li aria-current="page">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            <span class="text-teal-700 font-bold">Materi Belajar</span>
                                        </div>
                                    </li>
                                </ol>
                            </nav>
                            <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $currentMaterial->title }}</h1>
                            <div class="mt-2 flex items-center text-sm text-gray-500 gap-4">
                                <span class="bg-gray-200 px-2 py-0.5 rounded text-xs uppercase font-bold tracking-wide">Materi</span>
                            </div>
                        </div>
                        
                        <hr class="border-gray-200 mx-6 lg:mx-12">
                        
                        <div class="px-6 lg:px-12 py-8">
                            <article class="prose prose-lg prose-teal max-w-none text-gray-700 leading-relaxed break-words">
                                {!! clean($currentMaterial->content) !!}
                            </article>
                        </div>
                        <div class="h-40 w-full bg-transparent"></div>
                    </div>
                </div>

                <div class="bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-30 absolute bottom-0 w-full">
                    <div class="max-w-4xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
                        <span id="statusText" class="text-sm italic text-gray-500 order-2 sm:order-1 flex items-center">
                            @if(in_array($currentMaterial->id, $completedMaterialIds))
                                <span class="text-green-600 font-bold">✓ Materi Selesai</span>
                            @else
                                <span class="animate-pulse">Scroll ke bawah untuk lanjut...</span>
                            @endif
                        </span>

                        <div class="order-1 sm:order-2 w-full sm:w-auto">
                            @php
                                $nextUrl = $nextMaterial 
                                    ? route('student.learning', ['course' => $course->id, 'material' => $nextMaterial->id])
                                    : route('student.dashboard');
                            @endphp

                            <button id="btnNext" 
                                    onclick="finishAndNext('{{ $nextUrl }}')"
                                    class="block w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-white transition-all shadow-lg transform active:scale-95 text-center border-b-4
                                    {{ in_array($currentMaterial->id, $completedMaterialIds) 
                                       ? 'bg-teal-600 hover:bg-teal-700 border-teal-800' 
                                       : 'bg-gray-300 border-gray-400 cursor-not-allowed opacity-70' }}"
                                    {{ in_array($currentMaterial->id, $completedMaterialIds) ? '' : 'disabled' }}>
                                
                                @if($nextMaterial)
                                    Lanjut Materi Berikutnya &rarr;
                                @else
                                    🎉 Selesai Kelas
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('contentContainer');
            const btnNext = document.getElementById('btnNext');
            const statusText = document.getElementById('statusText');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            const totalMaterials = {{ $totalMats }};
            let doneMaterials = {{ $doneMats }};
            let isAlreadyCompleted = {{ in_array($currentMaterial->id ?? 0, $completedMaterialIds) ? 'true' : 'false' }};
            const materialId = "{{ $currentMaterial->id ?? '' }}";

            async function saveProgress() {
                try {
                    const response = await fetch(`{{ url('/progress/complete') }}/${materialId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    });
                    const data = await response.json();
                    if(data.status === 'error') {
                        alert('Gagal menyimpan progress: ' + data.message);
                        return false;
                    }
                    return true;
                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan koneksi saat menyimpan progress.');
                    return false;
                }
            }

            window.markAsComplete = function() {
                if (isAlreadyCompleted) return;

                isAlreadyCompleted = true;
                btnNext.disabled = false;
                btnNext.classList.remove('bg-gray-300', 'border-gray-400', 'cursor-not-allowed', 'opacity-70');
                btnNext.classList.add('bg-teal-600', 'hover:bg-teal-700', 'border-teal-800');
                statusText.innerHTML = "<span class='text-green-600 font-bold'>✓ Selesai! Klik Lanjut</span>";

                doneMaterials++;
                let newPercent = (doneMaterials / totalMaterials) * 100;
                if(progressBar) progressBar.style.width = newPercent + "%";
                if(progressText) progressText.innerText = Math.round(newPercent) + "% Selesai";

                saveProgress();
            }

            window.finishAndNext = async function(url) {
                btnNext.innerText = "Menyimpan...";
                btnNext.disabled = true;

                const success = await saveProgress();
                
                if (success) {
                    window.location.href = url;
                } else {
                    btnNext.innerText = "Coba Lagi";
                    btnNext.disabled = false;
                }
            }

            if (container && materialId && !isAlreadyCompleted) {
                if (container.scrollHeight <= container.clientHeight) {
                    markAsComplete();
                }
                container.addEventListener('scroll', function() {
                    if (container.scrollTop + container.clientHeight >= container.scrollHeight - 50) {
                        markAsComplete();
                    }
                        });
            }
        });
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .prose img { border-radius: 0.75rem; margin: 0 auto; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .prose iframe { width: 100%; aspect-ratio: 16/9; border-radius: 0.75rem; }
    </style>
</x-app-layout>