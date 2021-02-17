<?php ($districts = \DB::table('districts')->get()); ?>

<div class="tab-pane p-20" id="user_info" role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"> <a class="nav-link active show" id="user_info_tab_inner_tab" data-toggle="tab" href="#user_info_tab_inner" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">მომხმარებლის ინფორმაცია</span></a> </li>
        <li class="nav-item"> <a class="nav-link" id="move_to_cgd_tab" data-toggle="tab" href="#move_to_cgd" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">ჩგდ - ს გადატანა </span></a> </li>
        <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER'])) : ?>
        <li class="nav-item"> <a class="nav-link" id="change_password_tab" data-toggle="tab" href="#change_password" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">პაროლის შეცვლა </span></a> </li>
        <?php endif; // Entrust::hasRole ?>
        <li class="nav-item" onclick="refreshPayment()"> <a class="nav-link" id="open_payment_tab" data-toggle="tab" href="#payment_tab" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">გადახდა </span></a> </li>
    </ul>


    <div class="tab-content tabcontent-border">
        <div class="tab-pane active show" id="user_info_tab_inner" role="tabpanel">
            <div class="row">
                <div class="col-md-6 col-md-offset-3" >
                    <?php if(auth()->user()->can('edit-user-info') || auth()->user()->id == 46): ?>
                    
                        <form action="#" id="user_info_form">

                            <input type="hidden" name="updating" value="<?php echo e(isset($order->user_info) ? 1 : 0); ?>">
                            
                            <input type="hidden" name="request_id" value="<?php echo e($order->id); ?>">

                            <div class="form-group" >
                                <label for="name">სახელი</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="user_name" value="<?php echo e(isset($order->user_info) ? $order->user_info->name : ''); ?>">
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="name">გვარი</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="lastname" value="<?php echo e(isset($order->user_info) ? $order->user_info->lastname : ''); ?>">
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="name">ტელეფონის ნომერი</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="number2" value="<?php echo e(isset($order->user_info) ? $order->user_info->number2 : ''); ?>">
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="name">პირადი ნომერი</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="personal_number" value="<?php echo e(isset($order->user_info) ? $order->user_info->personal_id : ''); ?>">
                                </div>
                            </div>


                            <div class="form-group" >
                                <label for="revenue">შემოსავალი</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="revenue" value="<?php echo e(isset($order->user_info) ? $order->user_info->revenue : ''); ?>">
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="name">სქესი</label>
                                <div class="input-group mb-3">
                                    <select name="gender" class="form-control" >
                                        <option value="m" <?php echo e(isset($order->user_info) ? $order->user_info->gender == 'm' ? 'selected': '' : ''); ?>>მამრობითი</option>
                                        <option value="f" <?php echo e(isset($order->user_info) ? $order->user_info->gender == 'f' ? 'selected': '' : ''); ?>>მდედრობითი</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="name">დაბადების თარიღი</label>
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" name="birthdate" value="<?php echo e(isset($order->user_info) ? $order->user_info->birthdate : ''); ?>">
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="name">ქალაქი</label>
                                <div class="input-group mb-3 " id="city_input" onchange="onCityChange(event)">
                                    <select name="city" class="form-control" >
                                        <option></option>
                                        <?php $__currentLoopData = $data['cities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($city->id); ?>" <?php echo e(isset($order->user_info) ? $order->user_info->city_id == $city->id ? 'selected': '' : ''); ?>><?php echo e($city->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div id="district_input"></div>

                            <div class="form-group" >
                                <label for="name">მისამართი</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" maxlength="50" name="address" value="<?php echo e(isset($order->user_info) ? $order->user_info->address : ''); ?>">
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="name">კრედოს კლიენტი</label>
                                <div class="input-group mb-3">
                                    <select name="credo_client" class="form-control" >
                                        <option></option>
                                        <option value="1">კი</option>
                                        <option value="0">არა</option>
                                    </select>
                                </div>
                            </div>

                            
                                
                                <div class="form-group" >
                                    <button type="button" class="btn btn-success waves-effect text-left" id="save_user_data">შენახვა</button>
                                </div>
                                
                            
                        </form>

                    <?php elseif( \Entrust::can('see-user-info') ): ?>

                        <table class="table color-bordered-table dark-bordered-table">
                            <?php if(isset($order->user_info)): ?>
                                <tr><td>სახელი: </td><td><?php echo e(isset($order->user_info->name) ? $order->user_info->name : ''); ?></td></tr>
                                <tr><td>გვარი: </td><td><?php echo e(isset($order->user_info->lastname) ? $order->user_info->lastname : ''); ?></td></tr>
                                <tr><td>პირადი ნომერი: </td><td><?php echo e(isset($order->user_info->personal_id) ? $order->user_info->personal_id : ''); ?></td></tr>
                                <tr><td>სქესი: </td><td><?php echo e(isset($order->user_info->gender) ? $order->user_info->gender == 'm' ? ' მამრობითი' : ' მდედრობითი' :''); ?></td></tr>
                                <tr><td>დაბადების თარიღი: </td><td><?php echo e(isset($order->user_info->birthdate) ? $order->user_info->birthdate :''); ?></td></tr>
                                <tr>
                                    <td>ქალაქი: </td>
                                    <td>
                                        <?php if(isset($order->user_info->city_id)): ?>
                                        <?php $__currentLoopData = $data['cities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($order->user_info->city_id == $city->id): ?>
                                        <?php echo e($city->name); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr><td>მისამართი: </td><td><?php echo e(isset($order->user_info->address) ? $order->user_info->address :''); ?></td></tr>
                            <?php else: ?>
                                <tr><td>ამ მომხმარებელზე დამატებითი ინფორმაცია არ არის შევსებული</td></tr>
                            <?php endif; ?>

                        </table>

                    <?php endif; ?>


                </div>
            </div>
        </div>



        <div class="tab-pane " id="move_to_cgd" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    
                    <?php echo $__env->make('techplus.requests.create_request', [
                        'request_id' => $order->id,  
                        'user_info' => $order->user_info, 
                        "number" => $order->people->number, 
                        'text' => $order->text,
                        'button_id' => 'add_request_button_cgd',
                        'script' => 'movedtotechplus();'
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </div>
            </div>
        </div>

        <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER'])) : ?>
            <div class="tab-pane" id="change_password" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ახალი პაროლი</label>
                            <input type="text" class="form-control" name="new_password" id="new_password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success mt-4" onclick="submitChangePassword()">შეცვლა</button>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                submitChangePassword = function(){
                    $.ajax({
                        url: '<?php echo e(route('operator.changepassword')); ?>',
                        type: 'POST',
                        data: {i: 1, request_id: <?php echo e($order->id); ?>, password: $('#new_password').val() },
                        success: function(data){
                            console.log(data);
                        }
                    });
                }
            </script>
        <?php endif; // Entrust::hasRole ?>



        <div class="tab-pane" id="payment_tab" role="tabpanel">
            <div class="row" id="load-payment-div">
                
            </div>
            <div class="row">
                <div class="col-md-12 no-margin text-right" >
                    <button class="btn btn-primary mt-4" onclick="refreshPayment()">გაახლება</button>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            refreshPayment = function(){
                $.ajax({
                    url: '<?php echo e(route('unipay.load')); ?>',
                    type: 'GET',
                    data: {i: 1, request_id: <?php echo e($order->id); ?> },
                    success: function(data){
                        $('#load-payment-div').html(data);
                    }
                });
            }

            createUnipayOrder = function(e){
                e.preventDefault();
                var form = $(e.target)
                var serialized = form.serialize();
                $.ajax({
                    url: '<?php echo e(route('unipay.create')); ?>?i=1&' + serialized,
                    type: 'GET',
                    success: function(data){
                        console.log(data)
                        refreshPayment();
                        $('#close_modal_button').show();
                    }
                });
            }

        </script>


    </div>
        
</div>


<script>
    $(document).ready(function(){
        $('#move_to_cgd_tab').click(function(){
            $('.modal-footer').hide();
        });
        $('#user_info_tab_inner_tab').click(function(){
            $('.modal-footer').show();
        });

    })

    var dist = `<div class="form-group" id="district-input">
        <label for="name">უბანი</label>
        <div class="input-group mb-3">
            <select name="district_id" class="form-control" >
                <option></option>
                <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($district->id); ?>" <?php echo e(isset($order->user_info) ? $order->user_info->district_id == $district->id ? 'selected': '' : ''); ?>><?php echo e($district->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>`;

    movedtotechplus = function(){
        window.status_saved = true;
        MAIL_STATUS_CHANGED_AS_APPROVED = true;
        window.not_responding_request = false;
        window.status_saved = true; 
        $('#close_modal_button').css('display', 'inline-block');      
        $('#close_request_x').css('display', 'block');
        clearInterval(window.counter_timer);
    }

    function onCityChange(){
        var value = $('#city_input').val();
        if(value == 1){
            $('#district_input').html(dist);
        } else {
            $('#district_input').html('');
        }
    }
    onCityChange()
</script>