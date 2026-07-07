<?php

namespace App\Livewire\System;

use App\Models\AuditConfig;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AuditConfigList extends Component
{
    public array $configs = [];
    public bool $showEdit = false;
    public ?int $editingId = null;
    public array $editForm = [];

    public function mount(): void
    {
        $this->loadConfigs();
    }

    public function loadConfigs(): void
    {
        $this->configs = AuditConfig::orderBy('audit_module')->orderBy('id')->get()->toArray();
    }

    public function startEdit(int $id): void
    {
        $config = AuditConfig::find($id);
        if (!$config) return;
        $this->editingId = $id;
        $this->editForm = $config->toArray();
        $this->showEdit = true;
    }

    public function cancelEdit(): void
    {
        $this->showEdit = false;
        $this->editingId = null;
        $this->editForm = [];
    }

    public function saveConfig(): void
    {
        $config = AuditConfig::find($this->editingId);
        if (!$config) {
            $this->dispatch('notify', type: 'error', message: '配置不存在');
            return;
        }

        $config->update([
            'is_enabled' => $this->editForm['is_enabled'] ?? false,
            'record_create' => $this->editForm['record_create'] ?? false,
            'record_update' => $this->editForm['record_update'] ?? false,
            'record_delete' => $this->editForm['record_delete'] ?? false,
            'record_view' => $this->editForm['record_view'] ?? false,
            'record_old_data' => $this->editForm['record_old_data'] ?? false,
            'record_new_data' => $this->editForm['record_new_data'] ?? false,
        ]);

        $this->loadConfigs();
        $this->cancelEdit();
        $this->dispatch('notify', type: 'success', message: '审计配置已更新');
    }

    public function toggleGlobal(string $field): void
    {
        foreach ($this->configs as &$config) {
            $c = AuditConfig::find($config['id']);
            if ($c) {
                $c->update([$field => !($config[$field] ?? false)]);
            }
        }
        $this->loadConfigs();
    }

    public function render()
    {
        $grouped = collect($this->configs)->groupBy('audit_module');
        return view('livewire.system.audit-config-list', [
            'groupedConfigs' => $grouped,
        ]);
    }
}
