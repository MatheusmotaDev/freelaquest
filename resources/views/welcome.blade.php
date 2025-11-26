<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FreelaQuest - O RPG do Freelancer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-900 text-gray-100 font-sans selection:bg-arcane selection:text-white overflow-x-hidden">
        
        <!-- BACKGROUND DECORATIVO (Nebulosa) -->
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-arcane/20 rounded-full blur-[100px] opacity-50"></div>
            <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-mystic/20 rounded-full blur-[100px] opacity-50"></div>
        </div>

        <!-- NAVBAR -->
        <nav class="relative z-50 px-6 py-6 flex justify-between items-center max-w-7xl mx-auto">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <x-application-logo class="h-12 w-auto fill-current text-white" />
                <span class="text-2xl font-extrabold tracking-tighter">
                    FREELA<span class="text-arcane">QUEST</span>
                </span>
            </div>

            <!-- Links de Auth -->
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:text-arcane transition border border-gray-700 bg-gray-800/50 px-4 py-2 rounded-lg">Voltar ao Jogo</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-300 hover:text-white transition px-4 py-2">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-arcane/30 transition transform hover:-translate-y-1">
                                Criar Conta
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- HERO SECTION -->
        <main class="relative z-10">
            <div class="max-w-7xl mx-auto px-6 pt-16 pb-24 text-center lg:pt-24">
                
                <!-- Badge de Versão -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gray-800/80 border border-gray-700 text-sm text-gray-300 mb-8 backdrop-blur-sm">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    Sistema V1.0 Online
                </div>

                <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                    Transforme seus Freelas <br>
                    em uma <span class="text-transparent bg-clip-text bg-gradient-to-r from-arcane via-mystic to-purple-500">Aventura Épica</span>
                </h1>

                <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    O sistema definitivo para devs e criativos. Gerencie projetos, controle o financeiro e 
                    <strong class="text-white">suba de nível</strong> na vida real a cada conquista desbloqueada.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-20">
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-arcane to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-lg font-bold py-4 px-10 rounded-xl shadow-xl shadow-arcane/20 transition transform hover:scale-105 flex items-center justify-center gap-2">
                        <span>⚔️</span> Começar Missão
                    </a>
                    <a href="#features" class="bg-gray-800/80 hover:bg-gray-700 text-white text-lg font-bold py-4 px-10 rounded-xl border border-gray-700 transition backdrop-blur-sm">
                        Explorar Recursos
                    </a>
                </div>

                <!-- MOCKUP DO SISTEMA (Melhorado e Detalhado) -->
                <div class="relative max-w-6xl mx-auto perspective-1000 group">
                    <!-- Efeito de brilho atrás -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-arcane to-mystic rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    
                    <div class="relative bg-gray-900 border border-gray-700/50 rounded-xl shadow-2xl overflow-hidden">
                        <!-- Barra de Título do Browser Fake -->
                        <div class="bg-gray-800 border-b border-gray-700 p-3 flex items-center gap-2">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="flex-1 text-center">
                                <div class="bg-gray-900 rounded-md py-1 px-3 text-xs text-gray-500 inline-block w-64">freelaquest.app/dashboard</div>
                            </div>
                        </div>

                        <!-- Interface Simulada (CSS Only) -->
                        <div class="flex h-[500px] text-left">
                            <!-- Sidebar Fake -->
                            <div class="w-64 bg-gray-900 border-r border-gray-800 p-4 hidden md:block space-y-4">
                                <div class="h-8 w-32 bg-gray-800 rounded animate-pulse mb-8"></div>
                                <div class="space-y-2">
                                    <div class="h-10 w-full bg-gray-800/50 rounded flex items-center px-3"><div class="w-4 h-4 bg-arcane rounded mr-3"></div><div class="h-2 w-20 bg-gray-700 rounded"></div></div>
                                    <div class="h-10 w-full bg-transparent rounded flex items-center px-3"><div class="w-4 h-4 bg-gray-800 rounded mr-3"></div><div class="h-2 w-24 bg-gray-800 rounded"></div></div>
                                    <div class="h-10 w-full bg-transparent rounded flex items-center px-3"><div class="w-4 h-4 bg-gray-800 rounded mr-3"></div><div class="h-2 w-16 bg-gray-800 rounded"></div></div>
                                </div>
                            </div>

                            <!-- Conteúdo Principal Fake -->
                            <div class="flex-1 bg-gray-900 p-6 overflow-hidden relative">
                                <!-- Header Interno -->
                                <div class="flex justify-between items-center mb-8">
                                    <div class="h-6 w-48 bg-gray-800 rounded"></div>
                                    <div class="flex gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gray-800"></div>
                                        <div class="h-10 w-32 bg-arcane/20 rounded-full border border-arcane/30"></div>
                                    </div>
                                </div>

                                <!-- Cards de Status -->
                                <div class="grid grid-cols-3 gap-6 mb-8">
                                    <div class="h-32 bg-gray-800 rounded-xl border border-gray-700 p-4 flex flex-col justify-between">
                                        <div class="w-8 h-8 bg-arcane/20 rounded-lg"></div>
                                        <div class="space-y-2">
                                            <div class="h-2 w-20 bg-gray-700 rounded"></div>
                                            <div class="h-6 w-32 bg-gray-600 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="h-32 bg-gray-800 rounded-xl border border-gray-700 p-4 flex flex-col justify-between">
                                        <div class="w-8 h-8 bg-green-500/20 rounded-lg"></div>
                                        <div class="space-y-2">
                                            <div class="h-2 w-20 bg-gray-700 rounded"></div>
                                            <div class="h-6 w-24 bg-green-500/20 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="h-32 bg-gray-800 rounded-xl border border-gray-700 p-4 flex flex-col justify-between relative overflow-hidden">
                                        <!-- Barra de Progresso Fake -->
                                        <div class="absolute bottom-0 left-0 w-3/4 h-1 bg-purple-500"></div>
                                        <div class="w-8 h-8 bg-purple-500/20 rounded-lg"></div>
                                        <div class="space-y-2">
                                            <div class="h-2 w-24 bg-gray-700 rounded"></div>
                                            <div class="h-6 w-16 bg-gray-600 rounded"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabela Fake -->
                                <div class="bg-gray-800 rounded-xl border border-gray-700 p-4 h-full">
                                    <div class="h-4 w-32 bg-gray-700 rounded mb-6"></div>
                                    <div class="space-y-4">
                                        <div class="h-12 w-full bg-gray-700/30 rounded flex items-center px-4 justify-between">
                                            <div class="h-3 w-32 bg-gray-700 rounded"></div>
                                            <div class="h-3 w-16 bg-gray-700 rounded"></div>
                                        </div>
                                        <div class="h-12 w-full bg-gray-700/30 rounded flex items-center px-4 justify-between">
                                            <div class="h-3 w-40 bg-gray-700 rounded"></div>
                                            <div class="h-3 w-16 bg-green-500/20 rounded"></div>
                                        </div>
                                        <div class="h-12 w-full bg-gray-700/30 rounded flex items-center px-4 justify-between">
                                            <div class="h-3 w-24 bg-gray-700 rounded"></div>
                                            <div class="h-3 w-16 bg-red-500/20 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Overlay de "Real" -->
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FEATURES (Funcionalidades) -->
            <div id="features" class="bg-gray-800/30 py-24 border-y border-gray-800 backdrop-blur-sm">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold mb-4">Tudo o que você precisa para upar de nível</h2>
                        <p class="text-gray-400">Ferramentas poderosas escondidas em uma interface simples.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-gray-900 p-8 rounded-2xl border border-gray-800 hover:border-arcane/50 transition group hover:-translate-y-1 duration-300">
                            <div class="w-14 h-14 bg-arcane/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-arcane transition duration-300 shadow-[0_0_15px_rgba(88,101,242,0.2)]">
                                <span class="text-2xl">💰</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-white">Gestão Financeira</h3>
                            <p class="text-gray-400 leading-relaxed text-sm">
                                Controle entradas e saídas com gráficos automáticos. Crie orçamentos profissionais e converta em projetos com um clique.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-gray-900 p-8 rounded-2xl border border-gray-800 hover:border-mystic/50 transition group hover:-translate-y-1 duration-300">
                            <div class="w-14 h-14 bg-mystic/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-mystic transition duration-300 shadow-[0_0_15px_rgba(123,74,238,0.2)]">
                                <span class="text-2xl">🏆</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-white">Gamificação Real</h3>
                            <p class="text-gray-400 leading-relaxed text-sm">
                                Transforme trabalho em jogo. Ganhe XP por cada real faturado, suba no ranking global e desbloqueie conquistas raras.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-gray-900 p-8 rounded-2xl border border-gray-800 hover:border-green-500/50 transition group hover:-translate-y-1 duration-300">
                            <div class="w-14 h-14 bg-green-500/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-500 transition duration-300 shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                                <span class="text-2xl">📊</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-white">Skill Tree Analytics</h3>
                            <p class="text-gray-400 leading-relaxed text-sm">
                                Descubra onde está o dinheiro. Nosso sistema analisa quais habilidades (ex: Laravel, Design) geram mais lucro para você.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA FINAL -->
            <div class="py-24 text-center px-6 relative overflow-hidden">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-arcane/10 rounded-full blur-3xl -z-10"></div>
                
                <h2 class="text-4xl font-bold mb-6">Pronto para dominar o mercado?</h2>
                <p class="text-gray-400 mb-8 max-w-xl mx-auto">Junte-se a outros freelancers e comece a organizar sua carreira hoje mesmo. É grátis para começar.</p>
                <a href="{{ route('register') }}" class="inline-block bg-white text-gray-900 hover:bg-gray-200 font-bold py-4 px-12 rounded-full shadow-xl shadow-white/10 transition transform hover:scale-105 hover:-translate-y-1">
                    Criar Conta Grátis
                </a>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="border-t border-gray-800 bg-gray-950 pt-12 pb-8">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    
                    <!-- Brand -->
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-8 w-auto fill-current text-gray-600" />
                        <div>
                            <span class="font-bold text-gray-300 block">FreelaQuest</span>
                            <span class="text-xs text-gray-600">Sistema de RPG para Freelancers</span>
                        </div>
                    </div>

                    <!-- Social Links (Adicionados) -->
                    <div class="flex items-center gap-6">
                        <a href="https://github.com/MatheusmotaDev" target="_blank" class="text-gray-500 hover:text-white transition transform hover:scale-110" title="GitHub">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>

                        <a href="https://www.linkedin.com/in/matheusdevmota/" target="_blank" class="text-gray-500 hover:text-blue-500 transition transform hover:scale-110" title="LinkedIn">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center md:text-left flex flex-col md:flex-row justify-between text-xs text-gray-600">
                    <p>&copy; {{ date('Y') }} FreelaQuest. Desenvolvido por Matheus Mota.</p>
                    <p class="mt-2 md:mt-0">Feito com Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                </div>
            </div>
        </footer>
    </body>
</html>