<nav x-data="{ open: false }" class="sticky top-4 z-50 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-8">
    
    <!-- Ilha Flutuante (Glassmorphism) -->
    <div class="bg-gray-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl shadow-black/50 relative overflow-visible">
        
        <!-- Brilho no topo -->
        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-50"></div>

        <div class="px-4 sm:px-6">
            <div class="flex justify-between h-16">
                
                <!-- LADO ESQUERDO: Logo + Menus -->
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center mr-6">
                        <a href="{{ route('dashboard') }}" class="group flex items-center gap-2">
                            <div class="transition-transform group-hover:scale-110 duration-300">
                                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                            </div>
                            <span class="font-bold text-lg tracking-tight text-white hidden md:block">
                                FREELA<span class="text-arcane">QUEST</span>
                            </span>
                        </a>
                    </div>

                    <!-- Links de Navegação (Desktop) -->
                    <div class="hidden sm:flex items-center gap-1">
                        
                        <!-- 1. DASHBOARD (Link Direto) -->
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out flex items-center gap-2 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-arcane border border-arcane/30' : 'text-gray-300 hover:text-white hover:bg-white/5 border border-transparent' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Painel
                        </a>

                        <!-- 2. GESTÃO (Dropdown) -->
                        <div class="relative" x-data="{ openGestao: false }">
                            <button @click="openGestao = !openGestao" @click.outside="openGestao = false" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 border border-transparent transition flex items-center gap-1">
                                <span>📂 Gestão</span>
                                <svg class="w-3 h-3 ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="openGestao" x-transition class="absolute left-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-xl shadow-xl z-50 overflow-hidden" style="display: none;">
                                <a href="{{ route('projects.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition">🚀 Projetos</a>
                                <a href="{{ route('clients.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition">👥 Clientes</a>
                                <a href="{{ route('quotes.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition">📄 Orçamentos</a>
                            </div>
                        </div>

                        <!-- 3. CARREIRA (Dropdown) -->
                        <div class="relative" x-data="{ openCarreira: false }">
                            <button @click="openCarreira = !openCarreira" @click.outside="openCarreira = false" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 border border-transparent transition flex items-center gap-1">
                                <span>🏆 Carreira</span>
                                <svg class="w-3 h-3 ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="openCarreira" x-transition class="absolute left-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-xl shadow-xl z-50 overflow-hidden" style="display: none;">
                                <a href="{{ route('badges.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition">🏅 Conquistas</a>
                                <a href="{{ route('analytics.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition">📊 Analytics</a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- LADO DIREITO: Avisos + Perfil -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 gap-3">
                    
                    <!-- Ícone de Avisos (Sino) -->
                    <a href="{{ route('announcements.index') }}" class="relative p-2 text-gray-400 hover:text-white transition rounded-full hover:bg-white/10 group" title="Avisos do Sistema">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <!-- Bolinha Vermelha (Decorativa por enquanto) -->
                        <span class="absolute top-2 right-2 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-gray-900"></span>
                    </a>

                    <!-- Dropdown de Perfil -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 px-3 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 transition focus:outline-none focus:ring-2 focus:ring-arcane/50 cursor-pointer group">
                                
                                <div class="text-right hidden md:block">
                                    <div class="text-sm font-bold text-white leading-none group-hover:text-arcane transition">
                                        {{ explode(' ', Auth::user()->name)[0] }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-medium leading-none mt-1">
                                        Nível {{ Auth::user()->current_level }}
                                    </div>
                                </div>

                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-arcane to-mystic p-[2px] shadow-lg shadow-arcane/20">
                                    <div class="w-full h-full rounded-full bg-gray-900 flex items-center justify-center text-white text-sm font-bold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                </div>

                                <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-gray-800 border border-gray-700 rounded-md overflow-hidden">
                                <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-gray-700 hover:text-white">
                                    {{ __('👤 Perfil') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="text-red-400 hover:bg-red-900/20 hover:text-red-300"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('🚪 Sair') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger (Mobile) -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Mobile (Lista Plana para facilitar) -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-700 bg-gray-900/95 backdrop-blur-xl rounded-b-2xl">
            <div class="pt-2 pb-3 space-y-1 px-2">
                <!-- Dashboard -->
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Painel') }}
                </x-responsive-nav-link>
                
                <!-- Gestão -->
                <div class="px-4 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider">Gestão</div>
                <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" class="text-gray-300 hover:text-white hover:bg-white/10 ml-2">
                    {{ __('Projetos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" class="text-gray-300 hover:text-white hover:bg-white/10 ml-2">
                    {{ __('Clientes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('quotes.index')" :active="request()->routeIs('quotes.*')" class="text-gray-300 hover:text-white hover:bg-white/10 ml-2">
                    {{ __('Orçamentos') }}
                </x-responsive-nav-link>

                <!-- Carreira -->
                <div class="px-4 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider mt-2">Carreira</div>
                <x-responsive-nav-link :href="route('badges.index')" :active="request()->routeIs('badges.index')" class="text-gray-300 hover:text-white hover:bg-white/10 ml-2">
                    {{ __('Conquistas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.index')" class="text-gray-300 hover:text-white hover:bg-white/10 ml-2">
                    {{ __('Analytics') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.*')" class="text-gray-300 hover:text-white hover:bg-white/10 ml-2">
                    {{ __('Avisos') }}
                </x-responsive-nav-link>
            </div>

            <!-- Perfil Mobile -->
            <div class="pt-4 pb-4 border-t border-gray-800">
                <div class="px-4 flex items-center gap-3">
                     <div class="w-10 h-10 rounded-full bg-mystic flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" class="text-red-400 hover:text-red-300"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Sair') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>