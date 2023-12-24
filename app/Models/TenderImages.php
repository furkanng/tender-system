<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderImages extends Model
{
    use HasFactory;

    protected $table = "tender_images";
    protected $fillable = [
        "tender_id",
        "images",
        "url",
    ];
}
