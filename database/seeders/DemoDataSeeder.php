<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Personnel;
use App\Models\HardwareDevice;
use App\Models\Software;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $userId = \App\Models\User::first()?->id ?? 1;

        // 1. 运维单位
        $vendors = [
            ['name' => '华为技术服务有限公司', 'short_name' => '华为', 'type' => 'hardware', 'cooperation_status' => 1, 'contact_name' => '张伟', 'contact_phone' => '13800138001', 'address' => '深圳市龙岗区'],
            ['name' => '阿里云智能科技有限公司', 'short_name' => '阿里云', 'type' => 'software', 'cooperation_status' => 1, 'contact_name' => '李娜', 'contact_phone' => '13800138002', 'address' => '杭州市余杭区'],
            ['name' => '北京浪潮电子信息产业有限公司', 'short_name' => '浪潮', 'type' => 'hardware', 'cooperation_status' => 1, 'contact_name' => '王强', 'contact_phone' => '13800138003', 'address' => '北京市海淀区'],
            ['name' => '腾讯云智慧运维服务有限公司', 'short_name' => '腾讯云', 'type' => 'integrated', 'cooperation_status' => 1, 'contact_name' => '赵敏', 'contact_phone' => '13800138004', 'address' => '深圳市南山区'],
            ['name' => '杭州海康威视数字技术股份有限公司', 'short_name' => '海康威视', 'type' => 'infrastructure', 'cooperation_status' => 1, 'contact_name' => '刘洋', 'contact_phone' => '13800138005', 'address' => '杭州市滨江区'],
        ];

        foreach ($vendors as $data) {
            Vendor::firstOrCreate(['name' => $data['name']], $data);
        }

        $vendorIds = Vendor::pluck('id', 'name')->toArray();

        // 2. 人员
        $personnelData = [
            ['vendor_id' => $vendorIds['华为技术服务有限公司'], 'name' => '张伟', 'phone' => '13800138001', 'gender' => 1, 'position' => '高级工程师', 'status' => 1, 'is_resident' => 1, 'resident_location' => '市政府数据中心'],
            ['vendor_id' => $vendorIds['华为技术服务有限公司'], 'name' => '陈明', 'phone' => '13900139001', 'gender' => 1, 'position' => '工程师', 'status' => 1, 'is_resident' => 0],
            ['vendor_id' => $vendorIds['阿里云智能科技有限公司'], 'name' => '李娜', 'phone' => '13800138002', 'gender' => 0, 'position' => '项目经理', 'status' => 1, 'is_resident' => 1, 'resident_location' => '政务云平台'],
            ['vendor_id' => $vendorIds['阿里云智能科技有限公司'], 'name' => '孙涛', 'phone' => '13900139002', 'gender' => 1, 'position' => '开发工程师', 'status' => 1, 'is_resident' => 0],
            ['vendor_id' => $vendorIds['北京浪潮电子信息产业有限公司'], 'name' => '王强', 'phone' => '13800138003', 'gender' => 1, 'position' => '技术主管', 'status' => 1, 'is_resident' => 1, 'resident_location' => '机房A'],
            ['vendor_id' => $vendorIds['腾讯云智慧运维服务有限公司'], 'name' => '赵敏', 'phone' => '13800138004', 'gender' => 0, 'position' => '运维经理', 'status' => 1, 'is_resident' => 0],
            ['vendor_id' => $vendorIds['腾讯云智慧运维服务有限公司'], 'name' => '周杰', 'phone' => '13900139004', 'gender' => 1, 'position' => '运维工程师', 'status' => 1, 'is_resident' => 1, 'resident_location' => '数据中心'],
            ['vendor_id' => $vendorIds['杭州海康威视数字技术股份有限公司'], 'name' => '刘洋', 'phone' => '13800138005', 'gender' => 1, 'position' => '安防工程师', 'status' => 1, 'is_resident' => 0],
        ];

        foreach ($personnelData as $data) {
            Personnel::firstOrCreate(['phone' => $data['phone']], $data);
        }

        // 3. 硬件设备
        $devices = [
            ['device_no' => 'SRV-2026-001', 'device_name' => '华为FusionServer 2288H V6', 'device_type' => 'server', 'brand' => '华为', 'model' => 'FusionServer 2288H V6', 'location' => '机房A-机柜1', 'vendor_id' => $vendorIds['华为技术服务有限公司'], 'purchase_amount' => 45000.00, 'warranty_period' => 36, 'status' => 1, 'next_maintenance_date' => now()->addMonths(1)->format('Y-m-d')],
            ['device_no' => 'UPS-2026-001', 'device_name' => '华为UPS5000-E', 'device_type' => 'ups', 'brand' => '华为', 'model' => 'UPS5000-E 400kVA', 'location' => '机房A-配电间', 'vendor_id' => $vendorIds['华为技术服务有限公司'], 'purchase_amount' => 120000.00, 'warranty_period' => 60, 'status' => 1, 'next_maintenance_date' => now()->addMonths(2)->format('Y-m-d')],
            ['device_no' => 'SW-2026-001', 'device_name' => '华为CloudEngine S12700E', 'device_type' => 'switch', 'brand' => '华为', 'model' => 'S12700E-8', 'location' => '机房A-网络区', 'vendor_id' => $vendorIds['华为技术服务有限公司'], 'purchase_amount' => 85000.00, 'warranty_period' => 36, 'status' => 1, 'next_maintenance_date' => now()->addMonths(3)->format('Y-m-d')],
            ['device_no' => 'FW-2026-001', 'device_name' => '华为USG6300E', 'device_type' => 'firewall', 'brand' => '华为', 'model' => 'USG6300E', 'location' => '机房A-安全区', 'vendor_id' => $vendorIds['华为技术服务有限公司'], 'purchase_amount' => 32000.00, 'warranty_period' => 36, 'status' => 1, 'next_maintenance_date' => now()->addMonths(1)->format('Y-m-d')],
            ['device_no' => 'STG-2026-001', 'device_name' => '浪潮AS5500G5', 'device_type' => 'storage', 'brand' => '浪潮', 'model' => 'AS5500G5', 'location' => '机房A-存储区', 'vendor_id' => $vendorIds['北京浪潮电子信息产业有限公司'], 'purchase_amount' => 180000.00, 'warranty_period' => 60, 'status' => 1, 'next_maintenance_date' => now()->addMonths(2)->format('Y-m-d')],
            ['device_no' => 'AC-2026-001', 'device_name' => '海康威视精密空调', 'device_type' => 'air_conditioner', 'brand' => '海康威视', 'model' => 'HVAC-50KW', 'location' => '机房A-空调区', 'vendor_id' => $vendorIds['杭州海康威视数字技术股份有限公司'], 'purchase_amount' => 65000.00, 'warranty_period' => 24, 'status' => 1, 'next_maintenance_date' => now()->addMonths(1)->format('Y-m-d')],
            ['device_no' => 'PD-2026-001', 'device_name' => '配电柜A01', 'device_type' => 'power_distribution', 'brand' => '海康威视', 'model' => 'PD-400A', 'location' => '机房A-配电间', 'vendor_id' => $vendorIds['杭州海康威视数字技术股份有限公司'], 'purchase_amount' => 28000.00, 'warranty_period' => 24, 'status' => 1, 'next_maintenance_date' => now()->addMonths(3)->format('Y-m-d')],
            ['device_no' => 'SRV-2026-002', 'device_name' => '浪潮NF5280M6', 'device_type' => 'server', 'brand' => '浪潮', 'model' => 'NF5280M6', 'location' => '机房B-机柜2', 'vendor_id' => $vendorIds['北京浪潮电子信息产业有限公司'], 'purchase_amount' => 38000.00, 'warranty_period' => 36, 'status' => 2, 'next_maintenance_date' => now()->addMonths(1)->format('Y-m-d')],
        ];

        foreach ($devices as $data) {
            $data['created_by'] = $userId;
            HardwareDevice::firstOrCreate(['device_no' => $data['device_no']], $data);
        }

        // 4. 软件系统
        $software = [
            ['software_no' => 'SW-2026-001', 'software_name' => '政务云平台管理系统', 'version' => 'v3.2.1', 'deploy_environment' => '生产环境', 'deploy_server' => 'srv-web-01, srv-web-02', 'license_info' => '永久授权，50用户', 'vendor_id' => $vendorIds['阿里云智能科技有限公司'], 'maintenance_start_date' => '2026-01-01', 'maintenance_end_date' => '2026-12-31', 'sla_level' => '7x24', 'is_resident_required' => 1, 'resident_location' => '政务云平台', 'work_start_time' => '08:00', 'work_end_time' => '18:00', 'emergency_response_time' => 30, 'status' => 1],
            ['software_no' => 'SW-2026-002', 'software_name' => '数据交换平台', 'version' => 'v2.5.0', 'deploy_environment' => '生产环境', 'deploy_server' => 'srv-data-01', 'license_info' => '年度授权，100节点', 'vendor_id' => $vendorIds['阿里云智能科技有限公司'], 'maintenance_start_date' => '2026-01-01', 'maintenance_end_date' => '2026-12-31', 'sla_level' => '7x24', 'is_resident_required' => 0, 'work_start_time' => '09:00', 'work_end_time' => '17:30', 'emergency_response_time' => 60, 'status' => 1],
            ['software_no' => 'SW-2026-003', 'software_name' => '统一身份认证系统', 'version' => 'v4.0.2', 'deploy_environment' => '生产环境', 'deploy_server' => 'srv-auth-01', 'license_info' => '永久授权，无限用户', 'vendor_id' => $vendorIds['腾讯云智慧运维服务有限公司'], 'maintenance_start_date' => '2026-01-01', 'maintenance_end_date' => '2026-12-31', 'sla_level' => '5x8', 'is_resident_required' => 1, 'resident_location' => '数据中心', 'work_start_time' => '08:30', 'work_end_time' => '17:30', 'emergency_response_time' => 120, 'status' => 1],
            ['software_no' => 'SW-2026-004', 'software_name' => '视频监控管理平台', 'version' => 'v5.1.0', 'deploy_environment' => '生产环境', 'deploy_server' => 'srv-video-01', 'license_info' => '按摄像头数量授权', 'vendor_id' => $vendorIds['杭州海康威视数字技术股份有限公司'], 'maintenance_start_date' => '2026-01-01', 'maintenance_end_date' => '2026-12-31', 'sla_level' => '7x24', 'is_resident_required' => 0, 'work_start_time' => '08:00', 'work_end_time' => '18:00', 'emergency_response_time' => 60, 'status' => 1],
            ['software_no' => 'SW-2026-005', 'software_name' => '工单管理系统', 'version' => 'v1.8.3', 'deploy_environment' => '生产环境', 'deploy_server' => 'srv-ticket-01', 'license_info' => '开源免费', 'vendor_id' => $vendorIds['腾讯云智慧运维服务有限公司'], 'maintenance_start_date' => '2026-01-01', 'maintenance_end_date' => '2026-12-31', 'sla_level' => '5x8', 'is_resident_required' => 0, 'work_start_time' => '09:00', 'work_end_time' => '17:30', 'emergency_response_time' => 240, 'status' => 2],
        ];

        foreach ($software as $data) {
            $data['created_by'] = $userId;
            Software::firstOrCreate(['software_no' => $data['software_no']], $data);
        }

        // 5. 巡检模板
        $templateData = [
            'template_name' => '机房环境巡检',
            'template_type' => 'inspection',
            'category' => '硬件',
            'description' => '机房温湿度、UPS、空调等设备巡检',
            'is_enabled' => 1,
            'created_by' => $userId,
        ];
        $template = \App\Models\InspectionTemplate::firstOrCreate(
            ['template_name' => $templateData['template_name']],
            $templateData
        );

        $templateItems = [
            ['item_name' => '机房温度', 'item_type' => 'number', 'standard' => '18-27°C', 'is_required' => 1, 'sort_order' => 1],
            ['item_name' => '机房湿度', 'item_type' => 'number', 'standard' => '40%-60%', 'is_required' => 1, 'sort_order' => 2],
            ['item_name' => 'UPS运行状态', 'item_type' => 'single_choice', 'options' => json_encode(['正常', '异常']), 'standard' => '正常', 'is_required' => 1, 'sort_order' => 3],
            ['item_name' => '空调运行状态', 'item_type' => 'single_choice', 'options' => json_encode(['正常', '异常']), 'standard' => '正常', 'is_required' => 1, 'sort_order' => 4],
            ['item_name' => '消防设备检查', 'item_type' => 'single_choice', 'options' => json_encode(['正常', '异常']), 'standard' => '正常', 'is_required' => 1, 'sort_order' => 5],
            ['item_name' => '巡检照片', 'item_type' => 'photo', 'is_required' => 1, 'sort_order' => 6],
        ];
        foreach ($templateItems as $item) {
            $item['template_id'] = $template->id;
            \App\Models\InspectionTemplateItem::firstOrCreate(
                ['template_id' => $template->id, 'item_name' => $item['item_name']],
                $item
            );
        }

        $visitTemplate = \App\Models\InspectionTemplate::firstOrCreate(
            ['template_name' => '软件系统回访'],
            [
                'template_name' => '软件系统回访',
                'template_type' => 'visit',
                'category' => '软件',
                'description' => '软件系统运行状态回访',
                'is_enabled' => 1,
                'created_by' => $userId,
            ]
        );

        // 6. 巡检计划
        $hwDevice = HardwareDevice::first();
        $personnel = \App\Models\Personnel::first();
        $huaweiVendor = Vendor::where('name', '华为技术服务有限公司')->first();

        $planData = [
            'plan_name' => '机房A周巡检',
            'template_id' => $template->id,
            'vendor_id' => $huaweiVendor->id,
            'target_type' => 'hardware',
            'target_id' => $hwDevice?->id ?? 1,
            'cycle_type' => 'weekly',
            'execute_time' => '09:00',
            'start_date' => now()->format('Y-m-d'),
            'assignee_id' => $personnel?->id,
            'is_enabled' => 1,
            'created_by' => $userId,
        ];
        $plan = \App\Models\InspectionPlan::firstOrCreate(
            ['plan_name' => $planData['plan_name']],
            $planData
        );

        // 7. 巡检任务
        $taskData = [
            'task_no' => 'INS-' . now()->format('Ymd') . '-001',
            'plan_id' => $plan->id,
            'template_id' => $template->id,
            'task_name' => '机房A周巡检任务',
            'task_type' => 'inspection',
            'vendor_id' => $huaweiVendor->id,
            'target_type' => 'hardware',
            'target_id' => $hwDevice?->id ?? 1,
            'assignee_id' => $personnel?->id,
            'planned_date' => now()->format('Y-m-d'),
            'planned_time' => '09:00',
            'start_time' => now()->subHours(2),
            'end_time' => now()->subHour(),
            'overall_result' => 1,
            'status' => 2,
            'sign_in_address' => '市政府数据中心机房A',
        ];
        \App\Models\InspectionTask::firstOrCreate(
            ['task_no' => $taskData['task_no']],
            $taskData
        );

        $taskData2 = [
            'task_no' => 'INS-' . now()->format('Ymd') . '-002',
            'plan_id' => null,
            'template_id' => $template->id,
            'task_name' => '机房B紧急巡检',
            'task_type' => 'inspection',
            'vendor_id' => $huaweiVendor->id,
            'target_type' => 'hardware',
            'target_id' => $hwDevice?->id ?? 1,
            'assignee_id' => $personnel?->id,
            'planned_date' => now()->addDay()->format('Y-m-d'),
            'planned_time' => '10:00',
            'status' => 0,
        ];
        \App\Models\InspectionTask::firstOrCreate(
            ['task_no' => $taskData2['task_no']],
            $taskData2
        );

        // 回访任务
        $sw = Software::first();
        $aliVendor = Vendor::where('name', '阿里云智能科技有限公司')->first();
        $aliPersonnel = \App\Models\Personnel::where('name', '李娜')->first();
        $taskData3 = [
            'task_no' => 'VIS-' . now()->format('Ymd') . '-001',
            'plan_id' => null,
            'template_id' => $visitTemplate->id,
            'task_name' => '政务云平台月度回访',
            'task_type' => 'visit',
            'vendor_id' => $aliVendor?->id,
            'target_type' => 'software',
            'target_id' => $sw?->id,
            'assignee_id' => $aliPersonnel?->id,
            'planned_date' => now()->format('Y-m-d'),
            'planned_time' => '14:00',
            'start_time' => now()->subHours(3),
            'end_time' => now()->subHours(2),
            'overall_result' => 1,
            'status' => 3,
            'auditor_id' => $userId,
            'audit_time' => now()->subHour(),
            'audit_result' => 1,
            'audit_comment' => '回访结果良好，系统运行稳定',
        ];
        \App\Models\InspectionTask::firstOrCreate(
            ['task_no' => $taskData3['task_no']],
            $taskData3
        );

        // 8. 排班
        $schedules = [
            ['software_id' => $sw?->id, 'personnel_id' => $aliPersonnel?->id, 'shift_date' => now()->format('Y-m-d'), 'shift_type' => 'day', 'start_time' => '08:00', 'end_time' => '18:00', 'status' => 1],
            ['software_id' => $sw?->id, 'personnel_id' => $aliPersonnel?->id, 'shift_date' => now()->addDay()->format('Y-m-d'), 'shift_type' => 'day', 'start_time' => '08:00', 'end_time' => '18:00', 'status' => 1],
            ['software_id' => null, 'personnel_id' => $personnel?->id, 'shift_date' => now()->format('Y-m-d'), 'shift_type' => 'night', 'start_time' => '18:00', 'end_time' => '08:00', 'status' => 1],
        ];
        foreach ($schedules as $s) {
            if ($s['personnel_id']) {
                \App\Models\Schedule::firstOrCreate(
                    ['personnel_id' => $s['personnel_id'], 'shift_date' => $s['shift_date'], 'shift_type' => $s['shift_type']],
                    $s
                );
            }
        }

        // 9. 操作日志
        $logs = [
            ['user_id' => $userId, 'method' => 'POST', 'path' => '/contracts/main', 'ip' => '127.0.0.1', 'action' => '创建主合同', 'description' => '创建主合同：数据中心运维服务合同'],
            ['user_id' => $userId, 'method' => 'PUT', 'path' => '/assets/hardware/1', 'ip' => '127.0.0.1', 'action' => '更新设备', 'description' => '更新硬件设备：SRV-2026-001'],
            ['user_id' => $userId, 'method' => 'DELETE', 'path' => '/personnel/1', 'ip' => '127.0.0.1', 'action' => '删除人员', 'description' => '删除人员信息'],
            ['user_id' => $userId, 'method' => 'POST', 'path' => '/login', 'ip' => '127.0.0.1', 'action' => '用户登录', 'description' => '用户登录系统'],
            ['user_id' => $userId, 'method' => 'POST', 'path' => '/inspection/plans', 'ip' => '127.0.0.1', 'action' => '创建巡检计划', 'description' => '创建巡检计划：机房A周巡检'],
        ];
        foreach ($logs as $log) {
            \App\Models\OperationLog::create($log);
        }

        // 10. 服务单位
        $serviceUnits = [
            ['name' => '市政府数据中心', 'short_name' => '市数据中心', 'address' => '市政府大楼A座3楼', 'contact_name' => '王明', 'contact_phone' => '13800138100', 'status' => 1, 'created_by' => $userId],
            ['name' => '政务服务中心', 'short_name' => '政务中心', 'address' => '市民广场B座', 'contact_name' => '李红', 'contact_phone' => '13800138101', 'status' => 1, 'created_by' => $userId],
            ['name' => '应急管理局', 'short_name' => '应急局', 'address' => '行政中心C座5楼', 'contact_name' => '张军', 'contact_phone' => '13800138102', 'status' => 1, 'created_by' => $userId],
        ];
        foreach ($serviceUnits as $su) {
            \App\Models\ServiceUnit::firstOrCreate(['name' => $su['name']], $su);
        }
        $serviceUnitIds = \App\Models\ServiceUnit::pluck('id', 'name')->toArray();

        // 11. 回访计划
        $surveyPlans = [
            [
                'plan_name' => '市数据中心月度回访',
                'service_unit_id' => $serviceUnitIds['市政府数据中心'],
                'vendor_id' => $vendorIds['华为技术服务有限公司'] ?? null,
                'cycle_type' => 'monthly',
                'cycle_day' => 15,
                'start_date' => now()->format('Y-m-d'),
                'remind_days' => 3,
                'is_enabled' => true,
                'next_execute_at' => now()->day(15)->startOfDay(),
                'created_by' => $userId,
            ],
            [
                'plan_name' => '政务中心季度满意度调查',
                'service_unit_id' => $serviceUnitIds['政务服务中心'],
                'vendor_id' => $vendorIds['阿里云智能科技有限公司'] ?? null,
                'cycle_type' => 'quarterly',
                'cycle_month' => 3,
                'cycle_day' => 1,
                'start_date' => now()->format('Y-m-d'),
                'remind_days' => 5,
                'is_enabled' => true,
                'next_execute_at' => now()->month(3)->day(1)->startOfDay(),
                'created_by' => $userId,
            ],
        ];
        foreach ($surveyPlans as $sp) {
            \App\Models\SatisfactionSurveyPlan::firstOrCreate(
                ['plan_name' => $sp['plan_name']],
                $sp
            );
        }
        $surveyPlanIds = \App\Models\SatisfactionSurveyPlan::pluck('id', 'plan_name')->toArray();

        // 12. 回访/满意度调查记录
        $personnelIds = \App\Models\Personnel::pluck('id', 'name')->toArray();
        $surveys = [
            [
                'plan_id' => $surveyPlanIds['市数据中心月度回访'] ?? null,
                'service_unit_id' => $serviceUnitIds['市政府数据中心'],
                'personnel_id' => $personnelIds['张伟'] ?? null,
                'survey_date' => now()->subDays(10)->format('Y-m-d'),
                'satisfaction_level' => 'very_satisfied',
                'service_attitude_score' => 5,
                'response_speed_score' => 4,
                'technical_level_score' => 5,
                'overall_evaluation' => '运维人员工作认真负责，响应及时，技术能力强',
                'improvement_suggestions' => '建议增加定期技术培训',
                'surveyor_id' => $userId,
                'status' => 1,
                'created_by' => $userId,
            ],
            [
                'plan_id' => null,
                'service_unit_id' => $serviceUnitIds['政务服务中心'],
                'personnel_id' => $personnelIds['李娜'] ?? null,
                'survey_date' => now()->subDays(5)->format('Y-m-d'),
                'satisfaction_level' => 'satisfied',
                'service_attitude_score' => 4,
                'response_speed_score' => 4,
                'technical_level_score' => 4,
                'overall_evaluation' => '整体服务满意，云平台运行稳定',
                'improvement_suggestions' => '希望优化部分系统响应速度',
                'surveyor_id' => $userId,
                'status' => 1,
                'created_by' => $userId,
            ],
            [
                'plan_id' => null,
                'service_unit_id' => $serviceUnitIds['应急管理局'],
                'personnel_id' => $personnelIds['王强'] ?? null,
                'survey_date' => now()->subDays(2)->format('Y-m-d'),
                'satisfaction_level' => 'general',
                'service_attitude_score' => 3,
                'response_speed_score' => 3,
                'technical_level_score' => 4,
                'overall_evaluation' => '服务基本满足需求，但响应速度有待提升',
                'improvement_suggestions' => '加强节假日期间的运维保障',
                'surveyor_id' => $userId,
                'status' => 1,
                'created_by' => $userId,
            ],
        ];
        foreach ($surveys as $survey) {
            \App\Models\SatisfactionSurvey::firstOrCreate(
                ['service_unit_id' => $survey['service_unit_id'], 'personnel_id' => $survey['personnel_id'], 'survey_date' => $survey['survey_date']],
                $survey
            );
        }

        // 13. 创建测试用户（不同角色）
        $testUsers = [
            ['name' => '项目经理A', 'email' => 'pm1@example.com', 'phone' => '13900000001', 'password' => 'password', 'vendor_id' => $vendorIds['华为技术服务有限公司'] ?? null, 'is_system_user' => true, 'status' => 1, 'role' => 'project_manager'],
            ['name' => '运维单位管理员', 'email' => 'vendor_admin@example.com', 'phone' => '13900000002', 'password' => 'password', 'vendor_id' => $vendorIds['阿里云智能科技有限公司'] ?? null, 'is_system_user' => true, 'status' => 1, 'role' => 'vendor_admin'],
            ['name' => '运维人员', 'email' => 'vendor_staff@example.com', 'phone' => '13900000003', 'password' => 'password', 'vendor_id' => $vendorIds['阿里云智能科技有限公司'] ?? null, 'is_system_user' => true, 'can_view_word' => true, 'can_view_pdf' => false, 'status' => 1, 'role' => 'vendor_staff'],
            ['name' => '服务单位联系人', 'email' => 'service@example.com', 'phone' => '13900000004', 'password' => 'password', 'service_unit_id' => $serviceUnitIds['市政府数据中心'] ?? null, 'is_system_user' => true, 'status' => 1, 'role' => 'service_unit'],
            ['name' => '访客用户', 'email' => 'viewer@example.com', 'phone' => '13900000005', 'password' => 'password', 'is_system_user' => true, 'status' => 1, 'role' => 'viewer'],
            ['name' => '通讯录人员', 'email' => 'contact@example.com', 'phone' => '13900000006', 'password' => 'password', 'is_system_user' => false, 'status' => 1, 'role' => null],
        ];
        foreach ($testUsers as $u) {
            $role = $u['role'] ?? null;
            $password = $u['password'];
            unset($u['role']);
            $u['password'] = \Illuminate\Support\Facades\Hash::make($password);
            $user = \App\Models\User::firstOrCreate(['email' => $u['email']], $u);
            if (!$user->wasRecentlyCreated) {
                $user->update($u);
            }
            if ($role) {
                $user->syncRoles([$role]);
            }
        }

        $this->command->info('Demo data seeded successfully.');
    }
}
