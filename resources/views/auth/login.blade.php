<x-guest-layout>
    <!-- Status da Sessão -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Cabeçalho do Form -->
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Bem-vindo de volta!</h2>
            <p class="text-sm text-gray-400 mt-1">Faça login para continuar sua jornada.</p>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-600 transition" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-300">Senha</label>
            <input id="password" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-600 transition"
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-600 bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-400 hover:text-gray-300 transition">{{ __('Lembrar de mim') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-400 hover:text-indigo-400 transition rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Esqueceu a senha?') }}
                </a>
            @endif

            <button type="submit" class="ms-3 px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-lg shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Entrar') }}
            </button>
        </div>
        
        <!-- Link para Cadastro -->
        <div class="mt-8 pt-6 border-t border-gray-700 text-center">
            <p class="text-sm text-gray-400">
                Ainda não tem conta? 
                <a href="{{ route('register') }}" class="text-indigo-400 font-bold hover:text-indigo-300 hover:underline transition">Criar Missão</a>
            </p>
        </div>
    </form>
</x-guest-layout>