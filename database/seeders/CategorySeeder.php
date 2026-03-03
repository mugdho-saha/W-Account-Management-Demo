<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Salary', 'type' => 'income'],
            ['category_name' => 'Freelance', 'type' => 'income'],
            ['category_name' => 'Office Rent', 'type' => 'expense'],
            ['category_name' => 'Electricity Bill', 'type' => 'expense'],
            ['category_name' => 'Marketing', 'type' => 'expense'],
            ['category_name' => 'Travel', 'type' => 'expense'],
            ['category_name' => 'Software Subscription', 'type' => 'expense'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate($cat);
        }
    }
}
