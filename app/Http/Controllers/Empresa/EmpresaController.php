<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Empresa;

class EmpresaController extends Controller {
  public static function getEmpresas() {
      return Empresa::query()->select()->get()->toArray();
  }
}
