<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Size Attribute
        Attribute::create([
            'code'          =>  'size',
            'name'          =>  'Size',
            'frontend_type' =>  'select',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        //Color Attribute
        Attribute::create([
            'code' => 'color',
            'name' => 'color',
            'frontend_type' => 'select',
            'is_filterable' => 1,
            'is_required' => 1,
        ]);
    }
}
