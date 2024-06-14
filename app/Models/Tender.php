<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $table = "tenders";
    protected $fillable = [
        "company_id",
        "name",
        "brand",
        "model",
        "year",
        "km",
        "plate",
        "fuel_type",
        "roll",
        "tsrsb",
        "gear",
        "sase_no",
        "car_type",
        "damages",
        "images",
        "serviceName",
        "address",
        "servicePhone",
        "city",
        "district",
        "closed_date",
        "tender_type",
        "car_bid_id",
        "status",
    ];
}
