;
var user_edit_ops = {
	init:function()
	{
		this.eventBind();
	},

	eventBind:function()
	{
		$('.save').on('click',function(){
			var nickname = $("input[name=nickname]").val();
			var email 	 = $("input[name=email]").val();

			var btn_target = $(this);
			
			if( btn_target.hasClass( 'disabled' ) )
			{
				alert( '正在处理不要重复点击' );
				return false;
			}

			// 验证
			if( nickname.length < 1)
			{
				alert( '请输入正确的姓名' );
				return false;
			}

			if( email.length < 1 )
			{
				alert( '请输入正确的邮箱' );
				return false;
			}

			btn_target.addClass( 'disabled' );

			$.ajax({
				url :common_ops.buildWebUrl('/user/edit'),
				type:'POST',
				data:{
					nickname:nickname,
					email	:email,
				},
				dataType:'json',
				success:function( res ){
					alert( res.msg )

					btn_target.removeClass( 'disabled' );

					if( res.code == 200 )
					{
						window.location.href = window.location.href;
					}
				}
  
			})
		})
	}
}

$(document).ready( function(){
	user_edit_ops.init();
} );