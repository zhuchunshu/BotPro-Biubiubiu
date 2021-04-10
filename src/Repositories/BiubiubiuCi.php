<?php

namespace App\Plugins\Biubiubiu\src\Repositories;

use App\Plugins\Biubiubiu\src\Models\BiubiubiuCi as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class BiubiubiuCi extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
