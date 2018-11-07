<?php

namespace App\Helper;


class EditorHelper
{

    public static function editor($id)
    {
        $static_file = [
            '<link href="/static/admin/editor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">',
            '<script type="text/javascript" src="/static/admin/editor/third-party/jquery.min.js"></script>',
            '<script type="text/javascript" charset="utf-8" src="/static/admin/editor/umeditor.config.js"></script>',
            '<script type="text/javascript" charset="utf-8" src="/static/admin/editor/umeditor.min.js"></script>',
            '<script type="text/javascript" src="/static/admin/editor/lang/zh-cn/zh-cn.js"></script>',
        ];

        $editor = "<script id=\"{$id}\" style=\"height:200px;\"></script>";

        $init_js = "<script type=\"text/javascript\">var um = UM.getEditor('{$id}');</script>";

        return implode('', $static_file) . $editor . $init_js;
    }

}