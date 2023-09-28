
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('panel.index') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#slider-nav-item" aria-expanded="false" aria-controls="slider-nav-item">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Slider</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="slider-nav-item">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.slider.index') }}">Listele</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.slider.create') }}">Oluştur</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#order-nav-item" aria-expanded="false" aria-controls="order-nav-item">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Siparişler</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="order-nav-item">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.order.index') }}">Listele</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#product-nav-item" aria-expanded="false" aria-controls="product-nav-item">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Ürünler</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="product-nav-item">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.product.index') }}">Listele</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.product.create') }}">Oluştur</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#category-nav-item" aria-expanded="false" aria-controls="category-nav-item">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Kategori</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="category-nav-item">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.category.index') }}">Listele</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.category.create') }}">Oluştur</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('panel.about.index') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Hakkımızda</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('panel.contact.index') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">İletişim Mesajları</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('panel.setting.index') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Site Ayarları</span>
            </a>
        </li>
    </ul>
</nav>
