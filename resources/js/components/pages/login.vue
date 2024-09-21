<template>
      <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                  <div class="row w-100 mx-0 auth-page">
                        <div class="col-md-8 col-xl-6 mx-auto">
                              <div class="card">
                                    <div class="row">
                                          <div class="col-md-8 ps-md-0">
                                                <div class="auth-form-wrapper px-4 py-5">
                                                      <h2></h2>
                                                      <p class="text-danger" v-if="error">{{ error }}</p>
                                                <a href="#" class="noble-ui-logo d-block mb-2">Advance Admin Dashboard. Super Shop Management.<span><small> (Laravel 10 + VueJS 3)</small></span></a>
                                                <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                                                <form class="forms-sample" @submit.prevent="login">
                                                <div class="mb-3">
                                                      <label for="userEmail" class="form-label">Email address</label>
                                                      <input type="email" class="form-control" id="userEmail" placeholder="Email" v-model="form.email">
                                                </div>
                                                <div class="mb-3">
                                                      <label for="userPassword" class="form-label">Password</label>
                                                      <input type="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password" v-model="form.password">
                                                </div>
                                                <div class="form-check mb-3">
                                                      <input type="checkbox" class="form-check-input" id="authCheck">
                                                      <label class="form-check-label" for="authCheck">
                                                      Remember me
                                                      </label>
                                                </div>
                                                <div>
                                                      <button type="submit" class="btn btn-info">Login</button>

                                                </div>
                                                </form>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>

            </div>
      </div>
</template>

<script>
import { reactive, ref } from 'vue'
import { useRouter } from "vue-router"
import { useStore } from 'vuex'
export default{
      setup(){
            const router = useRouter()
            const store = useStore()

            let form = reactive({
                // default
                  email: 'admin@admin.com',
                  password: 'admin@admin.com'
            });
            let error = ref('')

            const base_url = window.location.origin;

            const login = async() =>{
                  await axios.post('/api/login', form)
                  .then(res => {
                        if(res.data.success){

                              // dispatch work action
                              store.dispatch('setUserInfo', res.data.data)
                              store.dispatch('setToken', res.data.data.token);

                              if(res.data.data.guard_name=='user'){

                                    // router.push({name:'Dashboard'})
                                    window.location.href = base_url + '/';

                              }else if(res.data.data.guard_name=='netuser'){

                                    window.location.href = base_url + '/netuser';
                              }

                        }else{
                              error.value = res.data.message;
                        }
                  })
            }

            return{
                  form,
                  login,
                  error
            }
      }
}
</script>

<style scoped>
.display-sidebar{
      display: none;
}
</style>
