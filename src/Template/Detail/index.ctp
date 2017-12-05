<div class="container">
	<?= $this->Html->css('sticky-footer.css');?>

	<?php if($list != null && $list->count() > 0):?>
		<?php foreach($list as $index => $row):?>
			<?= $this->element('Node',[
				'index' => $index,
				'item'  => $row
			]); ?>
		<?php endforeach?>
	<?php else:?>
		このRootにNodeは存在しません。
	<?php endif;?>

	<div class="panel panel-default">
		<div class="panel-heading">
			新しいNodeを作成
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="NodeUser">名前</label>
				<input type="text" class="form-control" id="NodeUser" >
			</div>
			<div class="form-group">
				<textarea class="form-control" id="NodeMessage" rows="3"></textarea>
			</div>
			<div class="form-group">
				<label for="NodeImage">画像を添付</label>
				<input type="file" class="form-control-file" id="NodeImage" aria-describedby="fileHelp">
			</div>
			<button type="submit" class="btn btn-primary" onclick="CreateNode()">作成</button>

		</div>
	</div>
	
	<footer class="footer">
		<div class="container">
			<p class="text-muted">Place sticky footer content here.</p>
		</div>
	</footer>

	<?= $this->Html->script('datepicker.js');?>
	<?= $this->Html->script('AccessAPI.js');?>
</div>

