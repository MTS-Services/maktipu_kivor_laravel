<x-admin::app>
    <x-slot name="pageSlug">admin</x-slot>
    <x-slot name="breadcrumb">Admin Management</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.am.admin.create')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.create />
        @break

        @case('admin.am.admin.edit')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.edit :admin="$admin"/>
        @break

        @case('admin.am.admin.trash')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.trash />
        @break

        @case('admin.am.admin.view')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.view :admin="$admin"/>
        @break

        @default
            <x-slot name="title">Admins List</x-slot>
            <livewire:backend.admin.components.admin-management.admin.index />
    @endswitch

</x-admin::app>
