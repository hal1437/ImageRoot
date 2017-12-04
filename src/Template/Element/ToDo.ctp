<div class="panel panel-default">
	<div class="panel-body">
		<div class="pull-right">
			<?php if ($item->isComplete()==true): ?>
				<button class="btn btn-success" onclick="ToggleToDo(<?= $item->getToDoID()?>)">完了済み</button>
			<?php else: ?>
				<button class="btn btn-warning" onclick="ToggleToDo(<?= $item->getToDoID()?>)">未完了</button>
			<?php endif; ?>
			<button class="btn btn-danger" onclick="RemoveToDo(<?= $item->getToDoID()?>)">削除</button>
		</div>
		<?= $item->getText() ?><br>
		作成日：<?= $item->getDate()->format('Y年m月d日')?><br>
		期限　：<?= $item->getLimit()->format('Y年m月d日')?><br>
		
		<?php if(isset($parent)):?>
			リスト：
			<a href="/detail?list=<?= $item->getListID()?>">
				<?= $parent ?><br>
			</a>
		<?php endif;?>
	</div>
</div>
