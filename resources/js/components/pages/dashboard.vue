<template>

      <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                  <div class="card">
                        <h6 class="card-header bg-info text-">Dashboard Summary</h6>
                        <div class="card-body ">

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 ">
                                    <img src="images/supershop-management-software.png" alt="Super Shop Management Software Image" style="max-height: 300px; width: 100%;" />
                                </div>
                            </div>

                        </div>
                  </div>
            </div>
      </div> <!-- row -->

</template>

<script>
// import flatpickr from 'backend/assets/vendors/flatpickr/flatpickr.min.js';
import { reactive, ref, onBeforeMount, onMounted } from 'vue'
import { useRouter } from "vue-router"

import {
      Chart as ChartJS,
      ArcElement,
      CategoryScale,
      LinearScale,
      PointElement,
      LineElement,
      Title,
      Tooltip,
      Legend,
      BarElement
} from 'chart.js'
import { Line } from 'vue-chartjs'
// import * as chartConfig from './chartConfig.js'

import { Bar, Pie } from 'vue-chartjs'

ChartJS.register(
      ArcElement,
      CategoryScale,
      LinearScale,
      PointElement,
      LineElement,
      Title,
      Tooltip,
      Legend,
      BarElement
)

export default {
      components: {
            Bar,
            Line,
            Pie
      },
      setup() {
            const base_url = window.location.origin;

            const loaded = ref({});
            loaded.value = false;

            let info = reactive({
                  routers_count: '',
            });

            function logout() {
                  localStorage.removeItem('token');
                  router.push({ name: 'Home' })
            }

            onMounted(() => {

            });

            onBeforeMount(() => {

            })

            return {
                  logout,

            }
      }
}
</script>

<style>
#netuserStatusPie canvas {
      /* width: 310px !important; */
      /* height: 310px !important; */
      align-items: center !important;
}
</style>

<!-- <script src="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendors/apexcharts/apexcharts.min.js') }}"></script> -->
