import { createWebHistory, createRouter } from "vue-router";
import store from './store/index.js'

import home from './components/pages/home.vue';
import login from './components/pages/login.vue';

// import NetUserDirectory from './components/pages/frontend/netusers/index.vue';

import dashboard from './components/pages/dashboard.vue';

import users from './components/pages/users/index.vue';
import roleList from './components/pages/roles/index.vue';
import permissionList from './components/pages/permissions/index.vue';
import my_profile from './components/pages/users/my_profile.vue';
import suppliers from './components/pages/suppliers/index.vue';
import brands from './components/pages/brands/index.vue';
import categories from './components/pages/categories/index.vue';
import sub_categories from './components/pages/sub_categories/index.vue';
import products from './components/pages/products/index.vue';
import stocks from './components/pages/stocks/index.vue';

const routes = [
      { path : '/', name : 'Dashboard', component : dashboard, meta:{ requiresAuth:true } },
      { path : '/login', name : 'Login', component : login, meta:{ requiresAuth:false } },

    //   inventory
      { path : '/inventory/suppliers', name : 'suppliers', component : suppliers, meta:{ requiresAuth:true } },
      { path : '/inventory/brands', name : 'brands', component : brands, meta:{ requiresAuth:true } },
      { path : '/inventory/categories', name : 'categories', component : categories, meta:{ requiresAuth:true } },
      { path : '/inventory/sub_categories', name : 'sub_categories', component : sub_categories, meta:{ requiresAuth:true } },
      { path : '/inventory/products', name : 'products', component : products, meta:{ requiresAuth:true } },
      { path : '/inventory/stocks', name : 'stocks', component : stocks, meta:{ requiresAuth:true } },

      // Admin Users
      { path : '/admin/users', name : 'Admin-Users', component : users, meta:{ requiresAuth:true } },
      { path : '/admin/roles', name : 'Role-List', component : roleList, meta:{ requiresAuth:true } },
      { path : '/admin/permissions', name : 'Permission-List', component : permissionList, meta:{ requiresAuth:true } },
      
      { path : '/my_profile', name : 'my_profile', component : my_profile, meta:{ requiresAuth:true } },
];

const router = createRouter({
      history: createWebHistory(),
      routes
});

router.beforeEach((to,from) => {

      if(to.meta.requiresAuth && store.getters.getToken == 0){
            return { name : 'Login' }
      }

      if(to.meta.requiresAuth == false && store.getters.getToken != 0){
            let udt = store.getters.getUserData;
            console.log("🚀 ~ router.beforeEach ~ udt:", udt)
            if(store.getters.getUserData.guard_name=='netuser'){
                  console.log('netuser directory.');
            }else{
                  return { name : 'Dashboard' }
            }
      }else{
            // console.log('log2')
            // next(); // may necessary to redirect next page completely.
      }
});

export default router;
