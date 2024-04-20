<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table = "support";

    protected $fillable = [
        "title",
        "user_id",
        "content",
        "status",
        "read"
    ];

    public function message()
    {
        return $this->hasMany(SupportMessage::class, "support_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
