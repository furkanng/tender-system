<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $table = "archives";

    protected $fillable = [
        "company_id",
        "company_name",
        "tender_no",
        "plate",
        "car",
        "year",
        "city",
        "date",
        "order",
        "my_bid",
        "bid_name",
        "bid_phone",
        "bid_win",
        "status",
    ];
}
