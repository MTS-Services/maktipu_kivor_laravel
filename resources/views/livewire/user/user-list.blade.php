<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Users</h1>
        <a href="{{ route('users.create') }}" wire:navigate class="btn btn-primary">
            Create User
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search users..."
                        class="form-input w-full">
                </div>

                <div>
                    <select wire:model.live="statusFilter" class="form-select w-full">
                        <option value="">All Statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select wire:model.live="perPage" class="form-select w-full">
                        <option value="10">10 per page</option>
                        <option value="15">15 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>

                <div>
                    <button wire:click="resetFilters" class="btn btn-secondary w-full">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if (count($selectedIds) > 0)
        <div class="card mb-4 bg-blue-50">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    <span class="font-medium">{{ count($selectedIds) }} selected</span>

                    <select wire:model.live="bulkAction" class="form-select">
                        <option value="">Select Action</option>
                        <option value="delete">Delete</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="suspend">Suspend</option>
                    </select>

                    <button wire:click="executeBulkAction" class="btn btn-primary"
                        @if (empty($bulkAction)) disabled @endif>
                        Execute
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Users Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="w-12">
                            <input type="checkbox" wire:model.live="selectAll" class="form-checkbox">
                        </th>
                        <th wire:click="sortBy('id')" class="cursor-pointer">
                            ID
                            @if ($sortField === 'id')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th>Avatar</th>
                        <th wire:click="sortBy('name')" class="cursor-pointer">
                            Name
                            @if ($sortField === 'name')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sortBy('email')" class="cursor-pointer">
                            Email
                            @if ($sortField === 'email')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th>Phone</th>
                        <th wire:click="sortBy('status')" class="cursor-pointer">
                            Status
                            @if ($sortField === 'status')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')" class="cursor-pointer">
                            Created At
                            @if ($sortField === 'created_at')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td>
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $user->id }}"
                                    class="form-checkbox">
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                    class="w-10 h-10 rounded-full">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ $user->status_color }}">
                                    {{ $user->status_label }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}" wire:navigate
                                        class="btn btn-sm btn-info">
                                        Edit
                                    </a>

                                    @if ($user->trashed())
                                        <button wire:click="restore({{ $user->id }})"
                                            class="btn btn-sm btn-success">
                                            Restore
                                        </button>
                                        <button wire:click="forceDelete({{ $user->id }})"
                                            wire:confirm="Are you sure you want to permanently delete this user?"
                                            class="btn btn-sm btn-danger">
                                            Delete Forever
                                        </button>
                                    @else
                                        <button wire:click="confirmDelete({{ $user->id }})"
                                            class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-gray-500">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="modal" x-data="{ show: @entangle('showDeleteModal') }">
            <div class="modal-backdrop" @click="show = false"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Confirm Delete</h3>
                    <button @click="show = false" class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('showDeleteModal', false)" class="btn btn-secondary">
                        Cancel
                    </button>
                    <button wire:click="delete" class="btn btn-danger">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
