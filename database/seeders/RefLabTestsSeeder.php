<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class RefLabTestsSeeder extends Seeder
{
    public function run()
    {
         DB::table('ref_lab_tests')->truncate();
        $now = Carbon::now();

        // Insert main panels first
        $mainPanels = [
            ['id' => 1, 'name' => 'Basic Metabolic Panel (BMP)', 'sub_of' => 0],
            ['id' => 2, 'name' => 'Comprehensive Metabolic Panel (CMP)', 'sub_of' => 0],
            ['id' => 3, 'name' => 'Complete Blood Count (CBC)', 'sub_of' => 0],
            ['id' => 4, 'name' => 'Lipid Panel', 'sub_of' => 0],
            ['id' => 5, 'name' => 'Thyroid Panel', 'sub_of' => 0],
            ['id' => 6, 'name' => 'Liver Function Panel', 'sub_of' => 0],
            ['id' => 7, 'name' => 'Kidney Function Panel', 'sub_of' => 0],
            ['id' => 8, 'name' => 'Hemoglobin A1C', 'sub_of' => 0],
            ['id' => 9, 'name' => 'Iron Panel', 'sub_of' => 0],
            ['id' => 10, 'name' => 'Inflammatory Markers', 'sub_of' => 0],
            ['id' => 11, 'name' => 'Others', 'sub_of' => 0],
        ];

        foreach ($mainPanels as &$panel) {
            $panel['created_at'] = $now;
            $panel['updated_at'] = $now;
        }

        DB::table('ref_lab_tests')->insert($mainPanels);

        // Insert sub-panels/tests
        $subPanels = [
            // BMP
            ['name' => 'Glucose: Blood sugar level', 'sub_of' => 1],
            ['name' => 'Calcium: Bone and nerve function', 'sub_of' => 1],
            ['name' => 'Sodium: Electrolyte and fluid balance', 'sub_of' => 1],
            ['name' => 'Potassium: Electrolyte and fluid balance', 'sub_of' => 1],
            ['name' => 'Chloride: Electrolyte and fluid balance', 'sub_of' => 1],
            ['name' => 'Bicarbonate (CO₂): Acid-base balance', 'sub_of' => 1],
            ['name' => 'Blood Urea Nitrogen (BUN): Kidney function', 'sub_of' => 1],
            ['name' => 'Creatinine: Kidney function', 'sub_of' => 1],

            // CMP (includes BMP + extra)
            ['name' => 'Albumin: Liver and kidney function', 'sub_of' => 2],
            ['name' => 'Total Protein: Liver and kidney function', 'sub_of' => 2],
            ['name' => 'Alkaline Phosphatase (ALP): Liver function', 'sub_of' => 2],
            ['name' => 'ALT: Liver function', 'sub_of' => 2],
            ['name' => 'AST: Liver function', 'sub_of' => 2],
            ['name' => 'Bilirubin: Liver function and red blood cell breakdown', 'sub_of' => 2],

            // CBC
            ['name' => 'White Blood Cells (WBC): Immune function', 'sub_of' => 3],
            ['name' => 'Red Blood Cells (RBC): Oxygen transport', 'sub_of' => 3],
            ['name' => 'Hemoglobin: Oxygen-carrying capacity', 'sub_of' => 3],
            ['name' => 'Hematocrit: Oxygen-carrying capacity', 'sub_of' => 3],
            ['name' => 'Platelets: Blood clotting', 'sub_of' => 3],
            ['name' => 'Neutrophils: Infection and immune response', 'sub_of' => 3],
            ['name' => 'Lymphocytes: Infection and immune response', 'sub_of' => 3],
            ['name' => 'Monocytes: Infection and immune response', 'sub_of' => 3],
            ['name' => 'Eosinophils: Infection and immune response', 'sub_of' => 3],
            ['name' => 'Basophils: Infection and immune response', 'sub_of' => 3],

            // Lipid Panel
            ['name' => 'Total Cholesterol', 'sub_of' => 4],
            ['name' => 'LDL ("Bad" Cholesterol)', 'sub_of' => 4],
            ['name' => 'HDL ("Good" Cholesterol)', 'sub_of' => 4],
            ['name' => 'Triglycerides', 'sub_of' => 4],

            // Thyroid Panel
            ['name' => 'TSH (Thyroid-Stimulating Hormone)', 'sub_of' => 5],
            ['name' => 'Free T4: Thyroid function', 'sub_of' => 5],
            ['name' => 'Free T3: Thyroid function', 'sub_of' => 5],

            // Liver Function Panel
            ['name' => 'ALT', 'sub_of' => 6],
            ['name' => 'AST', 'sub_of' => 6],
            ['name' => 'ALP', 'sub_of' => 6],
            ['name' => 'Bilirubin', 'sub_of' => 6],
            ['name' => 'Total Protein', 'sub_of' => 6],
            ['name' => 'Albumin', 'sub_of' => 6],

            // Kidney Function Panel
            ['name' => 'BUN', 'sub_of' => 7],
            ['name' => 'Creatinine', 'sub_of' => 7],
            ['name' => 'GFR (Glomerular Filtration Rate)', 'sub_of' => 7],

            // Hemoglobin A1C
            ['name' => 'Hemoglobin A1C: Average blood sugar over 2-3 months', 'sub_of' => 8],

            // Iron Panel
            ['name' => 'Serum Iron', 'sub_of' => 9],
            ['name' => 'Ferritin', 'sub_of' => 9],
            ['name' => 'TIBC (Total Iron Binding Capacity)', 'sub_of' => 9],

            // Inflammatory Markers
            ['name' => 'CRP (C-Reactive Protein)', 'sub_of' => 10],
            ['name' => 'ESR (Erythrocyte Sedimentation Rate)', 'sub_of' => 10],
        ];

        foreach ($subPanels as &$panel) {
            $panel['created_at'] = $now;
            $panel['updated_at'] = $now;
        }

        DB::table('ref_lab_tests')->insert($subPanels);
    }
}
