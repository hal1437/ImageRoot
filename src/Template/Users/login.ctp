<div class="container">
	<div>
		<h1>ログインページ</h1>
		<p class="lead"><?= $title?></p>
	</div>
	<button type="button" class="btn btn-primary" onclick="location.href='/Auth/twitter'"><i class="fab fa-twitter"></i> Twitter</button>
	<button type="button" class="btn btn-primary" onclick="location.href='/Auth/facebook'"><i class="fab fa-facebook-square"></i> Facebook</button>
	<?= $this->Html->script('AccessAPI.js');?>
	<?= $this->Html->script('Home.js');?>
</div>


