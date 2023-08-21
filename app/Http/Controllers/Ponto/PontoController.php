<?php

namespace App\Http\Controllers\Ponto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PontoUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class PontoController extends Controller {
    public function index(){
        $userCpf = Auth::user()->cpf;
        $dadosPonto = PontoUser::where('cpf', $userCpf)->get();

        $resultadoFormatado= [];

        Carbon::setLocale('pt_BR');
        foreach ($dadosPonto as $item){

            $dataRegistroEntrada = Carbon::createFromFormat('Y-m-d H:i:s', $item['data_entrada']);
            $dataRegistroSaida = Carbon::createFromFormat('Y-m-d H:i:s', $item['data_saida']);

            $diasDaSemana = [
                'Sun' => 'Domingo',
                'Mon' => 'Segunda-feira',
                'Tue' => 'Terça-feira',
                'Wed' => 'Quarta-feira',
                'Thu' => 'Quinta-feira',
                'Fri' => 'Sexta-feira',
                'Sat' => 'Sábado',
            ];

            $dadosFormatados = [
                'horaEntrada' => $dataRegistroEntrada->format('H:i'),
                'dataCompletaEntrada' => $dataRegistroEntrada->format('d-m-Y'),
                'diaDaSemanaEntrada' => $diasDaSemana[$dataRegistroEntrada->format('D')],

                'horaSaida' => $dataRegistroSaida->format('H:i'),
                'dataCompletaSaida' => $dataRegistroSaida->format('d-m-Y'),
                'diaDaSemanaSaida' => $diasDaSemana[$dataRegistroSaida->format('D')]

            ];

            $resultadoFormatado[] = $dadosFormatados;

        }
        return view('ponto.index', compact( 'resultadoFormatado'));
    }
    public function filtrarDados($data_inicio, $data_fim){

        $userCpf = Auth::user()->cpf;
        $dadosPonto = PontoUser::where('cpf', $userCpf)->get();

        $dadosFiltrados = [];



        Carbon::setLocale('pt_BR');
        foreach ($dadosPonto as $item){
            $dataRegistroEntrada = Carbon::createFromFormat('Y-m-d H:i:s', $item['data_entrada']);
            $dataRegistroSaida = Carbon::createFromFormat('Y-m-d H:i:s', $item['data_saida']);

            if ($dataRegistroEntrada->greaterThanOrEqualTo($data_inicio) && $dataRegistroSaida->lessThanOrEqualTo($data_fim)) {
                $diasDaSemana = [
                    'Sun' => 'Domingo',
                    'Mon' => 'Segunda-feira',
                    'Tue' => 'Terça-feira',
                    'Wed' => 'Quarta-feira',
                    'Thu' => 'Quinta-feira',
                    'Fri' => 'Sexta-feira',
                    'Sat' => 'Sábado',
                ];
                $dadosFormatados = [
                    'horaEntrada' => $dataRegistroEntrada->format('H:i'),
                    'dataCompletaEntrada' => $dataRegistroEntrada->format('d-m-Y'),
                    'diaDaSemanaEntrada' => $diasDaSemana[$dataRegistroEntrada->format('D')],

                    'horaSaida' => $dataRegistroSaida->format('H:i'),
                    'dataCompletaSaida' => $dataRegistroSaida->format('d-m-Y'),
                    'diaDaSemanaSaida' => $diasDaSemana[$dataRegistroSaida->format('D')],
                ];
                $dadosFiltrados[] = $dadosFormatados;
            }
        }
        return response()->json(['dados' => $dadosFiltrados]);
    }

}
