<?php

namespace App\Livewire\System;

use App\Models\OperationLog;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class OperationLogList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $action = '';
    #[Url] public string $dateFrom = '';
    #[Url] public string $dateTo = '';

    public function resetFilters(): void
    {
        $this->search = '';
        $this->action = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function render()
    {
        $q = OperationLog::query()->with('user');
        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('description', 'like', "%{$this->search}%")
                  ->orWhere('ip', 'like', "%{$this->search}%");
            });
        }
        if ($this->action) $q->where('action', $this->action);
        if ($this->dateFrom) $q->whereDate('created_at', '>=', $this->dateFrom);
        if ($this->dateTo) $q->whereDate('created_at', '<=', $this->dateTo);

        $logs = $q->latest()->paginate(20);
        $actions = OperationLog::select('action')->distinct()->pluck('action');

        return view('livewire.system.operation-log-list', [
            'logs' => $logs,
            'actions' => $actions,
        ]);
    }
}
