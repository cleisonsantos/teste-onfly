<template>
  <div class="d-flex justify-content-center">
    <div class="col-xl-10 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-header"><h3>Despesas</h3></div>

        <div class="card-body">
          <div class="col-md-12">
            <h4>Cadastrar despesa</h4>
            <form>
              <div class="row">
                <textarea
                  v-model="description"
                  class="form-control col-md-3 my-1"
                  cols="10"
                  rows="2"
                  placeholder="Descreva a despesa"
                ></textarea>
                <input
                  v-model="expenseDate"
                  type="date"
                  class="form-control col-md-3 my-1"
                  placeholder="Data"
                />
                <input
                  v-model.lazy="amount"
                  class="form-control col-md-3 my-1"
                  v-money="money"
                  placeholder="Valor"
                />
                <div class="custom-file col-md-3 my-1">
                  <input
                    class="custom-file-input"
                    placeholder="Adicionar imagem"
                    type="file"
                    id="picture"
                    ref="picture"
                    v-on:change="handlePicture()"
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
          <div class="">
            <h4>Lista de despesas</h4>
            <input
              type="text"
              class="col-md-3 col-sm-12 m-1"
              v-on:keyup="searchExpense()"
              v-on:keyup.delete="searchExpense()"
              v-model="search"
              placeholder="Buscar descrição"
            />
            <div class="overflow-auto">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>EDITAR</th>
                    <th>EXCLUIR</th>
                    <th>Foto</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Usuário</th>
                  </tr>
                </thead>
                <tr v-for="expense in expenses" :key="expense.index">
                  <td>
                    <button
                      class="btn btn-info"
                      v-on:click="editFields(expense.id)"
                    >
                      <font-awesome-icon :icon="editIcon" />
                    </button>
                  </td>
                  <td>
                    <button
                      class="btn btn-danger"
                      v-on:click="delExpense(expense.id)"
                    >
                      <font-awesome-icon :icon="deleteIcon" />
                    </button>
                  </td>
                  <td>
                    <img
                      style="height: 2.5rem"
                      v-bind:src="'/storage/' + expense.picture"
                      alt="Foto da despesa"
                    />
                  </td>
                  <td>{{ expense.description }}</td>
                  <td>{{ revertDate(expense.expense_date) }}</td>
                  <td>R$ {{ expense.amount }}</td>
                  <td>{{ expense.user }}</td>
                </tr>
              </table>
            </div>
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
</template>

<script>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEdit } from "@fortawesome/free-solid-svg-icons";
import { faTrash } from "@fortawesome/free-solid-svg-icons";

export default {
  components: {
    FontAwesomeIcon,
  },
  computed: {},
  data() {
    return {
      unfilteredExpenses: [],
      expenses: [],
      id: "",
      description: "",
      expenseDate: "",
      amount: "",
      picture: [],
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
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "R$ ",
        precision: 2,
        masked: true /* doesn't work with directive */,
      },
      editIcon: faEdit,
      deleteIcon: faTrash,
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
      this.id = found.id;
      this.description = found.description;
      this.expenseDate = found.expense_date;
      this.amount = found.amount;
      this.picture = found.picture;
      this.disableBtn();
    },

    clearFields: function () {
      this.description = null;
      this.expenseDate = null;
      this.amount = null;
      this.picture = [];
    },
    alertSearchResult: function (m, className) {
      this.alertSearch.message = m;
      this.alertSearch.status = true;
      this.alertSearch.class = className;
    },
    searchExpense: function () {
      if (this.search) {
        let filtered = this.expenses.filter((e) =>
          e.description.toLowerCase().match(this.search.toLowerCase())
        );
        this.expenses = filtered;
      } else {
        this.expenses = this.unfilteredExpenses;
      }
    },
    alertSomething: function (m, className) {
      this.alert.message = m;
      this.alert.status = true;
      this.alert.class = className;
    },
    alertReset: function () {
      this.alert.message = null;
      this.alert.status = false;
      this.alert.class = null;
      this.alertSearch.message = null;
      this.alertSearch.status = false;
      this.alertSearch.class = null;
    },

    //FUNÇÃO PARA A IMAGEM
    handlePicture: function () {
      this.picture = []
      let uploadedPicture = this.$refs.picture.files;

      this.picture.push(uploadedPicture[0]);
    },

    //FUNÇÕES LISTAR, SALVAR, EDITAR E DELETAR FRONT-END PARA O BACK-END
    loadExpenses: function () {
      axios
        .get("/despesas")
        .then((res) => {
          this.expenses = res.data;
          console.log("Carregou!");
        })
        .catch((error) => {
          console.error();
          this.errored = true;
        })
        .finally(() => (this.loading = false));
      
    },
    saveExpense: function (e) {
      e.preventDefault();
      let formData = new FormData();
      formData.append("description", this.description);
      formData.append("expenseDate", this.expenseDate);
      formData.append(
        "amount",
        parseFloat(this.amount.replace("R$ ", "").replace(",", "."))
      );
      formData.append("picture", this.picture[0]);
      //console.log(formData)
      axios
        .post("/despesas", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.alertSomething(
            "Despesa adicionada com sucesso!",
            "alert alert-success"
          );
          this.loadExpenses();
        })
        .catch((error) => {
          this.alertSomething(error, "alert alert-danger");
        });

      
      this.clearFields();
      setTimeout(this.alertReset, 5000);
    },

    editExpense: function (e) {
      e.preventDefault();
      let url = "/despesas/" + this.id;
      let formData = new FormData()
      formData.append("_method", "PUT")
      formData.append("description", this.description);
      formData.append("expenseDate", this.expenseDate);
      formData.append(
        "amount",
        parseFloat(this.amount.replace("R$ ", "").replace(",", "."))
      );
      formData.append("picture", this.picture[0]);
      axios
        .post(url, formData,
       {
         headers: {
          'Content-Type': 'multipart/form-data'
         }
       })
        .then((res) => {
          this.alertSomething(
            "Despesa editada com sucesso!",
            "alert alert-success"
          );
          this.loadExpenses();
        })
        .catch((error) => {
          console.log(error);
          this.alertSomething(error, "alert alert-danger");
        });

      
      this.clearFields();
      this.disableBtn();
      setTimeout(this.alertReset, 5000);
    },
    delExpense: function (expense) {
      axios
        .delete("/despesas/" + expense)
        .then((res) => {
          console.log(res.data);
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