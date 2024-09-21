<template>

    <div class="row">
        <div class="col-md-12 grid-margin ">
            <div class="card card-info">
                <div class="card-header bg-default">Permission Setup <small class="text-default">(It will handle all
                        actions
                        inside App\Http\Controllers\)</small></div>
                <div class="card-body">
                    <form id="" @submit.prevent="searchPermission()" method="GET" role="form" class="form-inline"
                        enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="role_id" class="col-sm-3 col-form-label text-end">Role:</label>
                            <div class="col-sm-5">
                                <select name="role_id" id="role_id" class="form-control chosen required" required
                                    v-model="SyncForm.role_id" @change="searchPermission()">
                                    <option value="">Select</option>

                                    <option v-for="(data, index) in roleListData" :key="index" :value="data?.id">{{
                        data?.name }}</option>

                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-sm btn-success w-25" type="submit"> Search </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="card">
                <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
                    Permission List
                    <div>
                        <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addPermissionModal">Add
                            Permission</button> -->
                    </div>
                </h6>
                <div class="card-body">

                    <div class="card card-default">
                        <form id="role_permission_form" method="POST" enctype="multipart/form-data"
                            @submit.prevent="saveRolePermission">

                            <div
                                v-html="permissionSearch ? (permissionSearch.html ? permissionSearch.html : null) : null">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <br>
            <!-- <div class="card">
                <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
                    Permission List
                    <div>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addPermissionModal">Add
                            Permission</button>
                    </div>
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 align-self-center">
                        </div>
                        <div class="col-md-4 align-self-end">
                            <input type="text" @keyup="permissionList(1, true)"
                                class="form-control form-control-sm fw-bold" placeholder="Search..." id="queue_search"
                                v-model="SyncForm.queue_search" />
                        </div>
                        <div class="col-md-1 align-self-center">
                            <button class="btn btn-sm btn-success" @keypress="permissionList(1, true)">Search</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Permission Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in permissionListData.data" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ data.permi_module }}</td>
                                    <td>{{ data.permi_desc }}</td>
                                    <td>
                                        <button @click="editModal(data.permi_id)"
                                            class="btn btn-info btn-sm">Edit</button>
                                        <button class="btn btn-sm btn-danger"
                                            @click="deletePermission(data.permi_id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="..." class="mt-2">
                        <ul class="pagination justify-content-center">
                            <li v-for="(link, indexing) in permissionListData.links" :key="indexing" class="page-item">
                                <a class="page-link" href="#" :class="link.active ? 'active' : ''"
                                    @click="permissionList(link.label)" v-html="link.label">

                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div> -->
        </div>
    </div>

</template>

<script>
import { reactive, ref, onMounted } from 'vue'
import { useRouter } from "vue-router"
import store from '../../../store/index.js'
import $ from 'jquery'

export default {
    setup() {
        const router = useRouter()
        let error = ref('')
        let permissionListData = ref([]);
        let author_id = store.getters.getUserId
        let roleListData = ref([]);
        let permissionSearch = ref([]);
        let SyncForm = reactive({
            queue_search: '',
            role_id: '',
        });

        let form = reactive({
            permi_id: '',
            name: '',
            description: '',
            authored_by: author_id,
        });

        const roleList = async () => {

            await axios.get(`/api/admin/role-list`)
                .then(res => {
                    roleListData.value = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }

        // const permissionList = async (page = 1, search = false) => {

        //     let query = SyncForm.queue_search;
        //     if (query.length && query.length < 2) {
        //         query = ""; return false;
        //     }

        //     await axios.get(`/api/admin/permissions?page=${page}&search=${query}`)
        //         .then(res => {
        //             permissionListData.value = res.data.data
        //         })
        //         .catch(err => {
        //             console.log(err);
        //         })
        // }

        async function editModal(id) {
            try {
                const res = await axios.get('/api/admin/permissions/' + id); // Replace with your API endpoint
                form.permi_id = res.data.data.permi_id;
                form.name = res.data.data.name;
                form.description = res.data.data.description;

                $('#editPermissionModal').modal('show');
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // const deletePermission = (id) => {

        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then(async (result) => {
        //         if (result.isConfirmed) {
        //             await axios.post('/api/admin/permissions/' + id, { _method: 'DELETE' })
        //                 .then(res => {
        //                     if (res.data.status == 'success') {
        //                         Swal.fire({
        //                             icon: res.data.status,
        //                             title: res.data.message,
        //                             toast: true,
        //                             timer: 5000,
        //                             position: 'top-end',
        //                         });
        //                         permissionList();
        //                     } else {
        //                         Swal.fire({
        //                             icon: res.data.status,
        //                             title: res.data.message,
        //                             toast: true,
        //                             timer: 5000,
        //                             position: 'top-end',
        //                         });
        //                     }
        //                 }).catch(err => {
        //                     console.log(err);
        //                 });
        //         }
        //     });
        // }

        const searchPermission = async () => {

            permissionSearch.value = null;
            await axios.post('/api/admin/permission-list', SyncForm)
                .then(res => {
                    if (res.data.status == 'success') {
                        permissionSearch.value = res.data.data;
                    }
                })
                .catch(err => {
                    Swal.fire({
                        toast: true,
                        title: 'Error',
                        text: err,

                        timer: 5000,
                        position: 'top-end',
                    })
                })
        }

        const saveRolePermission = async () => {

            let permission_form_data = document.getElementById('role_permission_form');
            let form_data = new FormData(permission_form_data);

            await axios.post('/api/admin/permissions', form_data)
                .then(res => {
                    Swal.fire({
                        toast: true,
                        icon: res.data.status,
                        title: res.data.message,
                        timer: 5000,
                        position: 'top-end',
                    })
                })
                .catch(err => {
                    Swal.fire({
                        toast: true,
                        title: 'Error',
                        text: err,
                        timer: 5000,
                        position: 'top-end',
                    })
                })
        }

        onMounted(() => {
            // permissionList();
            roleList();

            $(function () {

                $(document).on('click', '.module', function (event) {
                    var that = this;
                    $(this).closest('tr').find('input').each(function (index, el) {
                        if ($(that).is(':checked')) {
                            $(el).prop('checked', true);
                        } else {
                            $(el).prop('checked', false);
                        }
                    });
                });
                $(document).on('click', '.module_sub_class', function () {
                    let tr = $(this).closest('tr');
                    var count = 0;
                    tr.find('.module_sub_class').each(function (index, el) {
                        if ($(this).is(':checked')) {
                            count += 1;
                        }
                    });
                    if (count > 0) {
                        tr.find('.module').prop('checked', true);
                    } else {
                        tr.find('.module').prop('checked', false);
                    }
                });
            });

        });

        return {
            form,
            permissionListData,
            editModal,
            SyncForm,
            // permissionList,
            // deletePermission,
            roleListData,
            roleList,
            searchPermission,
            permissionSearch,
            saveRolePermission
        }




    }

}



</script>
