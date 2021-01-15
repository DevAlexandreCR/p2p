<?php

namespace Database\Seeders;

use App\Constants\Permissions;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Permissions::values() as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
