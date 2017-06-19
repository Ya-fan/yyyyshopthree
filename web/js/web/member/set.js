;
var account_set_ops = {
	init:function()
	{
		this.eventBind();
	},
	eventBind:function()
	{
		$('.save').click(function(){
			
			var nickname_target = $("input[name=nickname]");
			var mobile_target = $("input[name=mobile]");
			var mobile = mobile_target.val();
			var nickname = nickname_target.val();

			var btn_target = $(this);
			if( btn_target.hasClass( 'disabled' ) )
			{
				common_ops.alert( '正在处理，请您不要重复提交' );
				return false;
			}

			if( mobile.length < 1 )
			{
				common_ops.tip( '填写正确的会员名',mobile );
				return false;
			}

			if( nickname.length < 1)
			{
				common_ops.tip( '填写正确的会员手机号',nickname );
			}

			btn_target.addClass( 'disabled' );

			$.ajax({
					url:common_ops.buildWebUrl( '/member/set' ),
					type:'POST',
					data:{
						nickname:nickname,
						mobile:mobile,
						id:$("input[name=id]").val(),
					},
					dataType:'json',
					success:function( res )
					{
						btn_target.removeClass( 'disabled' );
						
						callback = null;
						if( res.code ==200)
						{
							callback = function(){
								window.location.href = common_ops.buildWebUrl('/member/index'); 
							}
						}

						common_ops.alert( res.msg, callback );
					}
				})
			})



	
	}
};

$(document).ready( function(){
	account_set_ops.init();
} );