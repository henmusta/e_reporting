<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $roles = [
      [
        'name' => 'Super Admin',
        'slug' => Str::slug('Super Admin', '-'),
      ]
    ];

    Role::insert($roles);
  }
}
