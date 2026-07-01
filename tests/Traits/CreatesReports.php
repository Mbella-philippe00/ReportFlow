<?php

namespace Tests\Traits;

use App\Models\Employee;
use App\Models\WeeklyReport;

trait CreatesReports
{
    protected function createDraftReport(
        ?Employee $employee = null
    ): WeeklyReport {

        $employee ??= $this->createEmployee();

        return WeeklyReport::factory()
            ->for($employee)
            ->draft()
            ->create();
    }

    protected function createSubmittedReport(
        ?Employee $employee = null
    ): WeeklyReport {

        $employee ??= $this->createEmployee();

        return WeeklyReport::factory()
            ->for($employee)
            ->submitted()
            ->create();
    }

    protected function createApprovedReport(
        ?Employee $employee = null
    ): WeeklyReport {

        $employee ??= $this->createEmployee();

        return WeeklyReport::factory()
            ->for($employee)
            ->managerApproved()
            ->create();
    }

    protected function createGeneratedReport(
        ?Employee $employee = null
    ): WeeklyReport {

        $employee ??= $this->createEmployee();

        return WeeklyReport::factory()
            ->for($employee)
            ->generated()
            ->create();
    }

    protected function createRejectedReport(
        ?Employee $employee = null
    ): WeeklyReport {

        $employee ??= $this->createEmployee();

        return WeeklyReport::factory()
            ->for($employee)
            ->rejected()
            ->create();
    }
}
