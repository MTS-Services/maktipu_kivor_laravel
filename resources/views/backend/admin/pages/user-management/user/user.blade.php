<x-admin::app>
    <x-slot name="pageSlug">admin-users</x-slot>


    @switch(Route::currentRouteName())
        @case('admin.um.user.create')
            <x-slot name="title">User Create</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.create />
        @break

        @case('admin.um.user.edit')
            <x-slot name="title">User Edit</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.edit :user="$user" />
        @break

        @case('admin.um.user.view')
            <x-slot name="title">User View</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.view :user="$user" />
        @break

        @case('admin.um.user.trash')
            <x-slot name="title">User Trash</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.trash />
        @break

        @default
            <x-slot name="breadcrumb">User Management / List</x-slot>
            <x-slot name="title">User List</x-slot>
            <livewire:backend.admin.components.user-management.user.index />
    @endswitch

</x-admin::app>
