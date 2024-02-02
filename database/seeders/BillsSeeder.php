<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\Agreement;
use Carbon\Carbon;

class BillsSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have Agreements in the database
        $agreements = Agreement::all();

        foreach ($agreements as $agreement) {
            // Check if tenant_full_name is not null
            if ($agreement->tenant_full_name) {
                // Generate 10 bills for the year 2023
                for ($i = 1; $i <= 10; $i++) {
                    $billDate = Carbon::createFromDate(2021, rand(1, 12), rand(1, 28));

                    // Adjust other data as needed based on your data structure
                    $billData = [
                        'agreement_id' => $agreement->agreement_id,
                        'shop_id' => $agreement->shop_id,
                        'tenant_id' => $agreement->tenant_id,
                        'tenant_full_name' => $agreement->tenant_full_name,
                        'shop_address' => $agreement->shop_address,
                        'rent' => $agreement->rent,
                        'bill_date' => $billDate,
                        'due_date' => $billDate->addDays(rand(1, 30)), // Assuming a due date within 30 days
                        'status' => 'unpaid',
                        'penalty' => 0, // Adjust as needed
                        'discount' => 0, // Adjust as needed
                        'month' => $billDate->month,
                        'year' => $billDate->year,
                    ];

                    Bill::create($billData);
                }
            }
        }
    }
}
