<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header"><h3>Despesas</h3></div>

                    <div class="card-body">
                        
                        <div class="form-group col-md-12">
                            <h4>Cadastrar despesa</h4>
                        <form action="" @submit="save">
                            <div class="d-flex justify-content-md-around">
                            <textarea v-model="description" class="form-control col-md" name="" id="" cols="10" rows="2" placeholder="Descreva a despesa"></textarea>
                            <input v-model="expenseDate" type="date" class="form-control col-md" placeholder="Data">
                            <input v-model.number="amount" class="form-control col-md" type="number" placeholder="Valor">
                            <div class="custom-file col-md">
                                <input  class="custom-file-input col-md" placeholder="Adicionar imagem" type="file" id="foto" >
                                <label class="custom-file-label" for="foto">Adicionar foto</label>
                            </div>
                            <!-- <input type="hidden" v-model="userId" value="@php Auth::id(); @endphp"> -->
                            </div>
                            <div class="my-2">
                            <input type="submit" class="btn btn-success" value="Adicionar">
                            <button class="btn btn-warning">Cancelar</button>
                            </div>
                        </form>
                        </div>

                        {{ description }}
                        <br>
                        {{ expenseDate }}
                        <br>
                        {{ amount }}
                        <br>
                        {{ picture }}
                        <br>
                        <div>
                            <h4>Lista de despesas</h4>
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                    
                                    <th>Foto</th>
                                    <th>Descrição</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                    <th>Usuário</th>
                                    <th>EDITAR</th>
                                    <th>EXCLUIR</th>
                                </tr>
                            </thead>
                            <tr v-for="expense in expenses" :key="expense.index">
                                
                                <td>{{ expense.pic }}</td>
                                <td>{{ expense.description }}</td>
                                <td>{{ revertDate(expense.expense_date) }}</td>
                                <td>R$ {{ expense.amount }}</td>
                                <td>{{ expense.user }}</td>
                                <td><button class="btn btn-success" ng-click="editExpense(expense.id)"> <i class="fa fa-edit"></i> editar</button></td>
                                <td><button class="btn btn-danger" v-on:click="delExpense(expense.id)"> <i class="fa fa-trash"></i> excluir</button></td>
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
        return{
        expenses: [],
        description: "",
        expenseDate: "",
        amount: "",
        picture: ""
        }
    },
    methods: {
        /* addExpense: function (){
            this.expense = this.expense.push(description.amount, amount.amount, picture.amount)
        } */
        loadExpenses: function(){
        axios
            .get('/despesas')
            .then(res => {
                this.expenses = res.data;
            })
            .catch(error => {
                console.error();
                this.errored = true
                })
            .finally(() => this.loading = false)
        },
        save: function(e) {
            axios
            .post('/despesas', {
                description: this.description,
                expenseDate: this.expenseDate,
                amount: this.amount,
                picture: this.picture,
            })
            .then(function(res){
                console.log('Sucesso!')
            }).catch(error => {
                console.log(error)
            })
            e.preventDefault();

            this.loadExpenses()
        },
        revertDate: function(date) {
            date = date.split('-')            
            let newdate = date[2] + '/' + date[1] + '/' + date[0]
            return newdate
        },
        editExpense: function(){

        },
        delExpense: function(expense){
            axios
            .delete('/despesas/'+ expense)
            .then(res => {
                console.log('Deletado!')
            })
            .catch(error => {
                console.error();
                this.errored = true
                })
            .finally(() => this.loading = false)
            this.loadExpenses()
        }
    },
    mounted(){
        this.loadExpenses()
        
        
    }
}
</script>