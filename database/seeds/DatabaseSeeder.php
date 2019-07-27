<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        // $this->call(PermissionsTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        // $this->call(ConnectRelationshipsSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
=======
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
>>>>>>> Adding create and list of bundles
    }
}
