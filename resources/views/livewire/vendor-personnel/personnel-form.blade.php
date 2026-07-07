<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑人员' : '新增人员' }}</flux:heading>
            <flux:subheading>填写运维人员信息</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('personnel.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <flux:select wire:model="form.vendor_id" label="所属单位" required>
                    <option value="">请选择</option>
                    @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                </flux:select>
            </div>
            <div><flux:input wire:model="form.name" label="姓名" required /></div>
            <div><flux:input wire:model="form.phone" label="手机号" required /></div>
            <div><flux:input wire:model="form.email" label="邮箱" type="email" /></div>
            <div>
                <flux:select wire:model="form.gender" label="性别">
                    <option value="1">男</option><option value="0">女</option>
                </flux:select>
            </div>
            <div><flux:input wire:model="form.birth_date" label="出生日期" type="date" /></div>
            <div><flux:input wire:model="form.position" label="岗位" /></div>
            <div><flux:input wire:model="form.job_title" label="职称" /></div>
            <div><flux:input wire:model="form.entry_date" label="入职日期" type="date" /></div>
            <div>
                <flux:select wire:model="form.status" label="在职状态" required>
                    <option value="1">在职</option><option value="0">离职</option><option value="2">休假</option>
                </flux:select>
            </div>
            <div><flux:input wire:model="form.id_card" label="身份证号" /></div>
            <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" wire:model="form.is_resident" id="resident" class="rounded border-zinc-300 text-indigo-600">
                <label for="resident" class="text-sm">是否驻场</label>
            </div>
            <div><flux:input wire:model="form.resident_location" label="驻场地点" /></div>
            <div><flux:input wire:model="form.work_start_time" label="工作开始时间" type="time" /></div>
            <div><flux:input wire:model="form.work_end_time" label="工作结束时间" type="time" /></div>
            <div><flux:input wire:model="form.emergency_contact" label="紧急联系人" /></div>
            <div><flux:input wire:model="form.emergency_phone" label="紧急联系电话" /></div>
        </div>
        <div><flux:textarea wire:model="form.remark" label="备注" rows="2" /></div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建人员' }}</flux:button>
            <flux:button variant="ghost" :href="route('personnel.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>
