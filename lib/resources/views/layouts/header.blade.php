<div id="header">
    <div class="header">
        <div class="header__logo"><img src="{{ asset('lib/public/images/cand.png') }}"></div>
        <div class="header__app-name">PHẦN MỀM KIỂM TRA CHIẾN SỸ KHỎE CÔNG AN TỈNH</div>
        <div class="header__user-info">
            <div class="header__user-dropdow">
                <i class="fas fa-user-tie"></i> {{ $user }}
            </div>
            <ul class="header__dropdow-ul">
                <li data-toggle="modal" data-target="#doimatkhau"><a href="#"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
                <li><a href="{{ asset('admin') }}"><i class="fas fa-cogs"></i> Trang quản trị</a></li>
                <li><a href="{{ asset('logout') }}"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
    <!-- Modal Đổi mật khẩu -->
    <div class="modal fade" id="doimatkhau" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đổi mật khẩu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <doi-mat-khau></doi-mat-khau>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="far fa-window-close"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

