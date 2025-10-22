<x-user::app>
    <x-slot name="pageSlug">profile</x-slot>

    <div>
        User Profile
    </div>
    <a href="{{ route('two-factor.index') }}" class="underline hover:text-blue-400">
        Enable 2Factor Authentication

    </a>
</x-user::app>
