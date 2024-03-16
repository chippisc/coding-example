<?php

namespace Database\Seeders;

use App\Models\SchulcampusUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new SchulcampusUser();
        $user->username = 'Eric';
        $user->given_name = 'Eric';
        $user->family_name = 'Nachname';
        $user->role = 'teacher';
        $user->save();
    }
}
