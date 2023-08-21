<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'file_path',
        'file_name',
    ];
    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
}
