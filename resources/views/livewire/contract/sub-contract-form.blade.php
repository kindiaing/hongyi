<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">{{ $isEditing ? '编辑分包合同' : '新建分包合同' }}</flux:heading>
            <flux:subheading>填写分包合同基本信息</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('contracts.sub.index')" wire:navigate>
            返回列表
        </flux:button>
    </div>

    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <flux:select wire:model="form.main_contract_id" label="关联主合同" required>
                    <option value="">请选择主合同</option>
                    @foreach($mainContracts as $mc)
                        <option value="{{ $mc->id }}">{{ $mc->contract_name }}</option>
                    @endforeach
                </flux:select>
                @error('form.main_contract_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="form.contract_no" label="合同编号" required />
                @error('form.contract_no') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="form.contract_name" label="合同名称" required />
                @error('form.contract_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:select wire:model="form.vendor_id" label="分包商" required>
                    <option value="">请选择分包商</option>
                    @foreach($vendors as $v)
                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                </flux:select>
                @error('form.vendor_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:select wire:model="form.contract_type" label="合同类型" required>
                    <option value="">请选择类型</option>
                    @foreach($contractTypeOptions as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:input wire:model="form.sub_amount" label="分包金额" type="number" step="0.01" required />
                @error('form.sub_amount') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="form.sla_level" label="SLA等级" />
            </div>
            <div>
                <flux:select wire:model="form.status" label="合同状态" required>
                    @foreach($statusOptions as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:input wire:model="form.signed_date" label="签订日期" type="date" />
            </div>
            <div>
                <flux:input wire:model="form.start_date" label="生效日期" type="date" required />
                @error('form.start_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <flux:input wire:model="form.end_date" label="到期日期" type="date" required />
                @error('form.end_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <flux:textarea wire:model="form.payment_terms" label="付款条款" rows="3" />
        </div>

        <div>
            <flux:textarea wire:model="form.service_scope" label="服务范围" rows="3" />
        </div>

        <div>
            <flux:textarea wire:model="form.remark" label="备注" rows="2" />
        </div>

        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">项目经理</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($projectManagers as $pm)
                        <label class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-1.5 dark:border-zinc-700 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            <input type="checkbox" wire:model="selectedManagers" value="{{ $pm->id }}" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm">{{ $pm->name }}</span>
                        </label>
                    @endforeach
                </div>
                @if($projectManagers->isEmpty())
                    <p class="text-xs text-zinc-500">暂无项目经理，请先创建 project_manager 角色用户</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">关联人员</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($availablePersonnel as $p)
                        <label class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-1.5 dark:border-zinc-700 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            <input type="checkbox" wire:model="selectedPersonnel" value="{{ $p->id }}" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm">{{ $p->name }}</span>
                        </label>
                    @endforeach
                </div>
                @if($availablePersonnel->isEmpty())
                    <p class="text-xs text-zinc-500">暂无可用人员</p>
                @endif
            </div>

            @if($isEditing)
            <div class="flex items-center gap-2 mb-4">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="form.attachment_visible" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm font-medium">允许运维人员查看附件</span>
                </label>
                <p class="text-xs text-zinc-500 ml-2">关闭后，运维单位/运维公司角色无法查看此合同附件</p>
            </div>
            @endif
        </div>

        {{-- 附件上传 --}}
        <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700 space-y-4">
            <flux:heading size="sm">合同附件</flux:heading>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Word 版本（电子版）
                    </label>
                    <input type="file" wire:model="wordFile" accept=".doc,.docx"
                        class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400" />
                    @error('wordFile') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="wordFile" class="mt-1 text-xs text-zinc-500">上传中...</div>
                    @if($wordFile)
                        <div class="mt-2 text-xs text-emerald-600">已选择: {{ $wordFile->getClientOriginalName() }}</div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        PDF 版本（盖章版）
                    </label>
                    <input type="file" wire:model="pdfFile" accept=".pdf"
                        class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400" />
                    @error('pdfFile') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="pdfFile" class="mt-1 text-xs text-zinc-500">上传中...</div>
                    @if($pdfFile)
                        <div class="mt-2 text-xs text-emerald-600">已选择: {{ $pdfFile->getClientOriginalName() }}</div>
                    @endif
                </div>
            </div>

            @if($attachments->isNotEmpty())
            <div class="mt-4">
                <div class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">已有附件</div>
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    @foreach($attachments as $att)
                    <div class="flex items-center justify-between px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($att->version_type === 'word')
                                <flux:icon.document class="size-5 text-blue-500" />
                            @else
                                <flux:icon.document-text class="size-5 text-red-500" />
                            @endif
                            <div>
                                <div class="text-sm font-medium">{{ $att->file_name }}</div>
                                <div class="text-xs text-zinc-500">
                                    {{ $att->version_type_text }} · {{ $att->file_size_text }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ Storage::url($att->file_path) }}" target="_blank"
                                class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium text-indigo-600 hover:bg-indigo-50 dark:text-indigo-400 dark:hover:bg-indigo-900/20">
                                下载
                            </a>
                            <flux:button variant="ghost" size="sm" color="red"
                                wire:click="deleteAttachment({{ $att->id }})"
                                wire:confirm="确定删除此附件？">
                                <flux:icon.trash class="size-4" />
                            </flux:button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">
                {{ $isEditing ? '保存修改' : '创建合同' }}
            </flux:button>
            <flux:button variant="ghost" :href="route('contracts.sub.index')" wire:navigate>
                取消
            </flux:button>
        </div>
    </form>
</div>
