<?php
// database/seeders/TransactionSeeder.php
namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@test.com')->first();
        $incomeCats = Category::where('type', 'income')->pluck('category_id')->toArray();
        $expenseCats = Category::where('type', 'expense')->pluck('category_id')->toArray();

        // Create 20 random transactions over the last 30 days
        for ($i = 0; $i < 20; $i++) {
            $isExpense = rand(0, 1); // Randomly choose if it's income or expense logic

            Transaction::create([
                'user_id'         => $admin->id,
                'date'            => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'description'     => $isExpense ? 'Paid for service ' . ($i+1) : 'Received payment ' . ($i+1),
                'debit_category_id'  => $isExpense ? $expenseCats[array_rand($expenseCats)] : $incomeCats[array_rand($incomeCats)],
                'credit_category_id' => $isExpense ? $incomeCats[array_rand($incomeCats)] : $expenseCats[array_rand($expenseCats)],
                'amount'          => rand(500, 50000),
            ]);
        }
    }
}
