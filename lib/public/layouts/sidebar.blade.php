<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">PM Quản lý Văn bản</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">PX03</a>
			</div>
		</div>

      <!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				
				@can('loaivanban_xem')
				<li class="nav-item">
					<router-link to="/loaivanban" class="nav-link">
						<a>
							<i class="nav-icon fas fa-th"></i>
							<p>
								QL Loại Văn bản
							</p>
						</a>
					</router-link>
				</li>
				@endcan
				@can('nguonden_xem')
					<li class="nav-item">
						<router-link to="/nguonden" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>Nguồn văn bản đến</p>
						</router-link>
					</li>
				@endcan
				@can('nguondi_xem')
					<li class="nav-item">
						<router-link to="/nguondi" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>Nguồn văn bản đi</p>
						</router-link>
					</li>
				@endcan
				@can('lanhdao_xem')
				<li class="nav-item">
					<router-link to="/lanhdao" class="nav-link">
						<a>
							<i class="nav-icon fas fa-th"></i>
							<p>
								QL Lãnh đạo
							</p>
						</a>
					</router-link>
				</li>
				@endcan
				@can('donvi_xem')
				<li class="nav-item">
					<router-link to="/donvi" class="nav-link">
						<a>
							<i class="nav-icon fas fa-th"></i>
							<p>
								QL Đơn vị
							</p>
						</a>
					</router-link>
				</li>
				@endcan
				@can('chucnang_xem')
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
				@endcan
				@can('phanquyen_xem')
				<li class="nav-item">
					<router-link to="/phanquyen" class="nav-link">
						<a>
							<i class="nav-icon fas fa-th"></i>
							<p>
								QL Phân quyền
							</p>
						</a>
					</router-link>
				</li>
				@endcan
				@can('taikhoan_xem')
				<li class="nav-item">
					<router-link to="/taikhoan" class="nav-link">
						<a>
							<i class="nav-icon fas fa-th"></i>
							<p>
								QL Tài khoản
							</p>
						</a>
					</router-link>
				</li>
				@endcan
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