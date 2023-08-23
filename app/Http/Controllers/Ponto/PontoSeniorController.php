<?php

namespace App\Http\Controllers\Ponto;

use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Ponto\Ponto;
use App\Models\Ponto\PontoErrado;
use App\Models\Ponto\PontoSenior;
use Illuminate\Support\Arr;

class PontoSeniorController extends Controller {
    /**
     * Popula o banco do Mysql com os pontos
     * @return void
     */
    function populate()
    {
        $data = $this->allData();
        $data = $this->controllerPopulate($this->format($data));

    }

    /**
     * Busca os dados de ponto da tabela que simula o DB Senior
     * @return mixed[]
     */
    private function allData()
    {
        return PontoSenior::query()->select('*')->orderBy('numcad', 'asc')->orderBy('dataPonto', 'asc')->orderBy('horaPonto', 'asc')->get()->toArray();
    }

    /**
     * Esta função trata a data hora e minuto para o padrão USA
     * @param $data
     * @return mixed
     */
    private function format($data)
    {
        foreach ($data as $key => $df)
        {
            $numcad =  Arr::get($df, 'numcad');

            $dataPonto = Arr::get($df, 'dataPonto') . " " . ((strlen(Arr::get($df, 'horaPonto')) == 1 ? ('0'.Arr::get($df, 'horaPonto')) : Arr::get($df, 'horaPonto'))) . ':' . (strlen(Arr::get($df, 'minutoPonto')) == 1 ? ('0' . Arr::get($df, 'minutoPonto')) : Arr::get($df, 'minutoPonto')) . ":00";

            $data[$key] = [$numcad, Util::formatDateTimePatternUSA($dataPonto)];
        }

        return $data;
    }

    /**
     * Esta função controla o fluxo de inserção no banco de dados
     * @param $data
     * @return void
     */
    private function controllerPopulate($data)
    {
        set_time_limit(0);
        foreach ($data as $df) {
            $entrada = $this->checkInDB($df, 'data_entrada');
            $saida = $this->checkInDB($df, 'data_saida');

            if($this->checkIfExist($df, 'data_entrada') && $this->checkIfExist($df, 'data_saida')) {
                if (!$entrada && !$saida) {
                    $this->insert($df, 'data_entrada');
                } elseif ($entrada && !$saida) {
                    $this->update(Arr::get($entrada, 0), Arr::get($df, 1), 'data_saida');
                } elseif ((!$entrada && $saida) || ($entrada && $saida)) {
                    //Ponto incorreto
                }
            }
        }
        dd('Terminou');
    }

    /**
     * Caso seja detectado um ponto incorreto, esta função salva o ponto na tabela ponto_incorreto
     * @param $data
     * @param $column
     * @return void
     */
    private function insertPontoErrado($data, $column) {
        PontoErrado::query()
            ->insert([
                'empresa_cod' => 16,
                'matricula'   => Arr::get($data, 0),
                $column       => Arr::get($data, 1),
                'cpf'         => '12890905640'
            ]);
    }

    /**
     * Esta função verifica no DB se a data informada no parâmetro existe na coluna
     * informada no parâmetro
     * @param $cod
     * @param $column
     * @return false|mixed[]
     */
    private function checkInDB($cod, $column)
    {
        $date = Arr::get($cod, 1);
        $cod = Arr::get($cod, 0);
        $date = explode(' ',$date);
        $ponto = Ponto::query()
            ->select('*')
            ->where('matricula','=', $cod)
            ->where($column,'like', '%'.Arr::get($date, 0).'%')
            ->get()
            ->toArray();

        if(!$ponto) {
            //Não existe no DB
            return false;
        }
        return $ponto;
    }

    /**
     * Esta função cria uma linha do DB com os dados do ponto
     * inserindo na coluna informada no parâmetro
     * @param $data
     * @param $column
     * @return void
     */
    private function insert($data, $column)
    {
        try {
            $query = Ponto::query()
                ->insert([
                    'empresa_cod' => 16,
                    'matricula'   => Arr::get($data, 0),
                    $column       => Arr::get($data, 1),
                    'cpf'         => '12890905640'
                ]);

        } catch (\Exception $e) {
            dd($e);
        }

    }

    /**
     * Atualiza a linha respectiva à matrícula informada no parâmetro
     * @param $data [matricula, 00-00-00 00:00:00]
     * @param $value
     * @param $column
     * @return void
     */
    private function update($data, $value, $column)
    {
        try{
            Ponto::where('id',Arr::get($data,'id'))
                ->update([
                    $column => $value
                ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Esta função verifica na tabela Ponto se esse valor já foi inserido antes
     * para não haver duplicação na hora de popular
     * @param $data
     * @param $colum
     * @return bool|void
     */
    private function checkIfExist($data, $colum)
    {
        try {
            $query = Ponto::query()
                ->select($colum)
                ->where('matricula', Arr::get($data, 0))
                ->where($colum, Arr::get($data,1))
                ->get()
                ->toArray();

            return empty($query) ? true : false;
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
