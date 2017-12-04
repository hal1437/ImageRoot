<div class="container">
	<?php if($list != null && $list->count() > 0):?>
		<?php foreach($list as $index => $row):?>
			<?= $this->element('Node',[
				'index' => $index,
				'item'  => $row
			]); ?>
		<?php endforeach?>
	<?php else:?>
		このRootは存在しません。
	<?php endif;?>

	

	<?= $this->Html->script('datepicker.js');?>
	<?= $this->Html->script('AccessAPI.js');?>
</div>

