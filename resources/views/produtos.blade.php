@extends('layout.app', ['current' => 'produtos'])

@section('body')
<div class="card border">
    <div class="card-body">
        <h5 class="card-title">Lista de Produtos<h5>
            <table class="table table-hover table-bordered" id="tabelaProdutos">
                <thead>
                    <tr>
                        <th>Código</th> 
                        <th>Nome da Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
    </div>
    <div class="card-footer">
        <a class="btn btn-sm btn-primary" onClick="novoProduto()">Nova Produto</a>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formProduto">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Produto</h5>
                </div>
                <div class="modal-body">
                    
                    <input type="hidden" id="id" class="form-control">
                    <div class="form-group">
                        <label for="nomeProduto" class="control-label">Nome do Produto</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nomeProduto" placeholder="Nome do produto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="precoProduto" class="control-label">Nome do Preço</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="precoProduto" placeholder="Preço do produto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantidadeProduto" class="control-label">Quantidade do Produto</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="quantidadeProduto" placeholder="Quantidade do produto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="categoriaProduto" class="control-label">Categorias do Produto</label>
                        <div class="input-group">
                            <select class="form-control" id="categoriaProduto">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKE' : "{{ csrf_token() }}"
            }
        });

        function novoProduto() {
            $('#nomeProduto').val();
            $('#precoProduto').val();
            $('#quantidadeProduto').val();
            $('#id').val();
            $('#dlgProdutos').modal('show');
        }

        function carregarCategorias() {
            $.getJSON('/api/categorias', function(data) { 
                for (i = 0; i<data.length;i++) {
                    opcao = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';
                    $('#categoriaProduto').append(opcao);
                }
            });
        }

        function montarLinha(p) {
            var linha = "<tr>"+
                            "<td>"+p.id+"</td>"+
                            "<td>"+p.nome+"</td>"+
                            "<td>"+p.estoque+"</td>"+
                            "<td>"+p.preco+"</td>"+
                            "<td>"+p.categoria_id+"</td>"+
                            "<td>"+
                                '<button onclick="editar('+p.id+')" class="btn btn-sm btn-warning" style="margin-right: 5px;">Editar</button>'+
                                '<button onclick="remover('+p.id+')" class="btn btn-sm btn-danger">Apagar</button>'+
                            "</td>"+
                        "</tr>";

            return linha;        
        }

        function remover(id) {

            $.ajax({
                type: 'DELETE',
                url: '/api/produtos/'+id,
                context: this,
                success: function(data) {
                    console.log('Apagou OK');
                    linhas = $('#tabelaProdutos>tbody>tr');
                    e = linhas.filter( function(indice, elemento) {
                        return elemento.cells[0].textContent == id;
                    });

                    if (e) {
                        e.remove();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

        }

        function carregarProdutos() {
            $.getJSON('/api/produtos', function(produtos) { 
                for (i = 0; i<produtos.length;i++) {
                    linha = montarLinha(produtos[i]);
                    $('#tabelaProdutos>tbody').append(linha);
                }
            });
        }

        function criarProduto() {

            prod = { 
                    nome: $('#nomeProduto').val(), 
                    preco: $('#precoProduto').val(), 
                    estoque: $('#quantidadeProduto').val(), 
                    categoria_id: $('#categoriaProduto').val()
                }

                $.post('/api/produtos', prod, function(data) {
                    
                    produto = JSON.parse(data);
                    linha = montarLinha(produto);
                    $('#tabelaProdutos>tbody').append(linha);

                });

        }

        $('#formProduto').submit(function(evento) {
            evento.preventDefault();

            criarProduto();
            $('#dlgProdutos').modal('hide');
        });

        $(function() {
            carregarCategorias();
            carregarProdutos();
        })
    </script>
@endsection