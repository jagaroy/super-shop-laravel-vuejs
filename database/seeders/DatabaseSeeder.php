<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Stock;
use App\Models\SubCategory;
use App\Models\Supplier;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Insert into brands
        Brand::insert([
            [
                'id' => 1,
                'name' => 'Raymond',
                'remarks' => 'Test',
                'authored_by' => 1,
                'created_at' => '2024-09-20 07:34:46',
                'updated_at' => '2024-09-20 07:34:46',
                'deleted_at' => null
            ]
        ]);

        // Insert into categories
        Category::insert([
            [
                'id' => 1,
                'name' => 'Luxury',
                'remarks' => 'test',
                'authored_by' => 1,
                'created_at' => '2024-09-20 09:39:11',
                'updated_at' => '2024-09-20 09:39:11',
                'deleted_at' => null
            ]
        ]);

        // Insert into products
        Product::insert([
            [
                'id' => 1,
                'name' => 'Shirt',
                'supplier_id' => '1',
                'brand_id' => '1',
                'category_id' => '1',
                'sub_category_id' => '1',
                'product_image' => '/upload/products/product_image-66ed8de182c89.jpg',
                'unit_type' => 'Piece',
                'purchase_price_per_unit' => 1200,
                'retail_price_per_unit' => 1500,
                'sku' => '999',
                'remarks' => 'test',
                'authored_by' => 1,
                'created_at' => '2024-09-20 14:56:23',
                'updated_at' => '2024-09-20 14:59:45',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'name' => 'T-Shirt',
                'supplier_id' => '1',
                'brand_id' => '1',
                'category_id' => '1',
                'sub_category_id' => '1',
                'product_image' => '/upload/products/product_image-66ed8e817670f.jpg',
                'unit_type' => 'Piece',
                'purchase_price_per_unit' => 1500,
                'retail_price_per_unit' => 1700,
                'sku' => '688',
                'remarks' => 'test.',
                'authored_by' => 1,
                'created_at' => '2024-09-20 15:02:25',
                'updated_at' => '2024-09-20 15:02:25',
                'deleted_at' => null
            ]
        ]);

        // Insert into roles
        Role::insert([
            [
                'id' => 1,
                'name' => 'Manager',
                'description' => 'desc',
                'authored_by' => 1,
                'created_at' => '2022-03-26 11:51:30',
                'updated_at' => '2022-03-26 11:51:30',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'name' => 'Supervisor.',
                'description' => 'supr',
                'authored_by' => 1,
                'created_at' => '2022-03-26 11:52:18',
                'updated_at' => '2024-03-20 07:51:17',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'name' => 'demo',
                'description' => 'demo',
                'authored_by' => 1,
                'created_at' => '2022-07-13 11:44:19',
                'updated_at' => '2022-07-13 11:44:19',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'name' => 'Executive.',
                'description' => 'Executive Officer.',
                'authored_by' => 1,
                'created_at' => '2024-03-20 07:54:16',
                'updated_at' => '2024-03-20 07:56:00',
                'deleted_at' => null
            ],
            [
                'id' => 6,
                'name' => 'Officer',
                'description' => 'trs',
                'authored_by' => 1,
                'created_at' => '2024-04-29 18:30:37',
                'updated_at' => '2024-04-29 18:31:19',
                'deleted_at' => null
            ]
        ]);

        // Insert into stocks
        Stock::insert([
            [
                'id' => 1,
                'product_id' => '2',
                'quantity' => 215,
                'remarks' => 'Test',
                'authored_by' => 1,
                'created_at' => '2024-09-20 18:30:26',
                'updated_at' => '2024-09-21 08:38:37',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'product_id' => '1',
                'quantity' => 135,
                'remarks' => 'test',
                'authored_by' => 1,
                'created_at' => '2024-09-20 18:35:56',
                'updated_at' => '2024-09-21 08:38:15',
                'deleted_at' => null
            ]
        ]);

        // Insert into sub_categories
        SubCategory::insert([
            [
                'id' => 1,
                'category_id' => '1',
                'name' => 'Sub Luxury',
                'remarks' => 'Test',
                'authored_by' => 1,
                'created_at' => '2024-09-20 12:20:16',
                'updated_at' => '2024-09-20 12:20:16',
                'deleted_at' => null
            ]
        ]);

        // Insert into suppliers
        Supplier::insert([
            [
                'id' => 1,
                'supplier_name' => 'Mr. Rimon',
                'company_name' => 'Rim Textile',
                'phone' => '01111111',
                'email' => 'r@r.r',
                'address' => 'Uttara, Dhaka.',
                'website' => 'rimtextile.com',
                'remarks' => 'Test,',
                'authored_by' => 1,
                'created_at' => '2024-09-19 17:07:19',
                'updated_at' => '2024-09-19 17:20:20',
                'deleted_at' => null
            ]
        ]);

        // Seed the 'users' table
        User::insert([
            [
                'id' => 1,
                'type' => 'superadmin',
                'role_id' => 1,
                'name' => 'John Doe',
                'email' => 'admin@admin.com',
                'email_verified_at' => '2024-09-19 14:07:19',
                'password' => bcrypt('admin@admin.com'),
                'created_at' => '2024-09-19 14:07:19',
                'updated_at' => '2024-09-19 14:07:19',
                'deleted_at' => null
            ],
        ]);

        $this->call(DatabaseSeeder::class);
    }
}
