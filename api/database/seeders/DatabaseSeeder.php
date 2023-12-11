<?php

namespace Database\Seeders;

use App\Enums\ActiveStatusEnum;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		(new PermissionSeeder)->run();

		$users = \App\Models\User::factory(100)->create();

		// $patients = \App\Models\Patient::factory(50)->create();
	}
}
