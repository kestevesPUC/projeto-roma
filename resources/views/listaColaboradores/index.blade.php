@extends('layouts.app')

@section('content')

<div class="container grid gap-1 mt-1">

    <!-- Filtro de pesquisa por colaborador -->
    <form class="card pt-10 mx-auto  bg-secondary-subtle w-50" >
        <h1 class="bg-body-tertiary p-3 rounded-top fw-semibold" >Consulta Funcionários</h1>
        <div class="form d-flex flex-column p-3 pt-0">
            <div class="form d-flex flex-row gap-2">
                <div class="col g-3 align-items-center">
                    <div class="col-auto " >
                        <label for="nome-colaborador" class="col-form-label">Nome</label>
                    </div>
                    <div class="col-auto w-100">
                        <input type="text" id="nome_colaborador" name="nome_colaborador" class="form-control  border-light-subtle rounded" aria-describedby="nome do colaborador para ser filtrado">
                    </div>
                </div>
                <div class="col g-3 align-items-center">
                    <div class="col-auto">
                        <label for="cpf-colaborador" class="col-form-label ">Cpf</label>
                    </div>
                    <div class="col-auto w-100">
                        <input type="text" id="cpf_colaborador" name="cpf_colaborador" class="form-control border-light-subtle rounded" aria-describedby="cpf do colaborador para ser filtrado">
                    </div>
                </div>
            </div>    
            <div class="form d-flex flex-row align-items-end gap-2">
                <div class="col g-3 align-items-center">
                    <div class="col-auto ">
                        <label for="status-colaborador" class="col-form-label">Status</label>
                    </div>
                    <div class="col-auto w-100">
                        <select class="form-select align-items-end mt-1 w-100 border-light-subtle rounded" aria-label="Status do colaborador" id="status_colaborador" name="status_colaborador" style="width: 100%">
                            <option selected></option>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                </div>
                <div class="col g-3 align-items-center">
                    <div class="col-auto ">
                        <label for="status-colaborador" class="col-form-label">Diretor/Gerente</label>
                    </div>
                    <div class="col-auto w-100">
                        <select class="form-select align-items-end mt-1 w-100 border-light-subtle rounded" aria-label="confirmação de direção" id="diretorConfirmacao" name="diretorConfirmacao" style="width: 100%">
                            <option selected value=""></option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                
            <button id="filtrarColaborador" type="button"  class="btn btn-outline-secondary mt-2 bg-secondary text-light text-align-center" style="height: 38px;">Buscar</button>  
            </div>
        </div>
    </form>
    <!--Fim busca-->
    <button type="button" class="p-1 ms-auto bi-person-plus-fill text-bg-secondary rounded-circle" style="width:51px;height:51px;font-size:1.4rem;"></button>
    <!-- Tabela com dados de colaboradores -->
    <div class="row justify-content-center mt-3">
        
        <table class="table table-bordered"  style="width: 100%">
            <thead >
                <tr>
                    <th scope="col" class="text-center bg-secondary-subtle">Matrícula</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Colaborador</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Cpf</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Diretor/Gerente</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Status</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Editar</th>
                </tr>
            </thead>
            <tbody id="tabelaConsulta">
                
                @foreach($colaboradores as $colaborador)
                    <tr data-id="{{$colaborador->id}}">
                        <td class="text-center">{{$colaborador->matricula}}</td>
                        <td class="text-center">{{$colaborador->name}}</td>
                        <td class="text-center">{{$colaborador->cpf}}</td>
                        <td class="text-center"></td>
                        <td class="text-center">{{$colaborador->status === 1 ? 'Ativo' : 'Inativo'}}</td>
                        <td class="text-center">
                            <button type="button" class="btn bi-pencil-fill border-light-subtle"></button>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    <!--fim tabela-->
</div>
@endsection

@section('scriptConsulta')
<script>
    
    document.getElementById('filtrarColaborador').addEventListener('click', function(){

        var nomeColaborador = document.getElementById('nome_colaborador').value;
        var cpfColaborador = document.getElementById('cpf_colaborador').value;
        var statusSelect = document.getElementById('status_colaborador');
        var statusColaboradorSelect = statusSelect.value;
        var diretorSelect = document.getElementById('diretorConfirmacao');
        var diretorConfirmacaoValue = diretorSelect.value;
        var data = {
            nome_colaborador: nomeColaborador,
            cpf_colaborador: cpfColaborador,
            status_colaborador: statusColaboradorSelect
        }
        
        fetch('/controle/filtro_usuario',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {

                var tabela = document.getElementById('tabelaConsulta');
                tabela.innerHTML = '';
               
                data.dados.forEach(dado => {
                    tabela.innerHTML += '<tr data-id"'+ dado.id +'">' +
                        '<td class="text-center">' + dado.matricula + '</td>' +
                        '<td class="text-center">' + dado.name + '</td>' +
                        '<td class="text-center">' + dado.cpf + '</td>' +
                        '<td class="text-center"></td>' +
                        '<td class="text-center">' + dado.status + '</td>' +
                        '<td class="text-center"><button type="button" class="btn bi-pencil-fill border-light-subtle"></button></td>' +
                        '</tr>';
                });
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });
</script>
@endsection
