<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['date', 'description', 'debit_category_id', 'credit_category_id', 'amount', 'user_id'];

    public function debitCategory() {
        return $this->belongsTo(Category::class, 'debit_category_id', 'category_id');
    }

    public function creditCategory() {
        return $this->belongsTo(Category::class, 'credit_category_id', 'category_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
