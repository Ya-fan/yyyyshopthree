<?php 


 ?>

请选择员工:
 <select name="" id="staffList">
 	<?php foreach( $staff_Data as $val ) {?>
 		<option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
 	<?php 
 	} 
 	?>
 </select>

 <button id="play">打卡</button>

 <script>
 $('#play').on('click',function(){
 var staff_id = $('#staffList').val();


 	$.ajax({
 		type:"post",
 		url:"?r=punch/search",
 		data:'staff_id='+staff_id,
	 	// success:function()
	 	// {

	 	// }
 	})
 })

 </script>