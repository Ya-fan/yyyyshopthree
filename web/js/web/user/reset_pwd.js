;
var user_reset_pwd_ops = {

	init :function(){
		this.eventBind();
	},
	eventBind:function()
	{

		$('#save').on('click',function(){

			var old_password = $('#old_password').val();
			var new_password = $('#new_password').val();
			var btn_target = $(this);

			if( btn_target.hasClass( 'disabled' ) )
			{
				alert( '正在处理不要重复点击' );
				return false;
			}

			btn_target.addClass( 'disabled' );

			if( old_password.length < 1 )
			{
				alert( '请填写正确的原密码' );	
				return false;
			}

			if( new_password.length < 1 )
			{
				alert( '请填写正确的新密码' );
				return false;
			}

			if( new_password.length < 6 )
			{
				alert( '请填写6位以上的新密码' );
				return false;
			}

			if(  old_password == new_password )
			{
				alert( '新密码不能与原密码相同' );
				return false;
			}

			$.ajax({
				url :common_ops.buildWebUrl('/user/reset-pwd'),
				type:'POST',
				data:{
					old_password:old_password,
					new_password:new_password,
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

	user_reset_pwd_ops.init();

} )