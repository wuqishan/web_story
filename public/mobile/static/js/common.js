(function ($) {

    // 设置全局csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    // 扩展方法
    $.extend({
        "loading": function (paraents, show) {
            if (show) {
                $(paraents).find('.loading-show').show();
            } else {
                $(paraents).find('.loading-show').hide();
            }
        },
        "getSectionInfo": function (url, el, data) {
            $.loading($(el), 1);
            $.get(url, data, function (results) {
                $.loading($(el), 1);
                $(el).html(results);
            }, 'html');
        }
    });

})(jQuery);
