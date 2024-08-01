<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class history_statuses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'id' => 1,
                'name' => 'Created',
                'details' => 'Dibuat oleh Inventory',
            ],
            [
                'id' => 2,
                'name' => 'Send',
                'details' => 'Dikirim oleh Inventory',
            ],
            [
                'id' => 3,
                'name' => 'Sent',
                'details' => 'Diterima',
            ],
            [
                'id' => 4,
                'name' => 'Proccessed',
                'details' => 'Diproses',
            ],
            [
                'id' => 5,
                'name' => 'Returned',
                'details' => 'Dikirim Kembali Ke Inventory',
            ],
            [
                'id' => 6,
                'name' => 'Received',
                'details' => 'Diterima kembali oleh Inventory'
            ],
            [
                'id' => 7,
                'name' => 'SendToProduction',
                'details' => 'Dikirim ke produksi'
            ],
            [
                'id' => 8,
                'name' => 'ReceivedByProduction',
                'details' => 'Diterima oleh produksi'
            ],
        ];
        DB::table('history_statuses')->insert($statuses);
    }
}
