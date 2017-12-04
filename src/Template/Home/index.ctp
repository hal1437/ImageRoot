<div class="container">
	<div>
		<h1>トップページ</h1>
		<p class="lead"><?= $title?></p>
	</div>
	<!-- 新規作成パネル -->
	<div class="panel panel-default">
		<div class="panel-heading">
			新しいRootを作成
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="ListName">タイトル</label>
				<input type="text" class="form-control" id="ListName" placeholder="例.今日の夕飯">
				<button class="btn btn-primary" onclick="CreateToDoList()">作成</button>
			</div>
		</div>
	</div>

	<!-- Root一覧 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			最近のRoot一覧
		</div>
		<div class="panel-body">
			<div class="row">
				<?php foreach($query as $row):?>
					<div class="col-xs-6 col-md-3">
						<?= $this->element('Root',['item'=>$row]); ?>
					</div>
				<?php endforeach?>
			</div>
		</div>
	</div>

	

	<?= $this->Html->script('AccessAPI.js');?>
</div>

