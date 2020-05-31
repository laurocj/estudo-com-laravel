<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modalities = [
            ['name' => 'Presencial'],
            ['name' => 'EAD'],
            ['name' => 'Presencial - EAD']
        ];

        foreach($modalities as $modality)
            DB::table('modalities')->insert($modality);
    }
}
