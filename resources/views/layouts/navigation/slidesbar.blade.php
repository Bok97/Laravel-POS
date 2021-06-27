 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
      <img src="{{ asset('images/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <h4>{{ auth()->user()->getUsername() }}</h4>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="{{ route('products.index') }}" class="nav-link {{ activeSegment('products') }}">
              <i class="nav-icon fas fa-th-large"></i>
              <p>
                Product List
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('cart.index') }}" class="nav-link {{ activeSegment('cart') }}">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>POS Management</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('orders.index') }}" class="nav-link {{ activeSegment('orders') }}">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>Orders History</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
              <a href="{{ route('customers.index') }}" class="nav-link {{ activeSegment('customers') }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Customers</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
              @csrf
            </form>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>