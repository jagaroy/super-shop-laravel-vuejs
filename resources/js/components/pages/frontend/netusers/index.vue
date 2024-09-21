<template>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
            Income List
            <div>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addIncomeModal"
                @click="addData()">Add Income</button>
            </div>
          </h6>
          <div class="card-body">

            <div class="table-responsive">
              <table id="dataTableExample" class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Payment Category</th>
                    <th>Particular</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in incomeListData.data" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ data.payment_category?.title }}</td>
                    <td>{{ data.particular?.title }}</td>
                    <td>{{ data.amount }}</td>
                    <td>{{ data.date }}</td>
                    <td>{{ data.remarks }}</td>
                    <td>
                      <button @click="incomeEdit(data.id)" class="btn btn-info btn-sm">Edit</button>
                      <button @click="incomeDelete(data.id)" class="btn btn-danger btn-sm ms-1">Delete</button>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <nav aria-label="...">
              <ul class="pagination justify-content-center">
                <!-- <li class="page-item disabled">
                  <span class="page-link">Previous</span>
                </li> -->

                <li v-for="(link, indexing) in incomeListData.links" :key="indexing" class="page-item">
                  <a class="page-link" href="#" @click="incomeList(link.label)" :class="link.active ? 'active' : ''"
                    v-html="link.label">

                  </a>
                </li>

                <!-- <li class="page-item active" aria-current="page">
                  <span class="page-link">2</span>
                  </li>
                  <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li> -->
              </ul>
            </nav>

          </div>
        </div>
      </div>
    </div>

  </template>

  <script>
  import { reactive, ref, onMounted } from 'vue'
  import { useRouter } from "vue-router"
  import store from '../../../../store/index.js'

  export default {
    setup() {
      const router = useRouter()
      let error = ref('')
      let incomeListData = ref([]);
      let categoryListData = ref([]);
      let particularListData = ref([]);
      const author_id = store.getters.getUserId;
      const errors = ref({});

      let form = reactive({
        payment_category_id: '',
        particular_id: '',
        amount: '',
        date: '',
        remarks: '',
        authored_by: author_id,

        income_id: ''
      });

      async function incomeList(page = 1) {
        console.log('page', page);
        await axios.get('/api/netuser/netusers')
          .then(res => {
              console.log("🚀 ~ incomeList ~ res:", res)
            incomeListData.value = res.data.data
            categoryListData.value = res.data.categories
            particularListData.value = res.data.particulars
          })
          .catch(err => {
            console.log(err);
          })
      }

      const submitIncome = async () => {
        await axios.post('/api/admin/income', form)
          .then(res => {
            if(res.data.status=='success'){

              Swal.fire({
                icon: res.data.status,
                title: res.data.message,

                showConfirmButton: true,
                toast: true,
                timer: 5000,
                position: 'top-end',
              })
              $('#addIncomeModal').modal('hide');

              form.payment_category_id = null;
              form.particular_id = null;
              form.amount = null;
              form.date = null;
              form.remarks = '';
              incomeList();
            }
          })
          .catch(err => {
            console.log("🚀 ~ submitIncome ~ err:", err)
            if (err.response.status === 422) {
              errors.value = err.response.data.errors
            } else {
              Swal.fire({
                icon: 'error',
                title: err.response.message,
                toast: true,
                timer: 5000,
                position: 'top-end',
              });
            }
          })
      }

      const updateIncome = async (id) => {
        await axios.put('/api/admin/income/' + id, form)
          .then(res => {

            if(res.data.status=='success'){

              Swal.fire({
                icon: res.data.status,
                title: res.data.message,

                showConfirmButton: true,
                toast: true,
                timer: 5000,
                position: 'top-end',
              })

              $('#editIncomeModal').modal('hide');
              incomeList();
            }

          })
          .catch(err => {
            if (err.response.status === 422) {
              errors.value = err.response.data.errors
            } else {
              Swal.fire({
                icon: 'error',
                title: err.response.message,
                toast: true,
                timer: 5000,
                position: 'top-end',
              });
            }
          })
      }

      const incomeEdit = async (id) => {
        await axios.get('/api/admin/income/' + id)
          .then(res => {
            form.payment_category_id = res.data.data.payment_category_id;
            form.particular_id = res.data.data.particular_id;
            form.amount = res.data.data.amount;
            form.date = res.data.data.date;
            form.remarks = res.data.data.remarks;

            form.income_id = res.data.data.id

            $('#editIncomeModal').modal('show');
          })
          .catch(err => {
            console.log('err', err);

          })
      }

      const incomeDelete = async (id) => {
        if (!confirm('Are you sure to remove?')) {
          return false;
        }
        console.log('del id', id)
        await axios.post('/api/admin/income/' + id, {
          _method: 'DELETE'
        })
          .then(res => {
            console.log('del res', res)
            incomeList();
          })
          .catch(err => {
            console.log(err);
          })
      }

      function addData() {
        document.getElementById('addForm').reset()
        errors.value = null;
      }

      onMounted(() => {
        incomeList();
      });

      return {
        incomeListData,
        incomeList,
        form,
        categoryListData,
        particularListData,
        submitIncome,
        incomeEdit,
        updateIncome,
        incomeDelete,
        addData,
        errors
      }

    }

  }
  </script>
