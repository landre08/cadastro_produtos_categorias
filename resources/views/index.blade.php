@extends('layout.app')

@section('body')

<div class="jumbotron bg-light border border-primary">
    <div class="row">
        <div class="card-deck">
            <div class="card border border-primary">
                <div class="card-body">
                    <h5>Cadastro de Produtos</h5>
                    <p class="card-text">
                        Aqui fica o texto do card.
                    </p>
                    <a href="/produtos" class="btn btn-primary">Cadastre seus produtos</a>
                </div>
            </div>

            <div class="card border border-primary">
                <div class="card-body">
                    <h5>Cadastro de Categorias</h5>
                    <p class="card-text">
                        Aqui fica o texto do card.
                    </p>
                    <a href="/categorias" class="btn btn-primary">Cadastre suas categorias</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection