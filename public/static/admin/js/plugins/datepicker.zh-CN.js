(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as anonymous module.
        define('datepicker.zh-CN', ['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals.
        factory(jQuery);
    }
})(function ($) {

    'use strict';

    $.fn.datepicker.dates['zh-CN'] = {
        format: 'yyyy年mm月dd日',
        days: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
        daysShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        daysMin: ['日', '一', '二', '三', '四', '五', '六'],
        months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        weekStart: 1,
        yearFirst: true,
        yearSuffix: '年',
        today: "今天",
        clear: "清除"
    };
});
