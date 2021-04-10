<?php

namespace App\Plugins\Biubiubiu\src\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class BiubiubiuCi extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'biubiubiu_ci';
    public $timestamps = false;

}
