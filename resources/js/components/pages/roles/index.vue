<template>

  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
          Role List
          <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal" @click="addData()">Add
              Role</button>
          </div>
        </h6>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7 align-self-center">
            </div>
            <div class="col-md-4 align-self-end">
              <input type="text" @keyup="roleList(1, true)" class="form-control form-control-sm fw-bold"
                placeholder="Search..." id="queue_search" v-model="SyncForm.queue_search" />
            </div>
            <div class="col-md-1 align-self-center">
              <button class="btn btn-sm btn-success" @keypress="roleList(1, true)">Search</button>
            </div>
          </div>
          <div class="table-responsive">
            <table id="dataTableExample" class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(data, index) in roleListData.data" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ data.name }}</td>
                  <td>{{ data.description }}</td>
                  <td>
                    <button @click="editModal(data.id)" class="btn btn-info btn-sm">Edit</button>
                    <button class="btn btn-sm btn-danger ms-1" @click="deleteRole(data.id)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <nav aria-label="..." class="mt-2">
            <ul class="pagination justify-content-center">
              <li v-for="(link, indexing) in roleListData.links" :key="indexing" class="page-item">
                <a class="page-link" href="#" :class="link.active ? 'active' : ''" @click="roleList(link.label)"
                  v-html="link.label">

                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          <form id="addForm" @submit.prevent="submitRole">
            <div class="mb-3">
              <label for="ipv4" class="form-label">Role Name:</label>
              <input class="form-control" type="text" id="ipv4" v-model="form.name">
              <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
            </div>
            <div class="mb-3">
              <label for="mkt_user" class="form-label">Description</label>
              <input id="mkt_user" class="form-control" type="text" v-model="form.description">
              <span class="text-danger" v-if="errors?.description">{{ errors.description[0] }}</span>
            </div>
            <input class="btn btn-info" type="submit" value="Submit">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Role Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          <form id="signupForm" @submit.prevent="submitEditRole(form.id)">
            <div class="mb-3">
              <label for="ipv4" class="form-label">Role Name:</label>
              <input class="form-control" type="text" id="ipv4" v-model="form.name">
              <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
            </div>
            <div class="mb-3">
              <label for="mkt_user" class="form-label">Description</label>
              <input id="mkt_user" class="form-control" type="text" v-model="form.description">
              <span class="text-danger" v-if="errors?.description">{{ errors.description[0] }}</span>
            </div>

            <input class="btn btn-info" type="submit" value="Submit">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref, onMounted } from 'vue'
import { useRouter } from "vue-router"
import store from '../../../store/index.js'

export default {
  setup() {
    const router = useRouter()
    let errors = ref('')
    let roleListData = ref([]);
    let author_id = store.getters.getUserId
    let SyncForm = reactive({
      queue_search: ''
    });

    let form = reactive({
      id: '',
      name: '',
      description: '',
      authored_by: author_id,
    });


    const submitRole = async () => {
      await axios.post('/api/admin/roles', form)
        .then(res => {
          if(res.data.status=='success'){
            Swal.fire({
              toast: true,
              icon: res.data.status,
              title: res.data.message,
              showConfirmButton: true,
              timer: 5000,
              position: 'top-end',
            })
            $('#addRoleModal').modal('hide');
            roleList();
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

    const submitEditRole = async (id) => {
      await axios.put('/api/admin/roles/' + id, form)
        .then(res => {
          if(res.data.status=='success'){
            Swal.fire({
              toast: true,
              icon: res.data.status,
              title: res.data.message,
              showConfirmButton: true,
              timer: 5000,
              position: 'top-end',
            })
            $('#editRoleModal').modal('hide');
            roleList();
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

    const roleList = async (page = 1, search = false) => {

      let query = SyncForm.queue_search;
      if (query.length && query.length < 2) {
        query = ""; return false;
      }

      await axios.get(`/api/admin/roles?page=${page}&search=${query}`)
        .then(res => {
          roleListData.value = res.data.data
        })
        .catch(err => {
          console.log(err);
        })
    }

    async function editModal(id) {
      try {
        const res = await axios.get('/api/admin/roles/' + id); // Replace with your API endpoint
        form.id = res.data.data.id;
        form.name = res.data.data.name;
        form.description = res.data.data.description;

        $('#editRoleModal').modal('show');
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }

    const deleteRole = (id) => {

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(async (result) => {
        if (result.isConfirmed) {
          await axios.post('/api/admin/roles/' + id, { _method: 'DELETE' })
            .then(res => {
              if (res.data.status == 'success') {
                Swal.fire({
                  icon: res.data.status,
                  title: res.data.message,
                  toast: true,
                  timer: 5000,
                  position: 'top-end',
                });
                roleList();
              } else {
                Swal.fire({
                  icon: res.data.status,
                  title: res.data.message,
                  toast: true,
                  timer: 5000,
                  position: 'top-end',
                });
              }
            }).catch(err => {
              console.log(err);
            });
        }
      });
    }

    function addData() {
      document.getElementById('addForm').reset()
      errors.value = null;
    }

    onMounted(() => {
      roleList();
    });

    return {
      form,
      submitRole,
      submitEditRole,
      roleListData,
      editModal,
      SyncForm,
      roleList,
      deleteRole,
      errors,
      addData
    }

  }

}
</script>
