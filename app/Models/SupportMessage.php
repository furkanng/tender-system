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
        "user_id",
        "admin_id",
    ];

    public function support()
    {
        return $this->belongsTo(Support::class, "support_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, "admin_id", "id");
    }
}
