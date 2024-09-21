<template>
  <div class="row">

    <div class="col-md-2 grid-margin stretch-card">
      <button @click="exportjsPdf()" class="btn btn-sm btn-info">User List Report PDF</button>
    </div>

    <div class="col-md-2 grid-margin stretch-card">
      <button @click="downloadXLSX()" class="btn btn-sm btn-info">User List Report XLSX</button>
    </div>

    <!-- <div class="col-md-2 grid-margin stretch-card">
      <button @click="tableToJson()" class="btn btn-sm btn-info">tableToJson</button>
    </div> -->

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
          User List
          <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal"
              @click="addData()">Add
              User</button>
          </div>
        </h6>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7 align-self-center">
            </div>
            <div class="col-md-4 align-self-end">
              <input type="text" @keyup="userList(1, true)" class="form-control form-control-sm fw-bold"
                placeholder="Search..." id="search_button" />
            </div>
            <div class="col-md-1 align-self-center">
              <button class="btn btn-sm btn-success" @click="userList(1, true)">Search</button>
            </div>
          </div>
          <div id="temp-target">
            <table id="table" class="" style="width: 100%;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Type</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <tr v-for="(data, index) in userListData.data" :key="index">
                  <td>{{ index + 1 }}.</td>
                  <td>{{ data.name }}</td>
                  <td>{{ data.email }}</td>
                  <td>{{ data.phone }}</td>
                  <td>
                    <img style="width: 50px; height: 50px;" :src="base_url + data.image" alt="" @error="imageLoadError">

                  </td>
                  <td>{{ data.status }}</td>
                  <td>{{ data.type }}</td>
                  <td>{{ data.role ? data.role.name : 'NA' }}</td>
                  <td>
                    <button @click="userEdit(data.id)" class="btn btn-success btn-sm">Edit</button>
                    <button @click="deleteUser(data.id)" class="btn btn-danger btn-sm ms-1">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <nav aria-label="..." class="mt-2">
            <ul class="pagination justify-content-center">
              <li v-for="(link, indexing) in userListData.links" :key="indexing" class="page-item">
                <a class="page-link" href="#" :class="link.active ? 'active' : ''" @click="userList(link.label)"
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
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          <form id="addForm" @submit.prevent="submitUser">
            <div class="row mb-3">
              <label for="name" class="col-sm-3 col-form-label">Name:</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" id="name" v-model="form.name">
                <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="email" class="col-sm-3 col-form-label">Email:</label>
              <div class="col-sm-9">
                <input class="form-control" type="email" id="email" v-model="form.email">
                <span class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="password" class="col-sm-3 col-form-label">Password:</label>
              <div class="col-sm-9">
                <input class="form-control" type="password" id="password" v-model="form.password">
                <small class="text-right">
                  <span class="min">Minimum 8 characters</span>, <span class="uppercase">uppercase</span>, <span
                    class="lowercase">
                    lowercase</span>, <span class="digit">digit</span>,
                  <span class="special">special character</span>.
                </small>
                <span class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password:</label>
              <div class="col-sm-9">
                <input class="form-control" type="password" id="password_confirmation"
                  v-model="form.password_confirmation">
                <small class="text-right">
                  <span class="confirm">Confirm Password</span>.
                </small>
                <span class="text-danger" v-if="errors?.password_confirmation">{{ errors.password_confirmation[0]
                  }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="phone" class="col-sm-3 col-form-label">Phone:</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" id="phone" v-model="form.phone">
                <span class="text-danger" v-if="errors?.phone">{{ errors.phone[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="role_id" class="col-sm-3 col-form-label">Role:</label>
              <div class="col-sm-9">
                <select name="role_id" id="role_id" class="form-control chosen required" required
                  v-model="form.role_id">
                  <option value="">Select</option>

                  <option v-for="(data, index) in roleListData" :key="index" :value="data?.id">{{
        data?.name }}</option>

                </select>
                <span class="text-danger" v-if="errors?.role_id">{{ errors.role_id[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="status" class="col-sm-3 col-form-label">Status</label>
              <div class="col-sm-9 pt-2">
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" v-model="form.status" value="Active" id="active">
                  <label class="form-check-label" for="active">
                    Active
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" value="Inactive" class="form-check-input" v-model="form.status" id="inactive">
                  <label class="form-check-label" for="inactive">
                    Inactive
                  </label>
                </div>
                <span class="text-danger" v-if="errors?.status">{{ errors.status[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="" class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <input class="btn btn-info" type="submit" value="Submit">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Edit User Modal -->
  <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" @submit.prevent="submitEditUser(form.id)">
            <div class="row mb-3">
              <label for="name" class="col-sm-3 col-form-label">Name:</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" id="name" v-model="form.name">
                <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="email" class="col-sm-3 col-form-label">Email:</label>
              <div class="col-sm-9">
                <input class="form-control" type="email" id="email" v-model="form.email">
                <span class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="password" class="col-sm-3 col-form-label">Password:</label>
              <div class="col-sm-9">
                <input class="form-control" type="password" id="password" v-model="form.password">
                <small class="text-right">
                  <span class="min">Minimum 8 characters</span>, <span class="uppercase">uppercase</span>, <span
                    class="lowercase">
                    lowercase</span>, <span class="digit">digit</span>,
                  <span class="special">special character</span>.
                </small>
                <span class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password:</label>
              <div class="col-sm-9">
                <input class="form-control" type="password" id="password_confirmation"
                  v-model="form.password_confirmation">
                <small class="text-right">
                  <span class="confirm">Confirm Password</span>.
                </small>
                <span class="text-danger" v-if="errors?.password_confirmation">{{ errors.password_confirmation[0]
                  }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="phone" class="col-sm-3 col-form-label">Phone:</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" id="phone" v-model="form.phone">
                <span class="text-danger" v-if="errors?.phone">{{ errors.phone[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="role_id" class="col-sm-3 col-form-label">Role:</label>
              <div class="col-sm-9">
                <select name="role_id" id="role_id" class="form-control chosen required" required
                  v-model="form.role_id">
                  <option value="">Select</option>

                  <option v-for="(data, index) in roleListData" :key="index" :value="data?.id">{{
        data?.name }}</option>

                </select>
                <span class="text-danger" v-if="errors?.role_id">{{ errors.role_id[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="status" class="col-sm-3 col-form-label">Status</label>
              <div class="col-sm-9 pt-2">
                <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" v-model="form.status" value="Active" id="active">
                  <label class="form-check-label" for="active">
                    Active
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" value="Inactive" class="form-check-input" v-model="form.status" id="inactive">
                  <label class="form-check-label" for="inactive">
                    Inactive
                  </label>
                </div>
                <span class="text-danger" v-if="errors?.status">{{ errors.status[0] }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="" class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <input class="btn btn-info" type="submit" value="Submit">
              </div>
            </div>
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
import { jsPDF } from 'jspdf';
// import { JsonExcel } from 'vue-json-excel3';
import autoTable from 'jspdf-autotable'
import XLSX from 'xlsx';

export default {
  setup() {

    const router = useRouter()
    let error = ref('')
    let userListData = ref([]);
    let roleListData = ref([]);
    let author_id = store.getters.getUserId
    let token = store.getters.getToken
    const base_url = window.location.origin;
    const errors = ref({});

    let form = reactive({
      id: '',
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      phone: '',
      status: '',
      role_id: '',
      type: '',
      token: token
    });
    let SyncForm = reactive({
      user_id: '',
      author_id: author_id
    });

    const submitUser = async () => {
      await axios.post('/api/admin/users', form)
        .then(res => {
          if (res.data.status == 'success') {
            $('#addUserModal').modal('hide');

            userList();
          }
          Swal.fire({
            icon: res.data.status,
            title: res.data.message,
            toast: true,
            timer: 5000,
            position: 'top-end',
          });

        })
        .catch(err => {
          console.log("🚀 ~ submitUser ~ err:", err)
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
    const userList = async (page = 1, search = false) => {

      let query = document.getElementById('search_button').value;
      if (query.length && query.length < 2) {
        query = ""; return false;
      }

      await axios.get(`/api/admin/users?page=${page}&search=${query}`)
        .then(res => {
          userListData.value = res.data.data
        })
        .catch(err => {
          console.log(err);
        })
    }

    const roleList = async () => {
      await axios.get(`/api/admin/role-list`)
        .then(res => {
          roleListData.value = res.data.data
        })
        .catch(err => {
          console.log(err);
        })
    }

    const userEdit = async (id) => {
      await axios.get('/api/admin/users/' + id + '/edit')
        .then(res => {
          if (res.data.status == 'success') {

            form.id = res.data.data.id;
            form.name = res.data.data.name;
            form.email = res.data.data.email;
            form.password = '';
            form.password_confirmation = '';
            form.phone = res.data.data.phone;
            form.status = res.data.data.status;
            form.role_id = res.data.data.role_id;
          }

          $('#editUserModal').modal('show');
        })
        .catch(err => {
          console.log(err);
        })
    }
    const submitEditUser = async (id) => {
      console.log("🚀 ~ submitEditUser ~ id:", id)
      await axios.put('/api/admin/users/' + id, form)
        .then(res => {
          console.log(res)
          if (res.data.status == 'success') {

            $('#editUserModal').modal('hide');
            Swal.fire({
              icon: res.data.status,
              title: res.data.message,
              toast: true,
              timer: 5000,
              position: 'top-end',
            });
            userList();
          } else {
            Swal.fire({
              icon: res.data.status,
              title: res.data.message,

              showConfirmButton: true,
              timer: 5000
            })
          }
        })
        .catch(err => {
          console.log(err);
        })
    };

    const deleteUser = (id) => {

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
          await axios.post('/api/admin/users/' + id, { _method: 'DELETE' })
            .then(res => {
              if (res.data.status == 'success') {

                Swal.fire({
                  icon: res.data.status,
                  title: res.data.message,
                  toast: true,
                  timer: 5000,
                  position: 'top-end',
                });
                userList();
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

    function imageLoadError(event) {
      event.target.src = base_url + '/images/default.jpg'
    }

    function addData() {
      document.getElementById('addForm').reset()
      errors.value = null;
    }

    function exportPdf() {
      // Landscape export, 2×4 inches
      const doc = new jsPDF({
        // orientation: "landscape",
        // unit: "in",
        // format: [4, 2]
        fontSize: 9
      });
      var pdfjs = document.getElementById('temp-target').outerHTML;
      // Convert HTML to PDF in JavaScript
      doc.html(pdfjs, {
        callback: function (doc) {
          doc.setFont("helvetica");
          // doc.setFontType("bold");
          doc.setFontSize(9);
          doc.save("output.pdf");
        },
        // x: 10,
        // y: 10
      });
    }

    var generateData = function (amount) {
      var result = [];
      var data = {
        coin: "100",
        game_group: "GameGroup",
        game_name: "XPTO2",
        game_version: "25",
        machine: "20485861",
        vlt: "0"
      };
      for (var i = 0; i < amount; i += 1) {
        data.id = (i + 1).toString();
        result.push(Object.assign({}, data));
      }
      return result;
    };

    function createHeaders(keys) {
      var result = [];
      for (var i = 0; i < keys.length; i += 1) {
        result.push({
          id: keys[i],
          name: keys[i],
          prompt: keys[i],
          width: 65,
          align: "center",
          padding: 0
        });
      }
      return result;
    }

    var headers = createHeaders([
      "id",
      "coin",
      "game_group",
      "game_name",
      "game_version",
      "machine",
      "vlt"
    ]);

    function exportPdf2() {
      var doc = new jsPDF({ putOnlyUsedFonts: true, orientation: "portrait" });
      doc.table(10, 20, generateData(100), headers, { autoSize: true });
      doc.save('table_with_javascript_data');
      // // another style
      // var doc = new jsPDF('p', 'pt', 'letter')
      // // Supply data via script
      // var body = [

      //   [1, 'Oneplus', 30000, 11, ''],
      //   [1, 'Oneplus', 30000, 11, ''],
      //   [1, 'Oneplus', 30000, 11, ''],
      //   [1, 'Oneplus', 30000, 11, ''],
      //   [1, 'Oneplus', 30000, 11, ''],
      // ]
      // // generate auto table with body
      // var y = 10;
      // doc.setLineWidth(2);
      // doc.text(200, y = y + 30, "Product detailed report");
      // doc.autoTable({
      //   head: [['SL.No', 'Product Name', 'Price', 'Model', 'sdf'],],
      //   body: body,
      //   startY: 70,
      //   theme: 'grid',
      //   //for image
      //   didDrawCell: function (data) {
      //     if (data.column.index === 4 && data.cell.section === 'body') {
      //       var td = data.cell.raw;
      //       var dim = data.cell.height - data.cell.padding('vertical');
      //       console.log("🚀 ~ exportPdf2 ~ dim:", dim)
      //       var textPos = data.cell;
      //       var img_src = 'http://localhost:8000/upload/profiles/superadminp.jpg';
      //       doc.addImage(img_src, textPos.x, textPos.y, 20, 20);
      //     }
      //   }
      // })
      // // save the data to this file
      // doc.save('auto_table_with_javascript_data');
    }

    function exportjsPdf() {
      var doc = new jsPDF('p', 'pt');

      var elem = document.getElementById('table');
      var imgElements = document.querySelectorAll('#table tbody img');
      var data = doc.autoTableHtmlToJson(elem);

      var y = 10;
      doc.setLineWidth(2);
      doc.text(200, y = y + 20, "User List report");

      let columns_without_last = data.columns;
      columns_without_last.pop();
      let rows_without_last = data.rows;

      doc.autoTable(columns_without_last, rows_without_last, {
        bodyStyles: { minCellHeight: 30 },
        didDrawCell: function (data) {

          if (data.column.index === 6 && data.cell.section === 'body') {

            var img = imgElements[data.row.index];
            let x = data.row.cells[4].x;
            let y = data.row.cells[4].y;
            var dim = data.cell.height - data.cell.padding('vertical');
            // addImage throws error for invalid img src. so fill up with default image first in html
            // if(img)
            doc.addImage(img.src, x, y, 20, 20);
          }
        },
      });
      let now_mls = Date.now();
      doc.save("user-table-" + now_mls + ".pdf");
    }

    const items = [
      { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
      { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
      { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
      { age: 38, first_name: 'Jami', last_name: 'Carney' }
    ];

    function downloadXLSX() {

      // json to excel or table to excel

      var elem = document.getElementById('table');
      // const data = XLSX.utils.json_to_sheet(items)
      const data = XLSX.utils.table_to_sheet(elem)
      const wb = XLSX.utils.book_new()
      XLSX.utils.book_append_sheet(wb, data, 'data');
      let now_mls = Date.now();
      XLSX.writeFile(wb, 'User List Report-' + now_mls + '.xlsx')
    }

    function tableToJson() {
      let table = document.getElementById('table');
      var data = [];
      var headings = ['#', 'Name', 'Email', 'Phone', 'Image', 'Status', 'Type', 'Role', 'Action'];

      for (var i = 0; i < table.rows.length; i++) {
        var tableRow = table.rows[i];
        var rowData = [];

        for (var j = 1; j < tableRow.cells.length; j++) {
          let arr = {};
          // let index = tableRow.rows[0].innerHTML;
          let headings = table.rows[0].cells[j].innerHTML;
          arr[headings] = tableRow.cells[j].innerHTML;
          rowData.push(arr);
        }
        data.push(rowData);
      }
      return data;
    }

    onMounted(() => {
      userList();
      roleList();
    });

    return {
      form,
      submitUser,
      userListData,
      deleteUser,
      userList,
      userEdit,
      submitEditUser,
      base_url,
      errors,
      imageLoadError,
      roleList,
      roleListData,
      addData,
      exportPdf,
      exportPdf2,
      exportjsPdf,
      items,
      downloadXLSX,
      tableToJson,
    }

  }
}
</script>
