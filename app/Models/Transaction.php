<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function user()
	{
	    return $this->belongsTo('App\Models\User','user_id', 'id');
	}

	public function transaction_detail() 
	{
	    return $this->hasMany('App\Models\TransactionDetail','transaction_id', 'id');
	}
}
