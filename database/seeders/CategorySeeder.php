<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\support\facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([[
            'id'=>'1',
            'title'=>'Birthday',
        ],
        [
            'id'=>'2',
            'title'=>'Holiday',
        ],
        [
            'id'=>'3',
            'title'=>'Anniversary',
         
        ],
        [
            'id'=>'4',
            'title'=>'Festival',
        ],
        [
            'id'=>'5',
            'title'=>'Others',
        ]
        ]
        
    );

    }
}
