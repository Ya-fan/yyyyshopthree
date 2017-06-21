;
var product_index_ops = {

	init:function()
	{
		this.sort_field = 'default';
		this.sort ='';
		this.p = 1;
		this.eventBind();
	},

	eventBind:function()
	{
		var that = this;
		$( '.search_icon' ).click(function()
		{	
			that.search();
		});

		$('.sort_box .sort_list li a').click(function()
		{
			that.sort_field = $(this).attr('data');

			if( $(this).find('i').hasClass('high_icon') )
			{
				that.sort = 'asc';
			}
			else
			{
				that.sort = 'desc';
			}
			that.search();
		});

		process = true;
		// 当页面滑动事件
		$( window ).scroll( function(){
			if( ( $( window ).height()+$( window ).scrollTop() ) > $(document).height() -20  && process )
			{	process = false;
				that.p += 1;
				var params = {
				kw:$("input[name=kw]").val(),
				sort_field:this.sort_field,
				sort:this.sort,
				p:that.p,
			};
				$.ajax({
					url:common_ops.buildMUrl('/product/index'),
					type:'get',
					data:params,
				dataType:'json',
				success:function( res )
				{
					process =true;
					if( res.code  != 200 )
					{
						return ;
					}

				var html = '';
					if( res.data.has_next == 1 )
					{
						$.each( res.data.data,function( k, v){
							html+='<li>';
							html+='<a href="'+common_ops.buildMUrl('/product/info',{id:v.id})+'">';
	                    	html+='<i><img src="'+v.main_image+'"';
	                        html+='style="width: 100%;height: 200px;"/></i>';
							html+='<span>'+v.name+'</span><b>';
	                    	html+='<label>月销量'+v.month_count+'</label>¥'+v.price+'</b></a></li>';
					   })

					$('.probox .prolist').append( html );

					}
					else
					{
						process = false;
					}
			
				}
			  })
			}
		} )
	},
	search:function ()
		{
			var params = {
				kw:$("input[name=kw]").val(),
				sort_field:this.sort_field,
				sort:this.sort,
			};

			window.location.href = common_ops.buildMUrl( "/product/index",params );
		}
};


$(document).ready( function(){
	product_index_ops.init();
} );