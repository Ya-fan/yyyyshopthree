<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>saasda</title>
</head>
<body>
		<!-- <h1>我是common</h1> -->
	<?php if(isset($this->blocks['block1'])) :?>
		<?= $this->blocks['block1'] ?>
	<?php else: ?>
		<h1>我是common</h1>
	<?php endif; ?>
	<?= $content;?>
</body>
</html>