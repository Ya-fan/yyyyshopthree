;
upload = {
	error:function( msg )
	{
		common_ops.alert( msg );
	},
	success:function( imagekey )
	{
		if( !imagekey )
		{
			return ;
		}

		var html = '<img src="'+common_ops.buildPicUrl('brand',imagekey)+'"><span class="fa fa-times-circle del del_image" data="'+imagekey+'"><i></i></span>';

		if( $( ".upload_pic_wrap .pic-each" ).size() > 0 )
		{
			$(".upload_pic_wrap .pic-each").html( html );
		}
		else
		{
			$(".upload_pic_wrap").append( '<span class="pic-each">'+html+'</span>' );
		}
 		
 		brand_image_ops.deleteimage()
	}
}

var brand_image_ops =  {
	init:function()
	{
		this.eventBind();
	},
	eventBind:function()
	{
		$('.set_pic').click(function(){
		
			$('#brand_image_wrap').modal('show');
		});
		
		// 表单提交
		$("#brand_image_wrap .upload_pic_wrap input[name=pic]").change(function(){

				$("#brand_image_wrap .upload_pic_wrap").submit();
		})

		//点击保存
		$(".modal-footer .save").click(function(){

			var btn_target = $(this);
			if( btn_target.hasClass( 'disabled' ) )
			{
				common_ops.alert( '正在处理，请您不要重复提交' );
				return false;
			}

			if( $( ".upload_pic_wrap .pic-each" ).size() < 1 )
			{
				common_ops.alert('请重新上传图片');
			}

			btn_target.addClass('disabled');

			$.ajax({
					url:common_ops.buildWebUrl( '/brand/set-image' ),
					type:'POST',
					data:{
						imagekey:$("#brand_image_wrap .pic-each .del_image").attr('data'),
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
								window.location.href = window.location.href; 
							}
						}

						common_ops.alert( res.msg, callback );
					},
				})
			})
	 $('.remove').click(function(){

	 		var id = $(this).attr('data');
	 		var callback = {
	 			'ok':function(){
	 				$.ajax({
					url:common_ops.buildWebUrl( '/brand/image-ops' ),
					type:'POST',
					data:{
						id:id,
					},
					dataType:'json',
					success:function( res )
					{
						
					var	callback = null;
						if( res.code ==200)
						{
							callback = function(){
								window.location.href = window.location.href; 
							}
						}

						common_ops.alert( res.msg, callback );
					},
				})
	 			},
	 			'cancel':null 
	 		}
	 		
	 		common_ops.confirm( "确定删除？",callback );


	 })


	},
	deleteimage :function()
	{
			$( ".del_image" ).unbind().click( function()
			{
				$(this).parent().remove();
			} )
	}
};

$(document).ready( function(){
	brand_image_ops.init();
} );
