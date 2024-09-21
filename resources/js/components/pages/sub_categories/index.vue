<template>
    <div class="row">

        <div class="col-md-2 grid-margin stretch-card">
            <button @click="exportjsPdf()" class="btn btn-sm btn-info">Sub Category List PDF</button>
        </div>

        <div class="col-md-2 grid-margin stretch-card">
            <button @click="downloadXLSX()" class="btn btn-sm btn-info">Sub Category List XLSX</button>
        </div>

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
                    Sub Category List
                    <div>
                        <button type="button" class="btn bg-success " data-bs-toggle="modal"
                            data-bs-target="#addSubCategoryModal" @click="addData()">Add
                            Sub Category</button>
                    </div>
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 align-self-center">
                        </div>
                        <div class="col-md-4 align-self-end">
                            <input autocomplete="off" type="text" @keyup="Sub_CategoryList(1, true)"
                                class="form-control form-control-sm fw-bold" placeholder="Search..."
                                id="search_button" />
                        </div>
                        <div class="col-md-1 align-self-center">
                            <button class="btn btn-sm btn-success" @click="Sub_CategoryList(1, true)">Search</button>
                        </div>
                    </div>
                    <div id="temp-target">
                        <div class="table-responsive"></div>
                        <table id="table" class="table " style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(data, index) in Sub_CategoryListData.data" :key="index">
                                    <td>{{ index + 1 }}.</td>
                                    <td>{{ data.category?.name }}</td>
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.remarks }}</td>

                                    <td>
                                        <button @click="Sub_CategoryEdit(data.id)"
                                            class="btn btn-success btn-sm">Edit</button>
                                        <button @click="deleteSubCategory(data.id)"
                                            class="btn btn-danger btn-sm ms-1">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <nav aria-label="..." class="mt-2">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link, indexing) in Sub_CategoryListData.links" :key="indexing" class="page-item">
                            <a class="page-link" href="#" :class="link.active ? 'active' : ''"
                                @click="Sub_CategoryList(link.label)" v-html="link.label">

                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="addSubCategoryModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Create Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="addForm" @submit.prevent="submitSubCategory"
                        enctype="multipart/form-data">

                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="category_id" class="col-sm-3 form-label">Category:</label>
                            <select class="form-control chosen" name="category_id" v-model="form.category_id" required>
                                <option value="">Select</option>
                                <option v-for="(data, index) in categoryListData" :key="index" :value="data?.id">{{ data?.name }}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.category_id">{{ errors.category_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="name" class="col-sm-3 form-label">Name:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.name">
                            <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="remarks" class="col-sm-3 form-label">Remarks:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.remarks">
                            <span class="text-danger" v-if="errors?.remarks">{{ errors.remarks[0] }}</span>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <label for="" class="col-sm-6 mr-2">&nbsp;</label>
                            <button class="btn btn-sm btn-success w-25" type="submit"> Save </button>
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

    <!-- Edit Sub Category Modal -->
    <div class="modal fade bd-example-modal-lg" id="editSubCategoryModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="editForm" @submit.prevent="submitEditSubCategory(form.id)"
                        enctype="multipart/form-data">
                        <!-- change to edit fields -->

                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="category_id" class="col-sm-3 form-label">Category:</label>
                            <select class="form-control chosen" name="category_id" v-model="form.category_id" required>
                                <option value="">Select</option>
                                <option v-for="(data, index) in categoryListData" :key="index" :value="data?.id">{{ data?.name }}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.category_id">{{ errors.category_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="name" class="col-sm-3 form-label">Name:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.name">
                            <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="remarks" class="col-sm-3 form-label">Remarks:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.remarks">
                            <span class="text-danger" v-if="errors?.remarks">{{ errors.remarks[0] }}</span>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <label for="" class="col-sm-6 mr-2">&nbsp;</label>
                            <button class="btn btn-sm btn-success w-25" type="submit"> Save </button>
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
        let Sub_CategoryListData = ref([]);

        let categoryListData = ref([]);
        let author_id = store.getters.getUserId
        let token = store.getters.getToken
        const base_url = window.location.origin;
        const errors = ref({});

        let form = reactive({
            id: "",
            category_id: "",
            name: "",
            remarks: "",
            token: token
        });
        let SyncForm = reactive({
            Sub_Category_id: '',
            author_id: author_id
        });

        function onChange(event) {
            console.log(event);
            this.form.image = event.target.files[0];
        }

        const submitSubCategory = async (e) => {

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            await axios.post('/api/admin/sub_categories', form, config)
                .then(res => {
                    if (res.data.status == 'success') {
                        $('#addSubCategoryModal').modal('hide');

                        Sub_CategoryList();
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
                    console.log("🚀 ~ submitSubCategory ~ err:", err)
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

        const Sub_CategoryList = async (page = 1, search = false) => {

            let query = document.getElementById('search_button').value;
            if (query.length && query.length < 2) {
                query = ""; return false;
            }

            await axios.get(`/api/admin/sub_categories?page=${page}&search=${query}`)
                .then(res => {
                    Sub_CategoryListData.value = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }

        const categoryList = async () => {
            await axios.get(`/api/admin/category-list`)
            .then(res => {
            console.log('res:', res);
            categoryListData.value = res.data.data
            })
            .catch(err => {
            console.log(err);
            })
        }

        const Sub_CategoryEdit = async (id) => {
            await axios.get('/api/admin/sub_categories/' + id + '/edit')
                .then(res => {
                    if (res.data.status == 'success') {
                        form.id = res.data.data.id;
                        form.category_id = res.data.data.category_id;
                        form.name = res.data.data.name;
                        form.remarks = res.data.data.remarks;
                    }

                    $('#editSubCategoryModal').modal('show');
                })
                .catch(err => {
                    console.log(err);
                })
        }

        const submitEditSubCategory = async (id) => {

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            // put method can not accept config headers
            await axios.post('/api/admin/sub_Category_update/' + id, form, config)
                .then(res => {
                    console.log(res)
                    if (res.data.status == 'success') {

                        $('#editSubCategoryModal').modal('hide');
                        Swal.fire({
                            icon: res.data.status,
                            title: res.data.message,
                            toast: true,
                            timer: 5000,
                            position: 'top-end',
                        });
                        Sub_CategoryList();
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

        const deleteSubCategory = (id) => {

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
                    await axios.post('/api/admin/sub_categories/' + id, { _method: 'DELETE' })
                        .then(res => {
                            if (res.data.status == 'success') {

                                Swal.fire({
                                    icon: res.data.status,
                                    title: res.data.message,
                                    toast: true,
                                    timer: 5000,
                                    position: 'top-end',
                                });
                                Sub_CategoryList();
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
            setTimeout(function () {
                document.getElementById('addForm').reset();
            }, 500);
            errors.value = null;
        }

        function exportjsPdf() {
            var doc = new jsPDF('p', 'pt');

            var elem = document.getElementById('table');
            var imgElements = document.querySelectorAll('#table tbody img');
            var data = doc.autoTableHtmlToJson(elem);

            var y = 10;
            doc.setLineWidth(2);
            doc.text(200, y = y + 20, "Sub Category List report");

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
            doc.save("Sub_Category-table-" + now_mls + ".pdf");
        }

        const items = [
            { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        ];

        function downloadXLSX() {

            // json to excel or table to excel

            var elem = document.getElementById('table');
            // const data = XLSX.utils.json_to_sheet(items)
            const data = XLSX.utils.table_to_sheet(elem)
            const wb = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(wb, data, 'data');
            let now_mls = Date.now();
            XLSX.writeFile(wb, 'Sub Category List Report-' + now_mls + '.xlsx')
        }

        onMounted(() => {
            Sub_CategoryList();
            categoryList();
        });

        return {
            form,
            submitSubCategory,
            Sub_CategoryListData,
            deleteSubCategory,
            Sub_CategoryList,
            categoryList,
            categoryListData,
            Sub_CategoryEdit,
            submitEditSubCategory,
            base_url,
            errors,
            imageLoadError,
            addData,
            exportjsPdf,
            items,
            downloadXLSX,
            onChange
        }

    }
}
</script>
