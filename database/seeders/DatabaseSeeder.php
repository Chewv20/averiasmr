<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Linea;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //
        $user = new User;
        $user -> name = "Arturo";
        $user -> email = "admin@admin.com";
        $user -> password = "123456789";
        $user -> save();
    }
}
