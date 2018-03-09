
<?= $this->Html->css('Node.css');?>
<div class="panel panel-default">
	<div class="panel-body">

		<?= $index+1 ?>.　<?= $item->GetUserName() ?>　<?= $item->GetCreated() ?><br>

		<div class="node-message">
			<?= $item->GetMessage() ?>

			<!-- 画像が存在すれば追加 -->
			<?php if($item->GetImageID() != -1):?>
				<img class='node-image' id="image<?= $index+1 ?>" src="<?= $item->GetImageURL()?>" data-toggle="modal" data-target="#image_Modal<?= $index+1 ?>">
				<div class="modal fade" id="image_Modal<?= $index+1 ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
					<div class="modal-dialog modal-lg modal-middle"> 
						<div class="modal-content">
							<div class="modal-body">
								<img  src="<?= $item->GetImageURL()?>" class="aligncenter size-full wp-image-425" alt="baby-1151351_1920" />
							</div>
							<div class="modal-img_footer">
								<button type="button" class="btn btn-success" data-dismiss="modal">Close</button> 
							</div>
						
						</div>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
</div>


