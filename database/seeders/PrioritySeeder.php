<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\support\facades\DB;


class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reminderpriorities')->insert([[
            'id'=>'1',
            'priority'=>'Low',
        ],
        [
            'id'=>'2',
            'priority'=>'Medium',
        ],
        [
            'id'=>'3',
            'priority'=>'High',
         
        ]
        ]
    );

     
    }
}
