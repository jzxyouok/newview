$(function () {
    var mtree = '[data-name="mtree"]'; //盒子
    var mtreeBtn = '[data-name="mtree_btn"]'; //按钮
    var mtreeCheckbox = '[data-name="mtree_checkbox"]'; //复选框
    var mtreeLink = '[data-name="mtree_link"]'; //链接
    var mtreeIndent = '[data-name="mtree_indent"]'; //缩进
    var mtreeLevel = '[data-name="mtree_level"]'; //等级
    var mtreeName = '[data-name="mtree_name"]'; //文字
    var $_mtree = $(mtree); //盒子对象
    var $_mtreeBtn = $(mtreeBtn); //按钮对象
    var $_mtreeCheckbox = $(mtreeCheckbox); //复选框对象
    var $_mtreeLink = $(mtreeLink); //链接对象
    var $_mtreeIndent = $(mtreeIndent); //缩进对象
    var $_mtreeLevel = $(mtreeLevel); //等级对象
    var $_mtreeName = $(mtreeName); //文字对象
    var showLevel = $_mtree.data('show'); //设置显示几级：空=显示全部，0=显示主级，1=显示一级，2=显示两级...
    //showLevel = (showLevel == 'undefined' || showLevel == null) ? 0 : parseInt(showLevel);
    var openIcon = 'fa fa-caret-right'; //隐藏时显示的打开图标 openIcon
    var closeIcon = 'fa fa-caret-down'; //显示时显示的关闭图标 closeIcon
    var siblingsStatus = false; //展开/关闭时，同级是否改变状态：false=不改变，true=改变
    var currentName = 'current'; //高亮当前点击的元素
    var isShowCheckbox = $_mtreeCheckbox.length; //是否显示复选框
    var indent = 15; //缩进

    /**
     * [设置title]
     * @param  {[type]} e){                 	$(this).attr('title',$(this).text());    } [description]
     * @return {[type]}      [description]
     */
    $_mtreeName.each(function (e) {
        $(this).attr('title', $(this).text());
    });


    /**
     * [根据等级进行缩进]
     * @param  {[type]} e) {		var       indent [description]
     * @return {[type]}    [description]
     */
    $_mtreeIndent.each(function (e) {
        var width = $(this).closest('ul').data('level') * indent;
        if (width > 0) {
            $(this).css({
                display: 'inline-block',
                width: width
            })
        }
    });


    /**
     * [是否显示复选框]
     * @param  {Boolean} isShowCheckbox [true=显，false=不显示]
     * @return {[type]}                 [description]
     */
    if (isShowCheckbox) {
        $_mtreeCheckbox.show()
    } else {
        $_mtreeCheckbox.hide()
    }


    /**
     * [设置显示几级]
     * @return {[type]}                                    [description]
     */
    $_mtree.find('ul').each(function () {
        if (parseInt($(this).data('level')) <= showLevel && showLevel > 0) {
            $(this).show();
        }
        if (showLevel == 'undefined' || showLevel == null) {
            $(this).show();
        }
    });


    // 展开当前选中的栏目及所有上级
    $('.' + currentName).parents('ul').show();


    /**
     * [设置ICON图标]
     * @return {[type]}           [description]
     */
    $_mtreeBtn.each(function () {
        var $_this = $(this);
        var $_currentEle = $_this.closest('a');
        var $_isNull = $_currentEle.next('ul').text(); //下级是否存在内容
        var $_isHidden = $_currentEle.next('ul').is(':hidden'); //下级是否隐藏
        if ($_isNull) {
            if (!$_isHidden) {
                $_this.addClass(closeIcon);
                $_this.closest('a').removeClass('slide_up').addClass('slide_down');
            } else {
                $_this.addClass(openIcon);
                $_this.closest('a').removeClass('slide_down').addClass('slide_up');
            }
        }
    });


    /**
     * [状态切换]
     * @return {[type]}           [description]
     */
    $_mtree.on({
        click: function (e) {
            var $_this = $(this);
            var $_className = $_this.hasClass(openIcon); //当前状态：true=隐藏，false=显示
            var $_currentLevel = $_this.closest('a').next('ul'); //当前下级
            var $_currentSiblingsLevel = $_currentLevel.closest('li').siblings(); //兄弟节点下级
            var $_isNullNext = $_currentLevel.text(); //下级是否存在内容
            var $_isNullSiblings = $_currentSiblingsLevel.children('ul').text(); //兄弟节点下级是否存在内容
            var isSlideToggle = $_this.closest(mtree).data('slide-toggle'); //下级是否可以切换状态：false=不可以，true=可以
            isSlideToggle = (isSlideToggle == 'undefined' || isSlideToggle == null || isSlideToggle == "1") ? true : false;
            if (!isSlideToggle) return false;
            //下级存在内容执行
            if ($_isNullNext) {
                if ($_className) {
                    //1.显示下级
                    $_currentLevel.slideDown(150);
                    //2.改变icon
                    $_this.removeClass(openIcon).addClass(closeIcon);
                    //3.给当前栏目设置样式
                    $_this.closest('a').removeClass('slide_up').addClass('slide_down');
                } else {
                    //1.隐藏下级
                    $_currentLevel.slideUp(150);
                    //2.改变icon
                    $_this.removeClass(closeIcon).addClass(openIcon);
                    //3.给当前栏目设置样式
                    $_this.closest('a').removeClass('slide_down').addClass('slide_up');
                }
                if (siblingsStatus) {
                    //1.隐藏兄弟节点下级
                    $_currentSiblingsLevel.children('ul').slideUp(150);
                    //2.改变节点元素icon
                    $_currentSiblingsLevel.each(function () {
                        if ($(this).children('ul').text()) {
                            $(this).find(mtreeBtn).removeClass(closeIcon).addClass(openIcon);
                        }
                    })
                }
            }
            e.preventDefault();
            e.stopPropagation();
        }
    }, mtreeBtn);


    /**
     * [点击设置默认状态]
     * @return {[type]}           [description]
     */
    $_mtree.on({
        click: function (e) {
            var $_thisHref = $(this).prop('href').replace(/javascript:;|(#)*/, "");
            if ($_thisHref.length == 0) {
                $(this).find(mtreeBtn).click();
            }
            // if ($_thisHref) {
            //     $_mtreeLink.each(function () {
            //         $(this).removeClass(currentName);
            //     });
            //     $(this).addClass(currentName);
            // } else {
            //     $(this).find(mtreeBtn).click();
            // }
        }
    }, mtreeLink);


    /**
     * [click 复选框]
     * @param  {[type]} ){								if($(this).is(':checked') [description]
     * @return {[type]}                                      [description]
     */
    $_mtree.on({
        click: function (e) {
            //关联子节点
            if ($(this).is(':checked') === true) {
                $(this).closest('a').next('ul').find('input[type="checkbox"]:enabled').prop('checked', true);
            } else {
                $(this).closest('a').next('ul').find('input[type="checkbox"]:enabled').prop('checked', false);
            }
            //关联父节点
            if ($(this).is(':checked') === true) {
                $(this).parents('ul').prev('a').find('input[type="checkbox"]:enabled').prop('checked', true);
            } else {
                _getParentsCheckbox($(this));
            }
            e.stopPropagation();
        }
    }, 'input[type="checkbox"]:enabled');


    /**
     * [_getParentsCheckbox 查找所有父节点的复选框]
     * @param  {[type]} obj [description]
     * @return {[type]}     [description]
     */
    function _getParentsCheckbox(obj) {
        var checkenLen = obj.closest('ul').find('input[type="checkbox"]:enabled:checked').length;
        var checkbox = obj.closest('ul').prev('a').find('input[type="checkbox"]:enabled'); //当前复选框父节点上级兄弟节点中的复选框
        var checkboxLen = checkbox.length;
        if (checkboxLen > 0) {
            if (checkenLen > 0) {
                checkbox.prop('checked', true);
            } else {
                checkbox.prop('checked', false);
            }
            _getParentsCheckbox(checkbox);
        }
    }


})