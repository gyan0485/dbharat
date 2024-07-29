  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo e(url('')); ?>/asset/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo e(Auth::user()->name); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if(Auth::user()->role == 'super admin'): ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('user.create')); ?>" class="nav-link">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Create User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('user.list')); ?>" class="nav-link">
                  <i class="nav-icon far fa-circle text-warning"></i>
                  <p>User List</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="nav-icon far fa-image"></i>
              <p>Logout</p>
            </a>
          </li>

          <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?>
            <?php echo csrf_field(); ?>
          </form>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside><?php /**PATH C:\xampp\htdocs\AdminDashboard\resources\views/admin/layout/sidebar.blade.php ENDPATH**/ ?>