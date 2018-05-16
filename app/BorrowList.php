<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowList extends Model
{
    protected $fillable=['user_id','asset_id','status'];
}
