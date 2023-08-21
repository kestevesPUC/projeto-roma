<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Perfil\Perfil;

class PerfilController extends Controller {
    public static function getPerfil() {
        return Perfil::query()->select()->get()->toArray();
    }
}
