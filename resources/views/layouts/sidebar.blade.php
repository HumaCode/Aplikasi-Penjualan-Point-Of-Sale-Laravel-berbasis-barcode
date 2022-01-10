    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
                </div>
                <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->level == 1)
                    <li class="header">MAIN</li>

                    <li class="{{ Request::is('kategori*') ? 'active' : '' }}">
                        <a href="{{ route('kategori.index') }}">
                            <i class="fa fa-cubes" aria-hidden="true"></i> <span>Kategori</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('produk*') ? 'active' : '' }}">
                        <a href="{{ route('produk.index') }}">
                            <i class="fa fa-cube"></i> <span>Produk</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('member*') ? 'active' : '' }}">
                        <a href="{{ route('member.index') }}">
                            <i class="fa fa-id-card" aria-hidden="true"></i> <span>Member</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('supplier*') ? 'active' : '' }}">
                        <a href="{{ route('supplier.index') }}">
                            <i class="fa fa-truck" aria-hidden="true"></i> <span>Supplier</span>
                        </a>
                    </li>

                    <li class="header">TRANSAKSI</li>

                    <li class="{{ Request::is('pengeluaran*') ? 'active' : '' }}">
                        <a href="{{ route('pengeluaran.index') }}">
                            <i class="fa fa-money" aria-hidden="true"></i> <span>Pengeluaran</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('pembelian*') ? 'active' : '' }}">
                        <a href="{{ route('pembelian.index') }}">
                            <i class="fa fa-download"></i> <span>Pembelian</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('penjualan*') ? 'active' : '' }}">
                        <a href="{{ route('penjualan.index') }}">
                            <i class="fa fa-upload"></i> <span>Penjualan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('transaksi.index') }}">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Transaksi Aktif</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('transaksi.baru') }}">
                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <span>Transaksi Baru</span>
                        </a>
                    </li>

                    <li class="header">REPORT</li>

                    <li class="{{ Request::is('laporan*') ? 'active' : '' }}">
                        <a href="{{ route('laporan.index') }}">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span>Laporan</span>
                        </a>
                    </li>

                    <li class="header">SISTEM</li>

                    <li class="{{ Request::is('user*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}">
                            <i class="fa fa-users"></i> <span>User</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('setting*') ? 'active' : '' }}">
                        <a href="{{ route('setting.index') }}">
                            <i class="fa fa-cogs" aria-hidden="true"></i> <span>Setting</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('transaksi.index') }}">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Transaksi Aktif</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('transaksi.baru') }}">
                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <span>Transaksi Baru</span>
                        </a>
                    </li>
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>