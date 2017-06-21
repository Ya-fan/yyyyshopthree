;
var user_bind_ops = {

	init:function()
	{
		this.eventBind();
	},

	eventBind:function()
	{
		var that = this;
		$('.dologin').on('click',function(){

			var btn_target = $(this);
			if( btn_target.hasClass( 'disabled' ) )
			{
				alert( '正在处理，请您不要重复绑定' );
				return false;
			}

			var mobile 		= $("input[name=mobile]").val();
			var img_captcha 		= $("input[name=img_captcha]").val();
			var captcha_code 	= $("input[name=captcha_code]").val();

			if( mobile.length < 1 || !/^[1-9]\d{10}$/.test( mobile ) )
			{
				alert('请输入正确的手机号');
				return false;
			}

			if( img_captcha.length < 1 )
			{
				alert('请输入正确的图形验证码~');
				return false;
			}

			if( captcha_code.length < 1 )
			{
				alert('请输入正确的手机验证码');
				return false;
			}

			btn_target.addClass( 'disabled' );

			var data = {
				mobile:mobile,
				img_captcha:img_captcha,
				captcha_code:captcha_code,
			}

			$.ajax({
					url:common_ops.buildMUrl('/user/bind'),
					type:'POST',
					data:data,
				dataType:'json',
				success:function(msg){
					btn_target.removeClass( 'disabled' );
						
					callback = null;
					if( msg.code !=200)
					{
						$('#img_captcha').click();
						alert( msg.msg )
					window.location.href = window.location.href;
						return;
					}

					var host = window.location.host;
					var url  = msg.data.url;
				
					window.location ='http://'+window.location.host+url;
				}	
			});

		})

		$('.get_captcha').on('click',function(){
			var btn_target = $(this);
			if( btn_target.hasClass( 'disabled' ) )
			{
				common_ops.alert( '正在处理，请您不要重复绑定' );
				return false;
			}

			var mobile 		= $("input[name=mobile]").val();
			var img_captcha = $("input[name=img_captcha]").val();


			if( mobile.length < 1 || !/^[1-9]\d{10}$/.test( mobile ) )
			{
				alert('请输入正确的手机号');
				return false;
			}

			if( img_captcha.length < 1 )
			{
				alert('请输入正确的图形验证码~');
				return false;
			}

			btn_target.addClass( 'disabled' );

			$.ajax({
					url:common_ops.buildMUrl('/default/get_captcha'),
					type:'POST',
					data:{
						mobile:mobile,
						img_captcha:img_captcha,
						source:'wechat',
					},
				dataType:'json',
				success:function(msg){
					btn_target.removeClass( 'disabled' );
						
					alert( msg.msg )

					if( msg.code !=200)
					{
					window.location.href = window.location.href;
						return;
					}
				}	

			});


		})

		
	},

};


$(document).ready( function(){
	user_bind_ops.init();
} );