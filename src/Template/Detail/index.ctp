<div class="container">
	<?php if($list != null):?>
		<div>
			<h1><?= $list->getName() ?></h1>
			<p class="lead"><?= $title?></p>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				新しいToDoを作成
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="ToDoText">ToDo名</label>
					<input type="text" class="form-control" id="ToDoText" placeholder="例.数学のレポート">
				</div>
				<div class="form-group">
					<label for="ToDoDate">締め切り日付</label>
					<input type="text" class="form-control datepicker" id="ToDoDate" placeholder="日付を選択">
				</div>
				<button type="submit" class="btn btn-primary" onclick="CreateToDo()">作成</button>
			</div>
		</div>

		<?php if($list->getToDoCount()>0): ?>
			<?php foreach($query as $row):?>
				<?= $this->element('ToDo',['item'=>$row]); ?>
			<?php endforeach?>
		<?php else: ?>
			ToDoがありません。
		<?php endif; ?>

		<center>
			<button class="btn btn-danger" onclick="RemoveList(<?= $list->getID()?>)">ToDoListを削除</button>
		</center>
	<?php else:?>
		このToDoListは存在しません。
	<?php endif;?>

	

	<?= $this->Html->script('datepicker.js');?>
	<?= $this->Html->script('AccessAPI.js');?>
</div>

