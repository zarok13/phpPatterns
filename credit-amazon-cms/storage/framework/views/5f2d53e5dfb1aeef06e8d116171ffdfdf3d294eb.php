<?php ($order = $data['request']); ?>

<?php if(isset($order->calculated)): ?>
<?php $cal = $order->calculated; ?>

<div style="text-align: right; margin-bottom: 15px">
    
<?php if (\Entrust::can(['save_details', 'save_delivery_details'])) : ?>
<button class="btn btn-success save_request_details" id="save_details">შენახვა</button>
<?php endif; // Entrust::can ?>
<?php if (\Entrust::can(['save_details'])) : ?>
<button class="btn btn-success" id="move_techplus">ტექპლუსზე გადატანა</button>
<?php endif; // Entrust::can ?>
</div>

<form action="#" id="detail_form">
	<input type="hidden" name="calculated_id" value="<?php echo e($cal->id); ?>">
	
	<input type="hidden" name="saved" value="1">
	
    <table class="table dark-bordered-table">
        <tr><td>ინვოისის თანხა</td>            <td><input style="border-radius: 3px" type="text" name="invoice_amount" value="<?php echo e(isset($cal->invoice_amount)?$cal->invoice_amount : '0'); ?>"></td></tr>
        <tr><td>ფასდათმობა</td>                
            <td>
                <input style="border-radius: 3px" type="text" name="sale" value="<?php echo e(isset($cal->sale)?$cal->sale : '0'); ?>">
                <label for="sale" id="sale_label"></label> <br> 
            </td>
        </tr>
        <tr><td>გადახდილი თანხა</td>            
            <td style="display: flex">
                <input style="border-radius: 3px" id="paid_money_input" type="text" name="paid_money" value="<?php echo e(isset($cal->paid_money)?$cal->paid_money : '0'); ?>">
                <label for="paid_money" id="paid_money_label"></label> &nbsp;&nbsp; 
                <button type="button" href="#" class="btn btn-success btn-xs" onclick="
                    event.preventDefault();
                    $('#paid_money_input').val($('#paid_money_input').val().indexOf('0.8') == -1 ? $('#paid_money_input').val() + '*0.8' : $('#paid_money_input').val())
                    $(event.target).hide();
                    $('#inline_save_button').show();
                    calculateProfit();
                ">x0.8</button>
                <button type="button" href="#" class="btn btn-success btn-xs save_request_details" onclick="
                    event.preventDefault();
                    $('#inline_save_button').hide();
                " id="inline_save_button" style="display: none">შენახვა</button>
            </td>
        </tr>
        <tr><td>ფასი</td>                      <td><input style="border-radius: 3px" type="number" name="price" value="<?php echo e(isset($cal->price)?$cal->price : '0'); ?>"></td></tr>
        <tr>
            <td>მიტანა</td>                    
            <td>
                <input style="border-radius: 3px" type="text" name="delivery" value="<?php echo e(isset($cal->delivery)?$cal->delivery : '0'); ?>">
                ₾ <input type="checkbox" name="delivery_cur_usd" <?php echo e($cal->delivery_cur_usd ? 'checked' :''); ?> id="changeDelivCur"> 
                <label for="paid_money"  id="delivery_label"></label>
                <br> 
            </td>
        </tr>
        <tr>
            <td>განბაჟება</td>
            <td>
                <input style="border-radius: 3px" type="text" name="tax" value="<?php echo e(isset($cal->tax)?$cal->tax : '0'); ?>">
                ₾ <input type="checkbox" name="tax_cur_usd" <?php echo e($cal->tax_cur_usd ? 'checked' :''); ?> id="changeTaxCur"> 
                <label for="tax" id="tax_label"></label> <br> 
            </td>
        </tr>
        <tr>
            <td>Nova ფოსტა</td>
            <td>
                <input style="border-radius: 3px" type="text" name="nova_post" value="<?php echo e(isset($cal->nova_post)?$cal->nova_post : '0'); ?>">
            </td>
        </tr>
        <tr><td>მოგება</td>                    
            <td>
                <input style="border-radius: 3px" type="text" name="profit" value="<?php echo e(isset($cal->profit)?$cal->profit : '0'); ?>">
                <label for="profit">დღგ-ს ჩათვლით</label> <br> 
                <input type="text" name="profit_tax" value="0">
                <label for="profit">დღგ-ს გარეშე</label>           
            </td>
        </tr>
    
        <tr><td>მარჟა</td>                     
            <td>            
                <input style="border-radius: 3px" type="text" name="profit_percent" value="<?php echo e(isset($cal->profit_percent)?$cal->profit_percent : '0'); ?>">
                <label for="profit_percent">(%)დღგ-ს ჩათვლით </label> <br> 
                <input type="text" name="profit_percent_tax" value="0">
                <label for="profit_percent_tax">(%)  დღგ-ს გარეშე </label> <br> 
            </td>
        </tr>
    

        <tr><td>ბანკი</td>                     
            <td>
                <select name="bank" id="cal_bank">
                    <?php $__currentLoopData = $data['banks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($bank->id); ?>" <?php echo e(isset($cal->banks) ? $cal->banks->id == $bank->id ? ' selected' : '' :''); ?> ><?php echo e($bank->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
        </tr>
        <tr><td>თვეების რაოდენობა</td>         <td><input style="border-radius: 3px" type="number" name="month" value="<?php echo e(isset($cal->month)?$cal->month : '0'); ?>"></td></tr>
        
        
        <tr><td>ტექპლიუსის ჩარიცხვა</td>                     
            <td>
                <select  name="cred_pay" id="cred_pay">
                    <option value="0" <?php echo e($cal->cred_pay == 0 ? 'selected' : ''); ?>>ჩასარიცხია</option>
                    <option value="1" <?php echo e($cal->cred_pay == 1 ? 'selected' : ''); ?>>ჩარიცხულია</option>
                </select>
            </td>
        </tr>

        <tr><td>საიტი</td>                     
            <td>
                <select name="site" id="cal_site">
                    <?php $__currentLoopData = $data['sites']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($site->id); ?>" <?php echo e(isset($cal->sites) ? $cal->sites->id == $site->id ? ' selected' : '' :''); ?> ><?php echo e($site->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
        </tr>

        <tr><td>კალკულაციის თარიღი</td>        <td><input style="border-radius: 3px" type="text" name="date" value="<?php echo e(isset($cal->date)?$cal->date : '0'); ?>"></td></tr>
        <tr id="tracking_tr">
			<td>ტრეკინგ კოდი <a href="#" id="add_tracking">დამატება</a></td>
			<td id="tracking_input_fileds">
				<span class="tracking_to_delete">
					<?php if(isset($cal->tracking)): ?>
						<?php ($exploded = explode('|', $cal->tracking)); ?>
						<?php $__currentLoopData = $exploded; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tracking_date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php ($exp = explode('%', $tracking_date)); ?>

							<input style="border-radius: 3px" type="text" name="tracking[]" value="<?php echo e(!isset($exp[0])?:$exp[0]); ?>" placeholder="ტრეკინგ კოდი">
							<input type="date" name="tracking_date[]" placeholder="ჩამოსვლის თარიღი" value="<?php echo e(!isset($exp[1])?:$exp[1]); ?>">
							<a href="#" class="delete_tracking">წაშლა</a>
							<br>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<input style="border-radius: 3px" type="text" name="tracking[]" placeholder="ტრეკინგ კოდი">
						<input type="date" name="tracking_date[]" placeholder="ჩამოსვლის თარიღი">
						<a href="#" class="delete_tracking">წაშლა</a>
						<br>
					<?php endif; ?>
				</span>
			</td>
		</tr>
        <tr><td>ინვოისის ნომერი</td>           <td><input style="border-radius: 3px" type="text" name="invoice_number" value="<?php echo e(isset($cal->invoice_number)?$cal->invoice_number : '0'); ?>"></td></tr>
        <tr><td>თანხის სტატუსი</td>           
            <td>
                <select name="pay_status" id="pay_status">
                    <option value="1" <?php echo e(($cal->pay_status)?'selected' : ''); ?>>ჩარიცხულია</option>
                    <option value="0" <?php echo e(!($cal->pay_status)?'selected' : ''); ?>>ჩასარიცხია</option>
                </select>
            </td>
        </tr>
        <tr><td>ხელშეკრულების სტატუსი</td>           
            <td>
                <select name="agreement_status" id="agreement_status">
                    <option value="0" <?php echo e(($cal->agreement_status == 0)?'selected' : ''); ?>>მოსატანია</option>
                    <option value="1" <?php echo e(($cal->agreement_status == 1)?'selected' : ''); ?>>მოტანილია</option>
                    <option value="2" <?php echo e(($cal->agreement_status == 2)?'selected' : ''); ?>>გაგზავნილია</option>
                </select>
            </td>
        </tr>
        <tr><td>გასაუქმებელია კრისტალი</td>           
            <td>
                <select name="crystal_canceled" id="crystal_canceled">
                    <option value="0" <?php echo e(($cal->crystal_canceled == 0) ? 'selected' : ''); ?>>გადასარიცხია</option>
                    <option value="1" <?php echo e(($cal->crystal_canceled == 1) ? 'selected' : ''); ?>>გადარიცხულია</option>
                </select>
            </td>
        </tr>
            
        <tr><td>განბაჟების სტატუსი</td>        
            <td>
                <select name="tax_status" id="tax_status">
                    <option value="1" <?php echo e(($cal->tax_status)?'selected' : ''); ?>>გადახდილია</option>
                    <option value="0" <?php echo e(!($cal->tax_status)?'selected' : ''); ?>>გადასახდელია</option>
                </select>
            </td>
        </tr>
        
        <tr><td>კურსი</td>                     <td><input style="border-radius: 3px" type="text" name="cur" value="<?php echo e(isset($cal->cur)?$cal->cur : '0'); ?>"></td></tr>

        <tr><td>რეისის ნომერი</td>             <td><input style="border-radius: 3px" type="text" name="flight_number" value="<?php echo e(isset($cal->flight_number)?$cal->flight_number : '0'); ?>"></td></tr>
        <tr><td>წონა</td>                      <td><input style="border-radius: 3px" type="number" name="weight" value="<?php echo e(isset($cal->weight)?$cal->weight : '0'); ?>"></td></tr>
        

        <tr><td>ჩამოსვლის თარიღი</td>       <td><input style="border-radius: 3px" type="date" name="arrival_date" value="<?php echo e(isset($cal->arrival_date)?$cal->arrival_date : ''); ?>"></td></tr>
        <tr><td>დაგვიანების სტატუსი</td>       
            <td>
                <select name="late_status" id="late_status">
                    <option value="1" <?php echo e($cal->late_status?'selected':''); ?>>დაგვიანებულია</option>
                    <option value="0" <?php echo e(!($cal->late_status)?'selected':''); ?>>არ არის დაგვიანებული</option>
                </select>
            </td>
        </tr>
        
        <tr><td>გარანტია</td>                  <td><input style="border-radius: 3px" type="text" name="guarantee" value="<?php echo e(isset($cal->guarantee)?$cal->guarantee : '0'); ?>"></td></tr>
        <tr><td>საკომისიო</td>                 <td><input style="border-radius: 3px" type="text" name="comission" value="<?php echo e(isset($cal->comission)?$cal->comission : '0'); ?>"></td></tr>
        <tr><td>ღირებულება განვადებამდე</td>   <td><input style="border-radius: 3px" type="text" name="cost_before_g" value="<?php echo e(isset($cal->cost_before_g)?$cal->cost_before_g : '0'); ?>"></td></tr>
        <tr><td>ღირებულება საკომისიომდე</td>   <td><input style="border-radius: 3px" type="text" name="cost_before_c" value="<?php echo e(isset($cal->cost_before_c)?$cal->cost_before_c : '0'); ?>"></td></tr>
    </table>

</form>

<div style="display: none" id="tracking_field_template">
	<span class="tracking_to_delete">
		<input style="border-radius: 3px" type="text" name="tracking[]" placeholder="ტრეკინგ კოდი">
		<input type="date" name="tracking_date[]" placeholder="ჩამოსვლის თარიღი">
		<a href="#" class="delete_tracking">წაშლა</a>
		<br>
	</span>
</div>
<style>.delete_tracking{color:red}</style>
<?php else: ?>
<h1>განცხადება ჯერ არ დათვლილა</h1>
<?php endif; ?>
<?php if(isset($order->calculated)): ?>

<script>
    currency = 1;
    var delivcur =1;
    var taxcur =1;
    
    function calculateProfit(){
        // მოგების გამოთვლა
        // ფასდათმობა = ინვოისის თანხა * ბანკის ფასდათმობის საკომისიოზე
        // ინვოისის თანხას - საკომისიო - ფასდათმობა - გადახდილი თანხა - განბაჟება - მიტანა - ნოვა ფოსტა 
        // ცვლადი დღგ-თი
        // ცვლადი დღგ-ს გარეშე
        // მარჟა დღგ-თი
        // მარჟა დღგ-ს გარეშე
        // მიტანა მომაქვს კალკულატორიდან და ვამრავლებ კურსზე
        // განბაჟების გაყოფა კურსზე
        

        //ტრეკინგ კოდი იწერება ხელით
        //ფასდათმობა
        geo_tax_amount = 0.8475;

        invoice_amount = $("input[name='invoice_amount']");
        sale           = $("input[name='sale']");
        tax            = $("input[name='tax']");
        paid_money     = $("input[name='paid_money']"); //ეს არის ფასი PRICE
        delivery       = $("input[name='delivery']");
        nova_post      = $("input[name='nova_post']");
        price          = $("input[name='price']");
        cur            = $("input[name='cur']");
        
        profit         = $("input[name='profit']");
        profit_tax     = $("input[name='profit_tax']");
        profit_percent = $("input[name='profit_percent']");
        profit_percent_tax = $("input[name='profit_percent_tax']");
        
        // pay_status     = $("input[name='pay_status']");
        // tax_status     = $("input[name='tax_status']");
        // price          = $("input[name='price']");
        // guarantee      = $("input[name='guarantee']");
        // cost_before_g  = $("input[name='cost_before_g']");
        // cost_before_c  = $("input[name='cost_before_c']");
        
        
        currency = cur.val().length != 0 ? eval(cur.val()) : 1 ;
        if(parseInt($('#cal_site').val()) > 2){
            currency = 1;
        }
        
        invoice = invoice_amount.val().length != 0 ? eval(invoice_amount.val()) : 0 ;
        sale_amount = sale.val().length != 0 ? eval(sale.val()) : 0 ;
        sale_amount > 0 ? $('#sale_label').html(sale_amount.toFixed(2)):null;
        paid_money_amount = paid_money.val().length != 0 ? eval(paid_money.val()) * currency : 0 ;
        paid_money_amount > 0 ? $('#paid_money_label').html(paid_money_amount.toFixed(2)):null;

        delivery_amount = delivery.val().length != 0 ? eval(delivery.val()) * delivcur : 0 ;
        delivery_amount > 0 ? $('#delivery_label').html( (delivery_amount).toFixed(2) ):null;
        tax_amount = tax.val().length != 0 ? eval(tax.val()) * taxcur : 0 ;
        tax_amount > 0 ? $('#tax_label').html((tax_amount).toFixed(2)):null;
        nova_post_amount = nova_post.val().length != 0 ? eval(nova_post.val()) : 0 ;
        price_amount = price.val().length != 0 ? eval(price.val()) : 0 ;
        
        var income = invoice;
        var expense = sale_amount + paid_money_amount + delivery_amount + tax_amount + nova_post_amount;
        var pro = income - expense;
        
        if(pro != NaN){
            profit.val( (pro).toFixed(2) );
            profit_tax.val( (pro*geo_tax_amount).toFixed(2) )

            if(pro <= 0){
                profit.css('background-color', 'red');
                profit_tax.css('background-color', 'red');
                profit_percent.css('background-color', 'red');
                profit_percent_tax.css('background-color', 'red');
            } else {
                profit.css('background-color', 'inherit');
                profit_tax.css('background-color', 'inherit');
                profit_percent.css('background-color', 'inherit');
                profit_percent_tax.css('background-color', 'inherit');
            }

            profit_percent.val( (pro/income * 100).toFixed(2));
            profit_percent_tax.val( ((pro*geo_tax_amount)/income * 100).toFixed(2));

        } else {
            profit.val(0);
            profit_tax.val(0);
        }
        
        
    }

    $(document).ready(function(){
        
        delivcur =  !$('#changeDelivCur').prop('checked') ? $("input[name='cur']").val() : 1;
        taxcur   =  !$('#changeTaxCur').prop('checked')   ? $("input[name='cur']").val() : 1;
        
        $('#changeDelivCur').on('change', function(){
            var checked = $(this).prop('checked');
            if(checked) {
                delivcur = 1;
            } else {
                delivcur = $("input[name='cur']").val(); 
            }
        
            calculateProfit();
        });
        $('#changeTaxCur').on('change', function(){
            
            var checked = $(this).prop('checked');
            if(checked) {
                taxcur = 1;
            } else {
                taxcur = $("input[name='cur']").val(); 
            }
            
            calculateProfit();
        });

        $("#detail_form" ).keyup(function() {
            calculateProfit();
        });

        calculateProfit();
    });


    
    $('.save_request_details').on('click', function(){
        data = $('#detail_form').serializeArray();
       
        $.ajax({
            type: "POST",
            url: "/ajax/calculated/saveRaw",
            data: data,
            success: function (response) {
                console.log(response);
            }
        });

    });
    $('#move_techplus').on('click', function(){
        data = $('#request_id_input').val();
       
        $.ajax({
            type: "GET",
            url: "/techplus/move/request/"+data,
            data: data,
            success: function (response) {
                console.log(response);
            }
        });

    });


	
</script>



<script>
	$(document).ready(function(){
		$('#add_tracking').on('click', function(event){
			event.preventDefault();
			$('#tracking_input_fileds').append(
				$('#tracking_field_template').html()
			);
			
			$('.delete_tracking').on('click', function(event){
				event.preventDefault();
				if($('.delete_tracking').length > 2){
					$(this).closest('.tracking_to_delete').remove();
				} else alert('ერთი ტრეკინგი მაინც უნდა იყოს');
			});
		});
		
	});
</script>
<?php endif; ?>
