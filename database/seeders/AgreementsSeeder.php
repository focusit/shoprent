<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agreement;
use App\Models\ShopRent;
use App\Models\Tenant;
use Carbon\Carbon;

class AgreementsSeeder extends Seeder
{
  public function run()
  {
    // Generate 10 agreements with random data
    for ($i = 1; $i <= 10; $i++) {
      $agreementData = [
        'agreement_id' => 'A' . str_pad($i, 3, '0', STR_PAD_LEFT),
        'shop_id' => 'Q' . str_pad($i, 3, '0', STR_PAD_LEFT),
        'tenant_id' => 'T' . str_pad($i, 3, '0', STR_PAD_LEFT),
        'with_effect_from' => Carbon::now()->subMonths(rand(1, 12))->toDateString(),
        'valid_till' => Carbon::now()->addMonths(rand(1, 12))->toDateString(),
        'rent' => rand(1000, 5000),
        'status' => rand(0, 1) ? 'active' : 'inactive',
        'remark' => 'Random remark for Agreement ' . $i,
        'document_field' => 'Document ' . $i,
        'created_at' => now(),
        'updated_at' => now(),
      ];

      // Create an agreement
      $agreement = Agreement::create($agreementData);

      // Update shop and tenant based on agreement status
      if ($agreement->status === 'active') {
        // Update ShopRent status to 'occupied'
        ShopRent::where('shop_id', $agreement->shop_id)
          ->update(['status' => 'occupied', 'tenant_id' => $agreement->tenant_id]);

        // // Update Tenant status to 'allocated'
        // Tenant::where('tenant_id', $agreement->tenant_id)
        //   ->update(['status' => 'allocated']);
      }
    }
  }
}
