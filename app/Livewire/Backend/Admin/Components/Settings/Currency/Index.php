<?php
namespace App\Livewire\Backend\Admin\Components\Settings\Currency;

use App\Enums\CurrencyStatus;
use App\Services\Admin\CurrencyService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    // protected $listeners = ['CurrencyCreated' => '$refresh', 'CurrencyUpdated' => '$refresh'];

    protected CurrencyService $currencyService;

    public function boot(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function render()
    {
        $datas = $this->currencyService->getPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [
          
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
                [
                'key' => 'code',
                'label' => 'Code',
                'sortable' => true
            ],
            [
                'key' => 'symbol',
                'label' => 'Symbol',
                'sortable' => true
            ],
            [
                'key' => 'exchange_rate',
                'label' => 'Exchange Rate',
                'sortable' => true,
                'format' => function ($data) {
                    return number_format($data->exchange_rate, $data->decimal_places);
                }
            ],
            [
                'key' => 'decimal_places',
                'label' => 'Decimal Places',
                'sortable' => true
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->status->color() . '">' .
                        $data->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->creater_admin?->name ?? 'System';
                       
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'route' => 'admin.as.currency.view',
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.as.currency.edit'
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete'
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return view('livewire.backend.admin.components.settings.currency.index', [
            'datas' => $datas,
            'statuses' => CurrencyStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }
    
    public function delete(): void
    {
        try {
            if (!$this->deleteId) {
                return;
            }

            $this->currencyService->deleteData($this->deleteId);
            $this->reset(['deleteId', 'showDeleteModal']);

            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete data: ' . $e->getMessage());
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($id, $status): void
    {
        try {
            $currencyStatus = CurrencyStatus::from($status);

            match ($currencyStatus) {
                CurrencyStatus::ACTIVE => $this->currencyService->activateData($id),
                CurrencyStatus::INACTIVE => $this->currencyService->deactivateData($id),
                default => null,
            };

            $this->success('Data status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select data and an action');
            Log::info('No data selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'delete' => $this->bulkDelete(),
                'active' => $this->bulkUpdateStatus(CurrencyStatus::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(CurrencyStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    protected function bulkDelete(): void
    {
        $count = $this->currencyService->bulkDeleteData($this->selectedIds);
        $this->success("{$count} Data deleted successfully");
    }

    protected function bulkUpdateStatus(CurrencyStatus $status): void
    {
        $count = $this->currencyService->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Data updated successfully");
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    protected function getSelectableIds(): array
    {
        return $this->currencyService->getPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
