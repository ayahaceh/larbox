<?php

namespace Modules\System\Models;

use App\Models\Model;

class Settings extends Model
{
    protected $table = 'system_settings';

    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = 'name';
    protected $routeKeyName = 'name';
}
