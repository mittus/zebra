<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenders;
use Carbon\Carbon;

class TestTaskData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = public_path('/test_task_data.csv');

        function import($file) {
            if(file_exists($file) && is_readable($file)) {
                $import = [];
                if(($handle = fopen($file, 'r')) !== false) {
                    $titles = null;
                    while(($row = fgetcsv($handle, 1000, ',')) !== false) {
                        $titles ? $import[] = array_combine($titles, $row) : $titles = $row;
                    }
                }
                return $import;
            }
        }

        foreach (array_reverse(import($file)) as $value) {
            Tenders::insert([
                'code' => $value['Внешний код'],
                'number' => $value['Номер'],
                'status' => $value['Статус'],
                'name' => $value['Название'],
                'date' => Carbon::parse($value['Дата изм.']),
            ]);
        }
    }
}
