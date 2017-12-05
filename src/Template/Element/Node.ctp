
<?= $this->Html->css('Node.css');?>
<div class="panel panel-default">
	<div class="panel-body">

		<?= $index+1 ?>.　<?= $item->GetUserName() ?>　<?= $item->GetCreated() ?><br>

		<div class="node-message">
			<?= $item->GetMessage() ?>

			<!-- 画像が存在すれば追加 -->
			<?php if($item->GetImageID() != -1):?>
				<img class='node-image' src="<?= $item->GetImageURL()?>">
			<?php endif;?>
		</div>
	</div>
</div>

