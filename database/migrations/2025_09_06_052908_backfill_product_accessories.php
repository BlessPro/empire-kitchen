<?php
// database/migrations/2025_09_06_000004_backfill_product_accessories.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
  public function up(): void {
    // For each product that has legacy accessory fields, create/attach a pivot row
    $products = DB::table('products')
      ->select('id','accessory_name','accessory_size','accessory_type')
      ->whereNotNull('accessory_name')
      ->where('accessory_name','<>','')
      ->get();

    foreach ($products as $p) {
      // Find or create accessory in catalog by name (case-insensitive)
      $name = trim($p->accessory_name);
      if ($name === '') continue;

      $acc = DB::table('accessories')->whereRaw('LOWER(name) = ?', [Str::lower($name)])->first();
      if (!$acc) {
        $accId = DB::table('accessories')->insertGetId([
          'name' => $name,
          'category' => null,
          'length_mm' => null, 'width_mm' => null, 'height_mm' => null, 'diameter_mm' => null,
          'size' => null, 'notes' => null, 'created_at' => now(), 'updated_at' => now(),
        ]);
      } else {
        $accId = $acc->id;
      }

      // Ensure a matching type option exists (optional)
      if (!empty($p->accessory_type)) {
        $existsType = DB::table('accessory_types')
          ->where('accessory_id', $accId)
          ->where('value', $p->accessory_type)
          ->exists();
        if (!$existsType) {
          DB::table('accessory_types')->insert([
            'accessory_id' => $accId,
            'value' => $p->accessory_type,
            'created_at' => now(),
            'updated_at' => now(),
          ]);
        }
      }

      // Attach to pivot if not already attached with same size/type
      $existsPivot = DB::table('product_accessory')
        ->where('product_id', $p->id)
        ->where('accessory_id', $accId)
        ->where('size', $p->accessory_size)
        ->where('type', $p->accessory_type)
        ->exists();

      if (!$existsPivot) {
        DB::table('product_accessory')->insert([
          'product_id' => $p->id,
          'accessory_id' => $accId,
          'quantity' => 1,
          'notes' => null,
          'size' => $p->accessory_size,
          'type' => $p->accessory_type,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
    }
  }

  public function down(): void {
    // No-op: we won't try to reverse the backfill
  }
};
