<nav x-data="{ open: false }" class="bg-gradient-to-r from-teal-500 to-cyan-600 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-white tracking-wide">Ajarin</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:ml-10 md:flex">
                    
                    
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('users.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200
                                  {{ request()->routeIs('users.*') ? 'bg-white/20 text-white' : 'text-white/90 hover:bg-white/10 hover:text-white' }}">
                            Kelola Akun
                        </a>
                        
                        <a href="{{ route('courses.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white/50 cursor-not-allowed"
                           title="Segera Hadir">
                            Katalog Kelas
                        </a>

                        <a href="#" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white/50 cursor-not-allowed"
                           title="Segera Hadir">
                            Monitoring
                        </a>
    @endif

                    @if(Auth::user()->role == 'guru')
                <a href="{{ route('courses.index') }}" class="block px-4 py-3 rounded-lg text-white font-medium
                          {{ request()->routeIs('courses.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    Kelas Saya
                </a>
                @endif

                @if(Auth::user()->role == 'siswa')
    <a href="{{ route('student.dashboard') }}" class="block px-4 py-3 rounded-lg text-white font-medium
                          {{ request()->routeIs('courses.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
        My Course
    </a>
    <a href="{{ route('student.catalog') }}" class="block px-4 py-3 rounded-lg text-white font-medium
                          {{ request()->routeIs('courses.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
        Katalog Kelas
    </a>
    @endif

                </div>
            </div>

            <!-- Right Side - User Profile -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 text-white">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ __('Profil') }}
                            </div>
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <div class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    {{ __('Log Out') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center md:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg text-white hover:bg-white/10 transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-white/20">
        <div class="pt-2 pb-3 space-y-1 px-4">
            
            @if(Auth::user()->role == 'admin')
                <a href="{{ route('users.index') }}" 
                   class="block px-4 py-3 rounded-lg text-white font-medium
                          {{ request()->routeIs('users.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    Kelola Akun
                </a>

                <a href="{{ route('courses.index') }}" class="block px-4 py-3 rounded-lg text-white/50 cursor-not-allowed">
                    Katalog Kelas (Segera Hadir)
                </a>
                
                <a href="#" class="block px-4 py-3 rounded-lg text-white/50 cursor-not-allowed">
                    Monitoring (Segera Hadir)
                </a>
            @endif

            @if(Auth::user()->role == 'guru')
                <a href="{{ route('courses.index') }}" class="block px-4 py-3 rounded-lg text-white font-medium
                          {{ request()->routeIs('courses.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    Kelas Saya
                </a>
                @endif
        </div>

        <!-- Responsive User Info -->
        <div class="pt-4 pb-3 border-t border-white/20">
            <div class="px-4 mb-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-white/70">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-1 px-4">
                <a href="{{ route('profile.edit') }}" 
                   class="block px-4 py-3 rounded-lg text-white hover:bg-white/10 font-medium">
                    Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left px-4 py-3 rounded-lg text-red-300 hover:bg-white/10 font-medium">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>