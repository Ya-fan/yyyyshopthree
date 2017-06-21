;
var account_index_ops = {

	init:function()
	{
		this.eventBind();
	},

	eventBind:function()
	{
		var that = this;
		$('.search').on('click', function(){

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
					url:common_ops.buildWebUrl( '/account/ops' ),
					type:'POST',
					data:{
						act:act,
						uid:uid,
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
	account_index_ops.init();
} );