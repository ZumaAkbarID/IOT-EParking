<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Business;
use App\Models\BusinessSubmission;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Zuma',
            'phone_number' => '081225389903',
            'role' => 'Admin',
            'business_uuid' => null,
            'password' => Hash::make('parkiranku')
        ]);

        $demoBusiness = 'c750e031-8669-4317-9d5f-c5556f11925d';
        $demoName = 'Demo';
        $demoPhone = '08123456789';
        User::factory()->create([
            'uuid' => Str::uuid()->toString(),
            'name' => $demoName,
            'phone_number' => $demoPhone,
            'role' => 'Pengurus',
            'business_uuid' => $demoBusiness,
            'password' => Hash::make('parkiranku')
        ]);

        $submissionUuid = Str::uuid()->toString();
        $demoBusinessName = 'Demo Bisnis';
        $demoBusinessDescription = 'Demo bisnis untuk testing';
        $demoBusinessAddress = 'Jl. Ringroad Utara';
        $demoBusinessThumbnail = 'business-thumbnail/demo.jpg';
        BusinessSubmission::factory()->create([
            'uuid' => $submissionUuid,
            'submiter_name' => $demoName,
            'submiter_phone_number' => $demoPhone,
            'business_name' => $demoBusinessName,
            'business_thumbnail' => $demoBusinessThumbnail,
            'business_description' => $demoBusinessDescription,
            'business_address' => $demoBusinessAddress,
            'status' => 'approved',
        ]);

        $demoBusinessUuid = $demoBusiness;
        Business::factory()->create([
            'submission_uuid' => $submissionUuid,
            'uuid' => $demoBusinessUuid,
            'business_name' => $demoBusinessName,
            'business_thumbnail' => $demoBusinessThumbnail,
            'business_description' => $demoBusinessDescription,
            'business_address' => $demoBusinessAddress
        ]);

        $demoMachineUuid = '0e9b8061-3c73-44d2-b804-eaf43404fc8c';
        Machine::factory()->create([
            'uuid' => $demoMachineUuid,
            'business_uuid' => $demoBusinessUuid,
            'machine_name' => "Blok A",
            'total_sensor' => 3,
            'price_each_sensor' => 2000,
        ]);
    }
}
