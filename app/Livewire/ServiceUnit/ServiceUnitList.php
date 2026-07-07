<?php

namespace App\Livewire\ServiceUnit;

use App\Models\ServiceUnit;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

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

    public function render()
    {
        $q = ServiceUnit::query()->with('contacts');
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
