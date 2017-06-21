;
var cat_set_ops = {
	init:function()
	{
		this.eventBind();
	},
	eventBind:function()
	{
		$('.save').on('click',function(){ 
				var name 	= $(".wrap_cat_set input[name=name]");
				var weight 		= $(".wrap_cat_set input[name=weight]");
				
				
				var btn_target = $(this);
				if( btn_target.hasClass( 'disabled' ) )
				{
					common_ops.alert( '正在处理，请您不要重复提交' );
					return false;
				}

				if( name.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的分類名', name  );
					return false;
				}

				if( weight.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的权重', weight )
					return false;
				}

			

				btn_target.addClass( 'disabled' );

				var nameVal = name.val();
				var weightVal = weight.val();

				$.ajax({
					url:common_ops.buildWebUrl( '/book/cat-set' ),
					type:'POST',
					data:{
						name:nameVal,
						weight:weightVal,
						
						id:$(".wrap_cat_set input[name=id]").val(),
					},
					dataType:'json',
					success:function( res )
					{
						btn_target.removeClass( 'disabled' );
						
						callback = null;
						if( res.code ==200)
						{
							callback = function(){
								window.location.href = common_ops.buildWebUrl('/book/cat'); 
							}
						}

						common_ops.alert( res.msg, callback );
					},
				})
				
		})
	}

};

$(document).ready( function(){
	cat_set_ops.init();
} );