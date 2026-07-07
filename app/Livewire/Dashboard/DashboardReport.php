<?php

namespace App\Livewire\Dashboard;

use App\Models\SubContract;
use App\Models\DataDictionary;
use App\Services\ExcelExportService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('layouts.app')]
class DashboardReport extends Component
{
    use WithPagination;

    #[Url] public string $sortField = 'id';
    #[Url] public string $sortDirection = 'asc';

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    // Export fields selection
    public array $exportColumns = [];
    public bool $showExportPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'seq' => ['label' => '序号', 'default' => true, 'sortable' => false],
            'main_contract' => ['label' => '主合同', 'default' => true, 'sortable' => true, 'field' => 'main_contract_id'],
            'service_period' => ['label' => '服务期限', 'default' => true, 'sortable' => false],
            'service_unit' => ['label' => '服务单位', 'default' => true, 'sortable' => true, 'field' => 'service_unit_id'],
            'contract_name' => ['label' => '项目名称', 'default' => true, 'sortable' => true, 'field' => 'contract_name'],
            'vendor' => ['label' => '运维公司', 'default' => true, 'sortable' => true, 'field' => 'vendor_id'],
            'contract_type' => ['label' => '项目类型', 'default' => true, 'sortable' => true, 'field' => 'contract_type'],
            'maintenance_type' => ['label' => '运维类型', 'default' => true, 'sortable' => true, 'field' => 'maintenance_type'],
            'sub_amount' => ['label' => '合同金额', 'default' => true, 'sortable' => true, 'field' => 'sub_amount'],
            'personnel_count' => ['label' => '运维人数', 'default' => true, 'sortable' => false],
            'sub_period' => ['label' => '分包服务期限', 'default' => true, 'sortable' => false],
            'remark' => ['label' => '备注', 'default' => false, 'sortable' => false],
        ];
        $saved = session('dashboard_report_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
        // Default export all columns
        $this->exportColumns = array_keys($this->availableColumns);
    }

    public function updatedVisibleColumns(): void
    {
        session(['dashboard_report_visible_columns' => $this->visibleColumns]);
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function export(string $format = 'xlsx'): StreamedResponse
    {
        $query = SubContract::query()
            ->with([
                'mainContract:id,contract_no,contract_name,start_date,end_date,total_amount',
                'vendor:id,name',
                'serviceUnit:id,name',
                'personnel:id,sub_contract_id',
            ])
            ->orderBy('main_contract_id', 'asc')
            ->orderBy('id', 'asc');

        $contracts = $query->get();

        // Data dictionary maps
        $maintenanceTypeMap = DataDictionary::where('category', 'maintenance_type')->pluck('name', 'code');
        $contractTypeMap = DataDictionary::where('category', 'contract_type')->pluck('name', 'code');

        // Build headers
        $headers = [];
        foreach ($this->exportColumns as $col) {
            if (isset($this->availableColumns[$col])) {
                $headers[$col] = $this->availableColumns[$col]['label'];
            }
        }

        // Build rows
        $rows = [];
        $seq = 1;
        foreach ($contracts as $contract) {
            $row = [];
            foreach (array_keys($headers) as $col) {
                $row[$col] = match ($col) {
                    'seq' => (string) $seq,
                    'main_contract' => ($contract->mainContract?->contract_name ?? '') . ($contract->mainContract?->contract_no ? " ({$contract->mainContract->contract_no})" : ''),
                    'service_period' => ($contract->mainContract?->start_date?->format('Y-m-d') ?? '') . ' 至 ' . ($contract->mainContract?->end_date?->format('Y-m-d') ?? ''),
                    'service_unit' => $contract->serviceUnit?->name ?? '',
                    'contract_name' => $contract->contract_name,
                    'vendor' => $contract->vendor?->name ?? '',
                    'contract_type' => $contractTypeMap[$contract->contract_type] ?? $contract->contract_type ?? '',
                    'maintenance_type' => $maintenanceTypeMap[$contract->maintenance_type] ?? $contract->maintenance_type ?? '',
                    'sub_amount' => number_format($contract->sub_amount, 2),
                    'personnel_count' => (string) $contract->personnel->count(),
                    'sub_period' => ($contract->start_date?->format('Y-m-d') ?? '') . ' 至 ' . ($contract->end_date?->format('Y-m-d') ?? ''),
                    'remark' => $contract->remark ?? '',
                    default => '',
                };
            }
            $rows[] = $row;
            $seq++;
        }

        $filename = '总数据报表_' . date('Ymd_His');
        return ExcelExportService::export($headers, $rows, $filename, $format);
    }

    public function render()
    {
        $query = SubContract::query()
            ->with([
                'mainContract:id,contract_no,contract_name,start_date,end_date,total_amount',
                'vendor:id,name',
                'serviceUnit:id,name',
                'personnel:id,sub_contract_id',
                'managers:id,sub_contract_id,user_id',
            ]);

        // Sorting
        $allowedSort = ['id', 'main_contract_id', 'service_unit_id', 'contract_name', 'vendor_id', 'contract_type', 'maintenance_type', 'sub_amount', 'start_date', 'end_date'];
        if (in_array($this->sortField, $allowedSort)) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('main_contract_id', 'asc')->orderBy('id', 'asc');
        }

        $contracts = $query->paginate(50);

        // Data dictionary maps
        $maintenanceTypeMap = DataDictionary::where('category', 'maintenance_type')->pluck('name', 'code');
        $projectLevelMap = DataDictionary::where('category', 'project_level')->pluck('name', 'code');
        $contractTypeMap = DataDictionary::where('category', 'contract_type')->pluck('name', 'code');

        return view('livewire.dashboard.dashboard-report', [
            'contracts' => $contracts,
            'maintenanceTypeMap' => $maintenanceTypeMap,
            'projectLevelMap' => $projectLevelMap,
            'contractTypeMap' => $contractTypeMap,
        ]);
    }
}
