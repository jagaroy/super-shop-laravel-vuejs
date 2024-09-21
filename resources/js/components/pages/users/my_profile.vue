<template>

    <div class="row">

        <div class="d-flex justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card" id="temp-target">
                    <h6 class="card-header bg-info d-flex justify-content-between align-items-center">
                        My Profile
                    </h6>
                    <div class="card-body">

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
                                    <input class="form-control" type="email" id="email" v-model="form.email"
                                        disabled="true">
                                    <span class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-sm-3 col-form-label">Password:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" id="password" v-model="form.password">
                                    <small class="text-right">
                                        <span class="min">Minimum 8 characters</span>, <span
                                            class="uppercase">uppercase</span>, <span class="lowercase">
                                            lowercase</span>, <span class="digit">digit</span>,
                                        <span class="special">special character</span>.
                                    </small>
                                    <span class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm
                                    Password:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" id="password_confirmation"
                                        v-model="form.password_confirmation">
                                    <small class="text-right">
                                        <span class="confirm">Confirm Password</span>.
                                    </small>
                                    <span class="text-danger" v-if="errors?.password_confirmation">{{
            errors.password_confirmation[0]
        }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-3 col-form-label">Phone:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" id="phone" v-model="form.phone"
                                        :disabled="true">
                                    <span class="text-danger" v-if="errors?.phone">{{ errors.phone[0] }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="role_id" class="col-sm-3 col-form-label">Role:</label>
                                <div class="col-sm-9">
                                    {{ form.role?.name }}

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9 pt-2">
                                    {{ form.status }}
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
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { reactive, ref, onMounted } from 'vue'
import { useRouter } from "vue-router"
import store from '../../../store/index.js'
import { jsPDF } from "jspdf";

export default {
    setup() {

        const router = useRouter()
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
            role: '',
            type: '',
            token: token
        });
        let SyncForm = reactive({
            user_id: '',
            author_id: author_id
        });

        const userEdit = async () => {
            let my_id = author_id;
            console.log("🚀 ~ userEdit ~ my_id:", my_id)
            await axios.get('/api/admin/my_profile')
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
                        form.role = res.data.data.role;
                    }

                    $('#editUserModal').modal('show');
                })
                .catch(err => {
                    console.log(err);
                })
        }
        const submitEditUser = async (id) => {
            console.log("🚀 ~ submitEditUser ~ id:", id)
            await axios.put('/api/admin/my_profile_update', form)
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
                        userEdit();
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

        function imageLoadError(event) {
            event.target.src = base_url + '/images/default.jpg'
        }


        onMounted(() => {
            userEdit();
        });

        return {
            form,
            userEdit,
            submitEditUser,
            base_url,
            errors,
            imageLoadError,
        }

    }
}
</script>
