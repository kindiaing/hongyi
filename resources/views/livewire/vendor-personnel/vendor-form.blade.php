<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑运维单位' : '新增运维单位' }}</flux:heading>
            <flux:subheading>填写运维单位基本信息</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('vendors.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div><flux:input wire:model="form.name" label="单位名称" required /></div>
            <div><flux:input wire:model="form.short_name" label="简称" /></div>
            <div><flux:input wire:model="form.unified_code" label="统一社会信用代码" /></div>
            <div>
                <flux:select wire:model="form.type" label="单位类型" required>
                    <option value="software">软件运维商</option>
                    <option value="hardware">硬件运维商</option>
                    <option value="infrastructure">机房建设商</option>
                    <option value="integrated">综合服务商</option>
                </flux:select>
            </div>
            <div><flux:input wire:model="form.qualification_level" label="资质等级" /></div>
            <div><flux:input wire:model="form.legal_person" label="法人姓名" /></div>
            <div><flux:input wire:model="form.contact_name" label="联系人" /></div>
            <div><flux:input wire:model="form.contact_phone" label="联系电话" /></div>
            <div><flux:input wire:model="form.contact_email" label="联系邮箱" type="email" /></div>
            <div><flux:input wire:model="form.address" label="地址" /></div>
            <div><flux:input wire:model="form.bank_name" label="开户银行" /></div>
            <div><flux:input wire:model="form.bank_account" label="银行账号" /></div>
            <div>
                <flux:select wire:model="form.cooperation_status" label="合作状态" required>
                    <option value="1">合作中</option><option value="0">终止</option><option value="2">暂停</option>
                </flux:select>
            </div>
        </div>
        <div><flux:textarea wire:model="form.remark" label="备注" rows="2" /></div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建单位' }}</flux:button>
            <flux:button variant="ghost" :href="route('vendors.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>
