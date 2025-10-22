@props([
    'columns' => [],
    'data' => [],
    'actions' => [],
    'searchProperty' => 'search',
    'showSearch' => true,
    'perPageProperty' => 'perPage',
    'showPerPage' => true,
    'perPageOptions' => [5, 10, 15, 20, 50, 100],
    'emptyMessage' => 'No records found.',
    'class' => '',
    'showRowNumber' => true,
    'mobileVisibleColumns' => 2, // Number of columns visible on mobile before expand
    'sortField' => 'created_at',
    'sortDirection' => 'desc',
    'showBulkActions' => true,
    'filters' => [],
    'statuses' => [],
    'statusFilter' => '',
    'selectedIds' => [],
    'bulkActions' => [],
    'bulkAction' => '',
    'resetFiltersAction' => 'resetFilters',
])

<div class="glass-card rounded-2xl p-4 lg:p-6 mb-6 {{ $class }}">

    {{-- FILTERS & SEARCH SECTION --}}
    <div class="space-y-4 mb-6">
        {{-- Top Row: Per Page, Status, Reset --}}
        <div class="glass-card p-4 rounded-lg flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            {{-- Per Page --}}
            @if ($showPerPage)
                <div class="w-full sm:w-auto">
                    <select wire:model.live="{{ $perPageProperty }}" class="select w-full sm:w-auto min-w-[140px]">
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}">{{ $option }} per page</option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Status Filter --}}
            @if (!empty($statuses))
                <div class="w-full sm:w-auto">
                    <select wire:model.live="statusFilter" class="select w-full sm:w-auto min-w-[140px]">
                        <option value="">All Statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Reset Button --}}
            <div class="w-full sm:w-auto">
                <x-ui.button wire:click="{{ $resetFiltersAction }}" type="accent" button class="w-full sm:w-auto">
                    <flux:icon icon="arrow-path" class="w-4 h-4 stroke-white" />
                    {{ __('Reset') }}
                </x-ui.button>
            </div>

            {{-- Spacer --}}
            <div class="hidden lg:flex flex-1"></div>

            {{-- Search --}}
            @if ($showSearch)
                <div class="w-full sm:flex-1 lg:max-w-xs">
                    <x-input type="text" wire:model.live.debounce.300ms="{{ $searchProperty }}"
                        placeholder="Search..." class="form-input w-full" />
                </div>
            @endif
        </div>

        {{-- Bulk Actions Row --}}
        @if ($showBulkActions && count($selectedIds) > 0)
            <div class="glass-card p-4 rounded-lg flex items-center gap-5">
                {{ count($selectedIds) }} {{ count($selectedIds) === 1 ? 'item' : 'items' }} selected
                </span>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:flex-1">
                    <select wire:model.live="bulkAction" class="select w-full sm:w-auto min-w-[160px]">
                        <option value="">Select Action</option>
                        @foreach ($bulkActions as $action)
                            <option value="{{ $action['value'] }}">{{ $action['label'] }}</option>
                        @endforeach
                    </select>

                    <button wire:click="confirmBulkAction" class="btn btn-secondary w-full sm:w-auto"
                        @if (empty($bulkAction)) disabled @endif>
                        Execute
                    </button>
                </div>
            </div>
        @endif
    </div>
    {{-- DESKTOP TABLE VIEW (lg and above) --}}
    <div class="hidden lg:block">
        <table class="min-w-full divide-y divide-accent/30">
            <thead class="glass-card shadow-none rounded-t-lg">
                <tr>
                    {{-- Bulk Select Checkbox --}}
                    @if ($showBulkActions)
                        <th scope="col" class="w-12 px-4 py-3 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="checkbox w-5 h-5 rounded">
                        </th>
                    @endif

                    {{-- Row Number/ID --}}
                    @if ($showRowNumber)
                        <th scope="col"
                            class="w-16 px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            @if (in_array('id', array_column($columns, 'key')))
                                <button type="button" wire:click="sortBy('id')"
                                    class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                                    ID

                                    <flux:icon icon="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                        class="w-4 h-4" />
                                </button>
                            @else
                                No.
                            @endif
                        </th>
                    @endif

                    {{-- Column Headers --}}
                    @foreach ($columns as $column)
                        @if ($column['key'] === 'id')
                            @continue
                        @endif
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            @if (isset($column['sortable']) && $column['sortable'])
                                <button type="button" wire:click="sortBy('{{ $column['key'] }}')"
                                    class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                                    {{ $column['label'] }}

                                    <flux:icon icon="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                        class="w-4 h-4" />
                                </button>
                            @else
                                {{ $column['label'] }}
                            @endif
                        </th>
                    @endforeach

                    {{-- Actions Column --}}
                    @if (count($actions) > 0)
                        <th scope="col"
                            class="w-24 px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-accent/20">
                @forelse ($data as $item)
                    @php
                        $rowNumber = in_array('id', array_column($columns, 'key'))
                            ? $item->id
                            : (method_exists($data, 'firstItem')
                                ? $data->firstItem() + $loop->index
                                : $loop->iteration);
                    @endphp
                    <tr wire:key="desktop-row-{{ $item->id ?? $loop->index }}"
                        class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150">

                        {{-- Bulk Select Checkbox --}}
                        @if ($showBulkActions)
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $item->id }}"
                                    class="checkbox w-5 h-5 rounded">
                            </td>
                        @endif

                        {{-- Row Number --}}
                        @if ($showRowNumber)
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $rowNumber }}
                            </td>
                        @endif

                        {{-- Data Columns --}}
                        @foreach ($columns as $column)
                            @if ($column['key'] === 'id')
                                @continue
                            @endif
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                @if (isset($column['format']) && is_callable($column['format']))
                                    {!! $column['format']($item) !!}
                                @else
                                    {{ data_get($item, $column['key']) ?? '-' }}
                                @endif
                            </td>
                        @endforeach

                        {{-- Actions Dropdown --}}
                        @if (count($actions) > 0)
                            {{-- <td class="px-4 py-3 text-center">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 group">
                                        <flux:icon icon="cog-6-tooth"
                                            class="w-5 h-5 text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200 group-hover:rotate-90 transition-all duration-300" />
                                    </button>

                                    <div x-show="open" x-cloak @click.outside="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1">
                                            @foreach ($actions as $action)
                                                @php
                                                    $param = $action['param'] ?? ($action['key'] ?? 'id');
                                                    $actionValue = data_get($item, $param);
                                                    $actionParam = is_numeric($actionValue)
                                                        ? $actionValue
                                                        : "'{$actionValue}'";
                                                @endphp

                                                @if (isset($action['route']))
                                                    <a href="{{ route($action['route'], $actionValue) }}" wire:navigate
                                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                        {{ $action['label'] }}
                                                    </a>
                                                @elseif (isset($action['method']))
                                                    <button type="button"
                                                        wire:click="{{ $action['method'] }}({{ $actionParam }})"
                                                        @click="open = false"
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                        {{ $action['label'] }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td> --}}
                            <td class="p-3 text-center flex-shrink-0">
                                <div class="relative inline-block text-left">
                                    <div x-data="{ open: false }">
                                        <button type="button" @click="open = !open"
                                            class="flex items-center justify-center gap-2 text-sm font-medium hover:rotate-90 transition-all duration-300 ease-linear group mx-auto">
                                            <flux:icon icon="cog-6-tooth"
                                                class="w-6 h-6 group-hover:stroke-accent transition-all duration-300 ease-linear" />
                                        </button>

                                        <div x-show="open" x-cloak
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute z-10 mt-2 min-w-32 w-fit max-w-52 origin-top-right right-0 rounded-md shadow-lg text-center"
                                            @click.outside="open = false">
                                            <div class="rounded-md bg-white shadow-xs">
                                                <div class="py-1">
                                                    @foreach ($actions as $action)
                                                        @if (isset($action['href']) && $action['href'] != null && $action['href'] != '#')
                                                            @php
                                                                $param =
                                                                    (isset($action['param']) && $action['param']
                                                                        ? $action['param']
                                                                        : $action['key']) ?? '';
                                                                $actionValue = data_get($item, $param);
                                                                $actionParam = is_numeric($actionValue)
                                                                    ? $actionValue
                                                                    : "'{$actionValue}'";
                                                                $href = empty($actionParam)
                                                                    ? $action['href']
                                                                    : "{$action['href']}/{$actionParam}";
                                                            @endphp
                                                            <a href="{{ $href }}"
                                                                title="{{ $action['label'] }}"
                                                                target="{{ $action['target'] ?? '_self' }}"
                                                                class="block px-4 py-2 w-full text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                wire:navigate>
                                                                {{ $action['label'] }}
                                                            </a>
                                                        @elseif (isset($action['route']) && $action['route'] != null && $action['route'] != '#')
                                                            @php
                                                                $param =
                                                                    (isset($action['param']) && $action['param']
                                                                        ? $action['param']
                                                                        : $action['key']) ?? '';
                                                                $actionValue = data_get($item, $param);
                                                                $actionParam = is_numeric($actionValue)
                                                                    ? $actionValue
                                                                    : "'{$actionValue}'";
                                                            @endphp
                                                            <a href="{{ route($action['route'], $actionParam) }}"
                                                                title="{{ $action['label'] }}"
                                                                target="{{ $action['target'] ?? '_self' }}"
                                                                class="block px-4 py-2 w-full text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                wire:navigate>
                                                                {{ $action['label'] }}
                                                            </a>
                                                        @elseif(isset($action['method']) && $action['method'] != null)
                                                            @php
                                                                $actionValue = data_get(
                                                                    $item,
                                                                    (isset($action['param']) && $action['param']
                                                                        ? $action['param']
                                                                        : $action['key']) ?? 'id',
                                                                );
                                                                $actionParam = is_numeric($actionValue)
                                                                    ? $actionValue
                                                                    : "'{$actionValue}'";
                                                            @endphp
                                                            <button type="button"
                                                                wire:click="{{ $action['method'] }}({{ $actionParam }})"
                                                                class="block px-4 py-2 w-full text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                @click="open = false">
                                                                {{ $action['label'] }}
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + ($showRowNumber ? 1 : 0) + ($showBulkActions ? 1 : 0) + (count($actions) > 0 ? 1 : 0) }}"
                            class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <flux:icon icon="inbox" class="w-12 h-12 text-gray-300 dark:text-gray-600" />
                                <p class="text-lg font-medium">{{ $emptyMessage }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW (below lg) --}}
    <div class="block lg:hidden space-y-3" x-data="{ expanded: false }">
        @forelse ($data as $item)
            @php
                $rowNumber = method_exists($data, 'firstItem') ? $data->firstItem() + $loop->index : $loop->iteration;
                $visibleColumns = array_slice($columns, 0, $mobileVisibleColumns);
                $hiddenColumns = array_slice($columns, $mobileVisibleColumns);
            @endphp

            <div wire:key="mobile-row-{{ $item->id ?? $loop->index }}"
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">

                {{-- Card Header --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between gap-3">
                        {{-- Left: Checkbox + Row Number --}}
                        <div class="flex items-center gap-3">
                            @if ($showBulkActions)
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $item->id }}"
                                    class="checkbox w-5 h-5 rounded flex-shrink-0">
                            @endif

                            @if ($showRowNumber)
                                <div
                                    class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-300 flex-shrink-0">
                                    {{ $rowNumber }}
                                </div>
                            @endif
                        </div>

                        {{-- Right: Actions Dropdown --}}
                        @if (count($actions) > 0)
                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-200 group">
                                    <flux:icon icon="ellipsis-vertical"
                                        class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200" />
                                </button>

                                <div x-show="open" x-cloak @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    class="absolute right-0 z-20 mt-2 w-48 origin-top-right rounded-lg bg-white dark:bg-gray-800 shadow-xl ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        @foreach ($actions as $action)
                                            @php
                                                $param = $action['param'] ?? ($action['key'] ?? 'id');
                                                $actionValue = data_get($item, $param);
                                                $actionParam = is_numeric($actionValue)
                                                    ? $actionValue
                                                    : "'{$actionValue}'";
                                            @endphp

                                            @if (isset($action['route']))
                                                <a href="{{ route($action['route'], $actionValue) }}" wire:navigate
                                                    class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    {{ $action['label'] }}
                                                </a>
                                            @elseif (isset($action['method']))
                                                <button type="button"
                                                    wire:click="{{ $action['method'] }}({{ $actionParam }})"
                                                    @click="open = false"
                                                    class="block w-full text-left px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    {{ $action['label'] }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Card Body: Visible Columns --}}
                <div class="p-4 space-y-3">
                    @foreach ($visibleColumns as $column)
                        @if ($column['key'] === 'id')
                            @continue
                        @endif
                        <div class="flex flex-col gap-1">
                            <dt class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                {{ $column['label'] }}
                            </dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                @if (isset($column['format']) && is_callable($column['format']))
                                    {!! $column['format']($item) !!}
                                @else
                                    {{ data_get($item, $column['key']) ?? '-' }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </div>

                {{-- Expandable Section --}}
                @if (count($hiddenColumns) > 0)
                    {{-- Expand/Collapse Button --}}
                    <button type="button" @click="expanded = !expanded"
                        class="w-full px-4 py-3 flex items-center justify-between bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            x-text="expanded ? 'Show Less' : 'Show More'">
                            Show More
                        </span>
                        {{-- <flux:icon icon="chevron-down"
                            class="w-5 h-5 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                            :class="expanded && 'rotate-180'" /> --}}
                    </button>

                    {{-- Hidden Columns --}}
                    <div x-show="expanded" x-cloak x-collapse class="border-t border-gray-200 dark:border-gray-700">
                        <div class="p-4 space-y-3 bg-gray-50/50 dark:bg-gray-800/30">
                            @foreach ($hiddenColumns as $column)
                                @if ($column['key'] === 'id')
                                    @continue
                                @endif
                                <div class="flex flex-col gap-1">
                                    <dt
                                        class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                        {{ $column['label'] }}
                                    </dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                        @if (isset($column['format']) && is_callable($column['format']))
                                            {!! $column['format']($item) !!}
                                        @else
                                            {{ data_get($item, $column['key']) ?? '-' }}
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="py-12 text-center">
                <div class="flex flex-col items-center justify-center gap-3">
                    <flux:icon icon="inbox" class="w-16 h-16 text-gray-300 dark:text-gray-600" />
                    <p class="text-lg font-medium text-gray-500 dark:text-gray-400">{{ $emptyMessage }}</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if (method_exists($data, 'links'))
        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
            {{ $data->links() }}
        </div>
    @endif
</div>
