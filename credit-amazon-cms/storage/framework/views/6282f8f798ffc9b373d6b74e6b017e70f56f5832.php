<select id="change-company" style="width: 150px;" class="form-control ml-2">
	<option value="crd" <?php echo e($company == 'crd' ? 'selected=""' : ''); ?>>კრედიტამაზონი</option>
	<option value="tch" <?php echo e($company == 'tch' ? 'selected=""' : ''); ?> >ტექპლიუსი</option>
	<option value="ctr" <?php echo e($company == 'ctr' ? 'selected=""' : ''); ?> disabled="">ციტრუსი</option>
</select>

<?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER', 'TECHPLUS_OPERATOR', 'SIGNATURE_OPERATOR'])) : ?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#change-company').on('change', function(e){
			$.ajax({
				url: '<?php echo e(route('operator.request.changecompany')); ?>',
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
<?php endif; // Entrust::hasRole ?>