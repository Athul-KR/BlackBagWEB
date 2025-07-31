<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefSpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    
    public function run()
    {
        DB::table('ref_specialties')->truncate();
        DB::table('ref_specialties')->insert([
    ['specialty_name' => 'Acute Care', 'specialty_uuid' => 'A1B2C3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Addiction Medicine', 'specialty_uuid' => 'D4E5F6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Adolescent Medicine', 'specialty_uuid' => 'G7H8I9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Adult Medicine', 'specialty_uuid' => 'J1K2L3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Allergy', 'specialty_uuid' => 'M4N5O6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Anesthesiology', 'specialty_uuid' => 'P7Q8R9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Cardiology', 'specialty_uuid' => 'S1T2U3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Cardiology-Interventional', 'specialty_uuid' => 'V4W5X6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Cardiovascular/Thoracic', 'specialty_uuid' => 'Y7Z8A9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Child/Adolescent Behavioral Health', 'specialty_uuid' => 'B1C2D3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Critical care', 'specialty_uuid' => 'E4F5G6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Dermatology', 'specialty_uuid' => 'H7I8J9','dosespot_speciality_id'=>'2'],
    ['specialty_name' => 'Diabetes', 'specialty_uuid' => 'K1L2M3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Emergency Medicine', 'specialty_uuid' => 'N4O5P6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Endocrinology', 'specialty_uuid' => 'Q7R8S9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Epidemiology', 'specialty_uuid' => 'T1U2V3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Family Medicine', 'specialty_uuid' => 'W4X5Y6','dosespot_speciality_id'=>'5'],
    ['specialty_name' => 'Gastroenterology', 'specialty_uuid' => 'Z7A8B9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'General Practice/ Primary Care', 'specialty_uuid' => 'C1D2E3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Geriatrics', 'specialty_uuid' => 'F4G5H6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Gynecology', 'specialty_uuid' => 'I7J8K9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Hematology', 'specialty_uuid' => 'L1M2N3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Hepatology', 'specialty_uuid' => 'O4P5Q6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'HIV/AIDS', 'specialty_uuid' => 'R7S8T9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Hospital Medicine', 'specialty_uuid' => 'U1V2W3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Immunology', 'specialty_uuid' => 'X4Y5Z6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Infectious Diseases', 'specialty_uuid' => 'A7B8C9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Internal Medicine', 'specialty_uuid' => 'D1E2F3','dosespot_speciality_id'=>'6'],
    ['specialty_name' => 'Mental Health', 'specialty_uuid' => 'G4H5I6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Neonatal-Perinatal Medicine', 'specialty_uuid' => 'J7K8L9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Nephrology', 'specialty_uuid' => 'M1N2O3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Neurology', 'specialty_uuid' => 'P4Q5R6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Neuropsychology', 'specialty_uuid' => 'S7T8U9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Nuclear Medicine', 'specialty_uuid' => 'V1W2X3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Obstetrics', 'specialty_uuid' => 'Y4Z5A6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Occupational Medicine', 'specialty_uuid' => 'B7C8D9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology', 'specialty_uuid' => 'E1F2G3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Blood Cancers', 'specialty_uuid' => 'H4I5J6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Breast', 'specialty_uuid' => 'K7L8M9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Dermatological', 'specialty_uuid' => 'N1O2P3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Glioblastoma', 'specialty_uuid' => 'Q4R5S6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Gynecological', 'specialty_uuid' => 'T7U8V9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Head and Neck', 'specialty_uuid' => 'W1X2Y3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Hematology', 'specialty_uuid' => 'Z4A5B6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Lung', 'specialty_uuid' => 'C7D8E9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Pediatrics', 'specialty_uuid' => 'F1G2H3','dosespot_speciality_id'=>'9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Radiation', 'specialty_uuid' => 'I4J5K6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Surgery', 'specialty_uuid' => 'L7M8N9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Oncology - Urological', 'specialty_uuid' => 'O1P2Q3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Ophthalmology', 'specialty_uuid' => 'R4S5T6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Optometric', 'specialty_uuid' => 'U7V8W9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Orthopedics', 'specialty_uuid' => 'X1Y2Z3','dosespot_speciality_id'=>'8'],
    ['specialty_name' => 'Otolaryngology', 'specialty_uuid' => 'A4B5C6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Pain Management', 'specialty_uuid' => 'D7E8F9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Palliative Care', 'specialty_uuid' => 'G1H2I3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Pathology', 'specialty_uuid' => 'J4K5L6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Pediatrics', 'specialty_uuid' => 'M7N8O9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Physical Medicine and Rehabilitation', 'specialty_uuid' => 'P1Q2R3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Podiatry', 'specialty_uuid' => 'S4T5U6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Psychiatry', 'specialty_uuid' => 'V7W8X9','dosespot_speciality_id'=>'11'],
    ['specialty_name' => 'Psychiatry - Child/Adolescent', 'specialty_uuid' => 'Y1Z2A3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Psychology', 'specialty_uuid' => 'B4C5D6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Psychology - Child/Adolescent', 'specialty_uuid' => 'E7F8G9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Public/Community Health', 'specialty_uuid' => 'H1I2J3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Pulmonology', 'specialty_uuid' => 'K4L5M6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Radiology', 'specialty_uuid' => 'N7O8P9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Radiology - Interventional', 'specialty_uuid' => 'Q1R2S3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Retail Medicine', 'specialty_uuid' => 'T4U5V6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Rheumatology', 'specialty_uuid' => 'W7X8Y9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Sports Medicine', 'specialty_uuid' => 'Z1A2B3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery', 'specialty_uuid' => 'C4D5E6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Cosmetic', 'specialty_uuid' => 'F7G8H9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Neurological', 'specialty_uuid' => 'I1J2K3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Oncology', 'specialty_uuid' => 'L4M5N6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Orthopedics', 'specialty_uuid' => 'O7P8Q9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Pediatrics', 'specialty_uuid' => 'R1S2T3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Transplantation', 'specialty_uuid' => 'U4V5W6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Urology', 'specialty_uuid' => 'X7Y8Z9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Surgery - Vascular', 'specialty_uuid' => 'A1B2C3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Transplant - Cardiology', 'specialty_uuid' => 'D4E5F6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Transplant - Hepatology', 'specialty_uuid' => 'G7H8I9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Transplant - Nephrology', 'specialty_uuid' => 'J1K2L3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Transplant - Pulmonology', 'specialty_uuid' => 'M4N5O6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Transplantation Medicine', 'specialty_uuid' => 'P7Q8R9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Urgent Care', 'specialty_uuid' => 'S1T2U3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Urology', 'specialty_uuid' => 'V4W5X6','dosespot_speciality_id'=>'12'],
    ['specialty_name' => 'Urology - Pediatrics', 'specialty_uuid' => 'Y7Z8A9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Women\'s Health', 'specialty_uuid' => 'B1C2D3', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Other', 'specialty_uuid' => 'E4F5G6', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'Optometrist', 'specialty_uuid' => 'H7I8J9', 'dosespot_speciality_id'=>NULL],
    ['specialty_name' => 'None', 'specialty_uuid' => 'K1L2M3', 'dosespot_speciality_id'=>NULL]


        ]);
    }
}
