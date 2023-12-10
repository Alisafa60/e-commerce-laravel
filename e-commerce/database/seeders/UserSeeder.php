<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $sellerUser = User::create([
            'name' => 'ali',
            'last_name' => 'Safa',
            'email' => 'seller@se',
            'username' => 'alisafa',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'seller')->first()->id,
        ]);
    
        $customerUser = User::create([
            'name' => 'hala',
            'last_name' => 'Nehme',
            'email' => 'custumer@se',
            'username' => 'halanehme',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'customer')->first()->id,
        ]);
    }
    
}
