<?php

use App\Repositories\FuelTypeRepository;
use Illuminate\Database\Seeder;

class FuelTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fuelTypes = ['Բենզին', 'Գազ', 'Հեզուկ Գազ', 'Դիզել'];
        foreach ($fuelTypes as $key => $type) {
            (new FuelTypeRepository())->create([
                'name' => $type
            ]);
        }
    }
}
