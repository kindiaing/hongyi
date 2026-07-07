<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">用户管理</flux:heading>
            <flux:subheading>系统用户与通讯录管理</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('system.users.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增用户
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索姓名/邮箱/电话/部门..." /></div>
            <div class="w-40">
                <flux:select wire:model.live="role">
                    <option value="">全部角色</option>
                    @foreach($roles as $r)<option value="{{ $r }}">{{ $r }}</option>@endforeach
                </flux:select>
            </div>
            <div class="w-36">
                <flux:select wire:model.live="type">
                    <option value="">全部类型</option>
                    <option value="system">系统用户</option>
                    <option value="address">通讯录</option>
                </flux:select>
            </div>
            <div class="w-36">
                <flux:select wire:model.live="status">
                    <option value="">全部状态</option>
                    <option value="1">正常</option>
                    <option value="0">禁用</option>
                </flux:select>
            </div>
            <flux:button variant="ghost" wire:click="resetFilters" size="sm">重置</flux:button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    <th class="px-4 py-3">姓名</th>
                    <th class="px-4 py-3">邮箱</th>
                    <th class="px-4 py-3">电话</th>
                    <th class="px-4 py-3">部门/供应商</th>
                    <th class="px-4 py-3">角色</th>
                    <th class="px-4 py-3">类型</th>
                    <th class="px-4 py-3">状态</th>
                    <th class="px-4 py-3">附件权限</th>
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($users as $u)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    <td class="px-4 py-3 font-medium">{{ $u->name }}</td>
                    <td class="px-4 py-3">{{ $u->email }}</td>
                    <td class="px-4 py-3">{{ $u->phone ?? '-' }}</td>
                    <td class="px-4 py-3 text-xs">
                        {{ $u->department ?? '-' }}<br>
                        @if($u->vendor)<span class="text-zinc-500">{{ $u->vendor->name }}</span>@endif
                    </td>
                    <td class="px-4 py-3">
                        @foreach($u->roles as $role)
                            <flux:badge size="sm" color="indigo" class="mr-1">{{ $role->name }}</flux:badge>
                        @endforeach
                    </td>
                    <td class="px-4 py-3">
                        @if($u->is_system_user)
                            <flux:badge size="sm" color="green">系统</flux:badge>
                        @else
                            <flux:badge size="sm" color="zinc">通讯录</flux:badge>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($u->status === 1)
                            <flux:badge size="sm" color="green">正常</flux:badge>
                        @else
                            <flux:badge size="sm" color="red">禁用</flux:badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-xs">
                        @if($u->can_view_word)<span class="text-green-600">W</span>@else<span class="text-zinc-400">W</span>@endif
                        @if($u->can_view_pdf)<span class="text-green-600 ml-1">P</span>@else<span class="text-zinc-400 ml-1">P</span>@endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" :href="route('system.users.edit', $u->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            @if(auth()->user()->hasRole('super_admin') && $u->id !== auth()->id())
                            <flux:button variant="ghost" size="sm" wire:click="toggleStatus({{ $u->id }})" title="切换状态"><flux:icon.power class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteUser({{ $u->id }})" wire:confirm="确定删除此用户？"><flux:icon.trash class="size-4" /></flux:button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
