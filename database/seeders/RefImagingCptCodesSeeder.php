<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefImagingCptCodesSeeder extends Seeder
{
    public function run()
    {
         DB::table('ref_imaging_cpt_codes')->truncate();
        $imagingTests = [
            // MRI Tests (positions 1-26 in RefImagingTestsSeeder)
            ['name' => 'MRA Abdomen', 'cpt' => '74185'],
            ['name' => 'MRA Arm', 'cpt' => '73225'],
            ['name' => 'MRA Femoral Art', 'cpt' => '73725'],
            ['name' => 'MRA Head/Neck', 'cpt' => '70546'],
            ['name' => 'MRA Wrist', 'cpt' => '73221'],
            ['name' => 'MRI Abdomen', 'cpt' => '74181'],
            ['name' => 'MRI Ankle', 'cpt' => '73721'],
            ['name' => 'MRI Brain w/o contrast', 'cpt' => '70551'],
            ['name' => 'MRI Brain w/wo contrast', 'cpt' => '70553'],
            ['name' => 'MRI Cardiac', 'cpt' => '75553'],
            ['name' => 'MRI Cervical w/o contrast', 'cpt' => '72141'],
            ['name' => 'MRI Cervical w/wo contrast', 'cpt' => '72156'],
            ['name' => 'MRI Chest', 'cpt' => '71550'],
            ['name' => 'MRI Elbow', 'cpt' => '73221'],
            ['name' => 'MRI Face, Orbit, Neck', 'cpt' => '70540'],
            ['name' => 'MRI Knee', 'cpt' => '73721'],
            ['name' => 'MRI Lower Extremity', 'cpt' => '73720'],
            ['name' => 'MRI Lumbar w/o contrast', 'cpt' => '72148'],
            ['name' => 'MRI Lumbar w/wo contrast', 'cpt' => '72158'],
            ['name' => 'MRI Pelvis', 'cpt' => '72196'],
            ['name' => 'MRI Shoulder', 'cpt' => '73221'],
            ['name' => 'MRI Shoulder Arth', 'cpt' => '73222'],
            ['name' => 'MRI Spectroscopy', 'cpt' => '76390'],
            ['name' => 'MRI Thoracic w/o contrast', 'cpt' => '72146'],
            ['name' => 'MRI Thoracic w/wo contrast', 'cpt' => '72157'],
            ['name' => 'MRI TMJ', 'cpt' => '70336'],
            ['name' => 'MRI Upper Extremity', 'cpt' => '73220'],

            // Specials Tests (positions 27-53)
            ['name' => 'Angio ABD Aortogram', 'cpt' => '75625'],
            ['name' => 'Angio Aortic Arch', 'cpt' => '75605'],
            ['name' => 'Angio ABD/lliofem', 'cpt' => '75605'], // First entry
            ['name' => 'Angio ABD/lliofem', 'cpt' => '75630'], // Second entry
            ['name' => 'Ango Carotid Bil', 'cpt' => '75605'],
            ['name' => 'Angio Carotid', 'cpt' => '75650'],
            ['name' => 'Angio Cerebral 4 Vessels', 'cpt' => '75605'],
            ['name' => 'Angio Pulm Select', 'cpt' => '75743'],
            ['name' => 'Angio Renal Select', 'cpt' => '75724'], // First entry
            ['name' => 'Angio Renal Select', 'cpt' => '75724'], // Second entry
            ['name' => 'Angio Thoracic Aorta', 'cpt' => '75605'],
            ['name' => 'Angio Extremity', 'cpt' => '75710'],
            ['name' => 'Bx', 'cpt' => '76003'],
            ['name' => 'Discogram Lumbar', 'cpt' => '72295'],
            ['name' => 'Drain Cath / Tube Change', 'cpt' => '74363'],
            ['name' => 'Emboliz', 'cpt' => '75894'],
            ['name' => 'Gastrostomy Tube Change', 'cpt' => '75984'],
            ['name' => 'Gastrostomy Tube Insert Perc', 'cpt' => '74350'],
            ['name' => 'Nephrostomy Tube Change', 'cpt' => '75984'],
            ['name' => 'Nephrostomy Tube Insert', 'cpt' => '74475'],
            ['name' => 'PICC Line Placement', 'cpt' => '75860'],
            ['name' => 'PTA', 'cpt' => '75962'],
            ['name' => 'Renal Vein Renins', 'cpt' => '75724'],
            ['name' => 'Stent Placement', 'cpt' => '75960'],
            ['name' => 'Superier Vena Cavagram', 'cpt' => '75827'],

            // CT Tests (positions 54-78)
            ['name' => 'CT Angio SPECIFY:', 'cpt' => ''],
            ['name' => 'CT Abdomen w/contrast', 'cpt' => '74160'],
            ['name' => 'CT Abdomen w/o contrast', 'cpt' => '74150'],
            ['name' => 'CT Abdomen/Pelvis w/cont', 'cpt' => '74160/72193'],
            ['name' => 'CT Abdomen/Pelvis w/o', 'cpt' => '74150/72192'],
            ['name' => 'CT Biopsy', 'cpt' => '76360'],
            ['name' => 'CT Cervical w/contrast', 'cpt' => '72126'],
            ['name' => 'CT Cervical w/o contrast', 'cpt' => '72125'],
            ['name' => 'CT Chest w/contrast', 'cpt' => '71260'],
            ['name' => 'CT Chest w/o contrast', 'cpt' => '71250'],
            ['name' => 'CT Face, Orbit', 'cpt' => '70481'],
            ['name' => 'CT Head w/wo contrast', 'cpt' => '70470'],
            ['name' => 'CT Head w/o contrast', 'cpt' => '70450'],
            ['name' => 'CT Lower Extremity w/cont.', 'cpt' => '73701'],
            ['name' => 'CT Lower Extremity w/o cont', 'cpt' => '73700'],
            ['name' => 'CT Lumbar w/contrast', 'cpt' => '72132'],
            ['name' => 'CT Lumbar w/o contrast', 'cpt' => '72131'],
            ['name' => 'CT Neck w/contrast', 'cpt' => '70491'],
            ['name' => 'CT Pelvis w/contrast', 'cpt' => '72193'],
            ['name' => 'CT Pelvis w/o contrast', 'cpt' => '72192'],
            ['name' => 'CT Sinuses', 'cpt' => '70486'],
            ['name' => 'CT Thoracic w/contrast', 'cpt' => '72129'],
            ['name' => 'CT Thoracic w/o', 'cpt' => '72128'],
            ['name' => 'CT Upper Ext w/contrast', 'cpt' => '73201'],
            ['name' => 'CT Upper Ext w/o', 'cpt' => '73200'],

            // Ultrasound Tests (positions 79-96)
            ['name' => 'US Abdomen', 'cpt' => '76700'],
            ['name' => 'US Aorta', 'cpt' => '93978'],
            ['name' => 'US Aspiration', 'cpt' => '76942'],
            ['name' => 'US Breast', 'cpt' => '76645'],
            ['name' => 'US Biopsy', 'cpt' => '76942'],
            ['name' => 'US Carotids', 'cpt' => '93880'],
            ['name' => 'US Chest', 'cpt' => '76604'],
            ['name' => 'US Gallbladder', 'cpt' => '76705'],
            ['name' => 'US Liver', 'cpt' => '76705'],
            ['name' => 'US Paracentesis', 'cpt' => '76942'],
            ['name' => 'US Popliteal', 'cpt' => '76880'],
            ['name' => 'US Pelvis', 'cpt' => '7686'],
            ['name' => 'US Renal', 'cpt' => '76770'],
            ['name' => 'US Scrotum', 'cpt' => '76870'],
            ['name' => 'US Thyroid', 'cpt' => '76536'],
            ['name' => 'US Transvaginal', 'cpt' => '76830'],
            ['name' => 'US Venous Flow Bil', 'cpt' => '93970'],
            ['name' => 'US Venous Flow', 'cpt' => '93971'],

            // Radiology Tests (positions 97-140)
            ['name' => 'Abdomen Flat & Erect', 'cpt' => '74020'],
            ['name' => 'Ankle', 'cpt' => '73610'],
            ['name' => 'Barium Enema', 'cpt' => '74270'],
            ['name' => 'Barium Enema w/air', 'cpt' => '74280'],
            ['name' => 'Barium Swallow', 'cpt' => '74220'],
            ['name' => 'Barium Swallow, Modified', 'cpt' => '74230'],
            ['name' => 'Calcaneus', 'cpt' => '73650'],
            ['name' => 'Cervical Flex-Exten', 'cpt' => '72052'],
            ['name' => 'Cervical Spine 5 View', 'cpt' => '72050'],
            ['name' => 'Cervical Spine AP/Lat', 'cpt' => '72040'],
            ['name' => 'Chest Fluoro', 'cpt' => '76000'],
            ['name' => 'Chest PA/Lat', 'cpt' => '71020'],
            ['name' => 'Chest PA only', 'cpt' => '71010'],
            ['name' => 'Clavicle', 'cpt' => '73000'],
            ['name' => 'Elbow', 'cpt' => '73080'],
            ['name' => 'Femur', 'cpt' => '73550'],
            ['name' => 'Fingers', 'cpt' => '73140'],
            ['name' => 'Foot', 'cpt' => '73630'],
            ['name' => 'Forearm', 'cpt' => '73090'],
            ['name' => 'Hand', 'cpt' => '73130'],
            ['name' => 'Hip', 'cpt' => '73510'],
            ['name' => 'Humerus', 'cpt' => '73060'],
            ['name' => 'IVP', 'cpt' => '74400'],
            ['name' => 'Knee', 'cpt' => '73562'],
            ['name' => 'KUB', 'cpt' => '74000'],
            ['name' => 'Lumbar Flex-Exten', 'cpt' => '72120'],
            ['name' => 'Lumbar Spine 5 View', 'cpt' => '72100'],
            ['name' => 'Lumbar Spine AP/Lat', 'cpt' => '72100'],
            ['name' => 'Pelvis', 'cpt' => '72170'],
            ['name' => 'Ribs', 'cpt' => '71111'], // First entry
            ['name' => 'Ribs', 'cpt' => '71100'], // Second entry
            ['name' => 'Sacrum/Coccyx', 'cpt' => '72220'],
            ['name' => 'Scoliosis Survey', 'cpt' => '72090'],
            ['name' => 'Shoulder', 'cpt' => '73030'],
            ['name' => 'Sinuses', 'cpt' => '70220'],
            ['name' => 'Skull AP/Lat', 'cpt' => '70250'],
            ['name' => 'Small Bowel', 'cpt' => '74250'],
            ['name' => 'Small Bowel & UGI', 'cpt' => '74249'],
            ['name' => 'Soft Tissue Neck', 'cpt' => '70360'],
            ['name' => 'Sternum', 'cpt' => '71120'],
            ['name' => 'Thoracic Spine AP/Lat', 'cpt' => '72072'],
            ['name' => 'Tibia-Fibula', 'cpt' => '73590'],
            ['name' => 'Toes', 'cpt' => '73660'],
            ['name' => 'UGI', 'cpt' => '74246'],
            ['name' => 'Waters View Only', 'cpt' => '70210'],
            ['name' => 'Wrist', 'cpt' => '73110'],

            // Nuclear Medicine Tests (positions 141-166)
            ['name' => 'Adrenal Scan', 'cpt' => '78075'],
            ['name' => 'Bone Scan - Limited', 'cpt' => '78300'],
            ['name' => 'Bone Scan - 3 Phase', 'cpt' => '78315'],
            ['name' => 'Bone Scan - Spect', 'cpt' => '78320'],
            ['name' => 'Bone Scan - Whole Body', 'cpt' => '78306'],
            ['name' => 'Brain Scan', 'cpt' => '78608'],
            ['name' => 'Brain - Spect', 'cpt' => '78607'],
            ['name' => 'Cardiac Blood Pool (MUGA)', 'cpt' => '78473'],
            ['name' => 'Cardiac - Rest/Stress', 'cpt' => '78483'],
            ['name' => 'Cardiac - Dip Thallium', 'cpt' => '78465'],
            ['name' => 'Cardiac Infarct Scan', 'cpt' => '78469'],
            ['name' => 'CSF Cysternograrn', 'cpt' => '78530'],
            ['name' => 'CSF Shuntogram', 'cpt' => '75809'],
            ['name' => 'Gastric Emptying Study', 'cpt' => '78264'],
            ['name' => 'Gl Blood Scan', 'cpt' => '78278'],
            ['name' => 'Hepatobiliary Scan (Hidia)', 'cpt' => '78223'],
            ['name' => 'Hepatobiliary Scan (Hidia) w/CCK', 'cpt' => '78223'],
            ['name' => 'Liver / Spleen Scan', 'cpt' => '78215'],
            ['name' => 'Liver Scan - Spect', 'cpt' => '78205'],
            ['name' => 'Lung Scan - Perfusion', 'cpt' => '78580'],
            ['name' => 'Lung Scan - Ventilation', 'cpt' => '78587'],
            ['name' => 'Lung Soon - Vent & Perfusion', 'cpt' => '78587'],
            ['name' => 'Lymph Node Scan', 'cpt' => '78195'],
            ['name' => 'Meckels Scan', 'cpt' => '78290'],
            ['name' => 'PET', 'cpt' => 'G0164'],
            ['name' => 'Renal Scan - Function', 'cpt' => '78709'],
            ['name' => 'Thyroid Therapy', 'cpt' => '79000'],
            ['name' => 'Thyroid Mets. Whole Body', 'cpt' => '78018'],
            ['name' => 'Thyroid Imaging w/uptake', 'cpt' => '78007'],
            ['name' => 'Tumor Local. Whole Body', 'cpt' => '78802'],

            // Mammography Tests (positions 167-171)
            ['name' => 'Screening Mammogram', 'cpt' => '76092'],
            ['name' => 'Diag Mammogram', 'cpt' => '76090'],
            ['name' => 'Diagnostic Mammogram', 'cpt' => '76091'],
            ['name' => 'Implants - Mammogram', 'cpt' => '76091'],
            ['name' => 'Bone Density', 'cpt' => '76075'],
        ];

        foreach ($imagingTests as $index => $test) {
            $imagingTestId = $index + 9; // Position in the array + 1 matches the position in RefImagingTestsSeeder
            
            if (!empty($test['cpt'])) {
                // Handle composite CPT codes (separated by /)
                $cptCodes = explode('/', $test['cpt']);
                
                foreach ($cptCodes as $cptCode) {
                    $cptCode = trim($cptCode);
                    
                    // Look up the CPT code ID from ref_cpt_codes table
                    $cptRecord = DB::table('ref_cpt_codes')
                        ->where('cpt_code', $cptCode)
                        ->first();
                    $cptimaging = DB::table('ref_imaging_tests')
                        ->where('name', $test['name'])
                        ->first();
                    if ($cptRecord) {
                        DB::table('ref_imaging_cpt_codes')->insert([
                            'imaging_test_id' => $cptimaging->id,
                            'cpt_code_id' => $cptRecord->id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
    }
}