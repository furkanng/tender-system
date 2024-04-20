<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    use HasFactory;

    protected $table = "support_message";

    protected $fillable = [
        "support_id",
        "answer",
    ];

    public function support()
    {
        return $this->belongsTo(Support::class, "support_id", "id");
    }
}
