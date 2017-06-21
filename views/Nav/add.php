 <!-- <form id="form"> -->
 <table>
 	<tr>
 		<h2>导航设置</h2>
 		<button id="add">添加导航+</button>
 	</tr>
	
	<tr>
		<div  style="width:600px;height:100px;overflow:auto" class="tag">
		<li style="list-style-type:none;">标签内容: <input type="text" name="nav_name[]"> 指定页面<input type="text" name="nav_url[]"> <input type="checkbox"   name= "is_new[]"value="1">新窗口&nbsp;&nbsp;&nbsp;<font color="red" class="del">x</font></li>	
			
		</div>
	</tr><br>
 	<tr>
		页面位置: <input type="radio" name="position" value="left"> 靠左 <input name="position" type="radio" value="right"> 靠右 <input name="position" value="center" type="radio">居中
	</tr>
	<br>
	<tr>
			字体设置: 
				
				<select  id="font_size">
				<?php for($i=1 ;$i<=30 ; $i++) {?>
					<option value="<?= $i ?>"><?= $i ?></option>
				<?php 
				}
				?>	
				</select>
				B:<input type="checkbox" value="1" name="font_bold" >
			颜色:
			<input type="color" name="font_color">
	</tr>
	<br>
	<tr>
		导航背景色：颜色:
			<input type="color" name="nav_color">
	</tr>
 </table>
 <input type="submit" value="提交" id="form">
 <!-- </form> -->


 <script>
 		$('#add').on('click',function()
 		{
 			var str = '<li style="list-style-type:none;">标签内容: <input type="text" name="nav_name[]"> 指定页面<input type="text" name="nav_url[]"> <input type="checkbox"  name="is_new[]" value="1">新窗口&nbsp;&nbsp;&nbsp;<font color="red" class="del">x</font></li>';
 				$('.tag').append(str);	
 		})

 		$('.tag').delegate('.del','click',function(){

 				$(this).parent().remove();
 		})

 		$('#form').click(function(){
 			
 			var nav_name  = [];
 			var nav_url   = [];
 			var is_new    = [];
 			var position = '';
 			var font_size = '';
 			var font_bold = '';
 			var nav_color = '';
 			var font_color = '';
			for (var i = 0; i < $("input[name='nav_name[]']").length; i++)
			{	
				nav_name[i] = $("input[name='nav_name[]']:eq("+i+")").val();
				nav_url[i]  = $("input[name='nav_url[]']:eq("+i+")").val();
				is_new[i]   = $("input[name='is_new[]']:eq("+i+")").is(":checked") ? 1 :0;
			};

 			position  = $("input[name='position']:checked").val();
 			font_size = $("#font_size").val();

			font_bold  = $("input[name='font_bold']").is(":checked") ? 1 :0;
			nav_color  = $("input[name='nav_color']").val();
			font_color  = $("input[name='font_color']").val();
 
			$.ajax({
				type:'post',
				url:'index.php?r=nav/add',
				data:{
					nav_name:nav_name,
					nav_url:nav_url,
					is_new:is_new,
					position:position,
					font_size:font_size,
					font_bold:font_bold,
					nav_color:nav_color,
					font_color:font_color
				},
			})

  		})
 </script>