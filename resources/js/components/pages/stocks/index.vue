<template>
    <div class="row">

        <div class="col-md-2 grid-margin stretch-card">
            <button @click="exportjsPdf()" class="btn btn-sm btn-info">Stock List PDF</button>
        </div>

        <div class="col-md-2 grid-margin stretch-card">
            <button @click="downloadXLSX()" class="btn btn-sm btn-info">Stock List XLSX</button>
        </div>

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
                    Stock List
                    <div>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addStockModal" @click="addData()">Add
                            Stock</button>
                    </div>
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 align-self-center">
                        </div>
                        <div class="col-md-4 align-self-end">
                            <input autocomplete="off" type="text" @keyup="StockList(1, true)"
                                class="form-control form-control-sm fw-bold" placeholder="Search..."
                                id="search_button" />
                        </div>
                        <div class="col-md-1 align-self-center">
                            <button class="btn btn-sm btn-success" @click="StockList(1, true)">Search</button>
                        </div>
                    </div>
                    <div id="temp-target">
                        <div class="table-responsive"></div>
                        <table id="table" class="table " style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity in Stock</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(data, index) in StockListData.data" :key="index">
                                    <td>{{ index + 1 }}.</td>
                                    <td>{{ data.product?.name }}</td>
                                    <td>{{ data.quantity }}</td>
                                    <td>{{ data.remarks }}</td>
                                    <td>
                                        <button @click="StockEdit(data.id)" class="btn btn-success btn-sm">Edit</button>
                                        <button @click="deleteStock(data.id)"
                                            class="btn btn-danger btn-sm ms-1">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <nav aria-label="..." class="mt-2">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link, indexing) in StockListData.links" :key="indexing" class="page-item">
                            <a class="page-link" href="#" :class="link.active ? 'active' : ''"
                                @click="StockList(link.label)" v-html="link.label">

                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="addStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Create Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title d-inline-block">Select and Add Product</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="addForm" action="#" method="POST" role="form" class="form-inline"
                                enctype="multipart/form-data">

                                <div class="row g-3 align-items-center">
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 mb-3">
                                        <label for="product_id" class="col-sm-4 mr-2">Product:</label>
                                        <select class="form-control chosen" name="product_id" id="product_id" required>
                                            <option value="">Select</option>
                                            <option v-for="(data, index) in productListData" :key="index" :value="data?.id" :data-image="data?.product_image">
                                                {{
                                                    data?.name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 mb-3">
                                        <label for="quantity" class="col-sm-4 mr-2">Quantity:</label>
                                        <input type="float" class="form-control" id="quantity" name="quantity"
                                            placeholder="" value="0" required>
                                    </div>
                                    <!-- <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 mb-3">
                                        <label for="remarks" class="col-sm-4 mr-2">Remarks:</label>
                                        <input type="text" class="form-control" id="remarks" name="remarks"
                                            placeholder="" />
                                    </div> -->
                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 mb-3">
                                        <label for="" class="col-sm-4 mr-2">&nbsp;</label>
                                        <button class="btn btn-sm btn-primary w-25 form-control" style="display: grid;" id="add_product"> Add </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card" id="product_list_area">
                        <div class="card-header bg-info">
                            <h3 class="card-title d-inline-block">New Stock</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="save_form" action="" method="POST" role="form" class="form-inline"
                                enctype="multipart/form-data">

                                <table id="product_list" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end" colspan="5">
                                                <button id="save_stock" class="btn btn-success btn-sm"> Save Stock
                                                </button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Stock Modal -->
    <div class="modal fade bd-example-modal-lg" id="editStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="editForm" @submit.prevent="submitEditStock(form.id)"
                        enctype="multipart/form-data">
                        <!-- change to edit fields -->

                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="product_id" class="col-sm-3 form-label">Product:</label>
                            <select class="form-control chosen" name="product_id" v-model="form.product_id" required>
                                <option value="">Select</option>
                                <option v-for="(data, index) in productListData" :key="index" :value="data?.id">{{
                                    data?.name }}</option>
                            </select>
                            <span class="text-danger" v-if="errors?.product_id">{{ errors.product_id[0] }}</span>
                        </div>
                        <div class="col-sm-form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3">
                            <label for="quantity" class="col-sm-3 form-label">Quantity:</label>
                            <input autocomplete="off" class="form-control" type="text" v-model="form.quantity">
                            <span class="text-danger" v-if="errors?.quantity">{{ errors.quantity[0] }}</span>
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
        let StockListData = ref([]);
        let productListData = ref([]);
        let author_id = store.getters.getUserId
        let token = store.getters.getToken
        const base_url = window.location.origin;
        const errors = ref({});

        let form = reactive({
            id: "",
            product_id: "",
            quantity: "",
            remarks: "",
            token: token
        });
        let SyncForm = reactive({
            Stock_id: '',
            author_id: author_id
        });

        function onChange(event) {
            console.log(event);
            this.form.image = event.target.files[0];
        }

        const submitStock = async (e) => {

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            await axios.post('/api/admin/stocks', form, config)
                .then(res => {
                    if (res.data.status == 'success') {
                        $('#addStockModal').modal('hide');

                        StockList();
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
                    console.log("🚀 ~ submitStock ~ err:", err)
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

        const StockList = async (page = 1, search = false) => {

            let query = document.getElementById('search_button').value;
            if (query.length && query.length < 2) {
                query = ""; return false;
            }

            await axios.get(`/api/admin/stocks?page=${page}&search=${query}`)
                .then(res => {
                    StockListData.value = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }

        const StockEdit = async (id) => {
            await axios.get('/api/admin/stocks/' + id + '/edit')
                .then(res => {
                    if (res.data.status == 'success') {
                        form.id = res.data.data.id;
                        form.product_id = res.data.data.product_id;
                        form.quantity = res.data.data.quantity;
                        form.remarks = res.data.data.remarks;
                    }

                    $('#editStockModal').modal('show');
                })
                .catch(err => {
                    console.log(err);
                })
        }
        const submitEditStock = async (id) => {

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            // put method can not accept config headers
            await axios.post('/api/admin/stock_update/' + id, form, config)
                .then(res => {
                    console.log(res)
                    if (res.data.status == 'success') {

                        $('#editStockModal').modal('hide');
                        Swal.fire({
                            icon: res.data.status,
                            title: res.data.message,
                            toast: true,
                            timer: 5000,
                            position: 'top-end',
                        });
                        StockList();
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

        const deleteStock = (id) => {

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
                    await axios.post('/api/admin/stocks/' + id, { _method: 'DELETE' })
                        .then(res => {
                            if (res.data.status == 'success') {

                                Swal.fire({
                                    icon: res.data.status,
                                    title: res.data.message,
                                    toast: true,
                                    timer: 5000,
                                    position: 'top-end',
                                });
                                StockList();
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
            doc.text(200, y = y + 20, "Stock List report");

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
                        // if(img)
                        doc.addImage(img.src, x, y, 20, 20);
                    }
                },
            });
            let now_mls = Date.now();
            doc.save("Stock-table-" + now_mls + ".pdf");
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
            XLSX.writeFile(wb, 'Stock List Report-' + now_mls + '.xlsx')
        }

        const productList = async () => {
            await axios.get(`/api/admin/product-list`)
                .then(res => {
                    console.log('res:', res);
                    productListData.value = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }

        $(document).ready(function() {
            $('#add_product').on('click', function (e) {
                e.preventDefault();
                var product_id = $('#product_id').val();
                if( ! product_id){
                    // $.notify('Please select a product!', 'error');
                    alert('Please select a product!');
                    return false;
                }
                var product_name = $('#product_id option:selected').text();
                var product_image = $('#product_id option:selected').data('image');

                var quantity = $('#quantity').val() - 0;
                if( ! quantity || quantity < 0){
                    // $.notify('Please input a positive quantity!', 'error');
                    alert('Please input a positive quantity!');
                    return false;
                }
                var count = $('#product_list tbody').find('tr');
                var already_exists = false;
                $.each(count, function (index, value) {
                    let loaded_product_id = $(value).find('input[name="product_id[]"]').val();
                    let loaded_quantity = $(value).find('input[name="quantity[]"]').val() - 0;

                    if(product_id==loaded_product_id){

                        $(value).find('input[name="quantity[]"]').val(loaded_quantity + quantity);
                        already_exists = true;
                    }
                });

                if( ! already_exists){
                    var serial = count.length + 1;
                    var rows = '<tr>';
                        rows += '<td>'+ serial +'.</td>';
                        rows += '<td>'+
                                    '<img src="'+base_url+ product_image+'" height="43px" />' +
                                '</td>';
                        rows += '<td>' +
                                product_name +
                                '<input hidden name="product_id[]" value="'+product_id+'" />' +
                            '</td>';
                        rows += '<td>' +
                            '<input class="form-control text-right" name="quantity[]" value="'+quantity+'" />' +
                        '</td>';
                        rows += '<td class="text-center">' +
                            '<button class="remove_btn btn btn-sm btn-danger">X</button>' +
                        '</td>';
                    rows += '</tr>';
                    $('#product_list tbody').append(rows);
                }
            });

            $(document).on('click', '.remove_btn', function (e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            });

            $('#save_form').on('submit', function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                console.log("🚀 ~ $ ~ form_data:", form_data)
                // return;

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                };

                axios.post('/api/admin/stocks', form_data, config)
                .then(res => {
                        console.log("🚀 ~ $ ~ res:", res)
                        if (res.data.status == 'success') {
                            $('#addStockModal').modal('hide');

                            StockList();
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
                        console.log("🚀 ~ submitStock ~ err:", err)
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

            });
        });

        onMounted(() => {
            StockList();
            productList();
        });

        return {
            form,
            submitStock,
            StockListData,
            deleteStock,
            StockList,
            StockEdit,
            submitEditStock,
            base_url,
            errors,
            imageLoadError,
            addData,
            exportjsPdf,
            items,
            downloadXLSX,
            onChange,
            productList,
            productListData
        }

    }
}

        var base_url = window.location.origin;
        console.log("🚀 ~ base_url:", base_url)

</script>
