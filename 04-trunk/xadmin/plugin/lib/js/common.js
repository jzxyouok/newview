$(function () {
    //全选
    $(document).on({
        click: function () {
            var name = $(this).data('checkname');
            var is_checked = $(this).is(':checked');
            $('input[type="checkbox"][name^=' + name + ']:enabled').prop('checked', is_checked);
        }
    }, 'input[type="checkbox"][data-checkname]');
    //关联全选
    $(document).on({
        click: function () {
            var name = $(this).attr('name').replace(/\[.*\]/, '');
            var checkbox = $('input[type="checkbox"][data-checkname="' + name + '"]:enabled');
            if (checkbox.length == 0) {
                return;
            }
            var checkedLen = $('input[type="checkbox"][name^="' + name + '"]:enabled:checked').length;
            var checkboxLen = $('input[type="checkbox"][name^="' + name + '"]:enabled').length;
            if (checkedLen < checkboxLen) {
                checkbox.prop('checked', false);
            } else {
                checkbox.prop('checked', true);
            }
        }
    }, 'input[type="checkbox"]');

    //回车搜索
    $(document).keydown(function (e) {
        if (e.which == 13) {
            $('[data-name="searchbtn"]').click();
        }
    });

    //删除
    $(document).on({
        click: function () {
            var tbname = $(this).data('tb');
            var id = $(this).data('id');
            var url = $(this).data('url');
            var primary = $(this).data('primary');
            if (tbname == '' || id == '' || url == '') {
                layer.msg('删除失败！', {icon: 2});
                return;
            }
            layer.confirm('确定删除？此操作不可恢复！', {icon: 3, title: '删除'}, function () {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {tbname: tbname, id: id, primary: primary},
                    success: function (data) {
                        if (data) {
                            layer.msg('删除成功！', {icon: 1, time: 1000}, function () {
                                $('[data-name="searchbtn"]').click();
                            });
                        } else {
                            layer.msg('删除失败！', {icon: 2});
                        }
                    }
                });
            });
        }
    }, '[data-name="del"]');

    //批量删除
    $(document).on({
        click: function () {
            var tbname = $(this).data('tb');
            var url = $(this).data('url');
            var primary = $(this).data('primary');
            var checkname = ($(this).data('checkname')) ? $(this).data('checkname') : 'id';
            var checkbox = $('input[type="checkbox"][name^=' + checkname + ']:enabled:checked');
            var id = '';
            //遍历已选中checkbox并获得val
            checkbox.each(function () {
                id += $(this).val() + ',';
            });
            id = id.substring(0, id.length - 1);
            //没有选中项
            if (id.length == 0) {
                layer.msg('没有选中项！', {icon: 4});
                return;
            }
            layer.confirm('确定删除？此操作不可恢复！', {icon: 3, title: '批量删除'}, function () {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {tbname: tbname, id: id, primary: primary},
                    success: function (data) {
                        if (data) {
                            layer.msg('删除成功！', {icon: 1, time: 1000}, function () {
                                $('[data-name="searchbtn"]').click();
                                $('input[type="checkbox"][name="checkAll"][data-checkname="' + checkname + '"]').prop('checked', false);
                            });
                        } else {
                            layer.msg('删除失败！', {icon: 2});
                        }
                    }
                });
            });
        }
    }, '[data-name="batch_del"]');

})

