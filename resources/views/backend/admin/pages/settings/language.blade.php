<x-admin::app>
    <x-slot name="pageSlug">language</x-slot>
    <x-slot name="breadcrumb">Language</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.language.create')
            <x-slot name="title">Language Create</x-slot>
            <livewire:backend.admin.components.settings.language.create />
        @break

        @case('admin.language.edit')
            <x-slot name="title">Language Create</x-slot>
            <livewire:backend.admin.components.settings.language.edit :language="$language"/>
        @break

        @case('admin.language.trash')
            <x-slot name="title">Language Create</x-slot>
            <livewire:backend.admin.components.settings.language.trash />
        @break

        @case('admin.language.view')
            <x-slot name="title">Language Create</x-slot>
            <livewire:backend.admin.components.settings.language.view :language="$language"/>
        @break

        @default
            <x-slot name="title">Language List</x-slot>
            <livewire:backend.admin.components.settings.language.index />
    @endswitch

</x-admin::app>
