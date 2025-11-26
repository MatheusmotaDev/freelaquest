<nav x-data="{ open: false }" class="sticky top-4 z-50 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-8">
    
    <!-- Ilha Flutuante (Glassmorphism) -->
    <div class="bg-gray-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl shadow-black/50 relative overflow-visible">
        
        <!-- Brilho no topo -->
        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-50"></div>

        <div class="px-4 sm:px-6">
            <div class="flex justify-between h-16">
                
                <!-- LADO ESQUERDO: Logo + Links -->
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
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
                    <div class="hidden space-x-1 xl:space-x-2 sm:-my-px sm:ml-6 lg:ml-10 sm:flex items-center">
                        
                        @php
                            $navClasses = 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out gap-2';
                            // Ativo: Texto Roxo/Azul brilhante
                            $activeClasses = 'bg-white/10 text-arcane border border-arcane/30 shadow-[0_0_15px_rgba(88,101,242,0.2)]';
                            // Inativo: Texto Branco/Cinza claro
                            $inactiveClasses = 'text-gray-300 hover:text-white hover:bg-white/10 border border-transparent';
                        @endphp

                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="{{ $navClasses }} {{ request()->routeIs('dashboard') ? $activeClasses : $inactiveClasses }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span class="hidden lg:inline">Painel</span>
                        </a>

                        <!-- Projetos -->
                        <a href="{{ route('projects.index') }}" class="{{ $navClasses }} {{ request()->routeIs('projects.*') ? $activeClasses : $inactiveClasses }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span class="hidden lg:inline">Projetos</span>
                        </a>

                        <!-- Clientes -->
                        <a href="{{ route('clients.index') }}" class="{{ $navClasses }} {{ request()->routeIs('clients.*') ? $activeClasses : $inactiveClasses }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="hidden lg:inline">Clientes</span>
                        </a>

                        <!-- Orçamentos -->
                        <a href="{{ route('quotes.index') }}" class="{{ $navClasses }} {{ request()->routeIs('quotes.*') ? $activeClasses : $inactiveClasses }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="hidden lg:inline">Orçamentos</span>
                        </a>
                        
                        <!-- Conquistas -->
                        <a href="{{ route('badges.index') }}" class="{{ $navClasses }} {{ request()->routeIs('badges.index') ? $activeClasses : $inactiveClasses }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            <span class="hidden lg:inline">Conquistas</span>
                        </a>

                        <!-- Analytics -->
                        <a href="{{ route('analytics.index') }}" class="{{ $navClasses }} {{ request()->routeIs('analytics.index') ? $activeClasses : $inactiveClasses }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            <span class="hidden lg:inline">Analytics</span>
                        </a>
                    </div>
                </div>

                <!-- LADO DIREITO: Perfil (Dropdown) -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 px-3 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 transition focus:outline-none focus:ring-2 focus:ring-arcane/50 cursor-pointer group">
                                
                                <!-- Nome e Nível (Texto Branco) -->
                                <div class="text-right hidden md:block">
                                    <div class="text-sm font-bold text-white leading-none group-hover:text-arcane transition">
                                        {{ explode(' ', Auth::user()->name)[0] }} <!-- Pega só o primeiro nome -->
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-medium leading-none mt-1">
                                        Nível {{ Auth::user()->current_level }}
                                    </div>
                                </div>

                                <!-- Avatar -->
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

                                <!-- Authentication -->
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

        <!-- Responsive Menu (Mobile) -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-700 bg-gray-900/95 backdrop-blur-xl rounded-b-2xl">
            <div class="pt-2 pb-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Projetos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Clientes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('quotes.index')" :active="request()->routeIs('quotes.*')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Orçamentos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('badges.index')" :active="request()->routeIs('badges.index')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Conquistas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.index')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Analytics') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings -->
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