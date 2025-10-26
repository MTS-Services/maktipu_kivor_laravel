<x-admin::app>
    <x-slot name="pageSlug">currency</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.as.currency.create')
            <x-slot name="breadcrumb">Application Settings > Currency Create</x-slot>
            <x-slot name="title">Currency Create</x-slot>
            <livewire:backend.admin.components.settings.currency.create />
        @break

        @case('admin.as.currency.edit')
            <x-slot name="breadcrumb">Application Settings > Currency Edit</x-slot>
            <x-slot name="title">Currency Edit</x-slot>
            <livewire:backend.admin.components.settings.currency.edit :data="$data"/>
        @break

        @case('admin.as.currency.trash')
            <x-slot name="breadcrumb">Application Settings > Currency Trash</x-slot>
            <x-slot name="title">Currency Trash</x-slot>
            <livewire:backend.admin.components.settings.currency.trash />
        @break

        @case('admin.as.currency.view')
            <x-slot name="breadcrumb">Application Settings > Currency Details</x-slot>
            <x-slot name="title">Currency Details</x-slot>
            <livewire:backend.admin.components.settings.currency.view :data="$data"/>
        @break

        @default
            <x-slot name="breadcrumb">Application Settings > Currency List</x-slot>
            <x-slot name="title">Currency List</x-slot>
            <livewire:backend.admin.components.settings.currency.index />
    @endswitch

</x-admin::app>
