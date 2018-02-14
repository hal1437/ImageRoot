<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?= $title?></title>
		<?= $this->Html->css('bootstrap.min.css');?>
		<?= $this->Html->css('ImageRoot.css');?>
		<?= $this->Html->css('https://use.fontawesome.com/releases/v5.0.6/css/all.css');?>

		<!-- スクリプト -->
		<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') ?>
		<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js') ?>
		<?= $this->Html->script('bootstrap.min.js') ?>
		<?= $this->Html->script('Login.js') ?>
	</head>

	<body>
		<!-- ナビゲーションバー -->
		<nav class="navbar navbar-inverse">
			<div class="navbar-header">
				<a href="/home" class="navbar-brand">ImageRoot</a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#gnavi">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			
			<div id="gnavi" class="collapse navbar-collapse">
				<!-- クッキーに名前がある場合の表示 --!>
				<ul class="nav navbar-nav navbar-right hidden">
					<button type="button" class="btn btn-primary" onclick="ClearUsername()" >
						<div style="display:inline;" id="UsernameButton">ユーザー名</div><i class="fas fa-sign-out-alt" ></i>
					</button>
				</ul>
				<!-- クッキーに名前がない場合の表示 --!>
				<ul class="nav navbar-nav navbar-right ">
					<button type="button" class="btn btn-primary" onclick="location.href='/Auth/twitter'"><i class="fab fa-twitter"></i> Twitter</button>
					<button type="button" class="btn btn-primary" onclick="location.href='/Auth/facebook'"><i class="fab fa-facebook-square"></i> Facebook</button>
				</ul>
			</div>
		</nav>	

		<!-- 本文 -->
		<?= $this->fetch('content'); ?>

	</body>
</html>


