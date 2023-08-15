@if ( auth()->user()->id_rol == 1)
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div> 

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirma contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="id_rol" :value="__('Rol asignado')" />
            <x-adminlte-select id="id_rol" name="id_rol" required>
                <option value="1" >Administrador</option>
                <option value="2">Regulador</option>
                <option value="3">Jefe de reguladores</option>
            </x-adminlte-select>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@else
    <x-guest-layout>
        <div class="flex items-center mt-">
            <p class="text text-gray-100 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" >
                {{ __('No tienes acceso') }}
            </p>
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="text text-gray-100 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="/home">
                {{ __('Regresar') }}
            </a>
        </div>
    </x-guest-layout>
@endif
