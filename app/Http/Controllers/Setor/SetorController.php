<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Models\Setor\Setor;

class SetorController extends Controller {

    /**
     * Busca no DB todos os setores existentes
     * @return mixed[]
     */
    public static function getSetor() {
        return Setor::query()->select()->get()->toArray();
    }
}
