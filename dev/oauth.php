<?php
require_once __DIR__ .  '/logic/common/common_logic.php';
$common_logic = new common_logic();


$result = $common_logic->google_oauth_logic($_GET['code']);

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>GoogleのOAuth2.0を使ってプロフィールを取得</title>
</head>
<body>
	<h2>ユーザー情報</h2>
	<table>
		<tr><td>ID</td><td><?php echo $result['id']; ?></td></tr>
		<tr><td>ユーザー名</td><td><?php echo $result['name']; ?></td></tr>
		<tr><td>苗字</td><td><?php echo $result['family_name']; ?></td></tr>
		<tr><td>名前</td><td><?php echo $result['given_name']; ?></td></tr>
		<tr><td>場所</td><td><?php echo $result['locale']; ?></td></tr>
		<tr><td>場所</td><td><?php echo $result['email']; ?></td></tr>
	</table>
	<h2>プロフィール画像</h2>
	<img src="<?php echo $result['picture']; ?>" width="100">
</body>
</html>