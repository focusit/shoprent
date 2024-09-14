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
    // Fetch all shops and tenants
    $shops = ShopRent::all();
    $tenants = Tenant::all();

    // Get the count of agreements to create based on the available shops and tenants
    $numOfAgreements = min($shops->count(), 1000);

    // Generate agreements and allocate each shop to a tenant
    for ($i = 1; $i <= $numOfAgreements; $i++) {
      $shop = $shops[$i];
      $tenant = $tenants[$i];
      
      // Generate unique agreement ID
      $agreementId = '2024-' . ("00".$i);
      
      // Generate agreement data
      $agreementData = [
        'agreement_id' => $agreementId,
        'shop_id' => $shop->id,
        'tenant_id' => $tenant->tenant_id,
        'with_effect_from' => Carbon::now()->subMonths(rand(1, 12))->toDateString(),
        'valid_till' => Carbon::now()->addMonths(rand(1, 12))->toDateString(),
        'rent' => rand(1000, 5000),
        'status' => 'active',
        'remark' => '',
        'document_field' => '',
        'created_at' => now(),
        'updated_at' => now(),
      ];

      // Create an agreement
      $agreement = Agreement::create($agreementData);

      // Update shop and tenant based on agreement status
      // if ($agreement->status === 'active') {
      //   // Update ShopRent status to 'occupied' and link tenant_id
      //   $shop->update([
      //     'status' => 'occupied',
      //     'tenant_id' => $tenant->tenant_id
      //   ]);

      //   // Update Tenant status to 'allocated'
      //   $tenant->update(['status' => 'allocated']);
      // }
    }
  }
}
