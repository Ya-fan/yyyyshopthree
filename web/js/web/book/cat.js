;
var book_cat_ops = {

	init:function()
	{
		this.eventBind();
	},

	eventBind:function()
	{
		var that = this;
		$(".search").change( function(){


			$(".wrap_search").submit();
		})
	
		$('.remove').on('click', function(){

			var id = $(this).attr('data');	

			that.ops( 'remove', id );

			})

		$('.recover').on('click', function(){

			var id = $(this).attr('data');	

			that.ops( 'recover', id );

			})
	},

	ops:function( act,uid )
	{ 
		callback =
		{
			"ok":function()
			{
					$.ajax({
					url:common_ops.buildWebUrl( '/book/cat-ops' ),
					type:'POST',
					data:{
						act:act,
						id:uid,
					},
					dataType:'json',
					success:function( res )
					{
					
						callback = null;
						if( res.code ==200)
						{
							callback =function(){
								window.location.href = window.location.href; 
							}
						}

					common_ops.alert( res.msg, callback );
					}
				})
			},
			"cancel":function()
			{
			
			}
			
		}

		common_ops.confirm( (act =='remove') ? '您确定要删除吗?':'您确定要恢复吗?', callback )

	}
};


$(document).ready( function(){
	book_cat_ops.init();
} );