<?php

namespace Database\Seeders;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 3) as $num) {

            DB::table('todos')->insert([

                'folder_id' => '1',
                'content' => 'サンプルタスク'.$num,
                'due_date' => Carbon::now()->addDay($num),
                'status' => $num,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);
        }
       
    }
}
