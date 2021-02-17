<select id="change-is-ganvadeba" style="width: 150px;" class="form-control ml-2">
	<option value="1" <?php echo e($is_ganvadeba == 1 ? 'selected=""' : ''); ?>>განვადება</option>
	<option value="0" <?php echo e($is_ganvadeba == 0 ? 'selected=""' : ''); ?>>ჩგდ</option>
</select>

<script type="text/javascript">
	$(document).ready(function(){
		$('#change-is-ganvadeba').on('change', function(e){
			$.ajax({
				url: '<?php echo e(route('operator.request.changeganvadeba')); ?>',
				type: 'POST',
				data: {
					i:1, 
					request_id: $('#request_id_input').val(),
					value: $(this).val()
				}
			});
		});
	});
</script>