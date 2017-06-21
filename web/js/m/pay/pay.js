;
var pay_buy_ops = {


	init:function()
	{
		this.eventBind();
	},
	eventBind:function()
	{
		$('.do_pay').on('click',function(){

			var btn_target = $(this);

			if( btn_target.hasClass('disabled')){
				alert( '正在提交，请不要重复提交' );
		
				return;
			}

			btn_target.addClass('disabled');

			$.ajax({
				type:'POST',
				url:common_ops.buildMUrl( '/pay/prepare' ),
				data:{
					pay_order_id:$('input[name=pay_order_id]').val()
				},
				success:function( res )
				{
					
				}

			})

		})
	},



};


$(document).ready( function(){
	pay_buy_ops.init();
} );