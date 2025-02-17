<?php

namespace Modules\Box\Models;

use App\Models\Model;

class Variation extends Model
{
    protected $table = 'box_variation';

    public $timestamps = false;

    protected $hidden = [
        'box_id',
    ];

    protected $casts = [
        'name' => 'array',
    ];
}
