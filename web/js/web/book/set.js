
;
upload = {
	error:function( msg )
	{
		common_ops.alert( msg );
	},
	success:function( imagekey )
	{
		// common_ops.alert( msg );

		var html = '<img src="'+common_ops.buildPicUrl('book',imagekey)+'"><span class="fa fa-times-circle del del_image" data="'+imagekey+'"><i></i></span>';

		if( $( ".upload_pic_wrap .pic-each" ).size() > 0 )
		{
			$(".upload_pic_wrap .pic-each").html( html );
		}
		else
		{
			$(".upload_pic_wrap").append( '<span class="pic-each">'+html+'</span>' );
		}
 		
 		book_set_ops.deleteimage()
	}
}
;
var book_set_ops = {
	init:function()
	{	
		this.ue=null;
		this.eventBind();
		this.initEditor();
		this.deleteimage();
	},
	eventBind:function()
	{	var that = this;
		$(".wrap_book_set .upload_pic_wrap input[name=pic]").change(function( )
		{
	
			$(".wrap_book_set .upload_pic_wrap").submit();

		})

		//快捷搜索
		$("select[name=cat_id]").select2({
			language:"zh-CN",
			width:"100%",
		});

		$("input[name=tags]").tagsInput({
			width:'auto',
			height:40,
			onAddTag:function(tag){

			},
			onRemoveTag:function(tag){

			}
		});

		// 保存
		$('.save').on('click',function(){ 
				var name 		= $(".wrap_book_set input[name=name]");
				var cat_id 		= $("select[name=cat_id]");
				var price 		= $(".wrap_book_set input[name=price]");
				var summary 		=  $.trim( that.ue.getContent() );
				var stock 		= $(".wrap_book_set input[name=stock]");
				var tags_target = $(".wrap_book_set input[name=tags]");
            	var tags = $.trim( tags_target.val() );

				var btn_target = $(this);
				if( btn_target.hasClass( 'disabled' ) )
				{
					common_ops.alert( '正在处理，请您不要重复提交' );
					return false;
				}

				if( cat_id.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的图书分类', cat_id )
					return false;
				}


				if( name.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的图书名称', name )
					return false;
				}

				if( price.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的图书价格', price )
					return false;
				}

				if( summary.length < 10 )
				{
					common_ops.tip( '请您填写正确的图书描述', summary )
					return false;
				}

				if( stock.val().length < 1 )
				{
					common_ops.tip( '请您填写正确的图书库存', stock )
					return false;
				}

				if( tags.length < 1 )
				{
					common_ops.tip( '请您填写正确的图书标签', tags )
					return false;
				}

				btn_target.addClass( 'disabled' );

				var cat_idVal = cat_id.val();
				var nameVal = name.val();
				var priceVal = price.val();
				var summaryVal = summary;
				var stockVal = stock.val();
				var tagsVal = tags;


				$.ajax({
					url:common_ops.buildWebUrl( '/book/set' ),
					type:'POST',
					data:{
						name:nameVal,
						cat_id:cat_idVal,
						price:priceVal,
						summary:summaryVal,
						stock:stockVal,
						tags:tagsVal,
						imagekey:$('.del_image').attr('data'),
						id:$(".wrap_book_set input[name=id]").val(),
					},
					dataType:'json',
					success:function( res )
					{
						btn_target.removeClass( 'disabled' );
						
						callback = null;
						if( res.code ==200)
						{
							callback = function(){
								window.location.href = common_ops.buildWebUrl('/book/index'); 
							}
						}

						common_ops.alert( res.msg, callback );
					},
				})
				
		})
	},
	initEditor:function(){
        var that = this;
        that.ue = UE.getEditor('editor',{
            toolbars: [
                [ 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall',  '|','rowspacingtop', 'rowspacingbottom', 'lineheight'],
                [ 'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink'],
                [ 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'horizontal', 'spechars','|','inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols' ]

            ],
            enableAutoSave:true,
            saveInterval:60000,
            elementPathEnabled:false,
            zIndex:4
        });
        that.ue.addListener('beforeInsertImage', function (t,arg){
            console.log( t,arg );
            //alert('这是图片地址：'+arg[0].src);
            // that.ue.execCommand('insertimage', {
            //     src: arg[0].src,
            //     _src: arg[0].src,
            //     width: '250'
            // });
            return false;
        });
    },
	deleteimage :function()
	{
			$( ".wrap_book_set .del_image" ).unbind().click( function()
			{
				$(this).parent().remove();
			} )
			

			
	}	

};

$(document).ready( function(){
	book_set_ops.init();
} );