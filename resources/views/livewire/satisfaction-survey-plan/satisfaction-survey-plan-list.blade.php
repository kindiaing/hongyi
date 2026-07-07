<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">回访/满意度调查计划</flux:heading>
            <flux:subheading>按周期自动生成回访任务计划</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('satisfaction.plans.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增计划
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索计划名称..." /></div>
            <div class="w-48">
                <flux:select wire:model.live="serviceUnitId">
                    <option value="">全部服务单位</option>
                    @foreach($serviceUnits as $su)
                        <option value="{{ $su->id }}">{{ $su->name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="w-36">
                <flux:select wire:model.live="cycleType">
                    <option value="">全部周期</option>
                    <option value="monthly">月度</option>
                    <option value="quarterly">季度</option>
                    <option value="annually">年度</option>
                    <option value="custom">自定义</option>
                </flux:select>
            </div>
            <div class="w-32">
                <flux:select wire:model.live="isEnabled">
                    <option value="">全部状态</option>
                    <option value="1">启用</option>
                    <option value="0">停用</option>
                </flux:select>
            </div>
            <flux:button variant="ghost" wire:click="resetFilters" size="sm">重置</flux:button>
            <div class="ml-auto">
                <flux:button variant="ghost" size="sm" wire:click="$toggle('showColumnPicker')">
                    <flux:icon.adjustments-horizontal class="size-4" /> 自定义列
                </flux:button>
            </div>
        </div>

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

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    @if(in_array('plan_name', $visibleColumns))<th class="px-4 py-3">计划名称</th>@endif
                    @if(in_array('service_unit_name', $visibleColumns))<th class="px-4 py-3">服务单位</th>@endif
                    @if(in_array('vendor_name', $visibleColumns))<th class="px-4 py-3">运维单位</th>@endif
                    @if(in_array('cycle_type', $visibleColumns))<th class="px-4 py-3">周期类型</th>@endif
                    @if(in_array('cycle_month', $visibleColumns))<th class="px-4 py-3">执行月份</th>@endif
                    @if(in_array('cycle_day', $visibleColumns))<th class="px-4 py-3">执行日期</th>@endif
                    @if(in_array('start_date', $visibleColumns))<th class="px-4 py-3">开始日期</th>@endif
                    @if(in_array('end_date', $visibleColumns))<th class="px-4 py-3">结束日期</th>@endif
                    @if(in_array('remind_days', $visibleColumns))<th class="px-4 py-3">提前提醒</th>@endif
                    @if(in_array('is_enabled', $visibleColumns))<th class="px-4 py-3">启用状态</th>@endif
                    @if(in_array('next_execute_at', $visibleColumns))<th class="px-4 py-3">下次执行</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($plans as $plan)
                @php
                    $cycleMap = ['monthly'=>'月度','quarterly'=>'季度','annually'=>'年度','custom'=>'自定义'];
                @endphp
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('plan_name', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $plan->plan_name }}</td>@endif
                    @if(in_array('service_unit_name', $visibleColumns))<td class="px-4 py-3">{{ $plan->serviceUnit?->name ?? '-' }}</td>@endif
                    @if(in_array('vendor_name', $visibleColumns))<td class="px-4 py-3">{{ $plan->vendor?->name ?? '-' }}</td>@endif
                    @if(in_array('cycle_type', $visibleColumns))<td class="px-4 py-3">{{ $cycleMap[$plan->cycle_type] ?? $plan->cycle_type }}</td>@endif
                    @if(in_array('cycle_month', $visibleColumns))<td class="px-4 py-3">{{ $plan->cycle_month ? $plan->cycle_month . '月' : '-' }}</td>@endif
                    @if(in_array('cycle_day', $visibleColumns))<td class="px-4 py-3">{{ $plan->cycle_day ? $plan->cycle_day . '日' : '-' }}</td>@endif
                    @if(in_array('start_date', $visibleColumns))<td class="px-4 py-3">{{ $plan->start_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('end_date', $visibleColumns))<td class="px-4 py-3">{{ $plan->end_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('remind_days', $visibleColumns))<td class="px-4 py-3">{{ $plan->remind_days }}天</td>@endif
                    @if(in_array('is_enabled', $visibleColumns))
                        <td class="px-4 py-3">
                            <flux:badge color="{{ $plan->is_enabled ? 'emerald' : 'zinc' }}" size="sm">{{ $plan->is_enabled ? '启用' : '停用' }}</flux:badge>
                        </td>
                    @endif
                    @if(in_array('next_execute_at', $visibleColumns))<td class="px-4 py-3">{{ $plan->next_execute_at?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $plan->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" wire:click="toggleEnabled({{ $plan->id }})">
                                <flux:icon.power class="size-4 {{ $plan->is_enabled ? 'text-emerald-500' : 'text-zinc-400' }}" />
                            </flux:button>
                            <flux:button variant="ghost" size="sm" :href="route('satisfaction.plans.edit', $plan->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deletePlan({{ $plan->id }})" wire:confirm="确定删除？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $plans->links() }}</div>
</div>
