<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\support\facades\DB;


class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('reminderstatus')->insert([[
                'id'=>'1',
                'status'=>'close',
            ],
            [
                'id'=>'2',
                'status'=>'open',
            ]
           
            ]
        );
    }
    
}
