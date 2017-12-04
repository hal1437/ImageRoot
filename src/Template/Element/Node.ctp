<div class="panel panel-default">
	<div class="panel-body">
		<?= $index+1 ?>. <?= $item->GetUserName() ?>「<?= $item->GetMessage() ?>」
		<?php if($item->GetImageID() != -1):?>
			<img class='node-image' src="<?= $item->GetImageURL()?>">
		<?php endif;?>
	</div>
</div>

