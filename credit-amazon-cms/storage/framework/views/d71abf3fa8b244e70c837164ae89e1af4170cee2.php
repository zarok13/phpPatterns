<div class="row">
        <div class="col-md-12">
    <?php if(isset($order->calculated)): ?>
    
        
            <form action="#" id="invoice_form" enctype="multipart/form-data">
                <input type="hidden" name="request_id" value="<?php echo e($order->id); ?>">
				
				
				
				
				<?php if( false ): ?>
						
					<div class="col-md-3" style="margin-top: 20px;">
						<label for="adress">ინვოისის ატვირთვა</label>

						<div class="form-group" >
							<div class="input-group">
								<input type="file" name="invoice_file" id="invoice_file" class="form-control" placeholder="აირციეთ ფაილი">
							</div>
						</div>
					</div>	

					<?php if(isset($data['invoice'])): ?>
						<a href="/invoice/download_file/?k=12&request_id=<?php echo e($order->id); ?>" target="_blank"> ინვოისის ჩამოტვირთვა </a> 
					<?php endif; ?>

					
					<div class="form-group" style="margin-top: 20px;">
						<button type="button" class="btn btn-success waves-effect text-left" id="generate_invoice_button">ატვირთვა</button>
					</div>
					<script>

						$('#generate_invoice_button').on('click', function(){
							
							var image_form_data = new FormData();
							var file_data = $("#invoice_file").prop("files")[0];
							image_form_data.append("file", file_data);
							image_form_data.append("request_id", $('#request_id').val());

							$.ajax({
								type: "POST",
								cache: false,
								contentType: false,
								processData: false,
								url: "<?php echo e(route('invoice.save_invoice_file')); ?>",
								data:image_form_data,
								success: function (response) {
									console.log(response);
								}
							});
						});
					</script>
				<?php else: ?>

					
					<section class="invoice_row"  >
						<?php if(isset($data['invoice']->items)): ?>
						
							<?php ($invoice_items_price = 0); ?>

							<?php $__currentLoopData = $data['invoice']->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php ($invoice_items_price += $item->price); ?>

								<div class="row items_row" style="margin-top: 5px;" id="items_row">
									<div class="col-md-5">
										<div class="form-group" >
											<div class="input-group">
												<input type="text" name="names[]" required="" class="form-control invoice_names" placeholder="დასახელება" value="<?php echo e($item->item); ?>">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" >
											<div class="input-group">
												<input type="text" name="quantities[]" required="" class="form-control invoice_quantities" placeholder="რაოდენობა"
													onkeyup="quantity_changed($(this)); update_full_price()" value="<?php echo e($item->quantity); ?>"
												>
												<input type="text" name="one_price[]" required="" class="form-control invoice_one_price" placeholder="ერთ. ფასი"
													onkeyup="price_changed($(this)); update_full_price()" value="<?php echo e($item->one_price); ?>" 
												>
												<input type="text" disabled name="full_price[]" required="" class="form-control invoice_full_price" placeholder="სულ ფასი" value="<?php echo e($item->price); ?>" >
											</div>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group" >
											<input type="button" class="btn btn-danger waves-effect text-left delete_invoice_row"  value="წაშლა" onclick="if($('.items_row').length > 1){$(this).closest('.items_row').remove(); update_full_price();}">
										</div>
									</div>

								</div>
								
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php else: ?>
							<div class="row items_row" style="margin-top: 5px;" id="items_row">
								<div class="col-md-5">
									<div class="form-group" >
										<div class="input-group">
											<input type="text" name="names[]" required="" class="form-control invoice_names" placeholder="დასახელება" >
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" >
										<div class="input-group">
											<input type="text" name="quantities[]" required="" class="form-control invoice_quantities" placeholder="რაოდენობა"
												onkeyup="quantity_changed($(this)); update_full_price()" value="1"
											>
											<input type="text" name="one_price[]" required="" class="form-control invoice_one_price" placeholder="ერთ. ფასი"
												onkeyup="price_changed($(this)); update_full_price()"  value="<?php echo e((isset($order->calculated->invoice_amount))?ceil($order->calculated->invoice_amount):''); ?>"
											>
											<input type="text" disabled name="full_price[]" required="" class="form-control invoice_full_price" placeholder="სულ ფასი" value="<?php echo e((isset($order->calculated->invoice_amount))?ceil($order->calculated->invoice_amount):''); ?>">
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group" >
										<input type="button" class="btn btn-danger waves-effect text-left delete_invoice_row"  value="წაშლა" onclick="if($('.items_row').length > 1){$(this).closest('.items_row').remove(); update_full_price();}">
									</div>
								</div>

							</div>
						<?php endif; ?>

					</section>
					
					<div class="row" >
						<div class="col-md-3" style="margin-top: 20px;">
							<label for="adress">მისამართი</label>

							<div class="form-group" >
								<div class="input-group">
									<?php ($address = ''); ?>
									<?php if(isset($order->user_info)): ?>
										<?php if(isset($order->user_info->address)): ?>
											<?php ($address = isset($order->user_info->address) ? $order->user_info->address : ''); ?>
										<?php endif; ?>
									<?php endif; ?>    
									<input type="text" name="address" required="" value="<?php echo e($address); ?>" class="form-control invoice_names" placeholder="მისამართი">
								</div>
							</div>
						</div>

						<?php if($order->calculated->bank == 2): ?>
						<div class="col-md-3" style="margin-top: 20px;">
							<label for="adress">სერვის ცენტრის მისამართი</label>

							<div class="form-group" >
								<div class="input-group">
									<?php ($bank_adress = ''); ?>
									<?php if(isset($order->user_info)): ?>
										<?php if(isset($order->user_info->bank_adress)): ?>
											<?php ($bank_adress = isset($order->user_info->bank_adress) ? $order->user_info->bank_adress : ''); ?>
										<?php endif; ?>
									<?php endif; ?>
									<input type="text" name="bank_adress" required="" value="<?php echo e($bank_adress); ?>" class="form-control invoice_names" placeholder="(მხოლოდ BOG) სთვის">
								</div>
							</div>
						</div>
						<?php endif; ?>


						

						<div class="col-md-3" style="margin-top: 20px;">
								<label for="adress">ხელის მოწერის თარიღი</label>

							<div class="form-group" >
								<div class="input-group">
									<?php ($signature_date = ''); ?>
									<?php if(isset($order->user_info)): ?>
										<?php if(isset($order->user_info->signature_date)): ?>
											<?php ($signature_date = isset($order->user_info->signature_date) ? $order->user_info->signature_date : ''); ?>
										<?php endif; ?>
									<?php endif; ?>
									<input type="text" name="signature_date" required="" value="<?php echo e($signature_date); ?>" class="form-control invoice_names" placeholder="ხელის მოწერის თარიღი">
								</div>
							</div>
						</div>
					</div>
					<div class="row" id="prepare_row">
						
					</div>

					<div class="row">
						<div class="col-md-10"></div>    
						<div class="col-md-2" style="margin-top: 10px"><h3 id="full_price_text">
							სულ ფასი: 
							<?php if(isset($invoice_items_price)): ?>
								<?php echo e($invoice_items_price); ?>

							<?php else: ?>
								<?php echo e((isset($order->calculated->invoice_amount)) ? ceil($order->calculated->invoice_amount):''); ?>

							<?php endif; ?>
							ლარი</h3></div>
					</div>
					
					<div class="form-group" style="margin-top: 20px;">
						<button type="button" class="btn btn-danger waves-effect text-left" id="add_item_to_invoice">დამატება</button>
					</div>
					
					<div class="form-group" style="margin-top: 20px;">
						<button type="button" class="btn btn-success waves-effect text-left" id="generate_invoice_button">გენერირება</button>
					</div>

					
										
					<script>
						
						$('#generate_invoice_button').on('click', function(){
							formdata = $('#invoice_form').serialize();

							$.ajax({
								type: "GET",
								url: "<?php echo e(route('invoice.prepare')); ?>?sdf=0&"+formdata,
								data:{},
								success: function (response) {
									$('#prepare_row').html(response);
								}
							});

						});
					</script>

				<?php endif; ?>
            </form>

        
    <?php else: ?>
        <h1>განცხადება ჯერ არ დათვლილა</h1>
    <?php endif; ?>
        </div>
    </div>

<script>
    $('#add_item_to_invoice').on('click', function(){
        $('.invoice_row').append($('#items_row').clone());
    });

    quantity_changed = function(event){
        full_price = event.closest('.input-group').find('.invoice_full_price');
        one_price= parseFloat(event.closest('.input-group').find('.invoice_one_price').val())
        quantity = parseFloat(event.val());
        if( quantity>0 && one_price > 0){
            full_price.val(one_price*quantity);
        } else {
            full_price.val(0);
        }
        update_full_price();
    }

    price_changed = function(event){
        full_price = event.closest('.input-group').find('.invoice_full_price');
        quantity = parseFloat(event.closest('.input-group').find('.invoice_quantities').val())
        one_price = parseFloat(event.val());
        if( quantity>0 && one_price > 0){
            full_price.val(one_price*quantity);
        } else {
            full_price.val(0);
        }
        update_full_price();
    }

    function update_full_price(){
        full_prices = $('.invoice_full_price');
        all_price = 0;
        $.each(full_prices, function(index){
            if($(this).val() > 0){
                all_price = all_price + parseFloat($(this).val());
                console.log($(this).val());
            }
        });

        $('#full_price_text').html('სულ ფასი: ' + all_price.toFixed(2) + 'ლარი');
    }

</script>