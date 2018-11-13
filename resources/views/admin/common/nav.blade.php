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
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">数据统计</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" data-nav="admin.admin.index" href="{{ route('admin.admin.index') }}"><i class="icon fa fa-circle-o"></i> 饼图统计</a></li>
                <li><a class="treeview-item" data-nav="admin.admin.table" href="{{ route('admin.admin.table') }}"><i class="icon fa fa-circle-o"></i> 数据表格统计</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i>
                <span class="app-menu__label">书本管理</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" data-nav="admin.book.index" href="{{ route('admin.book.index') }}"><i class="icon fa fa-circle-o"></i> 书本列表</a></li>
                <li><a class="treeview-item" data-nav="admin.chapter.list.all" href="{{ route('admin.chapter.list.all') }}"><i class="icon fa fa-circle-o"></i> 章节管理</a></li>
                <li><a class="treeview-item" data-nav="admin.category.index" href="{{ route('admin.category.index') }}"><i class="icon fa fa-circle-o"></i> 分类列表</a></li>
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
                <li><a class="treeview-item" data-nav="admin.setting.seo" href="{{ route('admin.setting.seo') }}"><i class="icon fa fa-circle-o"></i> SEO 管理</a></li>
                <li><a class="treeview-item" data-nav="admin.setting.banner" href="{{ route('admin.setting.banner') }}"><i class="icon fa fa-circle-o"></i> 首页Banner轮播</a></li>
                <li><a class="treeview-item" data-nav="admin.setting.logo" href="{{ route('admin.setting.logo') }}"><i class="icon fa fa-circle-o"></i> 网站Logo</a></li>
                <li><a class="treeview-item" data-nav="admin.friend_link.index" href="{{ route('admin.friend_link.index') }}"><i class="icon fa fa-circle-o"></i> 友情链接</a></li>
                <li><a class="treeview-item" data-nav="admin.common_article.index" href="{{ route('admin.common_article.index') }}"><i class="icon fa fa-circle-o"></i> 网站文章</a></li>
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