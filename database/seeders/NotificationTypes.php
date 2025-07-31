<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NotificationTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notification_types')->truncate();
        DB::table('notification_types')->insert([
          
            ['notification_type' => 'Invitation Accept'],
            ['notification_type' => 'Invitation Decline'],
            ['notification_type' => 'Appointment Create'],
            ['notification_type' => 'Cancel Appointment'],
            ['notification_type' => 'Payment Reminder'],
            ['notification_type' => 'Nurse Appointment'],
            ['notification_type' => 'Patient Appointment'],
            ['notification_type' => 'Cancel Appointment'],
            ['notification_type' => 'Patient Invitation'],
            ['notification_type' => 'Patient Decline'],
            ['notification_type' => 'Waiting in reception'],
            ['notification_type' => 'Complete Appointment'],
            ['notification_type' => 'Trial'],
            ['notification_type' => 'Subscription expiring'],
            ['notification_type' => 'Account Block'],
            ['notification_type' => 'Payment success'],
            ['notification_type' => 'Soap Note'],
            ['notification_type' => 'Reschedule Appointment Patient'],
            ['notification_type' => 'Reschedule Appointment Nurse'],
            ['notification_type' => 'Reschedule Appointment Doctor'],
            ['notification_type' => 'Rpm Device order sent to patients.'],
            ['notification_type' => 'Rpm Device accepted by user.'],
        ]);
    }
}
