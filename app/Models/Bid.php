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

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }

    public function tender()
    {

        return $this->belongsTo(Tender::class, 'tender_id', 'id');
    }

    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public static function booted()
    {
        static::created(function ($model) {

            $content = $model->user->name . " " . $model->tender->tender_no . " nolu ihaleye " .
                $model->bid_price . " TL teklif verdi";

            ActivityLog::create([
               "user_id" => $model->user_id,
               "content" => $content,
               "tender_id" => $model->tender_id,
               "bid_id" => $model->id,
            ]);
        });

        static::updated(function ($model) {
            if ($model->isDirty("bid_price")) {

                $content = $model->user->name . " " . $model->tender->tender_no . " nolu ihaleye verdiği teklifi " .
                    $model->bid_price . " TL olarak güncelledi";

                ActivityLog::create([
                    "user_id" => $model->user_id,
                    "content" => $content,
                    "tender_id" => $model->tender_id,
                    "bid_id" => $model->id,
                ]);
            }
        });
    }


}
