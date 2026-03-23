<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $fillable = ['order_number', 'customer_name', 'status', 'description', 'due_date'];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
