<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('/static/admin/images/48.jpg') }}" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">Wells Wu</p>
            <p class="app-sidebar__user-designation">PHP Developer</p>
        </div>
    </div>
    <ul class="app-menu" id="app-menu">
        <li>
            <a class="app-menu__item" href="index.html">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i>
                <span class="app-menu__label">小说管理</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" data-nav="admin.book.index" href="{{ route('admin.book.index') }}"><i class="icon fa fa-circle-o"></i> 小说列表</a></li>
                <li><a class="treeview-item" data-nav="admin.category.index" href="{{ route('admin.category.index') }}"><i class="icon fa fa-circle-o"></i> 小说分类列表</a></li>
                {{--<li><a class="treeview-item" data-nav="admin.goods_import.index" href="{{ route('admin.goods_import.index') }}"><i class="icon fa fa-circle-o"></i> 进库列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.goods_export.index" href="{{ route('admin.goods_export.index') }}"><i class="icon fa fa-circle-o"></i> 出库列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.category.index" href="{{ route('admin.category.index') }}"><i class="icon fa fa-circle-o"></i> 分类管理</a></li>--}}
            </ul>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i>
                <span class="app-menu__label">异常管理</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" data-nav="admin.check_info.index" href="{{ route('admin.check_info.index') }}"><i class="icon fa fa-circle-o"></i> 异常列表</a></li>
                {{--<li><a class="treeview-item" data-nav="admin.goods_import.index" href="{{ route('admin.goods_import.index') }}"><i class="icon fa fa-circle-o"></i> 进库列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.goods_export.index" href="{{ route('admin.goods_export.index') }}"><i class="icon fa fa-circle-o"></i> 出库列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.category.index" href="{{ route('admin.category.index') }}"><i class="icon fa fa-circle-o"></i> 分类管理</a></li>--}}
            </ul>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i>
                <span class="app-menu__label">工具管理</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" data-nav="admin.image.index" href="{{ route('admin.image.index') }}"><i class="icon fa fa-circle-o"></i> 封面图片</a></li>
                {{--<li><a class="treeview-item" data-nav="admin.category.index" href="{{ route('admin.category.index') }}"><i class="icon fa fa-circle-o"></i> 小说分类列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.goods_import.index" href="{{ route('admin.goods_import.index') }}"><i class="icon fa fa-circle-o"></i> 进库列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.goods_export.index" href="{{ route('admin.goods_export.index') }}"><i class="icon fa fa-circle-o"></i> 出库列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.category.index" href="{{ route('admin.category.index') }}"><i class="icon fa fa-circle-o"></i> 分类管理</a></li>--}}
            </ul>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i>
                <span class="app-menu__label">网站设置</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" data-nav="admin.setting.banner" href="{{ route('admin.setting.banner') }}"><i class="icon fa fa-circle-o"></i> 首页Banner轮播</a></li>
                <li><a class="treeview-item" data-nav="admin.setting.logo" href="{{ route('admin.setting.logo') }}"><i class="icon fa fa-circle-o"></i> 网站Logo</a></li>
                <li><a class="treeview-item" data-nav="admin.friend_link.index" href="{{ route('admin.friend_link.index') }}"><i class="icon fa fa-circle-o"></i> 友情链接</a></li>
                {{--<li><a class="treeview-item" data-nav="admin.goods_export.index" href="{{ route('admin.goods_export.index') }}"><i class="icon fa fa-circle-o"></i> 出库列表</a></li>--}}
                {{--<li><a class="treeview-item" data-nav="admin.category.index" href="{{ route('admin.category.index') }}"><i class="icon fa fa-circle-o"></i> 分类管理</a></li>--}}
            </ul>
        </li>

        <li>
            <a class="app-menu__item" href="charts.html">
                <i class="app-menu__icon fa fa-pie-chart"></i>
                <span class="app-menu__label">Charts</span>
            </a>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-edit"></i>
                <span class="app-menu__label">访客管理</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" data-nav="admin.comment.index" href="#"><i class="icon fa fa-circle-o"></i>评论管理</a></li>
            </ul>
        </li>
    </ul>
</aside>