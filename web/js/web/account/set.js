;
var account_set_ops = {
	init:function()
	{
		this.eventBind();
	},
	eventBind:function()
	{
		$('.save').on('click',function(){ 
			var nickname 	= $(".wrap_account_set input[name=nickname]");
				var mobile 		= $(".wrap_account_set input[name=mobile]");
				var email 		= $(".wrap_account_set input[name=email]");
				var login_name 	= $(".wrap_account_set input[name=login_name]");
				var login_pwd 	= $(".wrap_account_set input[name=login_pwd]");
				
				var btn_target = $(this);
				if( btn_target.hasClass( 'disabled' ) )
				{
					common_ops.alert( '正在处理，请您不要重复提交' );
					return false;
				}

				if( nickname.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的姓名', nickname  );
					return false;
				}

				if( mobile.val().length < 11 )
				{
					common_ops.tip( '请您填写正确的手机号', mobile )
					return false;
				}

				if( email.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的邮箱', email )
					return false;
				}

				if( login_name.val().length < 2 )
				{
					common_ops.tip( '请您填写正确的登录名', login_name )
					return false;
				}

				if( login_pwd.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的登录密码', login_pwd )
					return false;
				}

				btn_target.addClass( 'disabled' );

				var nicknameVal = nickname.val();
				var mobileVal = mobile.val();
				var emailVal = email.val();
				var login_nameVal = login_name.val();
				var login_pwdVal = login_pwd.val();

				$.ajax({
					url:common_ops.buildWebUrl( '/account/set' ),
					type:'POST',
					data:{
						nickname:nicknameVal,
						mobile:mobileVal,
						email:emailVal,
						login_name:login_nameVal,
						login_pwd:login_pwdVal,
						id:$(".wrap_account_set input[name=id]").val(),
					},
					dataType:'json',
					success:function( res )
					{
						btn_target.removeClass( 'disabled' );
						
						callback = null;
						if( res.code ==200)
						{
							callback = function(){
								window.location.href = common_ops.buildWebUrl('/account/index'); 
							}
						}

						common_ops.alert( res.msg, callback );
					},
				})
				
		})
	}

};

$(document).ready( function(){
	account_set_ops.init();
} );