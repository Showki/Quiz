<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<?php $i=0; ?>
<?php $j=0; ?>
<?php foreach ($data as $key => $value) :?>
<!-- 	<?php debug($key) ?> -->
	<?php if($value == "right"): ?>
		<?php $i+=1 ?>
	<?php endif; ?>
	<?php $j+=1 ?>
<?php endforeach ;?>
<?php $j-=1 ?>

	<div class='big_txt'>採点結果<div>
	<br /><br /><br />
	<div class='mega_txt'><?php echo $i.'/'.$j."点" ?></div>
	<br /><br /><br />
	<a class="btn btn-primary btn-large" href="input_data">戻る</a><br />