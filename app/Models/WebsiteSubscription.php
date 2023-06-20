<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'website_id',
        'description',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
