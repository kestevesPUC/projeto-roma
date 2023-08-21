@extends('layouts.app')

@section('content')

<div class="container grid gap-1 mt-8">

    <!-- Filtro de pesquisa por perfil -->
    <form class="card pt-10 mx-auto  bg-secondary-subtle w-50" >
        <h1 class="bg-body-tertiary p-3 rounded-top fw-semibold" >Consulta Perfil</h1>
        <div class="form d-flex flex-column p-3 pt-0">    
            <div class="form d-flex flex-row align-items-end gap-2">
                <div class="col g-3 align-items-center">
                    <div class="col-auto " >
                        <label for="nome-perfil" class="col-form-label">Nome</label>
                    </div>
                    <div class="col-auto w-100">
                        <input type="text" id="nome_perfil" name="nome_perfil" class="form-control  border-light-subtle rounded" aria-describedby="nome do perfil de acesso a ser filtrado">
                    </div>
                </div>
                <div class="col g-3 align-items-center">
                    <div class="col-auto ">
                        <label for="status-colaborador" class="col-form-label">Status</label>
                    </div>
                    <div class="col-auto w-100">
                        <select class="form-select align-items-end mt-1 w-100 border-light-subtle rounded" aria-label="Status do perfil" id="status_perfil" name="status_perfil" style="width: 100%">
                            <option value=""></option>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                </div>
                
            <button id="filtrarPerfil" type="button"  class="btn btn-outline-secondary mt-2 bg-secondary text-light text-align-center" style="height: 38px;">Buscar</button>  
            </div>
        </div>
    </form>
    <!--Fim busca-->
    <button type="button" class="p-1 ms-auto bi-plus text-bg-secondary rounded-circle mt-4" style="width:51px;height:51px;font-size:1.4rem;"></button>
    <!-- Tabela com dados de perfis -->
    <div class="row justify-content-center mt-3">
        
        <table class="table table-bordered"  style="width: 100%">
            <thead >
                <tr>
                    <th scope="col" class="text-center bg-secondary-subtle">Código</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Perfil de acesso</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Tipo</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Superior</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Ativo</th>
                    <th scope="col" class="text-center bg-secondary-subtle">Dias prev. Entr.</th>
                </tr>
            </thead>
            <tbody id="tabelaConsulta">
                
                @foreach($perfis as $perfil)
                    <tr>
                        <td class="text-center">{{$perfil->id}}</td>
                        <td class="text-center">{{$perfil->descricao}}</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center">{{$perfil->ativo === 1 ? 'Ativo' : 'Inativo'}}</td>
                        <td class="text-center"></td>
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
    
    document.getElementById('filtrarPerfil').addEventListener('click', function(){

        var nomePerfil = document.getElementById('nome_perfil').value;
        var statusSelect = document.getElementById('status_perfil');
        var statusPerfilSelect = statusSelect.value;
        var data = {
            nome_perfil: nomePerfil,
            status_perfil: statusPerfilSelect
        }
        
        fetch('/controle/filtro_perfil',{
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
                    tabela.innerHTML += '<tr>' +
                        '<td class="text-center">' + dado.id + '</td>' +
                        '<td class="text-center">' + dado.descricao + '</td>' +
                        '<td class="text-center"></td>' +
                        '<td class="text-center"></td>' +
                        '<td class="text-center">' + dado.status + '</td>' +
                        '<td class="text-center"></td>' +
                        '</tr>';
                });
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });
</script>
@endsection