<div class="container">
	<div>
		<h1>検索</h1>
		<p class="lead"><?= $title?></p>
	</div>

	<form action="/search" method="get" class="input-group">
		<input id="SearchWord" type="text" name="word" class="form-control" value="<?= $key_word ?>" placeholder="検索キーワード">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit">検索</button>
		</span>
	</form>
	<?php if($key_word != ""):?>
		<!--ToDoリストの表示-->
		<h1>検索キーワード"<?= $key_word ?>"</h3>

		<h3><?= $list_query->count() ?>件のリスト</h3>
		<?php foreach($list_query as $row):?>
			<?= $this->element('ToDoList',[ 'item' =>$row,
											'made' =>$row->getDate()]); ?>
		<?php endforeach?>

		<h3><?= $todo_query->count() ?>件のToDo</h3>
		<?php foreach($todo_query as $row):?>
			<?= $this->element('ToDo',['item'=>$row,
									   'parent'=>$row->getListName()]); ?>
		<?php endforeach?>
	<?php endif;?>
	<?= $this->Html->script('AccessAPI.js');?>
</div>

