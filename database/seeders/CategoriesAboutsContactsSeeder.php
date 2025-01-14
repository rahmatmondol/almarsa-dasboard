<?php

namespace Database\Seeders;

use App\Models\CategoriesAboutsContacts;
use Illuminate\Database\Seeder;

class CategoriesAboutsContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriesAboutsContacts::factory()->count(5)->create();
    }
}
