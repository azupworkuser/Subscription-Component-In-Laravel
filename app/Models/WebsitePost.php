<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsitePost extends Model
{
    use HasFactory;

    public const STATUS_INACTIVE = 1;
    public const STATUS_ACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'website_id',
        'title',
        'description',
        'status',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
