<?php $order = $data['order'][0];  
    $added_by = App\Models\CreditAmazon\Log::where('added_request', $order->id)
        ->with('addedByUser')->first();
    if($added_by) $added_by = $added_by->addedByUser->name;
?>
<input type="hidden" id="request_id_input" value="<?php echo e($order->id); ?>">
<script>var NUMBER = '<?php echo e($order->people->number); ?>';</script>


<div class="modal-dialog modal-lg"  style="max-width: 80%; min-width: 80% !important">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                <?php echo e($order->people->name); ?>, <?php echo e($order->people->number); ?> 

                <?php if( (int) $order->view_form2 != 0): ?>
                <span class="badge badge-danger">&nbsp;&nbsp;&nbsp;ჩგდ&nbsp;&nbsp;&nbsp;</span>
                    <?php if(count(explode(' | ', $order->text)) > 1): ?>
                    <span class="badge badge-danger">&nbsp;&nbsp;&nbsp;<?php echo e(explode(' | ', $order->text)[0]); ?>&nbsp;&nbsp;&nbsp;</span>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if($has_items): ?> 
                <span class="badge badge-danger">&nbsp;&nbsp;&nbsp;ნივთები გადატანილია&nbsp;&nbsp;&nbsp;</span>
                <?php endif; ?>
                
                <?php if($order->priority == 5): ?> 
                <span class="badge badge-danger">&nbsp;&nbsp;&nbsp;კრედო&nbsp;&nbsp;&nbsp;</span>
                <?php endif; ?>
                
                <?php if(\Auth::user()->hasRole(['MANAGER', 'SUPER_ADMIN'])): ?>
                    <?php if($added_by): ?> 
                    <span class="badge badge-success">&nbsp;&nbsp;&nbsp;<?php echo e($added_by); ?>&nbsp;&nbsp;&nbsp;</span>
                    <?php endif; ?>

                    <?php if($order->deleted >= 4): ?>
                    <button class="btn btn-success btn-xs" onclick="restoreRequest(<?php echo e($order->id); ?>)">აღდგენა</button>
                    <?php endif; ?>
                <?php endif; ?>
            </h4>

            <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER', 'TECHPLUS_OPERATOR'])) : ?>
                <?php echo $__env->make('partials.open_modal.edit-request-color', ['color' => $order->color], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('partials.open_modal.change-ganvadeba-or-cgd', ['is_ganvadeba' => $order->is_ganvadeba], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; // Entrust::hasRole ?>
            <?php echo $__env->make('partials.open_modal.change-company', ['company' => $order->company], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            
            <button type="button" class="close" id="close_request_x"  onclick="close_modal(<?php echo e($order->id); ?>)" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">            
                <div class="col-md-12 noMargin">
                        
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#request" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">შეკვეთა + ლინკები</span></a> </li>
                        
                        <?php if (\Entrust::can('see-comments')) : ?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#comments" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">კომენტარები</span></a> </li>
                        <?php endif; // Entrust::can ?>
                        
                        <?php if (\Entrust::can('see-calculator')) : ?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#calculator" onclick="get_calculator('#calculator')" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">კალკულატორი</span></a> </li>
                        <?php endif; // Entrust::can ?>
                        
                        <?php if (\Entrust::can(['see-user-info', 'edit-user-info'])) : ?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#user_info" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">პირადი ინფორმაცია</span></a> </li>
                        <?php endif; // Entrust::can ?>

                        <?php if (\Entrust::can(['see-request-details', 'edit-request-details'])) : ?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#details_tab" id="details_tab_selector" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">დეტალები</span></a> </li>
                        <?php endif; // Entrust::can ?>

                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#invoice_tab" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">ინვოისი</span></a> </li>

                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sms_tab" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">SMS</span></a> </li>
                    </ul>
  
                    <?php if (\Entrust::hasRole(['OPERATOR'])) : ?>
                    <style>.show_invoice { display: none;}
                    .noMargin{margin-bottom: 0 !important;}</style>
                    <?php endif; // Entrust::hasRole ?>
                    <style>
                    .noMargin{margin-bottom: 0 !important;}</style>


                    <div class="tab-content tabcontent-border">

                        <?php echo $__env->make('operator.request.partials.calculatorTab', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        
                        <?php echo $__env->make('operator.request.partials.commentsTab', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                
                        <?php echo $__env->make('operator.request.partials.userInfoTab', ['editable' => $editable], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        
                        <div class="tab-pane p-20" id="invoice_tab" role="tabpanel" >
                            <?php echo $__env->make('operator.request.generate_invoice', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        
                        <div class="tab-pane p-20" id="sms_tab" role="tabpanel" >
                            <?php echo $__env->make('operator.request.sms_tab', [
                                'number' => $order->people->number
                            ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        

                
                        <?php if (\Entrust::can(['see-request-details', 'edit-request-details'])) : ?>
                            <div class="tab-pane p-20" id="details_tab" role="tabpanel"></div>
                            <script>
                                $(document).ready(function(){
                                    $('#details_tab_selector').on('click', function(){
                                        var request_id = $('#request_id_input').val();
                                        $.ajax({
                                            url: '/operator/request/getdetailstab/' +request_id,
                                            method: 'get',
                                            data: {},
                                            success: function(response){
                                                $('#details_tab').html(response);
                                            }
                                        }) 
                                    });
                                })
                            </script>
                        <?php endif; // Entrust::can ?>


                        <div class="tab-pane active show" id="request" role="tabpanel">
                            <div class="p-10">
                                <table class="table color-bordered-table dark-bordered-table">
                                    <thead>
                                        <tr>
                                            <th>ნომერი</th>
                                            <th>შიდა სტატუსი</th>
                                            <th>თარიღი</th>
                                            <th>ფასი</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($order->id); ?></td>
                                            <td>
                                                <?php ($inner_statuses_array = []); ?>
                                                <?php $__currentLoopData = $order->innerStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inner_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <?php ($parent = ''); ?>

                                                    <?php if (\Entrust::hasRole(['MANAGER', 'SIGNATURE_OPERATOR'])) : ?>
                                                        <?php if($inner_status->id == 18): ?>
                                                            <?php (\App\Models\RequestInnerStatus::where('request_id', $order->id)->update([
                                                                'opened' => \Illuminate\Support\Facades\DB::raw('opened + 1')
                                                            ])); ?>
                                                        <?php endif; ?>
                                                    <?php endif; // Entrust::hasRole ?>
                                                    
                                                    <?php (array_push($inner_statuses_array, $inner_status->id)); ?>
                                                    
                                                    <?php if((int)$inner_status->parent_id): ?>
                                                        
                                                        <?php ($parent = \App\Models\InnerStatus::find($inner_status->parent_id)); ?>
                                                    <?php endif; ?>
                                                    <?php ($parent_name = isset($parent->name)?$parent->name:''); ?>
                                                    <?php echo e($parent_name.','.$inner_status->name); ?> </br>

                                                    <?php ($parent_status_javascript = isset($parent->id) ? $parent->id : 0 ); ?> 
                                                    <?php ($child_status_javascript = isset($inner_status->id) ? $inner_status->id : 0); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td><?php echo e($order->date); ?></td>
                                            <td><?php echo e($order->price); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <?php echo $__env->make('operator.request.partials.urls', ['urls' => $order->url, 'id' => $order->id], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo $__env->make('operator.request.partials.notification', ['id' => $order->id, 'notifications' => $data['notifications']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                

                                
                                <div class="col-md-12 noMargin" style="padding: 10px 0 0 0; ">
                                    <h4 class="card-title" style="font-weight: bold;">შენიშვნა</h4>
                                    <textarea style="border: 2px solid grey;resize: vertical;" name="order_text" placeholder="ცარიელია" id="order_text" class="form-control"><?php echo e($order->text); ?> </textarea>
                                    <button id="save_order_text" class="btn btn-info" >შენიშვნის შენახვა</button>
                                </div>

                                <table class="table color-bordered-table dark-bordered-table">
                                    <tbody>
                                        <tr>
                                            <td>სახელი: </td>
                                            <td><?php echo e($order->people->name); ?></td>
                                        </tr>
                                        <tr>
                                            <td>ნომერი: </td>
                                            <td><?php echo e($order->people->number); ?></td>
                                        </tr>
                                        <tr>
                                            <td>ელ-ფოსტა: </td>
                                            <td><?php echo e($order->people->email); ?></td>
                                        </tr>
                                        <tr>
                                            <td>nickname: </td>
                                            <td><?php echo e($order->people->nickname); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

     <?php if (\Entrust::can('see-old-requests')) : ?>
                                <div id="olRequestDiv"></div>
                                <script>
                                    $(document).ready(function(){
                                        window.preloader = false;

                                            $.ajax({
                                                type: "GET",
                                                url: "/operator/oldrequests/<?php echo e($order->people->number); ?>/<?php echo e($order->id); ?>",
                                                success: function (response) {
                                                    $('#olRequestDiv').html(response);           
                                                }
                                            });
                                        window.preloader = true;

                                        
                                    })
                                </script>
        <?php endif; // Entrust::can ?>                 

                            </div>
                        </div>






    
    
    



                        



    
                    </div>
                </div>
            </div>
        </div>


        <?php if($editable): ?>
        <div class="modal-footer">

            
            
            <?php if (\Entrust::can(['change-inner-status'])) : ?>
                <?php $hidden_statuses = []; ?>
                <?php ($allowed_statuses = []); ?>
                <?php if (\Entrust::hasRole('OPERATOR')) : ?>
                    <?php $allowed_statuses = Config::get('my.allowed_statuses') ?>
                <?php endif; // Entrust::hasRole ?>
                
                <div class="col-md-4">
					
                    <div class="form-group">
                        <label for="name">შიდა სტატუსი:</label>
                        <div class="input-group mb-3">
                            <select class="form-control" id="inner_status_select_parent">
                                <option value="0"></option>                                                    
                                <?php if(count($allowed_statuses) > 0): ?>
                                    <?php $__currentLoopData = $data['innerstatuses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(in_array($inner->id, $allowed_statuses)): ?>
                                            <?php if((int)$inner->parent_id == 0): ?>)
                                            <option <?php echo e(isset($order->innerStatus[0]->id) ? $inner->id == $order->innerStatus[0]->id ? 'selected' : '' :''); ?>  value="<?php echo e($inner->id); ?>"><?php echo e($inner->name); ?></option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php $__currentLoopData = $data['innerstatuses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(((int)$inner->parent_id == 0)): ?>
                                        <option <?php echo e(isset($order->innerStatus[0]->id) ? $inner->id == $order->innerStatus[0]->id ? 'selected' : '' :''); ?>  value="<?php echo e($inner->id); ?>"><?php echo e($inner->name); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                           
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">შიდა სტატუსი: </label>
                        <div class="input-group mb-3">
                            <select class="form-control" multiple="multiple" size="4" name="inner_status" id="inner_status_select">
                                
                            </select>
                        </div>
                    </div>
				</div>
				
				<div class="form-group smsArea" style="display: none;">
					<?php 
    					$phone_number_for_sms = preg_replace("/[^0-9,.]/", "", $order->people->number);
					?>
					<input type="hidden" name="phone_number" id="sms_phone_number" value="<?php echo e($phone_number_for_sms); ?>">
					<textarea style="border: 2px solid grey;"  name="sms_text" placeholder="ცარიელია" id="sms_text_val" class="form-control">Gikavshirdebodat Citrus.ge operatori. Gtxovt daelodet shemdeg zars an dagvikavshirdit nomerze <?php echo e(\Auth::user()->number); ?>.</textarea>
					<button id="send_sms" class="btn btn-info" >გაგზავნა</button>
				</div>



				<?php ($edit = true); ?>
                <?php if( isset($order->innerStatus[0]->id) ): ?>
					<input type="hidden" id="old_status_value" value="<?php echo e($order->innerStatus[0]->id); ?>">
					
                    <?php 
                    if(in_array($order->innerStatus[0]->id, [18, 19, 20, 21, 22, 29, 38]) && \Auth::user()->hasRole('OPERATOR')){
                        $edit = false;
                    } ?>
                    <script>
                        window.has_status_already = true;
                    </script>
                <?php else: ?> 
                    <script>
                        window.has_status_already = false;
                    </script>
                <?php endif; ?>
            <?php endif; // Entrust::can ?>

            <?php if (\Entrust::can(['edit-request'])) : ?>
				<?php if($editable): ?>
                    <button type="button" class="btn btn-success waves-effect text-left" id="edit_request_status">შენახვა</button>
                <?php endif; ?>
            <?php endif; // Entrust::can ?>

            <button type="button" class="btn btn-danger waves-effect text-left" id="close_modal_button" onclick="$('#refresh_calls').click()" style="display: none" data-dismiss="modal">დახურვა</button>
        </div>
        <?php endif; ?>


    </div>
</div>





<?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER', 'SIGNATURE_OPERATOR', 'TECHPLUS_MANAGER', 'TECHPLUS_OPERATOR', 'TECHPLUS'])) : ?>
<script>
    status_saved = true;
</script>
<?php endif; // Entrust::hasRole ?>
<?php if (\Entrust::hasRole('OPERATOR')) : ?>
<script>
    status_saved = false;
</script>
<?php endif; // Entrust::hasRole ?>



<script>
    window.talk_time = 0;
    window.notification = false;
    window.counter_timer = setInterval(function(){
        window.talk_time++;
    }, 1000);
</script>




<script>
    <?php if($editable): ?>
        var editable = true;
    <?php else: ?>
        var editable = false;
    <?php endif; ?>

	window.incomplete = false;
    var parent_status = <?php echo isset($parent_status_javascript) ? json_decode($parent_status_javascript):0; ?>; 
    var child_status = <?php echo isset($child_status_javascript) ? json_decode($child_status_javascript):0; ?>; 
    
    $(document).ready(function(){

        if(!editable) {
            $('.add_link').hide();
            $('.add_request_button').attr('disabled', true);
        }

        $('#inner_status_select').on('change', function(){
            status = $(this).val();
            if(status == 12){
                $('.show_invoice').css('display', 'block');
            } else {
                $('.show_invoice').css('display', 'none');
			}
            if(status == 15 || status == 43){
                $('.smsArea').css('display', 'block');
            } else {
                $('.smsArea').css('display', 'none');
			}
            // $.each(destroy_items, function(id, item){
            //     destroy_ids[id] = $(item).val();
            // });
        });

        $('#inner_status_select_parent').on('change', function(){
            $.ajax({
                type: "GET",
                url: "/get_status_children/",
                data: {
                    ss: "s", 
                    inner_status: $(this).val(), 
                },
                success: function (response) {
                    html = '';
                    $('#inner_status_select').empty();

                    $.each(response, function(id, stat){
                        html+='<option value="'+stat.id+'">'+stat.name+'</option>';
                    });

                    $('#inner_status_select').html(html);
                    // $('#inner_status_select').val(1);
                    if(child_status > 0){
                        $('#inner_status_select').val(child_status).change();
                    }
                }
            });
        });


		$('#send_sms').on('click', function(){
			var phone_number = $('#sms_phone_number').val();
			var sms_text = $('#sms_text_val').val();
			var request_id = $('#request_id_input').val();
			
			$.ajax({
				type: "GET",
				url: "/operator/sms/sendsms",
				data: {
					ss: "s", 
					phone_number: phone_number, 
					sms_text: sms_text,
					request_id: request_id
				},
				success: function (response) {
					console.log(response);
					swal('სმს წარმატებით გაიგზავნა');
				}
			});
		});

        if(parent_status > 0){
            $('#inner_status_select_parent').val(parent_status).change();
        }


        title_div = $('#myLargeModalLabel');
        if('transfer_text' in window){
            if(window.transfer_text.length > 1) {
            title_div.html(title_div.html() + ' ______ შენიშვნა :' + window.transfer_text);
            window.transfer_text = '';
        }
        }
        
    });

    var rejected_statuses = <?php echo e(json_encode(\Config::get('my.rejected_statuses'))); ?>;
    
    enableSubmit = function(){
        $('#edit_request_status').attr("disabled", false);
    }

    $('#edit_request_status').on('click', function(){
        $(this).attr("disabled", true);
        setTimeout(function() { enableSubmit() }, 5000);

        destroy_items = $('.destroy_this');
        destroy_ids = [];
        $.each(destroy_items, function(id, item){
			if($(item).val() == 40){
				window.incomplete = true;
			}
            destroy_ids[id] = $(item).val();
        });
        
        // თუ რომელიმე სტატუსი აქვს მონიშნული
        inner_status_val = $('#inner_status_select').val();
        old_status_val = $('#old_status_value').val();
        
        if(inner_status_val[0] && [16, 40, 56].indexOf(parseInt(inner_status_val[0])) != -1 && !window.notification ) {
            return swal("ამ სტატუსის მოსანიშნად აუცილებელია შეხსენების დაყენება");
        }

        if(!(inner_status_val == '' || inner_status_val ==null || inner_status_val ==0) ){
            $('#save_items_button').click();

            save_user_data(function(){
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('operator.edit_request_status')); ?>",
                    data: {
                        inner_status: inner_status_val, 
                        order_id: $('#request_id_input').val(), 
                        order_text: $('#order_text').val(),
                        destroy_ids: destroy_ids,
                        talk_time: window.talk_time,
                        old_status: old_status_val,
                        notification: window.notification ? 1 : 0
                    },
                    success: function (response) {
                        MAIL_STATUS_CHANGED_AS_APPROVED = true;
                        window.not_responding_request = false;
                        window.status_saved = true; 
                        $('#close_modal_button').css('display', 'inline-block');      
                        $('#close_request_x').css('display', 'none');
                        clearInterval(window.counter_timer);
                    }
                });
            });
            

        //თუ არცერთი სტატუსი არ არის მონიშნული
        } else {
            $('#inner_status_select').css('border', '2px solid red');
            console.log(inner_status_val);
            swal("შენახვამდე გთხოვთ მონიშნოთ სტატუსი ან დახურეთ განცხადება!");
        }
    });



    $('#close_request_x, #close_modal_button').on('click', function(){
        $.ajax({
            type: "POST",
            url: "<?php echo e(route('operator.close-time')); ?>",
            data: {
                i:1,e:2,
                request_id: $('#request_id_input').val(), 
            },
        });
    });

    
    


    // იღებს ინფორმაციას მომხმარებლის ფორმიდან და ინახავს
    // თუ რომელიმე ველი ცარიელია მაშინ არ ინახავს
    function save_user_data(callback = function(){return 0 ;} ){
        var inner_status_val = $('#inner_status_select_parent').val();

        var saved = {error: false};
        var formdata = get_form_data_true('#user_info_form', {credo_client: true});
        if(formdata != 0){
            $.ajax({
                type: "POST",
                url: "/operator/user/save",
                data: formdata,
                success: function (response) {
                    callback();
                },
                error: function(){
                    alert('გადაამოწმეთ პირადი ინფორმაციის ველი');
                }
            });
        } else {
            if(inner_status_val == 9 ) {
                alert('გადაამოწმეთ პირადი ინფორმაციის ველი!');
            } else {
                callback();
            }
        }
    }
    




    //ეს ეშვება მაშიცა მომხმარებლის ინფორმაციის ტაბში ვაჭერთ შენახვას
    $('#save_user_data').on('click', function(){
        save_user_data();
    });

    $('#save_order_text').on('click', function(event){
        event.preventDefault();
        var order_id = $('#request_id_input').val();
        var order_text = $('#order_text').val();
        $.ajax({
            type: "POST",
            url: "/operator/request/saveordertext",
            data: { request_id: order_id, order_text: order_text},
            success: function (response) {
                
            }
        });
    });



    function just_unlock(){
        order_id = $('#request_id_input').val();
        $.ajax({
            type: "POST",
            url: "<?php echo e(route('operator.request.close')); ?>",
            data: { request_id: request_id, oldrequests: unlock_ids, just_unlock: 'true'},
            success: function (response) {
                console.log(response);
                clearInterval(window.counter_timer);

            }
        });
    }



    //რექუესტის დახურვა: რექუესტს განბლოკავს და მოდალსაც დახურავს
    function close_request(request_id){
		if(window.incomplete || $('#inner_status_select_parent').val() == 40){
        	$('#View_Modal').modal('toggle');
			return;
		}
        unlock_items = $('.destroy_this');
        unlock_ids = [];
        $.each(unlock_items, function(id, item){
            unlock_ids[id] = $(item).val();
        });
        
        $.ajax({
            type: "POST",
            url: "<?php echo e(route('operator.request.close')); ?>",
            data: { request_id: request_id, oldrequests: unlock_ids},
            success: function (response) {
                console.log(response);
                window.not_responding_request = false;                

                clearInterval(window.counter_timer);
            }
        });
        
        $('#View_Modal').modal('toggle');
    }


    function confirmAndClose(request_id) {
        if(confirm('დარწმუნებული ხართ რომ გსურთ ამ განაცხადის დახურვა?')) {
            close_request(request_id);
        }
    }


    //თუ სტატუსი არ შეცვლილა მაშინ არ დაახურინებს
    function close_modal(request_id){
        if(!editable) {
            return confirmAndClose(request_id);
        }
        
        
        inner_status_val = $('#inner_status_select').val();
        old_status = $('#old_status_value').val();
        
        if(window.status_saved || window.has_status_already){
            if(window.has_status_already && !window.status_saved){
                swal({
                    title: "დახურვა",   
                    text: "ნამდვილად გსურთ და. ნამდვილად გსურთ დახურვა?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "დიახ!",   
                    cancelButtonText: "არა!",   
                    closeOnConfirm: true,   
                    closeOnCancel: true 
                }, function(isConfirm){   
                    if (isConfirm) {
                        console.log('here');
                        if(!window.not_responding_request){
                            close_request(request_id);
                            $('#refresh_calls').click();
                        } else {
                            swal({
                                title: "დახურვა",   
                                text: "სანამ სტატუსს არ მიანიჭებთ არ იღებს ან სხვა სტატუსს იქამდე განაცხადს ვერ დახურავთ",   
                                type: "warning",   
                                showCancelButton: true,   
                                confirmButtonColor: "#DD6B55",   
                                closeOnConfirm: true,   
                                closeOnCancel: true 
                            }, function(isConfirm){return});
                        }     
                    
                    } else {     
                        return;
                    } 
                });
            } else {
                close_request(request_id);    
            }
            
        } else {
            // close_request(request_id);
            if(!window.has_status_already){
                swal("სტატუსის შეცვლის გარეშე ამ განცხადებას ვერ დახურავთ!");
            }
        }



    }


    //
    $('#merge').on('click', function(event){
        event.preventDefault();
        var Ids = [];
        
        $("input[name='merged[]']").each( function (){
            if($(this).prop('checked') == true)
                Ids.push( $( this ).val() );
        });
        console.log(JSON.stringify(Ids));
        $.ajax({
            type: "POST",
            url: "/operator/request/merge",
            data: {Ids, request_id: $('#request_id_input').val() } ,
            success: function (response) {
                $('#View_Modal').html(response);
            }
        });
        
    });


    function refresh(){
        order_id = $('#request_id_input').val();
        $.ajax({
            type: "GET",
            url: "/operator/showOrder/"+order_id+'/',
            data: order_id,
            success: function (response) {
                $('#View_Modal').html(response);
            }
        }); 
    }

    function see_another(order_id){
        request_id = $('#request_id_input').val();
        $.ajax({
            type: "POST",
            url: "<?php echo e(route('operator.request.close')); ?>",
            data: { request_id: request_id },
            success: function (response) {
                console.log(response);
            }
        });
        
        $.ajax({
            type: "GET",
            url: "/operator/showOrder/"+order_id+'/',
            data: order_id,
            success: function (response) {
                $('#View_Modal').html(response);
            }
        });
    }
    




    
    function get_form_data(form){
        var unindexed_array = $(form).serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            if(n['value'] == "" || n['value']=='undefined' || n['value']==null){
            } else {
                $('[name="'+n['name']+'"]').css('border', '1px solid #e9ecef');
                indexed_array[n['name']] = n['value'];
            }
        });

        return indexed_array;
    }

    function get_form_data_true(form, unrequired_fields = {}){
        var unindexed_array = $(form).serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            if((n['value'] == "" || n['value']=='undefined' || n['value']==null) && unrequired_fields[n['name']] == undefined){
                $('[name="'+n['name']+'"]').css('border', '2px solid red');
                return indexed_array = 0;
            } else {
                $('[name="'+n['name']+'"]').css('border', '1px solid #e9ecef');
                indexed_array[n['name']] = n['value'];
            }
        });

        return indexed_array;
    }

    function restoreRequest(request_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo e(route('operator.restorerequest')); ?>',
            data: {i: 1, request_id: request_id},
            success: function(data){
                console.log(data)
            }
        })
    }

</script>

<?php if (\Entrust::can('generate-invoice')) : ?>
    <script>
        $(document).ready(function(){
            // show_invoice();
        });
    </script>        
<?php endif; // Entrust::can ?>