<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AppointmentTypeSeeder::class);
        $this->call(RefStatesSeeder::class);
        $this->call(RefDesignationSeeder::class);
        $this->call(RefImportDocsTypeSeeder::class);
        $this->call(RefUserTypes::class);
        $this->call(CountryCodesSeeder::class);
        $this->call(NotificationTypes::class);
        $this->call(RefSpecialtySeeder::class);
        $this->call(RefFcFoldersTypes::class);
        $this->call(RefImmunizationTypeSeeder::class);
        $this->call(RefNurseDesignationSeeder::class);
        $this->call(RefRelationSeeder::class);
        $this->call(RefSourceTypeSeeder::class);
        $this->call(RefSupportType::class);
        $this->call(RefMedicinesSeeder::class);
        $this->call(TimezoneSeeder::class);
        $this->call(RefConditionsSeeder::class);
        $this->call(RefTemperature::class);
        $this->call(RefCptCodesSeeder::class);
        $this->call(RefLabTestsSeeder::class);
        $this->call(RefImagingOptionsSeeder ::class);
        $this->call(RefImagingTestsSeeder::class);
        $this->call(RefImagingCptCodesSeeder::class);
        $this->call(RefIcd10CodesSeeder::class);
        $this->call(RefOnboardingStepSeeder::class);
        $this->call(RefConsultationTimesSeeder::class);
        $this->call(RefRpmDevices::class);
        $this->call(GenericSubscriptionSeeder::class);
        $this->call(RefMedicationDispenseUnitSeeder::class);
        $this->call(SubscriptionPlanSeeder::class);
        $this->call(AddonsSeeder::class);
        $this->call(RefStrengthUnitSeeder::class);
        $this->call(RefUserParticipantTypes::class);
        $this->call(RefPlanIconsSeeder::class);
        
        
    }
}
