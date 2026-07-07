<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="2">总数据报表</flux:heading>
            <flux:subheading>主合同与分包合同汇总统计</flux:subheading>
        </div>
        <div class="flex items-center gap-2">
            <flux:button variant="ghost" size="sm" wire:click="$toggle('showExportPicker')">
                <flux:icon.document-arrow-down class="size-4" /> 导出设置
            </flux:button>
            <flux:button variant="ghost" size="sm" wire:click="$toggle('showColumnPicker')">
                <flux:icon.adjustments-horizontal class="size-4" /> 自定义列
            </flux:button>
        </div>
    </div>

    @if($showExportPicker)
    <div class="rounded-md border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="mb-2 text-sm font-medium text-zinc-600 dark:text-zinc-400">选择要导出的列（默认全部）：</div>
        <div class="flex flex-wrap gap-3 mb-4">
            @foreach($availableColumns as $key => $col)
                <label class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-1.5 dark:border-zinc-700 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <input type="checkbox" wire:model.live="exportColumns" value="{{ $key }}" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm">{{ $col['label'] }}</span>
                </label>
            @endforeach
        </div>
        <div class="flex gap-2">
            <flux:button variant="primary" size="sm" wire:click="export('xlsx')">
                <flux:icon.document-arrow-down class="size-4" /> 导出 Excel
            </flux:button>
            <flux:button variant="outline" size="sm" wire:click="export('csv')">
                <flux:icon.document-text class="size-4" /> 导出 CSV
            </flux:button>
        </div>
    </div>
    @endif

    @if($showColumnPicker)
    <div class="rounded-md border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="mb-2 text-sm font-medium text-zinc-600 dark:text-zinc-400">选择要显示的列：</div>
        <div class="flex flex-wrap gap-3">
            @foreach($availableColumns as $key => $col)
                <label class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-1.5 dark:border-zinc-700 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <input type="checkbox" wire:model.live="visibleColumns" value="{{ $key }}" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm">{{ $col['label'] }}</span>
                </label>
            @endforeach
        </div>
    </div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    @if(in_array('seq', $visibleColumns))<th class="px-3 py-3 text-center" style="width:40px">序号</th>@endif
                    @if(in_array('main_contract', $visibleColumns))
                        <th class="px-3 py-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:click="sortBy('main_contract_id')">
                            主合同
                            @if($sortField === 'main_contract_id')<span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif
                        </th>
                    @endif
                    @if(in_array('service_period', $visibleColumns))<th class="px-3 py-3">服务期限</th>@endif
                    @if(in_array('service_unit', $visibleColumns))
                        <th class="px-3 py-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:click="sortBy('service_unit_id')">
                            服务单位
                            @if($sortField === 'service_unit_id')<span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif
                        </th>
                    @endif
                    @if(in_array('contract_name', $visibleColumns))
                        <th class="px-3 py-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:click="sortBy('contract_name')">
                            项目名称
                            @if($sortField === 'contract_name')<span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif
                        </th>
                    @endif
                    @if(in_array('vendor', $visibleColumns))
                        <th class="px-3 py-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:click="sortBy('vendor_id')">
                            运维公司
                            @if($sortField === 'vendor_id')<span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif
                        </th>
                    @endif
                    @if(in_array('contract_type', $visibleColumns))
                        <th class="px-3 py-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:click="sortBy('contract_type')">
                            项目类型
                            @if($sortField === 'contract_type')<span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif
                        </th>
                    @endif
                    @if(in_array('maintenance_type', $visibleColumns))
                        <th class="px-3 py-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:click="sortBy('maintenance_type')">
                            运维类型
                            @if($sortField === 'maintenance_type')<span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif
                        </th>
                    @endif
                    @if(in_array('sub_amount', $visibleColumns))
                        <th class="px-3 py-3 text-right cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:click="sortBy('sub_amount')">
                            合同金额
                            @if($sortField === 'sub_amount')<span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@endif
                        </th>
                    @endif
                    @if(in_array('personnel_count', $visibleColumns))<th class="px-3 py-3 text-center">运维人数</th>@endif
                    @if(in_array('sub_period', $visibleColumns))<th class="px-3 py-3">分包服务期限</th>@endif
                    @if(in_array('remark', $visibleColumns))<th class="px-3 py-3">备注</th>@endif
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($contracts as $index => $contract)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('seq', $visibleColumns))<td class="px-3 py-3 text-center">{{ $contracts->firstItem() + $index }}</td>@endif
                    @if(in_array('main_contract', $visibleColumns))
                        <td class="px-3 py-3">
                            <div class="font-medium">{{ $contract->mainContract?->contract_name ?? '-' }}</div>
                            <div class="text-xs text-zinc-400">{{ $contract->mainContract?->contract_no ?? '' }}</div>
                        </td>
                    @endif
                    @if(in_array('service_period', $visibleColumns))
                        <td class="px-3 py-3 text-xs">
                            @if($contract->mainContract)
                                {{ $contract->mainContract->start_date?->format('Y-m-d') ?? '-' }}<br>
                                <span class="text-zinc-400">至</span><br>
                                {{ $contract->mainContract->end_date?->format('Y-m-d') ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                    @endif
                    @if(in_array('service_unit', $visibleColumns))<td class="px-3 py-3">{{ $contract->serviceUnit?->name ?? '-' }}</td>@endif
                    @if(in_array('contract_name', $visibleColumns))<td class="px-3 py-3">{{ $contract->contract_name }}</td>@endif
                    @if(in_array('vendor', $visibleColumns))<td class="px-3 py-3">{{ $contract->vendor?->name ?? '-' }}</td>@endif
                    @if(in_array('contract_type', $visibleColumns))<td class="px-3 py-3">{{ $contractTypeMap[$contract->contract_type] ?? $contract->contract_type ?? '-' }}</td>@endif
                    @if(in_array('maintenance_type', $visibleColumns))<td class="px-3 py-3">{{ $maintenanceTypeMap[$contract->maintenance_type] ?? $contract->maintenance_type ?? '-' }}</td>@endif
                    @if(in_array('sub_amount', $visibleColumns))
                        <td class="px-3 py-3 text-right">
                            @if(auth()->user()->hasAnyRole(['super_admin', 'admin', 'project_manager']) || auth()->user()->can_view_amounts)
                                {{ number_format($contract->sub_amount, 2) }}
                            @else
                                <span class="text-zinc-400">***</span>
                            @endif
                        </td>
                    @endif
                    @if(in_array('personnel_count', $visibleColumns))
                        <td class="px-3 py-3 text-center">
                            <flux:badge size="sm" color="zinc">{{ $contract->personnel->count() }}</flux:badge>
                        </td>
                    @endif
                    @if(in_array('sub_period', $visibleColumns))
                        <td class="px-3 py-3 text-xs">
                            {{ $contract->start_date?->format('Y-m-d') ?? '-' }}<br>
                            <span class="text-zinc-400">至</span><br>
                            {{ $contract->end_date?->format('Y-m-d') ?? '-' }}
                        </td>
                    @endif
                    @if(in_array('remark', $visibleColumns))
                        <td class="px-3 py-3 max-w-xs truncate" title="{{ $contract->remark }}">
                            {{ Str::limit($contract->remark, 20) ?? '-' }}
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($visibleColumns) }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $contracts->links() }}</div>
</div>
