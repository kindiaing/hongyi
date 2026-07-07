<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">巡检计划管理</flux:heading>
            <flux:subheading>周期性巡检/回访计划配置</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('inspection.plans.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增计划
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索计划名称..." /></div>
            <div class="w-40">
                <flux:select wire:model.live="cycleType">
                    <option value="">全部周期</option>
                    <option value="daily">每日</option>
                    <option value="weekly">每周</option>
                    <option value="biweekly">双周</option>
                    <option value="monthly">每月</option>
                    <option value="quarterly">每季度</option>
                    <option value="custom">自定义</option>
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="vendorId">
                    <option value="">全部运维单位</option>
                    @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="templateId">
                    <option value="">全部模板</option>
                    @foreach($templates as $t)<option value="{{ $t->id }}">{{ $t->template_name }}</option>@endforeach
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
                    @if(in_array('template', $visibleColumns))<th class="px-4 py-3">模板</th>@endif
                    @if(in_array('vendor', $visibleColumns))<th class="px-4 py-3">运维单位</th>@endif
                    @if(in_array('target', $visibleColumns))<th class="px-4 py-3">巡检对象</th>@endif
                    @if(in_array('cycle_type', $visibleColumns))<th class="px-4 py-3">周期</th>@endif
                    @if(in_array('execute_time', $visibleColumns))<th class="px-4 py-3">执行时间</th>@endif
                    @if(in_array('start_date', $visibleColumns))<th class="px-4 py-3">开始日期</th>@endif
                    @if(in_array('end_date', $visibleColumns))<th class="px-4 py-3">结束日期</th>@endif
                    @if(in_array('assignee', $visibleColumns))<th class="px-4 py-3">负责人</th>@endif
                    @if(in_array('is_enabled', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('last_generated_at', $visibleColumns))<th class="px-4 py-3">上次生成</th>@endif
                    @if(in_array('next_generate_at', $visibleColumns))<th class="px-4 py-3">下次生成</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($plans as $p)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('plan_name', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $p->plan_name }}</td>@endif
                    @if(in_array('template', $visibleColumns))<td class="px-4 py-3">{{ $p->template?->template_name ?? '-' }}</td>@endif
                    @if(in_array('vendor', $visibleColumns))<td class="px-4 py-3">{{ $p->vendor?->name ?? '-' }}</td>@endif
                    @if(in_array('target', $visibleColumns))<td class="px-4 py-3">{{ $p->target_name }}</td>@endif
                    @if(in_array('cycle_type', $visibleColumns))<td class="px-4 py-3">{{ $p->cycle_type_text }}</td>@endif
                    @if(in_array('execute_time', $visibleColumns))<td class="px-4 py-3">{{ substr($p->execute_time, 0, 5) }}</td>@endif
                    @if(in_array('start_date', $visibleColumns))<td class="px-4 py-3">{{ $p->start_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('end_date', $visibleColumns))<td class="px-4 py-3">{{ $p->end_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('assignee', $visibleColumns))<td class="px-4 py-3">{{ $p->assignee?->name ?? '-' }}</td>@endif
                    @if(in_array('is_enabled', $visibleColumns))
                        <td class="px-4 py-3"><flux:badge color="{{ $p->is_enabled ? 'emerald' : 'zinc' }}" size="sm">{{ $p->is_enabled ? '启用' : '禁用' }}</flux:badge></td>
                    @endif
                    @if(in_array('last_generated_at', $visibleColumns))<td class="px-4 py-3">{{ $p->last_generated_at?->format('m-d H:i') ?? '-' }}</td>@endif
                    @if(in_array('next_generate_at', $visibleColumns))<td class="px-4 py-3">{{ $p->next_generate_at?->format('m-d H:i') ?? '-' }}</td>@endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $p->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" wire:click="toggleEnabled({{ $p->id }})" title="切换状态"><flux:icon.power class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" :href="route('inspection.plans.edit', $p->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deletePlan({{ $p->id }})" wire:confirm="确定删除？"><flux:icon.trash class="size-4" /></flux:button>
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
