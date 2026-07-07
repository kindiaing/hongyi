<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑用户' : '新增用户' }}</flux:heading>
            <flux:subheading>管理系统用户与角色</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('system.users.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div><flux:input wire:model="form.name" label="姓名" required /></div>
            <div><flux:input wire:model="form.email" label="邮箱" type="email" required /></div>
            <div><flux:input wire:model="form.phone" label="电话" placeholder="可选" /></div>
            <div><flux:input wire:model="form.department" label="部门" placeholder="可选" /></div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">所属供应商</label>
                <select wire:model="form.vendor_id" class="block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 text-sm">
                    <option value="">-- 无 --</option>
                    @foreach($vendors as $v)
                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">所属服务单位</label>
                <select wire:model="form.service_unit_id" class="block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 text-sm">
                    <option value="">-- 无 --</option>
                    @foreach($serviceUnits as $su)
                    <option value="{{ $su->id }}">{{ $su->name }}</option>
                    @endforeach
                </select>
            </div>
            <div><flux:input wire:model="form.password" label="密码" type="password" :required="!$isEditing" /></div>
            @if($isEditing)
            <div class="text-xs text-zinc-500 pt-6">留空则不修改密码</div>
            @endif
        </div>
        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4">
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">用户类型与权限</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="form.is_system_user" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm">系统用户（可登录）</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="form.can_view_word" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm">可查看 Word 附件</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="form.can_view_pdf" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm">可查看 PDF 附件</span>
                </label>
            </div>
            <p class="text-xs text-zinc-500 mt-2">非系统用户为通讯录人员，无法登录系统。附件权限仅对运维单位/运维公司角色生效。</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">角色</label>
            <div class="flex flex-wrap gap-3">
                @foreach($roles as $role)
                    <label class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-1.5 dark:border-zinc-700 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800">
                        <input type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建用户' }}</flux:button>
            <flux:button variant="ghost" :href="route('system.users.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>
