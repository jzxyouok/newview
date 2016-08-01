$(function () {
    //隐藏侧边栏
    // var CookieSidebarStatus = $.cookie('SidebarStatus');
    // if (CookieSidebarStatus) {
    //     $('[data-name="sidebar"]').addClass(CookieSidebarStatus);
    // }
    $('[data-name="sidebar_hidden"]').on('click', function () {
        $('[data-name="sidebar"]').toggleClass('sidebar_hidden');
        //var SidebarStatus = $('[data-name="sidebar"]').hasClass('sidebar_hidden');
        //设置cookie
        // if (SidebarStatus) {
        //     $.cookie('SidebarStatus', 'sidebar_hidden');
        // }else{
        //     $.cookie('SidebarStatus', '');
        // }
    })
})

