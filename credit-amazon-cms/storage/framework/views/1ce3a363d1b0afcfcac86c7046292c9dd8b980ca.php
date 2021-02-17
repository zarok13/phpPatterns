<div class="row">
	<div class="col-md-6">			
		<form id="send_sms_form">
			<div class="form-group">
				<label>ნომერი</label>
				<input type="text" class="form-control" required="" name="number" value="<?php echo e($number); ?>"/>
			</div>

			<div class="form-group">
				<label>ლინკი</label>
				<input type="text" class="form-control" required="" name="link" id="sms_link_input"/>
			</div>

			<div class="form-group">
				<label>SMS</label>
				<textarea rows="2" class="form-control" required="" name="text"></textarea>
			</div>


			<div class="form-group">
				<button type="submit" class="btn btn-success">გაგზავნა</button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#sms_link_input").on('change', function(){
			var link_input = $(this);
			var form = link_input.closest('form');
			var link = link_input.val();
			var product_id = getParameterByName('product_id', link);
			if(!product_id) return link_input.css('border', '2px solid red');
			var url = 'https://combo.ge/r.php?' + product_id;
			var text = 'Nivtis Sanaxavad Gadadit bmulze: ' + url;
			form.find('[name="text"]').html(text);

		});
		$('#send_sms_form').on('submit', function(e){
			e.preventDefault();
			var form = $(this);
			var num_input = form.find('[name="number"]');
			var link_input = form.find('[name="link"]');
			var text_input = form.find('[name="text"]');
			var link = link_input.val();
			var number = num_input.val();
			var text = text_input.val();

			if(number.length != 9) return num_input.css('border', '2px solid red');
			if(!link.indexOf('product_id=') > 0) link_input.css('border', '2px solid red');

			$.ajax({
				url: '<?php echo e(route('send_one_sms')); ?>',
				data: {i: 1, number: number, text: text},
				success: function(data){
					console.log(data);
				}
			});
		});
	})
</script>