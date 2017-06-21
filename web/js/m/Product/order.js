;
var product_order_ops = {

	init:function(){
		this.eventBind();
	},

	eventBind:function()
	{
		$('.do_order').click(function(){

			var address_id = 0; 

			var data = [];

			$('.order_list li').each( function(){

				var tmp_book_id  = $(this).attr('data');
				var tmp_quantity_num  = $(this).attr('data-quantity');

				data.push(tmp_book_id + '#' + tmp_quantity_num);

			} )

			if( data.length < 1 )
			{
				alert( '请选择商品在提交' );
				return;
			}

			$.ajax({
				type:'post',
				url:common_ops.buildMUrl( '/product/order' ),
				data:{
					product_item:data,

					address_id:address_id,
				},
				dataType:'json',
				success:function( res )
				{
					if( res.code  == 200 )
					{
						alert( res.msg )
						window.location.href = res.data.url;
					}
					else
					{
						alert( res.msg )
					}
				}
			})

		})
	},

};


$(document).ready(function(){

	product_order_ops.init();

})