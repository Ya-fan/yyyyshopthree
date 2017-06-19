;
// var default_index_ops = {

// 	init:function()
// 	{
// 		this.eventBind();
// 	},

// 	eventBind:function()
// 	{

// 	}
// };
$(document).ready( function(){
	// default_index_ops.init();
	
	TouchSlide({
		slideCell:"#slideBox",
		titCell:".hd ul",
		mainCell:".bd ul",
		autoPage:true,
		effect:"leftLoop",
		autoPlay:true,
	});


} );