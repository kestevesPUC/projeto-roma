@extends('layouts.app')

@section('tabelaPontoColaborador')
<form class="card pt-10 mx-auto  bg-body-secondary" style="width: 65%">
        <h1 class="bg-body-tertiary p-3 rounded-top fw-semibold" >Consulta de Registro de ponto</h1>
        <div class="form d-flex flex-column align-items-end mt-3 p-4">
            <div class="form d-flex flex-row align-items-end mt-3 p-4" style="width: 100%">
                <div class="form-group">
                    <label for="data_inicio">Data Inicial</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" lang="pt-BR">
                </div>
                <div class="form-group ml-4">
                    <label for="data_fim">Data Final</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control" lang="pt-BR">
                </div>
                <button id="filtrarDados" type="button"  class="btn btn-outline-secondary btn-sm ml-4 bg-secondary text-light" style="height: 42px">Consultar</button>
            </div>    
                
            
        </div>
    </form>
<table class=" table table-bordered" style="width: 100%">
        <thead>
                <tr>
                    <th scope="col" class="text-center">Colaborador</th>
                    <th scope="col" class="text-center">Matrícula</th>
                    <th scope="col" class="text-center">Admissão</th>
                    <th scope="col" class="text-center">Setor</th>
                    <th scope="col" class="text-center">Cargo</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                    <td class="text-center">{{Auth::user()->name}}</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    </tr>
            </tbody>
</table>
<table class="table table-bordered" id="tabelaConsulta" style="width: 100%">
            <thead >
                <tr>
                <th scope="col" class="text-center">Data</th>
                <th scope="col" class="text-center">Dia semana</th>
                <th scope="col" class="text-center">Entrada</th>
                <th scope="col" class="text-center">Saída</th>
                <th scope="col" class="text-center">Entrada 2</th>
                <th scope="col" class="text-center">Saída 2</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($resultadoFormatado as $ponto)
                    <tr>
                        <td class="text-center">{{$ponto['dataCompletaEntrada']}}</td>
                        <td class="text-center">{{$ponto['diaDaSemanaEntrada']}}</td>
                        <td class="text-center">{{$ponto['horaEntrada']}}</td>
                        <td class="text-center">{{$ponto['horaSaida']}}</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                @endforeach
                
            </tbody>
</table>
@endsection

@section('scriptConsulta')
<script>
    document.getElementById('filtrarDados').addEventListener('click', function(){
        var dataInicio = document.getElementById('data_inicio').value;
        var dataFim = document.getElementById('data_fim').value;
        var url = '/ponto/consulta_data/'+ encodeURIComponent(dataInicio) + '/' + encodeURIComponent(dataFim);
        fetch(url)
            .then(response => response.json())
            .then(data => {
                var tabela = document.getElementById('tabelaConsulta');
                tabela.innerHTML = '';
               
                data.dados.forEach(dado => {
                    tabela.innerHTML += '<tr>' +
                        '<td class="text-center">' + dado.dataCompletaEntrada + '</td>' +
                        '<td class="text-center">' + dado.diaDaSemanaEntrada + '</td>' +
                        '<td class="text-center">' + dado.horaEntrada + '</td>' +
                        '<td class="text-center">' + dado.horaSaida + '</td>' +
                        '<td class="text-center"></td>' +
                        '<td class="text-center"></td>' +
                        '</tr>';
                });
                console.log(data);
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });
</script>
@endsection