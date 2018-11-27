(function ($) {

    // 设置全局csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    // 扩展方法
    $.extend({
        "loading": function (parents, show) {
            if (show) {
                $(parents).find('.loading-show').show();
            } else {
                $(parents).find('.loading-show').hide();
            }
        },
        "getSectionInfo": function (url, el, data) {
            $.loading($(el), true);
            $.get(url, data, function (results) {
                $.loading($(el), false);
                $(el).find('.book_list').append(results);
            }, 'html');
        },
        "getBookMore": function ($url, el, data) {
            $.loading($(el), true);
            $.get(url, data, function (results) {
                $.loading($(el), false);
                $(el).before(results);
            }, 'html');
        }
    });

})(jQuery);
