<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md">
        <div class="card">
          <div class="card-header"><h3>Despesas</h3></div>

          <div class="card-body">
            <div class="">
              <h4>Cadastrar despesa</h4>
              <form>
                <div class="d-flex justify-content-md-around">
                  <textarea
                    v-model="description"
                    class="form-control col-md"
                    cols="10"
                    rows="2"
                    placeholder="Descreva a despesa"
                  ></textarea>
                  <input
                    v-model="expenseDate"
                    type="date"
                    class="form-control col-md"
                    placeholder="Data"
                  />
                  <input
                    v-model.number="amount"
                    class="form-control col-md"
                    type="number"
                    step="0.01"
                    placeholder="Valor"
                  />
                  <div class="custom-file col-md">
                    <input
                      class="custom-file-input col-md"
                      placeholder="Adicionar imagem"
                      type="file"
                      id="foto"
                    />
                    <label class="custom-file-label" for="foto"
                      >Adicionar foto</label
                    >
                  </div>
                  <!-- <input type="hidden" v-model="userId" value="@php Auth::id(); @endphp"> -->
                </div>
                <div
                  v-bind:class="alert.class"
                  class="col-md-4 my-1"
                  v-show="alert.status"
                  role="alert"
                >
                  {{ alert.message }}
                </div>
                <div class="my-2">
                  <button
                    class="btn btn-success"
                    v-on:click="saveExpense"
                    v-show="add.status"
                    v-bind:disabled="!description || !expenseDate || !amount"
                  >
                    Adicionar
                  </button>
                  <button
                    class="btn btn-info"
                    v-on:click="editExpense"
                    v-show="edit.status"
                    v-bind:value="edit.value"
                    v-bind:disabled="!description || !expenseDate || !amount"
                  >
                    Editar
                  </button>
                  <button
                    type="reset"
                    class="btn btn-warning"
                    v-on:click="clearFields"
                    value="Limpar"
                  >
                    Limpar
                  </button>
                </div>
              </form>
            </div>

            {{ description }}
            <br />
            {{ expenseDate }}
            <br />
            {{ amount }}
            <br />
            {{ picture }}
            <br />
            <div class="col-md-12">
              <h4>Lista de despesas</h4>
              <input
                type="text"
                class="col-md-3 col-sm-12 m-1"
                v-on:keyup="searchExpense()"
                v-on:keyup.delete="searchExpense()"
                v-model="search"
                placeholder="Buscar descrição"
              />
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
                  <td>
                    <button
                      class="btn btn-success"
                      v-on:click="editFields(expense.id)"
                    >
                      <i class="fa fa-edit"></i> editar
                    </button>
                  </td>
                  <td>
                    <button
                      class="btn btn-danger"
                      v-on:click="delExpense(expense.id)"
                    >
                      <i class="fa fa-trash"></i> excluir
                    </button>
                  </td>
                </tr>
              </table>
              <!-- <div
                v-bind:class="alertSearch.class"
                class="my-1 text-center"
                v-show="alertSearch.status"
                role="alert"
              >
                {{ alertSearch.message }}
              </div> -->
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
      unfilteredExpenses: [],
      expenses: [],
      description: "",
      expenseDate: "",
      amount: "",
      picture: "",
      search: "",
      alert: {
        message: "",
        status: false,
        class: "",
      },
      alertSearch: {
        message: "",
        status: false,
        class: "",
      },
      edit: { value: "Editar", status: false },
      add: { value: "Adicionar", status: true },
    };
  },
  methods: {
    revertDate: function (date) {
      date = date.split("-");
      let newdate = date[2] + "/" + date[1] + "/" + date[0];
      return newdate;
    },

    disableBtn: function () {
      this.edit.status === false
        ? (this.edit.status = true)
        : (this.edit.status = false);
      this.add.status === true
        ? (this.add.status = false)
        : (this.add.status = true);
    },

    editFields: function (id) {
      let found = this.expenses.find((e) => e.id === id);

      console.log(found);
      this.disableBtn();
    },

    clearFields: function () {
      this.description = null;
      this.expenseDate = null;
      this.amount = null;
      this.picture = null;
    },
    alertSearchResult: function (m, className) {
      this.alertSearch.message = m;
      this.alertSearch.status = true;
      this.alertSearch.class = className;
      console.log(this.alert.message);
    },
    searchExpense: function () {
      if (this.search) {
        let filtered = this.expenses.filter((e) =>
          e.description.toLowerCase().match(this.search.toLowerCase())
        );
        this.expenses = filtered;
      } else {
        this.expenses = this.unfilteredExpenses
      }
    },
    alertSomething: function (m, className) {
      this.alert.message = m;
      this.alert.status = true;
      this.alert.class = className;
      console.log(this.alert.message);
    },
    alertReset: function () {
      this.alert.message = null;
      this.alert.status = false;
      this.alert.class = null;
      this.alertSearch.message = null;
      this.alertSearch.status = false;
      this.alertSearch.class = null;
    },

    //FUNÇÕES LISTAR, SALVAR, EDITAR E DELETAR FRONT-END PARA O BACK-END
    loadExpenses: function () {
      axios
        .get("/despesas")
        .then((res) => {
          this.expenses = res.data;
          this.unfilteredExpenses = res.data
        })
        .catch((error) => {
          console.error();
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
    saveExpense: function (e) {
      axios
        .post("/despesas", {
          description: this.description,
          expenseDate: this.expenseDate,
          amount: this.amount,
          picture: this.picture,
        })
        .then((res) => {
          this.alertSomething("Despesa adicionada com sucesso!","alert alert-success");
        })
        .catch((error) => { 
          console.log(error)
          this.alertSomething(error, "alert alert-danger");
        });
      e.preventDefault();
      
      this.loadExpenses();
      this.clearFields();
      setTimeout(this.alertReset, 5000);
    },

    editExpense: function (expense) {
      axios
        .put("/despesas/" + expense.id, {
          description: this.description,
          expenseDate: this.expenseDate,
          amount: this.amount,
          picture: this.picture,
        })
        .then((res) => {
          console.log("editado!");
        })
        .catch((error) => {
          console.log(error);
        });

      this.alertSomething(
        "Despesa editada com sucesso!",
        "alert alert-success"
      );
    },
    delExpense: function (expense) {
      axios
        .delete("/despesas/" + expense)
        .then((res) => {
          console.log(res.data)
        })
        .catch((error) => {
          console.error();
          this.errored = true;
        })
        .finally(() => (this.loading = false));
      this.loadExpenses();
    },
  },
  mounted() {
    this.loadExpenses();
  },
};
</script>