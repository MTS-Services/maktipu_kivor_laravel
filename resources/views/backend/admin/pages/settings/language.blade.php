<x-admin::app>
    <x-slot name="pageSlug">language</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.as.language.create')
            <x-slot name="breadcrumb">Application Settings > Language Create</x-slot>
            <x-slot name="title">Language Create</x-slot>
            <livewire:backend.admin.components.settings.language.create />
        @break

        @case('admin.as.language.edit')
            <x-slot name="breadcrumb">Application Settings > Language Edit</x-slot>
            <x-slot name="title">Language Edit</x-slot>
            <livewire:backend.admin.components.settings.language.edit :language="$language"/>
        @break

        @case('admin.as.language.trash')
            <x-slot name="breadcrumb">Application Settings > Language Trash</x-slot>
            <x-slot name="title">Language Trash</x-slot>
            <livewire:backend.admin.components.settings.language.trash />
        @break

        @case('admin.as.language.view')
            <x-slot name="breadcrumb">Application Settings > Language Details</x-slot>
            <x-slot name="title">Language Details</x-slot>
            <livewire:backend.admin.components.settings.language.view :language="$language"/>
        @break

        @default
            <x-slot name="breadcrumb">Application Settings > Language List</x-slot>
            <x-slot name="title">Language List</x-slot>
            <livewire:backend.admin.components.settings.language.index />
    @endswitch

</x-admin::app>
