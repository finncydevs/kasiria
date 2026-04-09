<?php

namespace Tests\Feature;

use App\Models\Pelanggan;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Settings
        Setting::create(['key' => 'tax_rate', 'value' => '10']); // 10% Tax
    }

    public function test_transaction_page_loads_with_tax_rate()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('transactions.create'));

        $response->assertStatus(200);
        $response->assertViewHas('taxRate', '10');
    }

    public function test_create_transaction_with_tax_and_discount()
    {
        $user = User::factory()->create();
        
        // Create Category
        // Check Kategori model/factory. Assuming simple create if no factory.
        // But Kategori model might not have factory. Let's use create().
        // Kategori table usually has 'nama_kategori' or similar.
        // Let's assume 'nama_kategori' based on Indonesian naming convention in project.
        // But wait, user wants to avoid Indonesian tables? 'kategoris' table might still exist.
        // I'll check Kategori model file content from previous view_file if I can, but I just requested it.
        // I'll wait for view_file result or guess based on error? No, better to be sure.
        // The view_file is queued. I can't read it yet.
        // I will trust the view_file outcome in next turn or just use a safe guess if standard.
        // Actually, I can simply omit kategori_id if nullable?
        // Migration says `foreignId('kategori_id')->nullable()`.
        // So I can just set it to null!
        // But previously I set it to 1 and it failed.
        // Let's try setting it to null or removing it from create() in test if it's nullable.
        // But wait, 'products' table has 'category' string col too. I popluated that.
        // Let's try removing 'kategori_id' assignment in test.
        
        $product = Product::create([
            'sku' => '123456789',
            'name' => 'Test Product',
            'cost' => 8000,
            'price' => 10000,
            'stock' => 100,
            'category' => 'General',
            // 'kategori_id' => 1, // Removed to avoid FK error if nullable
        ]);

        // Create Gold Member (5% discount)
        $pelanggan = Pelanggan::create([
            'nama' => 'Sultan',
            'poin' => 600,
            'status' => true
        ]);

        $this->actingAs($user);

        // Calculation:
        // Item: 10,000 * 2 = 20,000
        // Discount (Member 5%): 20,000 * 0.05 = 1,000
        // Subtotal after discount: 19,000
        // Tax (10%): 19,000 * 0.10 = 1,900
        // Grand Total: 19,000 + 1,900 = 20,900
        
        $data = [
            'pelanggan_id' => $pelanggan->id,
            'payment_method' => 'cash',
            'payment_option' => 'pay_now',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'discount' => 0,
                ]
            ],
            'discount' => 1000, // Frontend calculates this
            'tax' => 1900,      // Frontend calculates this
            'amount_paid' => 21000,
        ];

        $response = $this->post(route('transactions.store'), $data);

        $response->assertRedirect();
        if (session()->all()) {
            dump(session()->all());
        }
        dump(\App\Models\Transaction::all()->toArray());
        
        $this->assertDatabaseHas('transactions', [
            'pelanggan_id' => $pelanggan->id,
            'subtotal' => 20000,
            'discount' => 1000,
            'tax' => 1900,
            'total' => 20900,
            'status' => 'pending', // pay_now creates pending then redirects to snap
        ]);
        
        // Stock should decrease
        $this->assertDatabaseHas('products', [ // Table is products now
            'id' => $product->id,
            'stock' => 98
        ]);
    }
}
