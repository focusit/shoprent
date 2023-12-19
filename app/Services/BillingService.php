<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\ShopRent;

class BillingService
{
  public function calculateAmount($shop)
  {
    $rent = $shop->rent;
    $discount = $shop->discount ?? 20 / 100 * $rent;
    $penalty = $shop->penalty ?? 50;
    return ($rent - $discount + $penalty);
  }

  function calculateLastDate($shop)
  {
    // Add logic to calculate the last date based on your business rules
    return now()
      ->subMonth()
      ->endOfMonth(); // Example: last day of the previous month
  }

  public function calculateDueDate($shop)
  {
    // Add logic to calculate the due date based on your business rules
    return now()
      ->addMonth()
      ->endOfMonth(); // Example: last day of the next month
  }

  function calculatePaymentDate($shop)
  {
    // Add logic to calculate the payment date based on your business rules
    return now(); // Example: current date
  }

  function calculatePenalty($shop)
  {
    // Add logic to calculate the penalty based on your business rules
    return $shop->penalty ?? 0; // Example: using a penalty column in the shop_rent table
  }

  function calculateDiscount($shop)
  {
    $rent = $shop->rent;
    return   $shop->discount ?? 20 / 100 * $rent;
  }
  public function getShopsToGenerateBills()
  {
    // Retrieve a list of shops that need bills generated
    // You can adjust this based on your actual business logic
    return ShopRent::all();
  }

  public function generateBill($shopId)
  {
    // Generate a bill for the specified shop
    // You can add more complex logic here to calculate amounts, due dates, etc.
    // This is just a placeholder, replace it with your actual implementation

    // For example, create a new Bill record in the database
    Bill::create([
      'shop_id' => $shopId,
      'tenant_id' => $shopId, // Assuming tenant_id is related to shop_id, adjust as needed
      'bill_amount' => 100,   // Replace with actual calculation
      'due_date' => now()->addMonth(),  // Replace with actual calculation
      'status' => 'unpaid',
    ]);
  }
  // Add other calculation methods as needed
}
