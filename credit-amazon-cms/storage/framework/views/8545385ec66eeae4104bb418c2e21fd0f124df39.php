<?php 
    $button_id = isset($button_id) ? $button_id : 'add_request_button';
    $sites = \App\Models\Site::select('id', 'name')->get();
    $cities = \App\Models\City::select('id', 'name')->orderBy('name', 'ASC')->get();
    $districts = \DB::table('districts')->get();
    $calc = null;
    if(!isset($user_info)) {
        $user_info = (object)[];
    }
?>




<form id="add_request_form">
    <?php if(isset($request_id)): ?>
        <?php ($calc = \App\Models\Calculated::where('request_id', $request_id)->first()); ?>
        <input type="hidden" name="request_id" value="<?php echo e($request_id); ?>">
    <?php endif; ?>
    
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="name">სახელი</label>
                <input type="text" class="form-control" id="create_request_name" name="name" value="<?php echo e(isset($user_info->name) ? $user_info->name : ''); ?>" />
            </div>
            <div class="form-group">
                <label for="name">გვარი</label>
                <input type="text" class="form-control" id="create_request_lastname" name="lastname" value="<?php echo e(isset($user_info->lastname) ? $user_info->lastname : ''); ?>" />
            </div>
            <div class="form-group">
                <label for="name">ტელეფონის ნომერი</label>
                <input type="text" class="form-control" id="create_request_number" name="number" value="<?php echo e(isset($number) ? $number : ''); ?>" />
            </div>
            <div class="form-group">
                <label for="name">ტელეფონის ნომერი 2</label>
                <input type="text" class="form-control" id="create_request_number_2" name="number2" value="<?php echo e(isset($user_info->number2) ? $user_info->number2 : ''); ?>" />
            </div>
            <div class="form-group">
                <label for="name">პირადი ნომერი</label>
                <input type="text" class="form-control" id="create_request_pn" name="pn" value="<?php echo e(isset($user_info->personal_id) ? $user_info->personal_id : ''); ?>" />
            </div>
            
            <div class="form-group">
                <label for="name">ფასი ( <span id="price_label" style="color: red"></span> )</label>
                <input type="text" class="form-control" id="create_request_override_price" name="override_price" value="<?php echo e($calc ? $calc->invoice_amount : ''); ?>" />
            </div>
            
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="name" >დაბადების თარიღი</label>
                <input type="date" class="form-control" id="create_request_birthdate" name="birthdate" value="<?php echo e(isset($user_info->birthdate) ? $user_info->birthdate : ''); ?>" />
            </div>
            <div class="form-group">
                <label for="name" >შენიშვნა</label>
                <textarea id="create_request_text" name="text" class="form-control" ><?php echo e(isset($text) ? $text : ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="name" >წინასწარ შენატანი</label>
                <input type="text" class="form-control" id="create_request_paid_already" name="paid_already" value="<?php echo e(isset($paid_already) ? $paid_already : ''); ?>" />
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">სქესი</label>
                <select id="create_request_gender" name="gender" class="form-control">
                    <option value="f" <?php echo e((isset($user_info->gender) && $user_info->gender == 'f') ? 'selected' : ''); ?>>მდედრობითი</option>
                    <option value="m" <?php echo e((isset($user_info->gender) && $user_info->gender == 'm') ? 'selected' : ''); ?>>მამრობითი</option>
                </select>
            </div>

            <div class="form-group">
                <label for="create_request_pay_method" id="create_request_pay_method_label">გადახდის მეთოდი</label>
                <select id="create_request_pay_method" name="pay_method" class="form-control">
                
                    <?php ($pay_methods = \Config::get('techplus.pay_methods')); ?>
                    <?php $__currentLoopData = $pay_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key > 50): ?>
                            <option value="<?php echo e($key); ?>" ><?php echo e($pm); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </select>
            </div>

            <div class="form-group">
                <label for="name">ქალაქი</label>
                <select id="create_request_city_id" name="city_id" class="form-control" required="" onchange="onCityChangeCGD(event)">
                    <option></option>
                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city->id); ?>" <?php echo e((isset($user_info->city_id) && $user_info->city_id == $city->id) ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div id="district_input_cgd"></div>

            <div class="form-group">
                <label for="name" >მისამართი</label>
                <input type="text" class="form-control" id="create_request_address" name="address" maxlength="50" value="<?php echo e(isset($user_info->address) ? $user_info->address : ''); ?>" />
            </div>
        </div>


        <?php if(isset($edit_links)): ?>
            <div class="col-md-12">
                <?php echo $__env->make('techplus.requests.partials.createRequestModalItems', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="row">
        <div class="col-md-6" style="margin-bottom: 0px;text-align: left">
            <button class="btn btn-success <?php echo e($button_id); ?>" data-only_save="0" >გადატანა</button>
        </div>

        <?php if(!\App\Models\Unipay::where('request_id', isset($request_id) ? $request_id : null)->first()): ?>
        <div class="col-md-6" style="margin-bottom: 0px;text-align: right">
            <button class="btn btn-danger <?php echo e($button_id); ?>" data-only_save="1">მხოლოდ შენახვა </button>
        </div>
        <?php endif; ?>
    </div>
</form>

<script>
    window.addsecondtry = 0;

    var distcgd = `<div class="form-group">
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

    function onCityChangeCGD(){

        var value = $('#create_request_city_id').val();
        if(value == 1){
            $('#district_input_cgd').html(distcgd);
        } else {
            $('#district_input_cgd').html('');
        }
    }
    onCityChangeCGD()


    $(document).ready(function(){
        $('#add_request_form').on('submit', function(e){
            e.preventDefault();
        })

        $('#create_request_override_price').on('blur', function(){
            selector = $(this);
            if(selector.val().length > 2){
                try {
                    $('#price_label').html(selector.val());
                    selector.val(eval(selector.val()));
                } catch (e) {
                    selector.val("");
                    return selector.css('border', '2px solid red');
                }
            }

            selector.css('border', '1px solid #e9ecef');

        });

        $('.<?php echo e($button_id); ?>').on('click', function(e){

            if(parseInt($('#create_request_override_price').val()) > 2){
                $('#create_request_override_price').css('border', '1px solid #e9ecef');
            } else {
                return $('#create_request_override_price').css('border', '2px solid red');
            }

            $('.<?php echo e($button_id); ?>').prop('disabled', true)
            
            var data = get_add_request_form_data();
            data.secondtry = window.addsecondtry;
            data.only_save = parseInt($(this).data('only_save'));

            $.ajax({
                url: '<?php echo e(route('techplus.save.request')); ?>',
                type: 'POST',
                data: data,
                success: function(data){
                    if(data.already){
                        if(confirm('ეს განცხადება დღეს უკვე დაემატა. ნამდვილად გსურT დამატება?')){
                            window.addsecondtry = 1;
                            $('.<?php echo e($button_id); ?>').prop('disabled', false);
                        }
                    } else {
                        <?php echo isset($script) ? $script : ''; ?>

                        console.log(data);
                    }
                }
            });

        });
    });


    get_add_request_form_data = function(){
        var formdata   = $('#add_request_form').serializeArray();
        var data = {};
        
        for(var i=0; i < formdata.length; i++){
            var fd = formdata[i];
            data[fd.name] = fd.value;
        }

        if(typeof FORMITEMS != "undefined"){
            data.items = FORMITEMS;
        }
        if(typeof FORMLINKS  != "undefined"){
            data.links = FORMLINKS;
        }

        return data;
    }
</script>