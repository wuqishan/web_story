/**
 *  自定义jquery扩展方法
 */

$.extend({
    /**
     * 文件上传功能
     *
     * @param option
     */
    sys_upload_img: function (option)
    {
        let optionDefault = {
            'inputName': 'upload_file',         // file 表单元素的name名称，同时会赋值该值的id
            'url': '',                          // 提交到url
            'formData': {},                     // 附带提交参数
            'multiple': false,                  // 是否是多图片传
            'defaultImg': '',                   // 显示点击上传的图片
            'uploadAreaObj': '#upload_area',    // 表单元素的位置，一般为 form-group col-md-12
            'label': '图片',                     // 提示词
            'hiddenName': 'temp_file',           // 存放数据的隐藏表单控件名字
            'initInfo': []
        };
        let settings = $.extend(optionDefault, option);

        // 显示控件配置
        let templateOptions = {
            'uploadAreaObj': settings.uploadAreaObj,
            'inputName': settings.inputName,
            'label': settings.label,
            'defaultImg': settings.defaultImg,
            'hiddenName': settings.hiddenName,
            'multiple': settings.multiple ? 'multiple' : ''
        };
        settings.formData.name = settings.inputName;
        $.sys_upload_img_template(templateOptions);

        let htmlTemplate = '<div class="upload-img-box upload-img-show" id="upload-img-show-{{id}}">' +
            '                   <img src="{{src}}">' +
            '                   <a href="javascript:void(0);" onclick="$.sys_del_upload_img({{id}}, \''+ settings.hiddenName +'\')" title="删除">×</a>' +
            '               </div>';

        // 执行初始化函数
        if (typeof settings.init === "function") {
            settings.callback(data.result);
        }

        if (settings.initInfo.length > 0) {
            let hiddenValue = [];
            let initImage = [];

            for (var i = 0; i < settings.initInfo.length; i++) {
                hiddenValue.push(settings.initInfo[i].id);
                initImage.push(
                    htmlTemplate.replace('{{id}}', settings.initInfo[i].id)
                        .replace('{{id}}', settings.initInfo[i].id)
                        .replace('{{src}}', settings.initInfo[i].filepath + settings.initInfo[i].filename)
                )
            }
            if (hiddenValue.length > 0 && initImage.length > 0) {
                $('input[name="'+ settings.hiddenName +'"]').val(hiddenValue.join(','));
                $('#file-input-position-control').before(initImage.join(''));
            }
        }

        // 定义上传事件
        $("#" + settings.inputName).fileupload({
            url: settings.url,
            dataType: 'json',
            autoUpload: true,
            formData: settings.formData,
            maxFileSize: 1000000, // 10 MB
            add: function (e, data) {
                data.submit();
                $('.upload-progress').show();
            },
            done: function (e, data) {
                let html = '';
                if (data.result.status) {
                    if (settings.multiple) {
                        html = htmlTemplate.replace('{{src}}', data.result.data.filepath + data.result.data.filename);
                        html = html.replace('{{id}}', data.result.data.id);
                        html = html.replace('{{id}}', data.result.data.id);
                        $('#file-input-position-control').before(html);
                    } else {
                        html = htmlTemplate.replace('{{src}}', data.result.data.filepath + data.result.data.filename);
                        html = html.replace('{{id}}', data.result.data.id);
                        html = html.replace('{{id}}', data.result.data.id);
                        $('.upload-img-show').remove();
                        $('#file-input-position-control').before(html);
                    }
                    // 执行回调函数
                    if (typeof settings.callback === "function") {
                        settings.callback(data.result);
                    }

                    // 隐藏表单中写数据
                    let hiddenObj = $('input[name="'+ settings.hiddenName +'"]');
                    if (settings.multiple) {
                        let tmpFileIds = hiddenObj.val();
                        let tmpFileIdArr = tmpFileIds.split(',');
                        tmpFileIdArr.push(data.result.data.id);
                        tmpFileIdArr = $.sys_array_remove_empty(tmpFileIdArr);
                        hiddenObj.val(tmpFileIdArr.join(','));
                    } else {
                        hiddenObj.val(data.result.data.id);
                    }

                    $.sys_notify("上传附件 : ", "附件上传成功！", 'fa fa-check', "success");
                } else {
                    $.sys_notify("上传附件 : ", "附件上传失败！", 'fa fa-warning', "warning");
                }

                $('.upload-progress').hide();
                $('.upload-progress .progress-bar').css('width', '0%');
            },
            progressall: function (e, data) {
                let progress = parseInt(data.loaded / data.total * 100, 10);
                $('.upload-progress .progress-bar').css('width', progress + '%');
            }
        });
    },

    /**
     * 文件上传显示html
     *
     * @param settings
     */
    sys_upload_img_template: function(settings)
    {
        let template = '<label>'+settings.label+' :</label><br>' +
            '<div class="upload-img-box" id="file-input-position-control">\n' +
            '                                    <input type="file" name="'+settings.inputName+'" id="'+settings.inputName+'" '+settings.multiple+'>\n' +
            '                                    <img src="'+settings.defaultImg+'">\n' +
            '                                </div>\n' +
            '                                <div class="bs-component upload-progress">\n' +
            '                                    <div class="progress mb-2">\n' +
            '                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>\n' +
            '                                    </div>\n' +
            '                                </div>' +
            '                                <input type="hidden" name="'+ settings.hiddenName +'">' +
            '                                <div class="form-control-feedback"></div>';

        $(settings.uploadAreaObj).html(template);
    },

    /**
     * 删除上传的图片
     *
     * @param temp_files_id
     */
    sys_del_upload_img: function (temp_files_id, hidden_name)
    {
        $.ajax({
            url: '/admin/upload/delete/' + temp_files_id,
            type: 'get',
            data: {},
            dataType: 'json',
            success: function (res){
                if (res.status) {
                    $.sys_notify("删除附件 : ", "附件删除成功！", 'fa fa-check', "success");
                    $('#upload-img-show-' + temp_files_id).remove();
                    let hiddenVal = $('input[name="'+ hidden_name +'"]').val();
                    hiddenVal = hiddenVal.split(',');
                    hiddenVal = $.sys_array_remove_val(hiddenVal, temp_files_id);
                    if (hiddenVal.length > 0) {
                        $('input[name="'+ hidden_name +'"]').val(hiddenVal.join(','));
                    } else {
                        $('input[name="'+ hidden_name +'"]').val('');
                    }
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    },

    /**
     * 表单提交
     *
     * @param option
     */
    sys_submit: function (option) {
        let optionDefault = {
            'formSelector': '#form-data',
            'url': '',
            'goTo': '',
            'data': {}
        };
        let settings = $.extend(optionDefault, option);
        $(settings.formSelector).ajaxSubmit({
            url: settings.url,
            type: 'post',
            dataType: 'json',
            data:settings.data,
            clearForm: true,
            success: function(results){
                if (results.status) {
                    location.href = settings.goTo;
                }
            },
            error: function(err){
                if (err.hasOwnProperty('responseJSON') && err.responseJSON.hasOwnProperty('errors')) {
                    for (let i in err.responseJSON.errors) {
                        $('[name='+ i +']').next('.form-control-feedback').html(err.responseJSON.errors[i][0]);
                    }
                }
            }
        });
    },

    /**
     * 提示语
     *
     * @param title
     * @param message
     * @param icon
     * @param type
     * @param delay
     */
    sys_notify: function (title, message, icon, type, delay) {
        delay = typeof delay !== 'undefined' ?  delay : 1000;
        $.notify({
            title: title,
            message: message,
            icon: icon

        },{
            type: type,
            delay:delay
        });
    },
    /**
     * 数组唯一
     *
     * @param array
     * @returns {Array}
     */
    sys_array_unique: function (array)
    {
        let newArray = [];
        if (array.length > 0) {
            for (let i = 0; i < array.length; i++) {
                if ($.inArray(array[i], newArray) === -1) {
                    newArray.push(array[i]);
                }
            }
        }

        return newArray;
    },
    /**
     * 数组去空值
     *
     * @param array
     * @returns {Array}
     */
    sys_array_remove_empty: function (array)
    {
        let newArray = [];
        if (array.length > 0) {
            for (let i = 0; i < array.length; i++) {
                if (array[i] !== '' && typeof(array[i]) !=='undefined') {
                    newArray.push(array[i]);
                }
            }
        }

        return newArray;
    },
    /**
     * 删除数组中指定value的值
     *
     * @param array
     * @param val
     * @returns {Array}
     */
    sys_array_remove_val: function (array, val)
    {
        let newArray = [];
        if (array.length > 0) {
            for (let i = 0; i < array.length; i++) {
                if (array[i] != val) {
                    newArray.push(array[i]);
                }
            }
        }

        return newArray;
    }
});