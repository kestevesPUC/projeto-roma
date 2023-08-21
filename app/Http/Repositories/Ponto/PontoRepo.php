<?php

namespace App\Repositories\Ponto;

use App\Models\Ponto\Ponto;

class PontoRepo {
    function loadGrid()
    {
        dd('awui');
        dd(Ponto::query()->select('*')->get());
    }
}
