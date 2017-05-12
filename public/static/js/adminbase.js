/**
 * Created by wuzm0 on 2017/4/30.
 */
$(document).ready(function(){
    var ms = 200;
    $('.sub-menu-o').show();
    if(is_mobile()){
        $('.data-list').addClass('table-responsive');
    }
    $('.main-menu').click(function(){
        var ul = $(this).siblings('ul');
        var i = $(this).find('.fa-pull-right');
        if(!$(ul).hasClass('sub-menu-o')){
            var old_i = $('.sub-menu-o').prev('a').find('.fa-angle-up');
            $(old_i[0]).removeClass('fa-angle-up').addClass('fa-angle-down');
            $('.sub-menu-o').slideUp(ms);
            $(ul).slideDown(ms);
            $('.sub-menu-o').removeClass('sub-menu-o');
            $(ul).addClass('sub-menu-o');
            $(i[0]).removeClass('fa-angle-down');
            $(i[0]).addClass('fa-angle-up');
        }else{
            $(ul).slideUp(ms);
            $('.sub-menu-o').slideUp(ms);
            $(ul).removeClass('sub-menu-o');
            $(i[0]).removeClass('fa-angle-up');
            $(i[0]).addClass('fa-angle-down');
        }
    });
    $('.btn-bar').click(function(){
        if(is_mobile()){
            if($('#menu-wrap').hasClass('mobile-menu')){
                    $('#menu-wrap').removeClass('mobile-menu');
            }else{
                $('#menu-wrap').addClass('mobile-menu');
            }
        }else{
            var flag = $('#menu-wrap').hasClass('menu-hide');
            if(flag){
                $('#menu-wrap').removeClass('menu-hide');
                $('#admin-bar').removeClass('mini-bar');
                $('#content-wrap').removeClass('mini-bar');
                $('.admin-footer').removeClass('mini-bar');
                $('#admin-bar').addClass('normal-bar');
                $('#content-wrap').addClass('normal-bar');
                $('.admin-footer').addClass('normal-bar');
            }else{
                $('#menu-wrap').addClass('menu-hide');
                $('#admin-bar').removeClass('normal-bar');
                $('#content-wrap').removeClass('normal-bar');
                $('.admin-footer').removeClass('normal-bar');
                $('#admin-bar').addClass('mini-bar');
                $('#content-wrap').addClass('mini-bar');
                $('.admin-footer').addClass('mini-bar');
            }
        }
    });
});
function is_mobile(){
    var os = new Array("Android","iPhone","Windows Phone","iPod","BlackBerry","MeeGo","SymbianOS");
    var info = navigator.userAgent;
    var len = info.length;
    for(var i=0;i<len;i++){
        if(info.indexOf(os[i])>0) return true;
    }
    return false;
}