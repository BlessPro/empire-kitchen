<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // If you already have real employees, you can skip creating samples
        if (Employee::count() > 0) {
            $this->command->info('Employees already exist — skipping sample creation.');
            return;
        }

        $samples = [
            ['name' => 'John Doe',      'email' => 'john@example.com',      'phone' => '0500000001', 'designation' => 'Designer'],
            ['name' => 'Jane Smith',    'email' => 'jane@example.com',      'phone' => '0500000002', 'designation' => 'Tech Supervisor'],
            ['name' => 'Abigail Mensah','email' => 'abigail@example.com',   'phone' => '0500000003', 'designation' => 'Accountant'],
            ['name' => 'Kwame Asare',   'email' => 'kwame@example.com',     'phone' => '0500000004', 'designation' => 'Sales Account'],
            ['name' => 'Ama Owusu',     'email' => 'ama@example.com',       'phone' => '0500000005', 'designation' => 'Production Officer'],
            ['name' => 'Yaw Boateng',   'email' => 'yaw@example.com',       'phone' => '0500000006', 'designation' => 'Installation Officer'],
        ];

        foreach ($samples as $i => $row) {
            Employee::create([
                'staff_id'          => $this->nextStaffId(),
                'name'              => $row['name'],
                'designation'       => $row['designation'],
                'email'             => $row['email'],
                'phone'             => $row['phone'],
                'commencement_date' => now()->subDays(rand(10, 400))->toDateString(),
                'nationality'       => 'Ghanaian',
                'dob'               => now()->subYears(rand(22, 45))->subDays(rand(0, 365))->toDateString(),
                'hometown'          => 'Accra',
                'language'          => 'English',
                'address'           => '123 Sample Street',
                'gps'               => 'GA-000-0000',
                'next_of_kin'       => 'Relative '.$i,
                'relation'          => 'Sibling',
                'nok_phone'         => '05000010'.$i,
                'bank'              => 'ABSA',
                'branch'            => 'Accra Main',
                'account_number'    => '0123456789'.$i,
                'avatar_path'       => null,
            ]);
        }
    }

    /** Generate the next available staff code like EMP-0007 */
    private function nextStaffId(): string
    {
        $last = Employee::where('staff_id', 'like', 'EMP-%')
            ->select(DB::raw("MAX(CAST(SUBSTRING(staff_id, 5) AS UNSIGNED)) as n"))
            ->value('n');

        $n = (int) $last + 1;
        return 'EMP-'.str_pad((string)$n, 4, '0', STR_PAD_LEFT);
    }
}
