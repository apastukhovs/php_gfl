<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo TITLE; ?></title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1 class="logo">Google Search</h1>
	<form action="" method="post" class="search">
		<input type="search" name="search" placeholder="search" class="input" required />
		<input type="submit" name="submit" value="" class="submit" />
	</form>
	<hr>
	<?php foreach($content as $key => $val) : ?>
	<div class="search-links">
		<?php if($val['url'] != '' || $val['text'] != '') : ?>
		<h3><a href="<?php echo $val['url'];?>"><?php echo $val['title'];?></a></h3>
		<p><?php echo $val['url'];?></p>
		<p><?php echo $val['text'];?></p>
		<?php endif; ?>
	</div>
	<br>
	<?php endforeach; ?>
</body>
</html>