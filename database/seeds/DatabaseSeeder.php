<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(MembersTableSeeder::class);
        $this->call(OwnersTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(CompanyProfilesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}
