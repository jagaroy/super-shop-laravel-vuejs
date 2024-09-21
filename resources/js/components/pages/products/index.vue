<template>
    <div class="row">

        <div class="col-md-2 grid-margin stretch-card">
            <button @click="exportjsPdf()" class="btn btn-sm btn-info">Product List PDF</button>
        </div>

        <div class="col-md-2 grid-margin stretch-card">
            <button @click="downloadXLSX()" class="btn btn-sm btn-info">Product List XLSX</button>
        </div>

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
                    Product List
                    <div>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addProductModal" @click="addData()">Add
                            Product</button>
                    </div>
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 align-self-center">
                        </div>
                        <div class="col-md-4 align-self-end text-center">
                            <input autocomplete="off" type="text" @keyup="ProductList(1, true)"
                                class="form-control form-control-sm fw-bold" placeholder="Search..."
                                id="search_button" />
                            <span>(Name, Supplier, Brand, Category, Sub Category)</span>
                        </div>
                        <div class="col-md-1 align-self-center">
                            <button class="btn btn-sm btn-success" @click="ProductList(1, true)">Search</button>
                        </div>
                    </div>
                    <div id="temp-target">
                        <div class="table-responsive"></div>
                        <table id="table" class="table " style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%">SL.</th>
                                    <th>Name</th>
                                    <th>Supplier</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Image</th>
                                    <th>Unit Type</th>
                                    <th>Purchase Price Per Unit</th>
                                    <th>Retail Price Per Unit</th>
                                    <th>SKU</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(data, index) in ProductListData.data" :key="index">
                                    <td>{{ index + 1 }}.</td>
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.supplier?.supplier_name }}</td>
                                    <td>{{ data.brand?.name }}</td>
                                    <td>{{ data.category?.name }}</td>
                                    <td>{{ data.sub_category?.name }}</td>
                                    <td>
                                        <img style="width: 50px; height: 50px;" :src="base_url + data.product_image" alt="image"
                                            @error="imageLoadError">
                                    </td>
                                    <td>{{ data.unit_type }}</td>
                                    <td>{{ data.purchase_price_per_unit }}</td>
                                    <td>{{ data.retail_price_per_unit }}</td>
                                    <td>{{ data.sku }}</td>
                                    <td>
                                        <button @click="ProductEdit(data.id)"
                                            class="btn btn-success btn-sm">Edit</button>
                                        <button @click="deleteProduct(data.id)"
                                            class="btn btn-danger btn-sm ms-1">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <nav aria-label="..." class="mt-2">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link, indexing) in ProductListData.links" :key="indexing" class="page-item">
                            <a class="page-link" href="#" :class="link.active ? 'active' : ''"
                                @click="ProductList(link.label)" v-html="link.label">

                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="addForm" @submit.prevent="submitProduct" enctype="multipart/form-data">

                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="name" class="col-sm-3 form-label">Name:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.name">
                            <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="supplier_id" class="col-sm-3 form-label">Supplier:</label>
                            <select class="form-control chosen" name="supplier_id" v-model="form.supplier_id">
                                <option value="">Select</option>
                                <option v-for="(data, index) in supplierListData" :key="index" :value="data?.id">{{
                                    data?.supplier_name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.supplier_id">{{ errors.supplier_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="brand_id" class="col-sm-3 form-label">Brand:</label>
                            <select class="form-control chosen" name="brand_id" v-model="form.brand_id">
                                <option value="">Select</option>
                                <option v-for="(data, index) in brandListData" :key="index" :value="data?.id">{{
                                    data?.name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.brand_id">{{ errors.brand_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="category_id" class="col-sm-3 form-label">Category:</label>
                            <select class="form-control chosen" name="category_id" v-model="form.category_id">
                                <option value="">Select</option>
                                <option v-for="(data, index) in categoryListData" :key="index" :value="data?.id">{{
                                    data?.name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.category_id">{{ errors.category_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="sub_category_id" class="col-sm-3 form-label">Sub Category:</label>
                            <select class="form-control chosen" name="sub_category_id" v-model="form.sub_category_id"
                                required>
                                <option value="">Select</option>
                                <option v-for="(data, index) in sub_categoryListData" :key="index" :value="data?.id">{{
                                    data?.name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.sub_category_id">{{ errors.sub_category_id[0]
                                }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="product_image" class="col-sm-3 form-label">Product Image:</label>
                            <input autocomplete="off" class="form-control" type="file" v-on:change="onChange" />
                            <span class="text-danger" v-if="errors?.product_image">{{ errors.product_image[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="unit_type" class="col-sm-3 form-label">Unit Type:</label>
                            <select class="form-control" v-model="form.unit_type" required>
                                <option value="">Select</option>
                                <option value="Kg">Kg</option>
                                <option value="Piece">Piece</option>
                            </select>
                            <span class="text-danger" v-if="errors?.unit_type">{{ errors.unit_type[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="purchase_price_per_unit" class="col-sm-3 form-label">Purchase Price Per
                                Unit:</label>
                            <input autocomplete="off" class="form-control" type="text"
                                v-model="form.purchase_price_per_unit">
                            <span class="text-danger" v-if="errors?.purchase_price_per_unit">{{
                                errors.purchase_price_per_unit[0]
                                }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="retail_price_per_unit" class="col-sm-3 form-label">Retail Price Per
                                Unit:</label>
                            <input autocomplete="off" class="form-control" type="text"
                                v-model="form.retail_price_per_unit">
                            <span class="text-danger" v-if="errors?.retail_price_per_unit">{{
                                errors.retail_price_per_unit[0]
                                }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="sku" class="col-sm-3 form-label">SKU:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.sku" readonly />
                            <span class="text-danger" v-if="errors?.sku">{{ errors.sku[0] }}</span>
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

    <!-- Edit Product Modal -->
    <div class="modal fade bd-example-modal-lg" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="editForm" @submit.prevent="submitEditProduct(form.id)"
                        enctype="multipart/form-data">
                        <!-- change to edit fields -->

                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="name" class="col-sm-3 form-label">Name:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.name">
                            <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="supplier_id" class="col-sm-3 form-label">Supplier:</label>
                            <select class="form-control chosen" name="supplier_id" v-model="form.supplier_id">
                                <option value="">Select</option>
                                <option v-for="(data, index) in supplierListData" :key="index" :value="data?.id">{{
                                    data?.supplier_name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.supplier_id">{{ errors.supplier_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="brand_id" class="col-sm-3 form-label">Brand:</label>
                            <select class="form-control chosen" name="brand_id" v-model="form.brand_id">
                                <option value="">Select</option>
                                <option v-for="(data, index) in brandListData" :key="index" :value="data?.id">{{
                                    data?.name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.brand_id">{{ errors.brand_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="category_id" class="col-sm-3 form-label">Category:</label>
                            <select class="form-control chosen" name="category_id" v-model="form.category_id">
                                <option value="">Select</option>
                                <option v-for="(data, index) in categoryListData" :key="index" :value="data?.id">{{
                                    data?.name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.category_id">{{ errors.category_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="sub_category_id" class="col-sm-3 form-label">Sub Category:</label>
                            <select class="form-control chosen" name="sub_category_id" v-model="form.sub_category_id"
                                required>
                                <option value="">Select</option>
                                <option v-for="(data, index) in sub_categoryListData" :key="index" :value="data?.id">{{
                                    data?.name}}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.sub_category_id">{{ errors.sub_category_id[0]
                                }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="product_image" class="col-sm-3 form-label">Product Image:</label>
                            <input autocomplete="off" class="form-control" type="file" v-on:change="onChange" />
                            <span class="text-danger" v-if="errors?.product_image">{{ errors.product_image[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="unit_type" class="col-sm-3 form-label">Unit Type:</label>
                            <select class="form-control" v-model="form.unit_type" required>
                                <option value="">Select</option>
                                <option value="Kg">Kg</option>
                                <option value="Piece">Piece</option>
                            </select>
                            <span class="text-danger" v-if="errors?.unit_type">{{ errors.unit_type[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="purchase_price_per_unit" class="col-sm-3 form-label">Purchase Price Per
                                Unit:</label>
                            <input autocomplete="off" class="form-control" type="text"
                                v-model="form.purchase_price_per_unit">
                            <span class="text-danger" v-if="errors?.purchase_price_per_unit">{{
                                errors.purchase_price_per_unit[0]
                                }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="retail_price_per_unit" class="col-sm-3 form-label">Retail Price Per
                                Unit:</label>
                            <input autocomplete="off" class="form-control" type="text"
                                v-model="form.retail_price_per_unit">
                            <span class="text-danger" v-if="errors?.retail_price_per_unit">{{
                                errors.retail_price_per_unit[0]
                                }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="sku" class="col-sm-3 form-label">SKU:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.sku">
                            <span class="text-danger" v-if="errors?.sku">{{ errors.sku[0] }}</span>
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
        let ProductListData = ref([]);
        let supplierListData = ref([]);
        let brandListData = ref([]);
        let categoryListData = ref([]);
        let sub_categoryListData = ref([]);
        let author_id = store.getters.getUserId
        let token = store.getters.getToken
        const base_url = window.location.origin;
        const errors = ref({});

        let form = reactive({
            id: "",
            name: "",
            supplier_id: "",
            brand_id: "",
            category_id: "",
            sub_category_id: "",
            product_image: "",
            unit_type: "",
            purchase_price_per_unit: "",
            retail_price_per_unit: "",
            sku: "",
            remarks: "",
            token: token
        });
        let SyncForm = reactive({
            Product_id: '',
            author_id: author_id
        });

        function onChange(event) {
            console.log(event);
            this.form.product_image = event.target.files[0];
        }

        const submitProduct = async (e) => {

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            await axios.post('/api/admin/products', form, config)
                .then(res => {
                    if (res.data.status == 'success') {
                        $('#addProductModal').modal('hide');

                        ProductList();
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
                    console.log("🚀 ~ submitProduct ~ err:", err)
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

        const ProductList = async (page = 1, search = false) => {

            let query = document.getElementById('search_button').value;
            if (query.length && query.length < 2) {
                query = ""; return false;
            }

            await axios.get(`/api/admin/products?page=${page}&search=${query}`)
                .then(res => {
                    ProductListData.value = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }

        const ProductEdit = async (id) => {
            await axios.get('/api/admin/products/' + id + '/edit')
                .then(res => {
                    if (res.data.status == 'success') {
                        form.id = res.data.data.id;
                        form.name = res.data.data.name;
                        form.supplier_id = res.data.data.supplier_id;
                        form.brand_id = res.data.data.brand_id;
                        form.category_id = res.data.data.category_id;
                        form.sub_category_id = res.data.data.sub_category_id;
                        form.unit_type = res.data.data.unit_type;
                        form.purchase_price_per_unit = res.data.data.purchase_price_per_unit;
                        form.retail_price_per_unit = res.data.data.retail_price_per_unit;
                        form.sku = res.data.data.sku;
                        form.remarks = res.data.data.remarks;
                    }

                    $('#editProductModal').modal('show');
                })
                .catch(err => {
                    console.log(err);
                })
        }
        const submitEditProduct = async (id) => {

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            // put method can not accept config headers
            await axios.post('/api/admin/product_update/' + id, form, config)
                .then(res => {
                    console.log(res)
                    if (res.data.status == 'success') {

                        $('#editProductModal').modal('hide');
                        Swal.fire({
                            icon: res.data.status,
                            title: res.data.message,
                            toast: true,
                            timer: 5000,
                            position: 'top-end',
                        });
                        ProductList();
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

        const deleteProduct = (id) => {

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
                    await axios.post('/api/admin/products/' + id, { _method: 'DELETE' })
                        .then(res => {
                            if (res.data.status == 'success') {

                                Swal.fire({
                                    icon: res.data.status,
                                    title: res.data.message,
                                    toast: true,
                                    timer: 5000,
                                    position: 'top-end',
                                });
                                ProductList();
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

                get_random_number();
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
            doc.text(200, y = y + 20, "Product List report");

            let columns_without_last = data.columns;
            columns_without_last.pop();
            let rows_without_last = data.rows;

            doc.autoTable(columns_without_last, rows_without_last, {
                bodyStyles: { minCellHeight: 30 },
                didDrawCell: function (data) {

                    var image_column = 6; // added
                    if (data.column.index === image_column && data.cell.section === 'body') {

                        var img = imgElements[data.row.index];

                        let x = data.row.cells[image_column].x;
                        let y = data.row.cells[image_column].y;
                        var dim = data.cell.height - data.cell.padding('vertical');
                        // addImage throws error for invalid img src. so fill up with default image first in html
                        // optional if(img)
                        doc.addImage(img.src, x, y, 20, 20);
                    }
                },
            });
            let now_mls = Date.now();
            doc.save("Product-table-" + now_mls + ".pdf");
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
            XLSX.writeFile(wb, 'Product List Report-' + now_mls + '.xlsx')
        }

        const supplierList = async () => {
            await axios.get(`/api/admin/supplier-list`)
                .then(res => {
                    console.log('res:', res);
                    supplierListData.value = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }

        const brandList = async () => {
            await axios.get(`/api/admin/brand-list`)
                .then(res => {
                    console.log('res:', res);
                    brandListData.value = res.data.data
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

        const sub_categoryList = async () => {
            await axios.get(`/api/admin/sub-category-list`)
                .then(res => {
                    console.log('res:', res);
                    sub_categoryListData.value = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }
        const get_random_number = async () => {
            await axios.get(`/api/admin/get_random_number`)
                .then(res => {
                    console.log('res:', res);
                    form.sku = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }

        onMounted(() => {
            ProductList();
            supplierList();
            brandList();
            sub_categoryList();
            categoryList();
        });

        return {
            form,
            submitProduct,
            ProductListData,
            deleteProduct,
            ProductList,
            ProductEdit,
            submitEditProduct,
            base_url,
            errors,
            imageLoadError,
            addData,
            get_random_number,
            exportjsPdf,
            items,
            downloadXLSX,
            onChange,

            supplierList,
            supplierListData,
            brandList,
            brandListData,
            sub_categoryList,
            sub_categoryListData,
            categoryList,
            categoryListData,
        }

    }
}
</script>
