<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">操作日志</flux:heading>
            <flux:subheading>系统操作记录与审计</flux:subheading>
        </div>
        <flux:button variant="ghost" size="sm" :href="route('system.audit_configs.index')" wire:navigate>
            <flux:icon.adjustments-horizontal class="size-4" /> 审计配置
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索描述/IP..." /></div>
            <div class="w-40">
                <flux:select wire:model.live="action">
                    <option value="">全部操作</option>
                    @foreach($actions as $a)<option value="{{ $a }}">{{ $a }}</option>@endforeach
                </flux:select>
            </div>
            <div class="w-40"><flux:input wire:model.live="dateFrom" type="date" label="开始日期" /></div>
            <div class="w-40"><flux:input wire:model.live="dateTo" type="date" label="结束日期" /></div>
            <flux:button variant="ghost" wire:click="resetFilters" size="sm">重置</flux:button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    <th class="px-4 py-3">时间</th>
                    <th class="px-4 py-3">用户</th>
                    <th class="px-4 py-3">方法</th>
                    <th class="px-4 py-3">路径</th>
                    <th class="px-4 py-3">操作</th>
                    <th class="px-4 py-3">描述</th>
                    <th class="px-4 py-3">IP地址</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($logs as $log)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $log->created_at?->format('Y-m-d H:i:s') ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $log->user?->name ?? '系统' }}</td>
                    <td class="px-4 py-3"><flux:badge size="sm" color="blue">{{ $log->method }}</flux:badge></td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $log->path }}</td>
                    <td class="px-4 py-3">{{ $log->action }}</td>
                    <td class="px-4 py-3 max-w-md truncate" title="{{ $log->description }}">{{ $log->description }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $log->ip }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
</div>
