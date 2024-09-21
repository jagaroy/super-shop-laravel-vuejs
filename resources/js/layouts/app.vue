<template>

      <div class="main-wrapper">
            <!-- partial:partials/_sidebar.html -->

            <nav id="main_sidebar" class="sidebar display-sidebar" v-if="$store.getters.getToken != 0">
                  <div class="sidebar-header">
                        <a href="#" class="sidebar-brand" style="line-height: 1; font-size: 21px">
                              Super Shop
                              <span><small style="font-size: 19px !important;font-weight: bold;"><br />Inventory Stock</small></span>
                        </a>
                        <div class="sidebar-toggler not-active">
                              <span></span>
                              <span></span>
                              <span></span>
                        </div>
                  </div>
                  <div class="sidebar-body">
                        <ul class="nav">
                              <li class="nav-item nav-category">Main</li>
                              <li class="nav-item collapse-item">
                                    <router-link to="/">
                                          <i class="link-icon" data-feather="box"></i>
                                          <span class="link-title">Dashboard</span>
                                    </router-link>
                              </li>
                              <!-- <li class="nav-item nav-category">Doctor</li> -->

                                <li class="nav-item collapse-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#inventory_menu" role="button"
                                          aria-expanded="false" aria-controls="inventory_menu">
                                          <i class="link-icon" data-feather="mail"></i>
                                          <span class="link-title fw-bolder">Inventory Management</span>
                                          <i class="link-arrow" data-feather="chevron-down"></i>
                                    </a>
                                    <div class="collapse" id="inventory_menu">
                                          <ul class="nav sub-menu">

                                            <li class="nav-item">
                                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                      <router-link :to="{ name: 'categories' }" class="nav-link">
                                                            Categories
                                                      </router-link>
                                                </li>
                                                <li class="nav-item">
                                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                      <router-link :to="{ name: 'sub_categories' }" class="nav-link">
                                                            Sub Categories
                                                      </router-link>
                                                </li>

                                                <li class="nav-item">
                                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                      <router-link :to="{ name: 'suppliers' }" class="nav-link">
                                                            Suppliers
                                                      </router-link>
                                                </li>
                                                <li class="nav-item">
                                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                      <router-link :to="{ name: 'brands' }" class="nav-link">
                                                            Brands
                                                      </router-link>
                                                </li>

                                                <li class="nav-item">
                                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                      <router-link :to="{ name: 'products' }" class="nav-link">
                                                            Products
                                                      </router-link>
                                                </li>

                                          </ul>
                                    </div>
                                </li>

                                <li class="nav-item collapse-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#stock_menu" role="button"
                                          aria-expanded="false" aria-controls="stock_menu">
                                          <i class="link-icon" data-feather="mail"></i>
                                          <span class="link-title fw-bolder">Stock Management</span>
                                          <i class="link-arrow" data-feather="chevron-down"></i>
                                    </a>
                                    <div class="collapse" id="stock_menu">
                                          <ul class="nav sub-menu">

                                            <li class="nav-item">
                                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                      <router-link :to="{ name: 'stocks' }" class="nav-link">
                                                            Stock
                                                      </router-link>
                                                </li>
                                          </ul>
                                    </div>
                                </li>

                              <li class="nav-item nav-category">Admin Section</li>
                              <li class="nav-item collapse-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#admin" role="button"
                                          aria-expanded="false" aria-controls="admin">
                                          <i class="link-icon" data-feather="mail"></i>
                                          <span class="link-title fw-bolder">Admin Management</span>
                                          <i class="link-arrow" data-feather="chevron-down"></i>
                                    </a>
                                    <div class="collapse" id="admin">
                                          <ul class="nav sub-menu">
                                                <li class="nav-item">
                                                      <router-link :to="{ name: 'Role-List' }" class="nav-link">
                                                            <i class="link-icon" data-feather="calendar"></i>
                                                            <span class="link-title">Role</span>
                                                      </router-link>
                                                </li>
                                                <li class="nav-item">
                                                      <router-link :to="{ name: 'Permission-List' }" class="nav-link">
                                                            <i class="link-icon" data-feather="calendar"></i>
                                                            <span class="link-title">Permission</span>
                                                      </router-link>
                                                </li>
                                                <li class="nav-item">
                                                      <router-link :to="{ name: 'Admin-Users' }" class="nav-link">
                                                            <i class="link-icon" data-feather="calendar"></i>
                                                            <span class="link-title">Admin Users</span>
                                                      </router-link>
                                                </li>
                                          </ul>
                                    </div>
                              </li>

                        </ul>
                  </div>
            </nav>
            <nav class="settings-sidebar" v-if="$store.getters.getToken != 0">
                  <div class="sidebar-body">
                        <a href="#" class="settings-sidebar-toggler">
                              <i data-feather="settings"></i>
                        </a>
                        <h6 class="text-muted mb-2">Sidebar:</h6>
                        <div class="mb-3 pb-3 border-bottom">
                              <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="sidebarThemeSettings"
                                          id="sidebarLight" value="sidebar-light" checked>
                                    <label class="form-check-label" for="sidebarLight">
                                          Light
                                    </label>
                              </div>
                              <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="sidebarThemeSettings"
                                          id="sidebarDark" value="sidebar-dark">
                                    <label class="form-check-label" for="sidebarDark">
                                          Dark
                                    </label>
                              </div>
                        </div>
                        <div class="theme-wrapper">
                              <h6 class="text-muted mb-2">Light Theme:</h6>
                              <a class="theme-item active" href="dashboard.html">
                                    <img :src="'backend/assets/images/screenshots/light.jpg'" alt="light theme">
                              </a>
                              <h6 class="text-muted mb-2">Dark Theme:</h6>
                              <a class="theme-item" href="https://www.nobleui.com/html/template/demo2/dashboard.html">
                                    <img :src="'backend/assets/images/screenshots/dark.jpg'" alt="light theme">
                              </a>
                        </div>
                  </div>
            </nav>
            <!-- partial -->
            <div class="page-wrapper">

                  <!-- partial:partials/_navbar.html -->
                  <nav class="navbar" v-if="$store.getters.getToken != 0">
                        <a href="#" class="sidebar-toggler">
                              <i data-feather="menu"></i>
                        </a>
                        <div class="navbar-content">
                              <form class="search-form">
                                    <div class="input-group">
                                          <div class="input-group-text">
                                                <i data-feather="search"></i>
                                          </div>
                                          <input type="text" class="form-control" id="navbarForm"
                                                placeholder="Search here...">
                                    </div>
                              </form>
                              <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="languageDropdown"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="flag-icon flag-icon-us mt-1" title="us"></i> <span
                                                      class="ms-1 me-1 d-none d-md-inline-block">English</span>
                                          </a>
                                          <div class="dropdown-menu" aria-labelledby="languageDropdown">
                                                <a href="javascript:;" class="dropdown-item py-2"><i
                                                            class="flag-icon flag-icon-us" title="us" id="us"></i> <span
                                                            class="ms-1"> English </span></a>
                                                <a href="javascript:;" class="dropdown-item py-2"><i
                                                            class="flag-icon flag-icon-fr" title="fr" id="fr"></i> <span
                                                            class="ms-1"> French </span></a>
                                                <a href="javascript:;" class="dropdown-item py-2"><i
                                                            class="flag-icon flag-icon-de" title="de" id="de"></i> <span
                                                            class="ms-1"> German </span></a>
                                                <a href="javascript:;" class="dropdown-item py-2"><i
                                                            class="flag-icon flag-icon-pt" title="pt" id="pt"></i> <span
                                                            class="ms-1"> Portuguese </span></a>
                                                <a href="javascript:;" class="dropdown-item py-2"><i
                                                            class="flag-icon flag-icon-es" title="es" id="es"></i> <span
                                                            class="ms-1"> Spanish </span></a>
                                          </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="grid"></i>
                                          </a>
                                          <div class="dropdown-menu p-0" aria-labelledby="appsDropdown">
                                                <div
                                                      class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                                                      <p class="mb-0 fw-bold">Web Apps</p>
                                                      <a href="javascript:;" class="text-muted">Edit</a>
                                                </div>
                                                <div class="row g-0 p-1">
                                                      <div class="col-3 text-center">
                                                            <a href="pages/apps/chat.html"
                                                                  class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i
                                                                        data-feather="message-square"
                                                                        class="icon-lg mb-1"></i>
                                                                  <p class="tx-12">Chat</p>
                                                            </a>
                                                      </div>
                                                      <div class="col-3 text-center">
                                                            <a href="pages/apps/calendar.html"
                                                                  class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i
                                                                        data-feather="calendar"
                                                                        class="icon-lg mb-1"></i>
                                                                  <p class="tx-12">Calendar</p>
                                                            </a>
                                                      </div>
                                                      <div class="col-3 text-center">
                                                            <a href="pages/email/inbox.html"
                                                                  class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i
                                                                        data-feather="mail" class="icon-lg mb-1"></i>
                                                                  <p class="tx-12">Email</p>
                                                            </a>
                                                      </div>
                                                      <div class="col-3 text-center">
                                                            <a href="pages/general/profile.html"
                                                                  class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i
                                                                        data-feather="instagram"
                                                                        class="icon-lg mb-1"></i>
                                                                  <p class="tx-12">Profile</p>
                                                            </a>
                                                      </div>
                                                </div>
                                                <div
                                                      class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                                                      <a href="javascript:;">View all</a>
                                                </div>
                                          </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="messageDropdown"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i data-feather="mail"></i>
                                          </a>
                                          <div class="dropdown-menu p-0" aria-labelledby="messageDropdown">
                                                <div
                                                      class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                                                      <p>9 New Messages</p>
                                                      <a href="javascript:;" class="text-muted">Clear all</a>
                                                </div>
                                                <div class="p-1">
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div class="me-3">
                                                                  <img class="wd-30 ht-30 rounded-circle"
                                                                        :src="'backend/assets/images/faces/face2.jpg'"
                                                                        alt="userr">
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-grow-1">
                                                                  <div class="me-4">
                                                                        <p>Leonardo Payne</p>
                                                                        <p class="tx-12 text-muted">Project status</p>
                                                                  </div>
                                                                  <p class="tx-12 text-muted">2 min ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div class="me-3">
                                                                  <img class="wd-30 ht-30 rounded-circle"
                                                                        :src="'backend/assets/images/faces/face3.jpg'"
                                                                        alt="userr">
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-grow-1">
                                                                  <div class="me-4">
                                                                        <p>Carl Henson</p>
                                                                        <p class="tx-12 text-muted">Client meeting</p>
                                                                  </div>
                                                                  <p class="tx-12 text-muted">30 min ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div class="me-3">
                                                                  <img class="wd-30 ht-30 rounded-circle"
                                                                        :src="'backend/assets/images/faces/face4.jpg'"
                                                                        alt="userr">
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-grow-1">
                                                                  <div class="me-4">
                                                                        <p>Jensen Combs</p>
                                                                        <p class="tx-12 text-muted">Project updates</p>
                                                                  </div>
                                                                  <p class="tx-12 text-muted">1 hrs ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div class="me-3">
                                                                  <img class="wd-30 ht-30 rounded-circle"
                                                                        :src="'backend/assets/images/faces/face5.jpg'"
                                                                        alt="userr">
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-grow-1">
                                                                  <div class="me-4">
                                                                        <p>Amiah Burton</p>
                                                                        <p class="tx-12 text-muted">Project deatline</p>
                                                                  </div>
                                                                  <p class="tx-12 text-muted">2 hrs ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div class="me-3">
                                                                  <img class="wd-30 ht-30 rounded-circle"
                                                                        :src="'backend/assets/images/faces/face6.jpg'"
                                                                        alt="userr">
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-grow-1">
                                                                  <div class="me-4">
                                                                        <p>Yaretzi Mayo</p>
                                                                        <p class="tx-12 text-muted">New record</p>
                                                                  </div>
                                                                  <p class="tx-12 text-muted">5 hrs ago</p>
                                                            </div>
                                                      </a>
                                                </div>
                                                <div
                                                      class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                                                      <a href="javascript:;">View all</a>
                                                </div>
                                          </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i data-feather="bell"></i>
                                                <div class="indicator">
                                                      <div class="circle"></div>
                                                </div>
                                          </a>
                                          <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
                                                <div
                                                      class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                                                      <p>6 New Notifications</p>
                                                      <a href="javascript:;" class="text-muted">Clear all</a>
                                                </div>
                                                <div class="p-1">
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div
                                                                  class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                                  <i class="icon-sm text-white" data-feather="gift"></i>
                                                            </div>
                                                            <div class="flex-grow-1 me-2">
                                                                  <p>New Order Recieved</p>
                                                                  <p class="tx-12 text-muted">30 min ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div
                                                                  class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                                  <i class="icon-sm text-white"
                                                                        data-feather="alert-circle"></i>
                                                            </div>
                                                            <div class="flex-grow-1 me-2">
                                                                  <p>Server Limit Reached!</p>
                                                                  <p class="tx-12 text-muted">1 hrs ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div
                                                                  class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                                  <img class="wd-30 ht-30 rounded-circle"
                                                                        :src="'backend/assets/images/faces/face6.jpg'"
                                                                        alt="userr">
                                                            </div>
                                                            <div class="flex-grow-1 me-2">
                                                                  <p>New customer registered</p>
                                                                  <p class="tx-12 text-muted">2 sec ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div
                                                                  class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                                  <i class="icon-sm text-white"
                                                                        data-feather="layers"></i>
                                                            </div>
                                                            <div class="flex-grow-1 me-2">
                                                                  <p>Apps are ready for update</p>
                                                                  <p class="tx-12 text-muted">5 hrs ago</p>
                                                            </div>
                                                      </a>
                                                      <a href="javascript:;"
                                                            class="dropdown-item d-flex align-items-center py-2">
                                                            <div
                                                                  class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                                  <i class="icon-sm text-white"
                                                                        data-feather="download"></i>
                                                            </div>
                                                            <div class="flex-grow-1 me-2">
                                                                  <p>Download completed</p>
                                                                  <p class="tx-12 text-muted">6 hrs ago</p>
                                                            </div>
                                                      </a>
                                                </div>
                                                <div
                                                      class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                                                      <a href="javascript:;">View all</a>
                                                </div>
                                          </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="profileDropdown"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <img class="wd-30 ht-30 rounded-circle"
                                                      :src="$store.getters.getUserimage" alt="profile">
                                          </a>
                                          <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                                <div
                                                      class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                                      <div class="mb-3">
                                                            <img class="wd-80 ht-80 rounded-circle"
                                                                  :src="$store.getters.getUserimage" alt="">
                                                      </div>
                                                      <div class="text-center">
                                                            <p class="tx-16 fw-bolder">{{
                  $store.getters.getUserData?.name }}</p>
                                                            <p class="tx-12 text-muted">{{
                                                                  $store.getters.getUserData?.email }}</p>
                                                      </div>
                                                </div>
                                                <ul class="list-unstyled p-1">
                                                      <li class="dropdown-item py-2">
                                                            <router-link :to="{ name: 'my_profile' }" class="nav-link">
                                                                  <i class="link-icon" data-feather="calendar"></i>
                                                                  <span class="link-title">My Profile</span>
                                                            </router-link>
                                                      </li>
                                                      <!-- <li class="dropdown-item py-2">
                                                            <a href="javascript:;" class="text-body ms-0">
                                                                  <i class="me-2 icon-md" data-feather="edit"></i>
                                                                  <span>Edit Profile</span>
                                                            </a>
                                                      </li>
                                                      <li class="dropdown-item py-2">
                                                            <a href="javascript:;" class="text-body ms-0">
                                                                  <i class="me-2 icon-md" data-feather="repeat"></i>
                                                                  <span>Switch User</span>
                                                            </a>
                                                      </li> -->
                                                      <li class="dropdown-item py-2">
                                                            <a href="javascript:;" class="text-body ms-0"
                                                                  @click="logout">
                                                                  <i class="me-2 icon-md" data-feather="log-out"></i>
                                                                  <span>Log Out</span>
                                                            </a>
                                                      </li>
                                                </ul>
                                          </div>
                                    </li>
                              </ul>
                        </div>
                  </nav>
                  <!-- partial -->

                  <div class="page-content">

                        <router-view></router-view>

                        <vue-progress-bar></vue-progress-bar>

                  </div>
                  <!-- partial:partials/_footer.html -->
                  <footer
                        class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small"
                        v-if="$store.getters.getToken != 0">
                        <p class="text-muted mb-1 mb-md-0">Copyright © 2024 <a href=""
                                    target="_blank">Jagabandhu Roy</a>.</p>
                        <p class="text-muted">Develop by
                              <a href="" target="_blank">
                                    Jagabandhu Roy
                              </a>
                              <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i>
                        </p>
                  </footer>
                  <!-- partial -->

            </div>
      </div>

      <div id="loading-spinner" class="clearfix"
            style="top: 10%; position: fixed; z-index: 50000;  right: 2%; display: none; opacity: .4;">
            <div class="spinner-border spinner-border-lg float-end text-success" role="status"
                  style="font-size: 40px !important; padding: 22px !important;">
                  <span class="visually-hidden">Loading...</span>
            </div>
      </div>



</template>

<script>
// import flatpickr from 'backend/assets/vendors/flatpickr/flatpickr.min.js';
import { useRouter } from "vue-router"
import { useStore } from "vuex"
export default {
      setup() {
            const router = useRouter();
            const store = useStore()

            function logout() {
                  store.dispatch('removeToken')
                  store.dispatch('removeUserInfo')
                  router.push({ name: 'Login' })
            }

            return {
                  logout
            }
      }
}

$(document).ready(function () {
      $(document).on('click', '#main_sidebar a.nav-link', function () {
            $(document).find('#main_sidebar li.collapse-item').each( function (indexInArray, valueOfElement) {
                  $(this).removeClass('active');
            });
            $(this).addClass('router-link-active router-link-exact-active active');
      });
});
</script>
<style>
.card-header {
            padding: 5px 25px !important;
        }
</style>
