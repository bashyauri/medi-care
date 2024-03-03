<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LicenseIssuingBodySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('license_issuing_bodies')->insert(
            [
                [
                    'license_body_name' => 'Pharmacists Council of Nigeria(PCN)',

                ],
                [
                    'license_body_name' => 'Community Health Practitioner Registration Board Of Nigeria (CHPRBN)',

                ],
                [
                    'license_body_name' => 'Medical Laboratory Science Council Of Nigeria (MLSCN)',

                ],

                [
                    'license_body_name' => 'Nigeria Medical Association (NMA)',

                ],
                [
                    'license_body_name' => 'Association of Medical Laborary Scientists of Nigeria (AMLSN)',

                ],
            ]
        );
    }
}
