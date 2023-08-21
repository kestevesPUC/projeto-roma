@extends('layouts.app')

@section('tabelaListaColaboradores')

<form class="card pt-10 mx-auto  bg-body-secondary" style="width: 65%">
        <h1 class="bg-body-tertiary p-3 rounded-top fw-semibold" >Consulta de Registro de ponto</h1>
        <div class="form d-flex flex-column align-items-end mt-3 p-4">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <select class="form-select" aria-label="Status do colaborador">
                <option selected>Status</option>
                <option value="0">Ativo</option>
                <option value="1">Inativo</option>
            </select> 
        </div>
</form>
@endsection