<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            DemoUsersSeeder::class,
            EmployeeSeeder::class,
            WeeklyReportSeeder::class,
            ReportDocumentSeeder::class,
            EnterpriseAdministrationSeeder::class,
            NotificationSeeder::class,
            ActivitySeeder::class,
        ]);
    }
}