<?php

namespace App\Http\Controllers\Ponto;

use App\Helpers\Util;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\PontoUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class PontoController extends Controller {
    public function index(){
        $userCpf = Auth::user()->cpf;

        $dadosPonto = PontoUser::where('cpf', $userCpf)->limit(10)->get();


        $resultadoFormatado= [];

        Carbon::setLocale('pt_BR');
        foreach ($dadosPonto as $item){
            $dataEntrada = $item->data_entrada;
            $dataSaida = $item->data_saida;


            if (!empty($dataEntrada) || !empty($dataSaida)) {
                try {

                    $dataRegistroEntrada = Carbon::create($dataEntrada);
                    $dataRegistroSaida = Carbon::create($dataSaida);

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
                        'id_registro' => $item['id']
                    ];

//                    $carbonDate->format

                    $dadosFormatados['dataCompletaEntrada'] = Util::formatDatePatternBR(Arr::get($dadosFormatados, 'dataCompletaEntrada'));
                    $resultadoFormatado[] = $dadosFormatados;


                } catch (\Exception $e) {
                    $mensagemErro = $e->getMessage();
                }
            }
        }

        return view('ponto.index', compact('resultadoFormatado'));
    }
    public function filtrarDados($data_inicio, $data_fim){

        $userCpf = Auth::user()->cpf;

        $dadosPonto = PontoUser::where('cpf', $userCpf)
            ->limit(10)
            ->get();

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

    public function proximaPagina(Request $request){
        $offset = $request->input('offset');
        $limit = 10;

        $userCpf = Auth::user()->cpf;

        $dadosPonto = PontoUser::where('cpf', $userCpf)
            ->limit($limit)
            ->offset($offset)
            ->get();

        $resultadoFormatado= [];

        Carbon::setLocale('pt_BR');
        foreach ($dadosPonto as $item){

            $dataEntrada = $item->data_entrada;
            $dataSaida = $item->data_saida;

            if (!empty($dataEntrada) && !empty($dataSaida)) {
                try {
                    $dataRegistroEntrada = Carbon::createFromFormat('Y-m-d H:i:s', $dataEntrada);
                    $dataRegistroSaida = Carbon::createFromFormat('Y-m-d H:i:s', $dataSaida);

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
                        'id_registro' => $item->id
                    ];
                    $resultadoFormatado[] = $dadosFormatados;
                } catch (\Exception $e) {
                    $mensagemErro = $e->getMessage();
                }
            }

        }
        return response()->json( $resultadoFormatado);
    }





}
