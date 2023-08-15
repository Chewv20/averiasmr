<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Linea;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


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
        $user -> id_rol = 1;
        $user -> save();

        $user1 = new User;
        $user1 -> name = "Regulador";
        $user1 -> username = 'regulador';
        $user1 -> password = "12345";
        $user1 -> id_rol = 2;
        $user1 -> save();

        $user2 = new User;
        $user2 -> name = "Jefe Regulador";
        $user2 -> username = 'jeferegulador';
        $user2 -> password = "12345";
        $user2 -> id_rol = 3;
        $user2 -> save(); 

        $rol = new Rol;
        $rol -> tipo_rol = 'Administrador';
        $rol -> save();

        $rol1 = new Rol;
        $rol1 -> tipo_rol = 'Regulador';
        $rol1 -> save();

        $rol2 = new Rol;
        $rol2 -> tipo_rol = 'Jefe Regulador';
        $rol2 -> save();
    }
}
