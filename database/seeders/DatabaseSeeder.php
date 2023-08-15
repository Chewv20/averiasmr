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
        $user -> name = "Administrador";
        $user -> username = 'admin';
        $user -> password = "12345";
        $user -> save();

        $user1 = new User;
        $user1 -> name = "Regulador";
        $user1 -> username = 'regulador';
        $user1 -> password = "12345";
        $user1 -> save();

        $user2 = new User;
        $user2 -> name = "Jefe Regulador";
        $user2 -> username = 'jeferegulador';
        $user2 -> password = "12345";
        $user2 -> save();
    }
}
