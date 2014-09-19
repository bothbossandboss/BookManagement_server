<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1><?php echo $data3 ?></h1>
		<h1><?php
		if($data4 != null){
			foreach ($data4 as $first) {
			 	foreach ($first as $second) {
			 		echo "$second<br>";
			 	}
			}
		}
		?></h1>
		 <h1><?php echo $data5 ?></h1>
	</body>
</html>