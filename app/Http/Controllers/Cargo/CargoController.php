<?php

namespace App\Http\Controllers\Cargo;

use App\Http\Controllers\Controller;
use App\Models\Cargo\Cargo;

class CargoController extends Controller {
    /**
     * Busca no DB todos os cargos existentes
     * @return mixed[]
     */
    public static function getCargo() {
        return Cargo::query()->select()->get()->toArray();
    }
}
