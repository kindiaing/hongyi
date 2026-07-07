<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">分包合同管理</flux:heading>
            <flux:subheading>总包方与运维软硬件公司签订的分包合同</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('contracts.sub.create')" wire:navigate>
            <flux:icon.plus class="size-4" />
            新建分包合同
        </flux:button>
    </div>

    <!-- 筛选栏 -->
    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="搜索合同编号/名称..." />
            </div>
            <div class="w-40">
                <flux:select wire:model.live="status">
                    <option value="">全部状态</option>
                    @foreach($statusOptions as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="mainContractId">
                    <option value="">全部主合同</option>
                    @foreach($mainContracts as $mc)
                        <option value="{{ $mc->id }}">{{ $mc->contract_name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="flex gap-2">
                <flux:button variant="ghost" wire:click="resetFilters" size="sm">重置</flux:button>
            </div>
            <div class="ml-auto">
                <flux:button variant="ghost" size="sm" wire:click="$toggle('showColumnPicker')">
                    <flux:icon.adjustments-horizontal class="size-4" />
                    自定义列
                </flux:button>
            </div>
        </div>

        <!-- 列选择器 -->
        @if($showColumnPicker)
            <div class="mt-4 rounded-md border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
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
    </div>

    <!-- 表格 -->
    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    @if(in_array('contract_no', $visibleColumns))<th class="px-4 py-3">合同编号</th>@endif
                    @if(in_array('contract_name', $visibleColumns))<th class="px-4 py-3">合同名称</th>@endif
                    @if(in_array('main_contract', $visibleColumns))<th class="px-4 py-3">关联主合同</th>@endif
                    @if(in_array('vendor', $visibleColumns))<th class="px-4 py-3">分包商</th>@endif
                    @if(in_array('contract_type', $visibleColumns))<th class="px-4 py-3">合同类型</th>@endif
                    @if(in_array('maintenance_type', $visibleColumns))<th class="px-4 py-3">运维类型</th>@endif
                    @if(in_array('project_level', $visibleColumns))<th class="px-4 py-3">项目层级</th>@endif
                    @if(in_array('sub_amount', $visibleColumns))<th class="px-4 py-3 text-right">分包金额</th>@endif
                    @if(in_array('signed_date', $visibleColumns))<th class="px-4 py-3">签订日期</th>@endif
                    @if(in_array('start_date', $visibleColumns))<th class="px-4 py-3">生效日期</th>@endif
                    @if(in_array('end_date', $visibleColumns))<th class="px-4 py-3">到期日期</th>@endif
                    @if(in_array('sla_level', $visibleColumns))<th class="px-4 py-3">SLA</th>@endif
                    @if(in_array('status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('service_scope', $visibleColumns))<th class="px-4 py-3">服务范围</th>@endif
                    @if(in_array('service_unit', $visibleColumns))<th class="px-4 py-3">服务单位</th>@endif
                    @if(in_array('managers', $visibleColumns))<th class="px-4 py-3">项目经理</th>@endif
                    @if(in_array('personnel', $visibleColumns))<th class="px-4 py-3">关联人员</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($contracts as $contract)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        @if(in_array('contract_no', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $contract->contract_no }}</td>@endif
                        @if(in_array('contract_name', $visibleColumns))<td class="px-4 py-3">{{ $contract->contract_name }}</td>@endif
                        @if(in_array('main_contract', $visibleColumns))<td class="px-4 py-3">{{ $contract->mainContract?->contract_name ?? '-' }}</td>@endif
                        @if(in_array('vendor', $visibleColumns))<td class="px-4 py-3">{{ $contract->vendor?->name ?? '-' }}</td>@endif
                        @if(in_array('contract_type', $visibleColumns))<td class="px-4 py-3">{{ $contract->contract_type }}</td>@endif
                        @if(in_array('maintenance_type', $visibleColumns))<td class="px-4 py-3">{{ $maintenanceTypeOptions[$contract->maintenance_type] ?? $contract->maintenance_type ?? '-' }}</td>@endif
                        @if(in_array('project_level', $visibleColumns))<td class="px-4 py-3">{{ $projectLevelOptions[$contract->project_level] ?? $contract->project_level ?? '-' }}</td>@endif
                        @if(in_array('sub_amount', $visibleColumns))
                            <td class="px-4 py-3 text-right">
                                @if(auth()->user()->hasAnyRole(['super_admin', 'admin', 'project_manager']) || auth()->user()->can_view_amounts)
                                    {{ number_format($contract->sub_amount, 2) }}
                                @else
                                    <span class="text-zinc-400">***</span>
                                @endif
                            </td>
                        @endif
                        @if(in_array('signed_date', $visibleColumns))<td class="px-4 py-3">{{ $contract->signed_date?->format('Y-m-d') ?? '-' }}</td>@endif
                        @if(in_array('start_date', $visibleColumns))<td class="px-4 py-3">{{ $contract->start_date->format('Y-m-d') }}</td>@endif
                        @if(in_array('end_date', $visibleColumns))<td class="px-4 py-3">{{ $contract->end_date->format('Y-m-d') }}</td>@endif
                        @if(in_array('sla_level', $visibleColumns))<td class="px-4 py-3">{{ $contract->sla_level ?? '-' }}</td>@endif
                        @if(in_array('status', $visibleColumns))
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'draft' => 'zinc',
                                        'active' => 'emerald',
                                        'expired' => 'orange',
                                        'terminated' => 'red',
                                    ];
                                    $color = $statusColors[$contract->status] ?? 'zinc';
                                @endphp
                                <flux:badge color="{{ $color }}" size="sm">
                                    {{ $statusOptions[$contract->status] ?? $contract->status }}
                                </flux:badge>
                            </td>
                        @endif
                        @if(in_array('service_scope', $visibleColumns))
                            <td class="px-4 py-3 max-w-xs truncate" title="{{ $contract->service_scope }}">
                                {{ Str::limit($contract->service_scope, 30) ?? '-' }}
                            </td>
                        @endif
                        @if(in_array('service_unit', $visibleColumns))
                            <td class="px-4 py-3">{{ $contract->serviceUnit?->name ?? '-' }}</td>
                        @endif
                        @if(in_array('managers', $visibleColumns))
                            <td class="px-4 py-3">
                                @foreach($contract->managers as $m)
                                    <flux:badge size="sm" color="indigo" class="mr-1">{{ $m->user->name ?? '-' }}</flux:badge>
                                @endforeach
                            </td>
                        @endif
                        @if(in_array('personnel', $visibleColumns))
                            <td class="px-4 py-3">
                                @foreach($contract->personnel as $p)
                                    <flux:badge size="sm" color="zinc" class="mr-1">{{ $p->user->name ?? '-' }}</flux:badge>
                                @endforeach
                            </td>
                        @endif
                        @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $contract->created_at->format('Y-m-d H:i') }}</td>@endif
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <flux:button variant="ghost" size="sm" :href="route('contracts.sub.edit', $contract->id)" wire:navigate>
                                    <flux:icon.pencil class="size-4" />
                                </flux:button>
                                <flux:button variant="ghost" size="sm" color="red" wire:click="deleteContract({{ $contract->id }})" wire:confirm="确定删除此分包合同？">
                                    <flux:icon.trash class="size-4" />
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">
                            暂无数据
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $contracts->links() }}
    </div>
</div>
