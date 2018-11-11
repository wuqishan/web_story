(function () {
    "use strict";

    var treeviewMenu = $('.app-menu');

    // Toggle Sidebar
    $('[data-toggle="sidebar"]').click(function (event) {
        event.preventDefault();
        $('.app').toggleClass('sidenav-toggled');

        if ($('.app').hasClass('sidenav-toggled')) {
            $.cookie('sidenav_toggled', 'open')
        } else {
            $.cookie('sidenav_toggled', 'close');
        }
    });
    if ($.cookie('sidenav_toggled') == 'open') {
        $('.app').addClass('sidenav-toggled')
    } else {
        $('.app').removeClass('sidenav-toggled')
    }

    // Activate sidebar treeview toggle
    $("[data-toggle='treeview']").click(function (event) {
        event.preventDefault();
        if (!$(this).parent().hasClass('is-expanded')) {
            treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
        }
        $(this).parent().toggleClass('is-expanded');
    });

    // Set initial active toggle
    $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

    //Activate bootstrip tooltips
    $("[data-toggle='tooltip']").tooltip();

    // 左侧menu高亮
    $('#app-menu .treeview-item').each(function (i) {
        var dataNav = $(this).attr('data-nav');
        if (window.routeName == '') {
            return true;
        }
        if (dataNav == window.routeName) {
            $(this).parents('li.treeview').addClass('is-expanded');
            $(this).addClass('active');
            return true;
        }
    });
    $('#app-menu > li').each(function (i) {
        if (! $(this).hasClass('treeview')) {
            var dataNav = $(this).find('a').attr('data-nav');
            if (window.routeName == '') {
                return true;
            }
            if (dataNav == window.routeName) {
                $(this).find('a').addClass('active');
                return true;
            }
        }
    });

    // 切换每页显示多少条数据
    $(".page_number").change(function () {
        var length = $(this).val();
        var currentUrl = location.href;
        currentUrl = currentUrl.replace('#', '');
        var lengthParam = $.get_url_param('length');
        if (lengthParam == null) {
            if (currentUrl.indexOf('?') > -1) {
                location.href = currentUrl + '&length=' + length;
            } else {
                location.href = currentUrl + '?length=' + length;
            }
        } else {
            location.href = currentUrl.replace('length=' + lengthParam, 'length=' + length);
        }

    });
})();
