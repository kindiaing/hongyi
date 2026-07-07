<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">服务单位管理</flux:heading>
            <flux:subheading>运维服务对应的服务单位信息管理</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('service-units.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增服务单位
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索名称/联系人/地址/电话..." /></div>
            <div class="w-32">
                <flux:select wire:model.live="status">
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
                    @if(in_array('name', $visibleColumns))<th class="px-4 py-3">单位名称</th>@endif
                    @if(in_array('short_name', $visibleColumns))<th class="px-4 py-3">简称</th>@endif
                    @if(in_array('address', $visibleColumns))<th class="px-4 py-3">地址</th>@endif
                    @if(in_array('primary_contact', $visibleColumns))<th class="px-4 py-3">主要联系人</th>@endif
                    @if(in_array('contact_count', $visibleColumns))<th class="px-4 py-3">联系人</th>@endif
                    @if(in_array('status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($serviceUnits as $unit)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 cursor-pointer" wire:click="toggleExpand({{ $unit->id }})">
                    @if(in_array('name', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $unit->name }}</td>@endif
                    @if(in_array('short_name', $visibleColumns))<td class="px-4 py-3">{{ $unit->short_name ?? '-' }}</td>@endif
                    @if(in_array('address', $visibleColumns))<td class="px-4 py-3 max-w-xs truncate" title="{{ $unit->address }}">{{ Str::limit($unit->address, 20) ?? '-' }}</td>@endif
                    @if(in_array('primary_contact', $visibleColumns))
                    <td class="px-4 py-3">
                        @php $primary = $unit->contacts->firstWhere('is_primary', true) ?? $unit->contacts->first(); @endphp
                        @if($primary)
                            {{ $primary->name }} {{ $primary->phone ? '('.$primary->phone.')' : '' }}
                        @else
                            <span class="text-zinc-400">-</span>
                        @endif
                    </td>
                    @endif
                    @if(in_array('contact_count', $visibleColumns))
                    <td class="px-4 py-3">
                        <flux:badge size="sm" color="zinc">{{ $unit->contacts->count() }}</flux:badge>
                    </td>
                    @endif
                    @if(in_array('status', $visibleColumns))
                        <td class="px-4 py-3"><flux:badge color="{{ $unit->status ? 'emerald' : 'red' }}" size="sm">{{ $unit->status ? '启用' : '停用' }}</flux:badge></td>
                    @endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $unit->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2" onclick="event.stopPropagation()">
                            <flux:button variant="ghost" size="sm" :href="route('service-units.edit', $unit->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteServiceUnit({{ $unit->id }})" wire:confirm="确定删除？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @if($expandedId === $unit->id)
                <tr>
                    <td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-3 bg-zinc-50 dark:bg-zinc-800/30">
                        <div class="text-sm font-medium mb-2">全部联系人：</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @forelse($unit->contacts as $c)
                            <div class="rounded border border-zinc-200 dark:border-zinc-700 p-3 bg-white dark:bg-zinc-900">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium">{{ $c->name }}</span>
                                    @if($c->is_primary)<flux:badge size="sm" color="amber">主要</flux:badge>@endif
                                    @if($c->user_id)<flux:badge size="sm" color="green">可登录</flux:badge>@endif
                                </div>
                                <div class="text-xs text-zinc-500 space-y-0.5">
                                    @if($c->phone)<div>电话: {{ $c->phone }}</div>@endif
                                    @if($c->position)<div>职务: {{ $c->position }}</div>@endif
                                    @if($c->email)<div>邮箱: {{ $c->email }}</div>@endif
                                    @if($c->address)<div>地址: {{ $c->address }}</div>@endif
                                </div>
                            </div>
                            @empty
                            <div class="text-zinc-500 text-xs">暂无联系人</div>
                            @endforelse
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $serviceUnits->links() }}</div>
</div>
