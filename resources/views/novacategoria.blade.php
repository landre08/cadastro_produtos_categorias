@extends('layout.app', ['current' => 'categorias'])

@section('body')
    <div class="card border">
        <div class="card-body">
            <form action="/categorias" method="post">
                @csrf
                <div class="form-group">
                    <label for="nomeCategoria">Nome da Categoria</label>
                    <input class="form-control" type="text" placeholder="Categoria" name="nomeCategoria" id="nomeCategoria" />
                </div>
                <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                <button type="cancel" class="btn btn-primary btn-sm">Cancelar</button>
            </form>
        </div>
    </div>
@endsection