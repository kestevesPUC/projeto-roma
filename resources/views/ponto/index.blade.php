@extends('layouts.app')

@section('content')
<div class="container grid gap-6 mt-5 fundo">
    <!-- formulário com filtro de perfis -->
    <form class="card pt-10 mx-auto  bg-secondary-subtle" style="width: 65%">
        <h1 class="bg-body-tertiary p-3 rounded-top fw-semibold" >Consulta de Registro de ponto</h1>
            <div class="form d-flex flex-row align-items-end mt-1 p-4" style="width: 100%">
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
                
            
    </form>
    
    <!-- botão de adicionar perfil de acesso -->
    <button type="button" class="p-1 ms-auto bi-plus text-bg-secondary rounded-circle mt-4" style="width:51px;height:51px;font-size:1.4rem;"></button>
    <!-- tabela de renderização de perfis de acesso -->
    <div class="row justify-content-center ">
        <table class=" table table-bordered" style="width: 100%">
            <thead>
                    <tr>
                        <th scope="col" class="text-center bg-secondary-subtle">Colaborador</th>
                        <th scope="col" class="text-center bg-secondary-subtle">Matrícula</th>
                        <th scope="col" class="text-center bg-secondary-subtle">Admissão</th>
                        <th scope="col" class="text-center bg-secondary-subtle">Setor</th>
                        <th scope="col" class="text-center bg-secondary-subtle">Cargo</th>
                    </tr>
                </thead>
                <tbody>
                        <tr >
                        <td class="text-center">{{Auth::user()->name}}</td>
                        <td class="text-center">{{Auth::user()->matricula}}</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        </tr>
                </tbody>
        </table>
        <table class="table table-bordered"  style="width: 100%">
            <thead >
                <tr>
                <th scope="col" class="text-center bg-secondary-subtle">Data</th>
                <th scope="col" class="text-center bg-secondary-subtle">Dia semana</th>
                <th scope="col" class="text-center bg-secondary-subtle">Entrada</th>
                <th scope="col" class="text-center bg-secondary-subtle">Saída</th>
                <th scope="col" class="text-center bg-secondary-subtle">Entrada 2</th>
                <th scope="col" class="text-center bg-secondary-subtle">Saída 2</th>
                </tr>
            </thead>
            <tbody id="tabelaConsulta">
                
                    @foreach($resultadoFormatado as $ponto)
                        <tr data-id="{{$ponto['id_registro']}}">
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
        
        <nav aria-label="Repaginar busca">
            <ul class="pagination">
                <li class="page-item">
                    <button type=button id="filtrarPaginaMenos" class="page-link text-body-emphasis" >Antigo</button>
                </li>
                <li class="page-item">
                    <button type="button" id="filtrarPaginaMais" class="page-link text-body-emphasis">Próximo</button>
                </li>
            </ul>
        </nav>
    </div>
</div>

       
@endsection

@section('scripts')
    <script src="{{ mix('assets/plugins/EssentialTables.js')}} "></script>
    <script src="{{ mix('js/ponto/index.js')}} "></script>
    <script >Ponto.init();</script>

@endsection

@section('scriptConsulta')
<script>
    document.getElementById('filtrarDados').addEventListener('click', function(){

        var dataInicio = document.getElementById('data_inicio').value;
        var dataFim = document.getElementById('data_fim').value;
        var url = '/controle/consulta_data/' + encodeURIComponent(dataInicio) + '/' + encodeURIComponent(dataFim);
 

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
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });
    var offset = 0;
    document.getElementById('filtrarPaginaMais').addEventListener('click', function(){
        
        
        offset += 10;
        
        fetch('/controle/proximaPagina?offset=' + offset)
            .then(response => response.json())
            .then(data => {
                var tabela = document.getElementById('tabelaConsulta');
                    console.log(data)
                tabela.innerHTML = '';
                data.forEach(dado => {
                    tabela.innerHTML += '<trdata-id"'+ dado.id_registro +'">' +
                        '<td class="text-center">' + dado.dataCompletaEntrada + '</td>' +
                        '<td class="text-center">' + dado.diaDaSemanaEntrada + '</td>' +
                        '<td class="text-center">' + dado.horaEntrada + '</td>' +
                        '<td class="text-center">' + dado.horaSaida + '</td>' +
                        '<td class="text-center"></td>'+
                        '<td class="text-center"></td>' +
                        '</tr>';
                });
            })
    })
    document.getElementById('filtrarPaginaMenos').addEventListener('click', function(){
        
        
        offset -= 10;
        
        fetch('/controle/proximaPagina?offset=' + offset)
            .then(response => response.json())
            .then(data => {
                var tabela = document.getElementById('tabelaConsulta');
                    console.log(data)
                tabela.innerHTML = '';
                data.forEach(dado => {
                    tabela.innerHTML += '<trdata-id"'+ dado.id_registro +'">' +
                        '<td class="text-center">' + dado.dataCompletaEntrada + '</td>' +
                        '<td class="text-center">' + dado.diaDaSemanaEntrada + '</td>' +
                        '<td class="text-center">' + dado.horaEntrada + '</td>' +
                        '<td class="text-center">' + dado.horaSaida + '</td>' +
                        '<td class="text-center"></td>'+
                        '<td class="text-center"></td>' +
                        '</tr>';
                });
            })
    })
</script>
@endsection
