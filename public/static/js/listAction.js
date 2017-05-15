/**
 * Created by Administrator on 2017/4/1.
 */
$('#check-all').click(function(){
    if($(this).is(':checked')){
        $('.data-check').each(function(){
            $(this).prop('checked',true);
        })
    }else{
        $('.data-check').each(function(){
            $(this).prop('checked',false);
        })
    }
});
function getCheckVal(){
    var str = '';
    $('.data-check').each(function(){
        if($(this).is(':checked')){
            str+=$(this).val()+',';
        }
    });
    return str.substring(0,str.length-1);
}
$(function() {
    $('.data-list').find('.enableOne').
        on('click', function() {
            var id = $(this).parent().data('id');
            var text = $(this).text();
            if(id==undefined){
                $('#confirm_msg').data('id',0);
            }else{
                $('#confirm_msg').data('id',id);
            }

            $('#confirm_msg').data('action','enableOne');
            $('#confirm_msg').text('你，确定要'+text+'吗？');
            $('#my-confirm').modal('show');
        });
    $('.data-list').find('.disableOne').
        on('click', function() {
            var id = $(this).parent().data('id');
            var text = $(this).text();
            if(id==undefined){
                $('#confirm_msg').data('id',0);
            }else{
                $('#confirm_msg').data('id',id);
            }

            $('#confirm_msg').data('action','disableOne');
            $('#confirm_msg').text('你，确定要'+text+'吗？');
            $('#my-confirm').modal('show');
        });
});


$(function() {
    $('.action').
        on('click', function() {
            var action = $(this).data('action');
            var url = $(this).data('url');
            switch (action){
                case 'redirect':
                    window.location.href = url;
                    break;
                case 'confirm':
                    var tips = $(this).data('tips');
                    $('#confirm_msg').data('url',url);
                    $('#confirm_msg').text('你，确定要'+tips+'这条记录吗？');
                    $('#my-confirm').modal('show');
                    break;
                default :
                    window.location.href = url;
            }
        });
});
$(function(){
    $('.top-action').on('click',function(){
        var ids = getCheckVal();
        var action = $(this).data('action');
        var url = $(this).data('url');
        switch (action){
            case 'redirect':
                window.location.href = url;
                break;
            case 'confirm':
                var tips = $(this).data('tips');
                $('#confirm_msg').data('url',url+'?&ids='+ids);
                $('#confirm_msg').text('你，确定要'+tips+'这些记录吗？');
                $('#my-confirm').modal('show');
                break;
        }
    })
});

$('#btn-sure').click(function(){
    var url = $('#confirm_msg').data('url');
    $('#my-confirm').modal('hide');
    window.location.href = url;
});


