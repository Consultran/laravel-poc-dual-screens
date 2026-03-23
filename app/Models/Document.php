<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['work_order_id', 'title', 'document_type', 'filename'];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
