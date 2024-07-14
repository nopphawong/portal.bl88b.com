  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= site_url() ?>" class="brand-link">
          <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Admin Portal</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url() ?>assets/dist/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

          <!-- SidebarSearch Form -->
          <!-- <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div> -->

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                  <?php if (is_master(session()->role)) : ?>
                      <li class="nav-item">
                          <a href="<?= site_url("agent") ?>" class="nav-link <?= $path == "agent" ? "active" : "" ?>">
                              <i class="nav-icon fas fa-th"></i>
                              <p>Agents</p>
                          </a>
                      </li>
                  <?php endif ?>
                  <?php if (!empty(session()->agent)) : ?>
                      <li class="nav-header text-uppercase"><?= session()->agent->code . ": " . session()->agent->name ?></li>
                      <li class="nav-item">
                          <a href="<?= site_url("agent/info") ?>" class="nav-link <?= $path == "agent/info" ? "active" : "" ?>">
                              <i class="nav-icon fa fa-info-circle"></i>
                              <p>Agent info</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="<?= site_url("webuser") ?>" class="nav-link <?= $path == "webuser" ? "active" : "" ?>">
                              <i class="nav-icon fas fa-globe"></i>
                              <p>Web Users</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="<?= site_url("banner") ?>" class="nav-link <?= $path == "banner" ? "active" : "" ?>">
                              <i class="nav-icon fa fa-layer-group"></i>
                              <p>Banners</p>
                          </a>
                      </li>
                      <?php if (is_agent(session()->role) || is_master(session()->role)) : ?>
                          <li class="nav-item">
                              <a href="<?= site_url("admin") ?>" class="nav-link <?= $path == "admin" ? "active" : "" ?>">
                                  <i class="nav-icon fa fa-users"></i>
                                  <p>Admins</p>
                              </a>
                          </li>
                      <?php endif ?>
                      <li class="nav-item">
                          <a href="<?= site_url("channel") ?>" class="nav-link <?= $path == "channel" ? "active" : "" ?>">
                              <i class="nav-icon fa fa-solid fa-network-wired"></i>
                              <p>Channels</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="<?= site_url("wheel/info") ?>" class="nav-link <?= $path == "wheel/info" ? "active" : "" ?>">
                              <i class="nav-icon fa fa-circle"></i>
                              <p>Wheel</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="<?= site_url("checkin/info") ?>" class="nav-link <?= $path == "checkin/info" ? "active" : "" ?>">
                              <i class="nav-icon fa fa-check-circle"></i>
                              <p>Checkin</p>
                          </a>
                      </li>
                      <li class="nav-item menu-is-opening menu-open">
                          <a class="nav-link">
                              <i class="nav-icon fa fa-solid fa-hashtag"></i>
                              <p>Lotto <i class="fas fa-angle-left right"></i></p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="<?= site_url("lotto") ?>" class="nav-link <?= $path == "lotto" ? "active" : "" ?>">
                                      <i class="nav-icon fa fa-solid fa-file"></i>
                                      <p>จัดการ งวด/แผง</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="<?= site_url("user/point") ?>" class="nav-link <?= $path == "user/point" ? "active" : "" ?>">
                                      <i class="nav-icon fa fa-solid fa-list"></i>
                                      <p>จัดการสิทธิการซื้อ</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  <?php endif  ?>

                  <?php  ?>
                  <?php  ?>
                  <?php  ?>
                  <?php  ?>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>