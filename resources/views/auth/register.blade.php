<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Cabeçalho do Form -->
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Começar Nova Aventura</h2>
            <p class="text-sm text-gray-400 mt-1">Crie sua conta para gerenciar seus freelas.</p>
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-300">Nome de Herói</label>
            <input id="name" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-600 transition" 
                   type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Seu Nome" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-600 transition" 
                   type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-300">Senha</label>
            <input id="password" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-600 transition"
                   type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-300">Confirmar Senha</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-600 transition"
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="underline text-sm text-gray-400 hover:text-indigo-400 transition rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Já tem conta?') }}
            </a>

            <button type="submit" class="ms-4 px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-lg shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Cadastrar') }}
            </button>
        </div>
    </form>
</x-guest-layout>