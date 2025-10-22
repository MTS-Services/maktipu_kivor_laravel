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

        @case('admin.um.user.profileInfo')
            <x-slot name="title">Profile Info</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.profile.persona-info :user="$user" />
        @break

        @case('admin.um.user.shopInfo')
            <x-slot name="title">Shop Info</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.profile.shop-info :user="$user" />
        @break

        @case('admin.um.user.kycInfo')
            <x-slot name="title">KYC Info</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.profile.kyc-info :user="$user" />
        @break

        @case('admin.um.user.statistic')
            <x-slot name="title">Statistic Info</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.profile.statistic :user="$user" />
        @break

        @case('admin.um.user.referral')
            <x-slot name="title">Statistic Info</x-slot>
            <x-slot name="breadcrumb">User Management</x-slot>
            <livewire:backend.admin.components.user-management.user.profile.referral :user="$user" />
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
