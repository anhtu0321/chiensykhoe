<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{asset('lib/public/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">PM </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{asset('lib/public/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">PX03</a>
			</div>
		</div>

      <!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				
				
				<li class="nav-item">
					<router-link to="/role" class="nav-link">
						<a>
							<i class="nav-icon fas fa-th"></i>
							<p>
								QL Group Chức năng
							</p>
						</a>
					</router-link>
				</li>
				<li class="nav-item">
					<router-link to="/chucnang" class="nav-link">
						<a>
							<i class="nav-icon fas fa-th"></i>
							<p>
								QL Chức năng
							</p>
						</a>
					</router-link>
				</li>
				
				<li class="nav-item">
					<a href="{{route('logout')}}" class="nav-link">
						<i class="fas fa-sign-out-alt nav-icon"></i>
						<p>Đăng xuất</p>
					</a>
				</li>
			</ul>
		</nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>