<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑设备' : '新增设备' }}</flux:heading>
            <flux:subheading>填写硬件设备信息</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('assets.hardware.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div><flux:input wire:model="form.device_no" label="设备编号" required /></div>
            <div><flux:input wire:model="form.device_name" label="设备名称" required /></div>
            <div>
                <flux:select wire:model="form.device_type" label="设备类型" required>
                    <option value="">请选择</option>
                    @foreach($deviceTypes as $code => $name)<option value="{{ $code }}">{{ $name }}</option>@endforeach
                </flux:select>
            </div>
            <div><flux:input wire:model="form.brand" label="品牌" /></div>
            <div><flux:input wire:model="form.model" label="型号" /></div>
            <div><flux:input wire:model="form.serial_no" label="序列号" /></div>
            <div><flux:input wire:model="form.location" label="所属位置/机房" /></div>
            <div>
                <flux:select wire:model="form.vendor_id" label="运维单位">
                    <option value="">请选择</option>
                    @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                </flux:select>
            </div>
            <div><flux:input wire:model="form.purchase_date" label="采购日期" type="date" /></div>
            <div><flux:input wire:model="form.purchase_amount" label="采购金额" type="number" step="0.01" /></div>
            <div><flux:input wire:model="form.warranty_period" label="质保期(月)" type="number" /></div>
            <div><flux:input wire:model="form.start_date" label="启用日期" type="date" /></div>
            <div><flux:input wire:model="form.expiry_date" label="预计到期日期" type="date" /></div>
            <div><flux:input wire:model="form.next_maintenance_date" label="下次维保日期" type="date" /></div>
            <div>
                <flux:select wire:model="form.status" label="状态" required>
                    <option value="1">在用</option><option value="0">报废</option><option value="2">维修中</option><option value="3">闲置</option>
                </flux:select>
            </div>
        </div>
        <div><flux:textarea wire:model="form.specification" label="规格参数" rows="3" /></div>
        <div><flux:textarea wire:model="form.remark" label="备注" rows="2" /></div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建设备' }}</flux:button>
            <flux:button variant="ghost" :href="route('assets.hardware.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>
