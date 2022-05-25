<?php

namespace Modules\User\Models;

use App\Models\Model;
use App\Casts\Storage\AsImage;

class Profile extends Model
{
    protected $table = 'user_profile';
    protected $primaryKey = 'user_id';

    public $incrementing = false;
    public $timestamps = false;


    protected $guarded = [
        'user_id',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $casts = [
        'image' => AsImage::class . ':100|500',
    ];
}
