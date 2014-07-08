<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<!-- 最初 -->
<!-- <dev class="text-center"> -->
<form action="checking_answers" method="post" enctype="multipart/form-data" auto:complete="off">



<?php foreach ($data['quiz_sentence'] as $key => $value): ?>
	<h3><?php echo $data['reg_name'].$value['sentence'] ?></h3><br />
	
	<h4><?php echo "<input type='radio' name=".$key." value='right'>".$value['right'] ?></h4><br />
	<?php if(!empty($value['wrong_1'])) :?>
		<h4><?php echo "<input type='radio' name='".$key."' value='wrong_1'>".$value['wrong_1'] ?></h4><br />
	<?php endif; ?>
	<?php if(!empty($value['wrong_2'])) :?>
		<h4><?php echo "<input type='radio' name='".$key."' value='wrong_2'>".$value['wrong_2'] ?></h4><br />
	<?php endif; ?>
	<?php if(!empty($value['wrong_3'])) :?>
		<h4><?php echo "<input type='radio' name='".$key."' value='wrong_3'>".$value['wrong_3'] ?></h4><br />
	<?php endif; ?>

<!-- 	<?php echo "<input type='hidden' name='".$key."' value='".$value['right']."'>" ?>
	<?php echo "<input type='hidden' name='".$key."' value='".$value['sentence']."'>" ?> -->
	<br /><br /><br /><br />
<?php endforeach; ?>

<input class="btn btn-primary btn-large" type="submit" name="answer_submit" value="答え合わせ！">
<!-- </div> -->

<!--  <?php debug($data); ?> -->