<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $table = "bids";
    protected $fillable = [
        "user_id",
        "tender_id",
        "company_id",
        "bid_price",
        "transfer_status",
        "cover_image",
        "tsrsb",
        "subject",
        "plate",
        "address",
        "tender_closed_date",
        "tender_company_id",
    ];
}
