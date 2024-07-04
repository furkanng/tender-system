<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $fillable = [
        'user_id',
        'tender_id',
        'bid_id',
        'archive_id',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class, "tender_id", "id");
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class, "bid_id", "id");
    }

    public function archive(): BelongsTo
    {
        return $this->belongsTo(Archive::class, "archive_id", "id");
    }

}
