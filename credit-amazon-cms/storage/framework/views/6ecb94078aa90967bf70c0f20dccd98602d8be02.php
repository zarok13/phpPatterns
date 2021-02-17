<select id="change-color-input" style="width: 150px; background: <?php echo e($color ?? 0); ?>" class="form-control ml-2">
	<option value="">ფერის შეცვლა</option>
	<option value="yellow" <?php echo e($color === 'yellow' ? 'selected=""' : ''); ?> style="background: yellow;">ყვითელი</option>	
	<option value="black" <?php echo e($color === 'black' ? 'selected=""' : ''); ?> style="background: black; color: white;">შავი</option>	
	
</select>

<script type="text/javascript">
	$(document).ready(function(){
		$('#change-color-input').on('click', function(){
			$(this).css('background', 'none')
		}).on('change', function(e){
			$.ajax({
				url: '<?php echo e(route('operator.request.changecolor')); ?>',
				type: 'POST',
				data: {
					i:1, 
					request_id: $('#request_id_input').val(),
					color: e.target.value
				}
			});
		});
	});
</script>