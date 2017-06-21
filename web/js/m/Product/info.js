/**
 * Created by YANG on 2017/6/22.
 */
;
var product_info_ops = {

    init: function ()
    {
        this.eventBind();
        this.updateViewCount();
    },
    
    eventBind: function ()
    {
        // 收藏
        $('.fav').click( function () {

            var id = $(this).attr('data');

          if( $(this).hasClass('has_faved') )
          {
              alert('该商品已经收藏')
              return;
          }

            $.ajax({
                url:common_ops.buildMUrl('/product/favs'),
                type:'post',
                data: {
                    id: id,
                    act:'set',
                },
                dataType:'json',
                success:function ( res ) {
                    if( res.code == -302 )
                    {
                        common_ops.notlogin( );
                        return;
                    }
                    window.location.href = window.location.href;
                }
            })
        })

    //立即订购
    $('.order_now_btn').click( function() {
        window.location.href = common_ops.buildMUrl( '/product/order', 
            {'id':$("input[name=id]").val(),'num':$("input[name=quantity]").val() } );
    })


    // 商品减
        $('.quantity-form .icon_lower').click(function() {

            var num = parseInt( $(this).next('.input_quantity').val() );    
            
            if( num > 1 )
            {
               $(this).next('.input_quantity').val( num - 1  );
            }

        })

    // 商品加
        $('.quantity-form .icon_plus').click(function() {

            var num = parseInt( $(this).prev('.input_quantity').val() );

            var max = parseInt( $(this).prev('.input_quantity').attr('max') );

            if( num < max )
            {
                $(this).prev('.input_quantity').val( num + 1 );
            }

        })

        // 加入购物车
        $('.add_cart_btn').click(function () {

            var id = $(this).attr('data');
            var quantity = $("input[name=quantity]").val();

            if( quantity <= 0 )
            {
                alert('请填写正确的商品数量');
                return false;
            }

                $.ajax({
                    url:common_ops.buildMUrl('/product/cart'),
                    type:'post',
                    data:{
                        book_id:id,
                        quantity:quantity,
                        act:'set',
                    },
                dataType:'json',
                success:function( res )
                {   
                    if( res.code == -302 )
                    {
                        common_ops.notlogin( );
                        return;
                    }
                    if( res.code  != 200)
                    {
                        alert( res.msg );
                    }
                    else
                    {
                        alert( res.msg );
                    }
                    window.location.href = window.location.href;
                }    
            })
        })
    },
    updateViewCount:function()
    {
        $.ajax({
            type:'post',
            url:common_ops.buildMUrl('/product/ops'),
            data:{
                act:'setViewCount',
                book_id:$('.pro_fixed input[name=id]').val(),
            },
            dataType:'json',
            success:function( res )
            {
                if( res.code !=200 )
                {
                    alert( res.msg );
                }
            }
        })
    }
};


$(document).ready( function(){
    product_info_ops.init();
} );