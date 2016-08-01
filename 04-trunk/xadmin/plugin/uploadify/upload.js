/**
 * Created by Admin on 2016/7/22.
 */
$(function () {
    //打开上传窗口
    $('[data-name="upload_btn"]').on('click', function () {
        var uploadifyJson = {
            "num": $(this).data('num'),
            "size": $(this).data('size'),
            "queue": $(this).data('queue'),
        };
        $.cookie('uploadify', JSON.stringify(uploadifyJson));
        layer.open({
            type: 2,
            title: false,
            closeBtn: false,
            area: ['520px', '360px'],
            // content: '<?=site_url("uploadify")?>',
            content: 'index.php/uploadify',
        });
    });
    //移除已上传文件
    $(document).on('click', '[data-name="upload_remove"]', function () {
        $(this).closest('li').remove();
    });
})

