<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = [
            ['name' => 'Manhã'],
            ['name' => 'Tarde'],
            ['name' => 'Noite'],
            ['name' => 'Livre'],
            ['name' => 'Diurno'],
            ['name' => 'Finais de semana']
        ];

        foreach($shifts as $shift)
            DB::table('shifts')->insert($shift);
    }
}
