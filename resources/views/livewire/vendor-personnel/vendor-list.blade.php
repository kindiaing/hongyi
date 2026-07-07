<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">运维单位管理</flux:heading>
            <flux:subheading>各运维软硬件公司信息管理</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('vendors.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增单位
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索名称/联系人..." /></div>
            <div class="w-40">
                <flux:select wire:model.live="type">
                    <option value="">全部类型</option>
                    <option value="software">软件运维商</option>
                    <option value="hardware">硬件运维商</option>
                    <option value="infrastructure">机房建设商</option>
                    <option value="integrated">综合服务商</option>
                </flux:select>
            </div>
            <div class="w-32">
                <flux:select wire:model.live="cooperationStatus">
                    <option value="">全部状态</option>
                    <option value="1">合作中</option>
                    <option value="0">终止</option>
                    <option value="2">暂停</option>
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
                    @if(in_array('unified_code', $visibleColumns))<th class="px-4 py-3">统一信用代码</th>@endif
                    @if(in_array('type', $visibleColumns))<th class="px-4 py-3">类型</th>@endif
                    @if(in_array('qualification_level', $visibleColumns))<th class="px-4 py-3">资质等级</th>@endif
                    @if(in_array('legal_person', $visibleColumns))<th class="px-4 py-3">法人</th>@endif
                    @if(in_array('contact_name', $visibleColumns))<th class="px-4 py-3">联系人</th>@endif
                    @if(in_array('contact_phone', $visibleColumns))<th class="px-4 py-3">联系电话</th>@endif
                    @if(in_array('contact_email', $visibleColumns))<th class="px-4 py-3">邮箱</th>@endif
                    @if(in_array('address', $visibleColumns))<th class="px-4 py-3">地址</th>@endif
                    @if(in_array('cooperation_status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($vendors as $v)
                @php
                    $typeMap = ['software'=>'软件运维商','hardware'=>'硬件运维商','infrastructure'=>'机房建设商','integrated'=>'综合服务商'];
                    $statusMap = ['终止','合作中','暂停'];
                    $statusColors = ['red','emerald','orange'];
                @endphp
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('name', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $v->name }}</td>@endif
                    @if(in_array('short_name', $visibleColumns))<td class="px-4 py-3">{{ $v->short_name ?? '-' }}</td>@endif
                    @if(in_array('unified_code', $visibleColumns))<td class="px-4 py-3">{{ $v->unified_code ?? '-' }}</td>@endif
                    @if(in_array('type', $visibleColumns))<td class="px-4 py-3">{{ $typeMap[$v->type] ?? $v->type }}</td>@endif
                    @if(in_array('qualification_level', $visibleColumns))<td class="px-4 py-3">{{ $v->qualification_level ?? '-' }}</td>@endif
                    @if(in_array('legal_person', $visibleColumns))<td class="px-4 py-3">{{ $v->legal_person ?? '-' }}</td>@endif
                    @if(in_array('contact_name', $visibleColumns))<td class="px-4 py-3">{{ $v->contact_name ?? '-' }}</td>@endif
                    @if(in_array('contact_phone', $visibleColumns))<td class="px-4 py-3">{{ $v->contact_phone ?? '-' }}</td>@endif
                    @if(in_array('contact_email', $visibleColumns))<td class="px-4 py-3">{{ $v->contact_email ?? '-' }}</td>@endif
                    @if(in_array('address', $visibleColumns))<td class="px-4 py-3 max-w-xs truncate" title="{{ $v->address }}">{{ Str::limit($v->address, 20) ?? '-' }}</td>@endif
                    @if(in_array('cooperation_status', $visibleColumns))
                        <td class="px-4 py-3"><flux:badge color="{{ $statusColors[$v->cooperation_status] ?? 'zinc' }}" size="sm">{{ $statusMap[$v->cooperation_status] ?? '未知' }}</flux:badge></td>
                    @endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $v->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" :href="route('vendors.edit', $v->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteVendor({{ $v->id }})" wire:confirm="确定删除？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $vendors->links() }}</div>
</div>
