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
    $('.data-list').find('.checkOne').
        on('click', function() {
            var id = $(this).parent().data('id');
            if(id==undefined){
                $('#confirm_msg').data('id',0);
            }else{
                $('#confirm_msg').data('id',id);
            }

            $('#confirm_msg').data('action','checkOne');
            $('#confirm_msg').text('你，确定要审核这条记录吗？');
            $('#my-confirm').modal('show');
        });
});


$(function() {
    $('.data-list').find('.delOne').
        on('click', function() {
            var id = $(this).parent().data('id');
            $('#confirm_msg').data('id',id);
            $('#confirm_msg').data('action','delOne');
            $('#confirm_msg').text('你，确定要删除这条记录吗？');
            $('#my-confirm').modal('show');
        });
});
$(function(){
    $('#delMore').on('click',function(){
        var ids = getCheckVal();
        $('#confirm_msg').data('ids',ids);
        $('#confirm_msg').data('action','delMore');
        $('#confirm_msg').text('你，确定要删除这些记录吗？');
        $('#my-confirm').modal('show');
    })
});
$(function(){
    $('#checkMore').on('click',function(){
        var ids = getCheckVal();
        $('#confirm_msg').data('ids',ids);
        $('#confirm_msg').data('action','checkMore');
        $('#confirm_msg').text('你，确定要审核这些记录吗？');
        $('#my-confirm').modal('show');
    })
});

function checkOne(id){
    console.log('check one by id:'+id);
}

function checkMore(ids){
    console.log('check more by ids:'+ids);
}

function delOne(id){
    console.log('del one by id:'+id);
}

function delMore(ids){
    console.log('del more by ids:'+ids);
}

$('#btn-sure').click(function(){
    var id = $('#confirm_msg').data('id');
    var ids = $('#confirm_msg').data('ids');
    var action = $('#confirm_msg').data('action');
    switch (action){
        case 'checkOne':
            checkOne(id);
            break;
        case 'checkMore':
            checkMore(ids);
            break;
        case 'delOne':
            delOne(id);
            break;
        case 'delMore':
            delMore(ids);
            break;
    }
    $('#my-confirm').modal('hide');
});


