<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑服务单位' : '新增服务单位' }}</flux:heading>
            <flux:subheading>填写服务单位基本信息及联系人</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('service-units.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div><flux:input wire:model="form.name" label="单位名称" required /></div>
            <div><flux:input wire:model="form.short_name" label="简称" /></div>
            <div class="md:col-span-2"><flux:input wire:model="form.address" label="地址" /></div>
            <div>
                <flux:select wire:model="form.status" label="状态" required>
                    <option value="1">启用</option>
                    <option value="0">停用</option>
                </flux:select>
            </div>
        </div>
        <div><flux:textarea wire:model="form.remark" label="备注" rows="2" /></div>

        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="sm">联系人信息</flux:heading>
                <flux:button variant="ghost" size="sm" wire:click="addContact" type="button">
                    <flux:icon.plus class="size-4" /> 添加联系人
                </flux:button>
            </div>
            @forelse($contacts as $index => $contact)
            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 p-4 mb-3 bg-zinc-50 dark:bg-zinc-900/50">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium">联系人 #{{ $index + 1 }}</span>
                        @if($contact['is_primary'])
                        <flux:badge size="sm" color="amber">主要</flux:badge>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if(!$contact['is_primary'])
                        <flux:button variant="ghost" size="sm" wire:click="setPrimary({{ $index }})" type="button">设为主要</flux:button>
                        @endif
                        <flux:button variant="ghost" size="sm" color="red" wire:click="removeContact({{ $index }})" type="button"><flux:icon.trash class="size-4" /></flux:button>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div><flux:input wire:model="contacts.{{ $index }}.name" label="姓名" required /></div>
                    <div><flux:input wire:model="contacts.{{ $index }}.phone" label="电话" /></div>
                    <div><flux:input wire:model="contacts.{{ $index }}.position" label="职务" /></div>
                    <div><flux:input wire:model="contacts.{{ $index }}.email" label="邮箱" type="email" /></div>
                    <div><flux:input wire:model="contacts.{{ $index }}.address" label="地址" /></div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">关联登录用户</label>
                        <select wire:model="contacts.{{ $index }}.user_id" class="block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 text-sm">
                            <option value="">-- 无 --</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-zinc-500 mt-1">关联后可登录系统</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-zinc-500 py-4">暂无联系人，请点击上方按钮添加</div>
            @endforelse
        </div>

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建单位' }}</flux:button>
            <flux:button variant="ghost" :href="route('service-units.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>
