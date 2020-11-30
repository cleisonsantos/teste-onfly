<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header"><h3>Despesas</h3></div>

                    <div class="card-body">
                        
                        <div class="form-group col-md-12">
                            <h4>Cadastrar despesa</h4>
                        <form action="">
                            <div class="d-flex justify-content-md-around">
                            <textarea class="form-control col-md" name="" id="" cols="10" rows="2" placeholder="Descreva a despesa"></textarea>
                            
                            <input class="form-control col-md" type="number" placeholder="Valor">
                            <div class="custom-file col-md">
                                <input class="custom-file-input col-md" placeholder="Adicionar imagem" type="file" id="foto" >
                                <label class="custom-file-label" for="foto">Adicionar foto</label>
</div>
                            </div>
                            <div class="my-2">
                            <button class="btn btn-success">Adicionar</button>
                            <button class="btn btn-warning">Cancelar</button>
                            </div>
                        </form>
                        </div>


                        <div>
                            <h4>Lista de despesas</h4>
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Descrição</th>
                                    <th>Categoria</th>
                                    <th>EDITAR</th>
                                    <th>EXCLUIR</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="product in products">
                                <td>%% expense.id %%</td>
                                <td>%% expense.pic %%</td>
                                <td>%% expense.description %%</td>
                                <td>R$ %% expense.value %%</td>
                                <td>%% expense.user %%</td>
                                <td><button class="btn btn-success" ng-click="editFieldsProducts(product.id)"> <i class="fa fa-edit"></i> editar</button></td>
                                <td><button class="btn btn-danger" ng-click="delProduct(product)"> <i class="fa fa-trash"></i> excluir</button></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {},
    data() {
        return { 
            message: 'Hello Teste'
        }
    }
}
</script>