<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CaseStage;

class CaseStagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [

            [
                'name_en' => 'New Case',
                'name_ar' => 'قضية جديدة',
                'sort_order' => 1,
            ],

            [
                'name_en' => 'Under Review',
                'name_ar' => 'قيد المراجعة',
                'sort_order' => 2,
            ],

            [
                'name_en' => 'Documents Collection',
                'name_ar' => 'جمع المستندات',
                'sort_order' => 3,
            ],

            [
                'name_en' => 'Court Submission',
                'name_ar' => 'تقديم للمحكمة',
                'sort_order' => 4,
            ],

            [
                'name_en' => 'Hearing Scheduled',
                'name_ar' => 'تم تحديد جلسة',
                'sort_order' => 5,
            ],

            [
                'name_en' => 'Judgment Pending',
                'name_ar' => 'بانتظار الحكم',
                'sort_order' => 6,
            ],

            [
                'name_en' => 'Closed',
                'name_ar' => 'مغلقة',
                'sort_order' => 7,
                'is_final' => true,
            ],

        ];

        foreach ($stages as $stage) {
            CaseStage::create($stage);
        }
    }
}
