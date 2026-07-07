<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataDictionary;

class DataDictionarySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // 设备类型
            ['category' => 'device_type', 'code' => 'server', 'name' => '服务器', 'sort_order' => 1],
            ['category' => 'device_type', 'code' => 'ups', 'name' => 'UPS电源', 'sort_order' => 2],
            ['category' => 'device_type', 'code' => 'switch', 'name' => '交换机', 'sort_order' => 3],
            ['category' => 'device_type', 'code' => 'firewall', 'name' => '防火墙', 'sort_order' => 4],
            ['category' => 'device_type', 'code' => 'storage', 'name' => '存储设备', 'sort_order' => 5],
            ['category' => 'device_type', 'code' => 'air_conditioner', 'name' => '精密空调', 'sort_order' => 6],
            ['category' => 'device_type', 'code' => 'power_distribution', 'name' => '配电柜', 'sort_order' => 7],
            // 合同类型
            ['category' => 'contract_type', 'code' => 'software', 'name' => '软件运维', 'sort_order' => 1],
            ['category' => 'contract_type', 'code' => 'hardware', 'name' => '硬件运维', 'sort_order' => 2],
            ['category' => 'contract_type', 'code' => 'infrastructure', 'name' => '机房建设', 'sort_order' => 3],
            ['category' => 'contract_type', 'code' => 'integrated', 'name' => '综合运维', 'sort_order' => 4],
            // 合同状态
            ['category' => 'contract_status', 'code' => 'draft', 'name' => '草稿', 'sort_order' => 1],
            ['category' => 'contract_status', 'code' => 'active', 'name' => '生效中', 'sort_order' => 2],
            ['category' => 'contract_status', 'code' => 'expired', 'name' => '已到期', 'sort_order' => 3],
            ['category' => 'contract_status', 'code' => 'terminated', 'name' => '已终止', 'sort_order' => 4],
            // 维保周期
            ['category' => 'maintenance_cycle', 'code' => 'monthly', 'name' => '月度', 'value' => '1', 'sort_order' => 1],
            ['category' => 'maintenance_cycle', 'code' => 'quarterly', 'name' => '季度', 'value' => '3', 'sort_order' => 2],
            ['category' => 'maintenance_cycle', 'code' => 'semi_annual', 'name' => '半年', 'value' => '6', 'sort_order' => 3],
            ['category' => 'maintenance_cycle', 'code' => 'annual', 'name' => '年度', 'value' => '12', 'sort_order' => 4],
            // 巡检周期
            ['category' => 'inspection_cycle', 'code' => 'daily', 'name' => '日巡检', 'value' => '1', 'sort_order' => 1],
            ['category' => 'inspection_cycle', 'code' => 'weekly', 'name' => '周巡检', 'value' => '7', 'sort_order' => 2],
            ['category' => 'inspection_cycle', 'code' => 'bi_weekly', 'name' => '双周巡检', 'value' => '14', 'sort_order' => 3],
            ['category' => 'inspection_cycle', 'code' => 'monthly', 'name' => '月巡检', 'value' => '30', 'sort_order' => 4],
            // 故障等级
            ['category' => 'fault_level', 'code' => 'critical', 'name' => '紧急', 'sort_order' => 1],
            ['category' => 'fault_level', 'code' => 'major', 'name' => '重大', 'sort_order' => 2],
            ['category' => 'fault_level', 'code' => 'minor', 'name' => '一般', 'sort_order' => 3],
            // 运维单位类型
            ['category' => 'vendor_type', 'code' => 'software', 'name' => '软件运维商', 'sort_order' => 1],
            ['category' => 'vendor_type', 'code' => 'hardware', 'name' => '硬件运维商', 'sort_order' => 2],
            ['category' => 'vendor_type', 'code' => 'infrastructure', 'name' => '机房建设商', 'sort_order' => 3],
            ['category' => 'vendor_type', 'code' => 'integrated', 'name' => '综合服务商', 'sort_order' => 4],
            // 项目层级
            ['category' => 'project_level', 'code' => 'provincial_unified', 'name' => '省统建', 'sort_order' => 1],
            ['category' => 'project_level', 'code' => 'provincial', 'name' => '省建', 'sort_order' => 2],
            ['category' => 'project_level', 'code' => 'municipal', 'name' => '市建', 'sort_order' => 3],
            // 运维类型
            ['category' => 'maintenance_type', 'code' => 'resident_original', 'name' => '原建设方驻场', 'sort_order' => 1],
            ['category' => 'maintenance_type', 'code' => 'remote_original', 'name' => '原建设方远程运维', 'sort_order' => 2],
            ['category' => 'maintenance_type', 'code' => 'self_inspection', 'name' => '自主巡检', 'sort_order' => 3],
            ['category' => 'maintenance_type', 'code' => 'self_resident', 'name' => '自主运维驻场', 'sort_order' => 4],
            ['category' => 'maintenance_type', 'code' => 'purchased', 'name' => '购买服务', 'sort_order' => 5],
            // 满意度等级
            ['category' => 'satisfaction_level', 'code' => 'very_satisfied', 'name' => '非常满意', 'sort_order' => 1],
            ['category' => 'satisfaction_level', 'code' => 'satisfied', 'name' => '满意', 'sort_order' => 2],
            ['category' => 'satisfaction_level', 'code' => 'general', 'name' => '一般', 'sort_order' => 3],
            ['category' => 'satisfaction_level', 'code' => 'dissatisfied', 'name' => '不满意', 'sort_order' => 4],
        ];

        foreach ($data as $item) {
            DataDictionary::firstOrCreate(
                ['category' => $item['category'], 'code' => $item['code']],
                $item
            );
        }
    }
}
