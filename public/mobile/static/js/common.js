(function ($) {

    // 设置全局csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    // 扩展方法
    $.fn.extend({
        "getSectionInfo": function (url, el, data) {
            $.get(url, data, function (results) {
                $(el).html(results);
            }, 'html');
        }
    });

})(jQuery);
