;
upload = {
	error:function( msg )
	{
		common_ops.alert( msg );
	},
	success:function( imagekey )
	{
		// common_ops.alert( msg );

		var html = '<img src="'+common_ops.buildPicUrl('brand',imagekey)+'"><span class="fa fa-times-circle del del_image" data="'+imagekey+'"><i></i></span>';

		if( $( ".upload_pic_wrap .pic-each" ).size() > 0 )
		{
			$(".upload_pic_wrap .pic-each").html( html );
		}
		else
		{
			$(".upload_pic_wrap").append( '<span class="pic-each">'+html+'</span>' );
		}
 		
 		brand_set_ops.deleteimage()
	}
}
;
var brand_set_ops = {
	init:function()
	{
		this.eventBind();
		this.deleteimage();
	},
	eventBind:function()
	{
		$('.save').on('click',function(){

				var btn_target = $(this);
				if( btn_target.hasClass( 'disabled' ) )
				{
					common_ops.alert( '正在处理，请您不要重复提交' );
					return false;
				}

				btn_target.addClass('disabled');

		var name_target 	= $(".wrap_brand_set input[name=name]");
		
		var name  	= name_target.val();

		var mobile_target 	= $(".wrap_brand_set input[name=mobile]");
		var mobile  	=mobile_target.val();

		var address_target 	= $(".wrap_brand_set input[name=address]");
		var address  =	address_target.val();

		var description_target = $(".wrap_brand_set textarea[name=description]");
		var description  =	description_target.val();

		var imagekey = $(".wrap_brand_set .pic-each .del_image").attr('data');

		if( name.length < 1 )
		{
					common_ops.tip( '请您填写品牌名', name_target  );
					return false;
		}	

		if( $( ".upload_pic_wrap .pic-each" ).size() < 1 )
		{
					common_ops.alert( '请选择图片' );
					return false;
		}

		if( mobile.length < 1 )
		{
					common_ops.tip( '请您填写品牌手机号', mobile_target );
					return false;
		}
		
		if( address.length < 1 )
		{
					common_ops.tip( '请您填写品牌地址', address_target  );
					return false;
		}

		if( description.length < 1 )
		{
					common_ops.tip( '请您填写品牌简介', description_target  );
					return false;
		}

		$.ajax({
					url:common_ops.buildWebUrl( '/brand/set' ),
					type:'POST',
					data:{
						name:name,
						mobile:mobile,
						imagekey:imagekey,
						description:description,
						address:address,
						// id:$(".wrap_account_set input[name=id]").val(),
					},
					dataType:'json',
					success:function( res )
					{
						btn_target.removeClass( 'disabled' );
						
						callback = null;
						if( res.code ==200)
						{
							callback = function(){
								window.location.href = common_ops.buildWebUrl('/brand/info'); 
							}
						}

						common_ops.alert( res.msg, callback );
					},
				})
		}),

		$(".wrap_brand_set .upload_pic_wrap input[name=pic]").change(function( )
		{
	
			$(".wrap_brand_set .upload_pic_wrap").submit();

		})

		// 点击删除上传
		

	},
	deleteimage :function()
	{
			$( ".wrap_brand_set .del_image" ).unbind().click( function()
			{
				$(this).parent().remove();
			} )
			

			
	}	

}

$(document).ready( function(){
	brand_set_ops.init();
} );
