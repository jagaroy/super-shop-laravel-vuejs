<template>
      <nav class="sidebar">
            <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
            Vue.JS 3<span>Laravel 10</span>
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
                  <li class="nav-item">
                        <a href="dashboard.html" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                        </a>
                  </li>
                  
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">SMS Records</span>
                        </a>
                  </li>
                  <li class="nav-item nav-category">Invoice Section</li>
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Generate Invoices</span>
                        </a>
                  </li>
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Invoices</span>
                        </a>
                  </li>
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Complain Sheets</span>
                        </a>
                  </li>

                  <li class="nav-item nav-category">Accounts Section</li>
                  <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Payments / Accounts</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="emails">
                        <ul class="nav sub-menu">
                              <li class="nav-item">
                                    <a href="pages/email/inbox.html" class="nav-link">Payment Category</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/read.html" class="nav-link">Particulars</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/compose.html" class="nav-link">Expenses</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/compose.html" class="nav-link">Incomes</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/compose.html" class="nav-link">Payment Reports</a>
                              </li>
                        </ul>
                        </div>
                  </li>
                  <li class="nav-item nav-category">Inventory Section</li>
                  <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Inventory Management</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="emails">
                        <ul class="nav sub-menu">
                              <li class="nav-item">
                                    <a href="pages/email/inbox.html" class="nav-link">Materials Item</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/read.html" class="nav-link">Materials Product Add</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/compose.html" class="nav-link">Materials POS</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/compose.html" class="nav-link">Stock Report</a>
                              </li>
                              <li class="nav-item">
                                    <a href="pages/email/compose.html" class="nav-link">Technician Staff</a>
                              </li>
                        </ul>
                        </div>
                  </li>

                  <li class="nav-item nav-category">Application Section</li>
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Roles</span>
                        </a>
                  </li>
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Permissions</span>
                        </a>
                  </li>
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Users</span>
                        </a>
                  </li>
                  <li class="nav-item">
                        <a href="pages/apps/calendar.html" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Settings</span>
                        </a>
                  </li>


                  <li class="nav-item nav-category">Docs</li>
                  <li class="nav-item">
                        <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
                        <i class="link-icon" data-feather="hash"></i>
                        <span class="link-title">Documentation</span>
                        </a>
                  </li>
                  </ul>
            </div>
      </nav>
</template>

<script>

</script>