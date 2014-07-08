<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<!-- 最初 -->
<?php if(empty($data['area_submit'])):?>
	<form action="input_data" method="post" enctype="multipart/form-data" auto:complete="off">

	<label for="area"><h4>地方を選択してください</h4></label>

	<select class="selectpicker" id="area" name="area">
		<?php foreach($data as $key => $value): ?>
		<?php echo "<option value=".$key.">".$value."</option>"; ?>
		<?php endforeach; ?>
	</select>
	<br />
	<input class="btn btn-primary btn-large" type="submit"  name="area_submit" value="決定">

<!-- 二段目 -->
<?php else:?>
	<form action="get_select_data" method="post" enctype="multipart/form-data" auto:complete="off">
	<label for="area"><h4>都道府県を選択してください</h4></label>
	<select id="regional" name="regional">
	<?php echo $data['area']; ?><br />	
		<?php foreach($data['area_data']['regional'] as $key => $value): ?>
		<?php echo "<option value=".$key.">".$value."</option>"; ?>
		<?php endforeach; ?>
	</select>
	<?php echo "<input type='hidden' name='area' value='".$data['area']."'>"; ?>
	<br />
	<input class="btn btn-primary btn-large" type="submit" name="all_area_submit" value="決定">
<?php endif;?>

</body>
</html><!-- 
<?php debug($data) ?> -->