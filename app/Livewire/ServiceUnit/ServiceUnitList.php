<?php

namespace App\Livewire\ServiceUnit;

use App\Models\ServiceUnit;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;
use App\Services\ExcelExportService;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('layouts.app')]
class ServiceUnitList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $status = '';
    public ?int $expandedId = null;

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    // Export fields selection
    public array $exportColumns = [];
    public bool $showExportPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'name' => ['label' => '单位名称', 'default' => true],
            'short_name' => ['label' => '简称', 'default' => false],
            'address' => ['label' => '地址', 'default' => true],
            'primary_contact' => ['label' => '主要联系人', 'default' => true],
            'contact_count' => ['label' => '联系人数量', 'default' => false],
            'status' => ['label' => '状态', 'default' => true],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('service_unit_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
        // Default export all columns
        $this->exportColumns = array_keys($this->availableColumns);
    }

    public function updatedVisibleColumns(): void
    {
        session(['service_unit_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->expandedId = null;
        $this->resetPage();
    }

    public function toggleExpand(int $id): void
    {
        $this->expandedId = $this->expandedId === $id ? null : $id;
    }

    public function deleteServiceUnit(int $id): void
    {
        $unit = ServiceUnit::find($id);
        if ($unit) {
            $data = $unit->toArray();
            $unit->delete();
            $this->dispatch('notify', type: 'success', message: '服务单位已删除');
            AuditLogService::delete('service_unit', '删除服务单位', "删除服务单位：{$data['name']}", $data);
        }
    }

    public function export(string $format = 'xlsx'): StreamedResponse
    {
        $q = ServiceUnit::query()->with(['contacts', 'primaryContact']);

        // Data scope: service_unit role only sees their own
        $user = auth()->user();
        if ($user->hasRole('service_unit') && $user->service_unit_id) {
            $q->where('id', $user->service_unit_id);
        }

        $units = $q->latest()->get();

        // Build headers
        $headers = [];
        foreach ($this->exportColumns as $col) {
            if (isset($this->availableColumns[$col])) {
                $headers[$col] = $this->availableColumns[$col]['label'];
            }
        }

        // Build rows
        $rows = [];
        foreach ($units as $unit) {
            $row = [];
            foreach (array_keys($headers) as $col) {
                $row[$col] = match ($col) {
                    'name' => $unit->name,
                    'short_name' => $unit->short_name ?? '',
                    'address' => $unit->address ?? '',
                    'primary_contact' => $unit->primaryContact
                        ? $unit->primaryContact->name . ($unit->primaryContact->phone ? " ({$unit->primaryContact->phone})" : '')
                        : ($unit->contacts->first() ? $unit->contacts->first()->name . ($unit->contacts->first()->phone ? " ({$unit->contacts->first()->phone})" : '') : ''),
                    'contact_count' => (string) $unit->contacts->count(),
                    'status' => $unit->status ? '启用' : '停用',
                    'created_at' => $unit->created_at->format('Y-m-d H:i'),
                    default => '',
                };
            }
            $rows[] = $row;
        }

        $filename = '服务单位_' . date('Ymd_His');
        return ExcelExportService::export($headers, $rows, $filename, $format);
    }

    public function render()
    {
        $q = ServiceUnit::query()->with(['contacts', 'primaryContact']);
        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('name', 'like', "%{$this->search}%")
                    ->orWhere('short_name', 'like', "%{$this->search}%")
                    ->orWhere('address', 'like', "%{$this->search}%")
                    ->orWhereHas('contacts', function($c) {
                        $c->where('name', 'like', "%{$this->search}%")
                          ->orWhere('phone', 'like', "%{$this->search}%");
                    });
            });
        }
        if ($this->status !== '') {
            $q->where('status', (int)$this->status);
        }

        // Data scope: service_unit role only sees their own
        $user = auth()->user();
        if ($user->hasRole('service_unit') && $user->service_unit_id) {
            $q->where('id', $user->service_unit_id);
        }

        return view('livewire.service-unit.service-unit-list', [
            'serviceUnits' => $q->latest()->paginate(15),
        ]);
    }
}
