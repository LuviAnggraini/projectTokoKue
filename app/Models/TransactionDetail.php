<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    public function cake() {
	    return $this->belongsTo('App\Models\Cake','cake_id', 'id');
	}

	public function transaction() {
	    return $this->belongsTo('App\Models\Transaction','transaction_id', 'id');
	}
}
