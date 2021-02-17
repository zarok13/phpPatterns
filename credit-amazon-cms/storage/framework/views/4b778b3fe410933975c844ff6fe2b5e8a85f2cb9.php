<?php ($items = $data['items']); ?>

<table class="table table-hoverable" style="max-width: 100%;">
    <tr style="background: lightgrey">
        <th>დასახელება</th>
        <th>მომწოდებელი</th>
        <th>რაოდ.</th>
        <th>ასაღები ფასი</th>
        <th>გასაყიდი ფასი</th>
        <th>მომწოდებლის ჩარიცხვა</th>
        <th>გაგზავნამდე</th>
        <th>სტატუსი</th>
        <th>?</th>
    </tr>
    
    <?php ($get_price_sum = 0); ?>
    <?php ($sell_price_sum = 0); ?>
    <?php ($item_ids = []); ?>

    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $additionalItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php ($item_ids[] = $additionalItem->id); ?>
        <?php if(!($additionalItem->isset)): ?>            
        <tr  class="itemtr" data-id="<?php echo e($additionalItem->id); ?>" <?php echo ($additionalItem->deleted || in_array($additionalItem->status, [5, 6]) ) ? 'style="background: #ff8484;"' : ''; ?>>
            
            <td  style="max-width: 150px; font-size: 9pt" ><?php echo e($additionalItem->name); ?></td>
            <td>
                <?php if(Entrust::can('tch_edit_item_supplier')): ?>
                    <?php ($suppliers = \App\Models\Supplier::orderBy('name')->select('id', 'name')->get()); ?>
    
                    <select class="supplierIdSelect" data-id="<?php echo e($additionalItem->id); ?>">
                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sup->id); ?>" <?php echo e($additionalItem->supplier_id == $sup->id ? 'selected' : ''); ?>><?php echo e($sup->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php else: ?>
                    <?php ($supplier = \App\Models\Supplier::select('id', 'name')->where('id',$additionalItem->supplier_id)->first()); ?>
                    <?php if($supplier): ?>
                        <?php echo e($supplier->name); ?>

                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td>
                <?php if(Entrust::can('tch_edit_item_quantity')): ?>
                    <input type="text" class="updateQuantity" style="width: 15px"  data-id="<?php echo e($additionalItem->id); ?>" value="<?php echo e($additionalItem->quantity); ?>">
                <?php else: ?>
                    <?php echo e($additionalItem->quantity); ?>

                <?php endif; ?>
            </td>

            
            
            
            <td>
            
                <?php 
                    if(!$additionalItem->deleted && !in_array($additionalItem->status, [5, 6])){
                        $get_price_sum += $additionalItem->get_price * $additionalItem->quantity;
                    }
                ?>
                <?php if(Entrust::can('tch_get_price_edit')): ?> 

                    <input type="text" class="updateGetPrice"  style="max-width: 50px;"  data-id="<?php echo e($additionalItem->id); ?>" 
                        value="<?php echo e($additionalItem->get_price); ?>"> <strong style="font-weight: bold"> <?php echo e($additionalItem->get_price *  $additionalItem->quantity); ?> </strong> 

                <?php elseif(Entrust::can('tch_get_price_view')): ?>
                    <?php echo e($additionalItem->get_price *  $additionalItem->quantity); ?>

                <?php endif; ?>
            </td>



            <td>
            
                <?php 
                    if(!$additionalItem->deleted && !in_array($additionalItem->status, [5, 6])){
                        $sell_price_sum += $additionalItem->sell_price;
                    } 
                ?>
                <?php if(Entrust::can('tch_sale_price_edit')): ?>
                    <input type="text" class="updateSellPrice" style="max-width: 50px;" data-id="<?php echo e($additionalItem->id); ?>" 
                        value="<?php echo e($additionalItem->sell_price); ?>"> <?php echo e($additionalItem->real_sell_price); ?>

                <?php else: ?>
                    <?php echo e($additionalItem->sell_price); ?>

                <?php endif; ?>
                

            </td>
            
            <td>
                <?php if(Entrust::can('tch_edit_supplier_pay')): ?>
                    <select class="supplierpayselect" data-id="<?php echo e($additionalItem->id); ?>">
                        <option value=""></option>
                        <option value="0" <?php echo e($additionalItem->supplier_pay == 0 ? 'selected' : ''); ?>>ჩასარიცხია</option>
                        <option value="1" <?php echo e($additionalItem->supplier_pay == 1 ? 'selected' : ''); ?>>ჩარიცხულია</option>
                    </select>
                <?php else: ?>
                    <?php echo e($additionalItem->supplier_pay == 0 ? 'ჩასარიცხია' : 'ჩარიცხულია'); ?>

                <?php endif; ?>
            </td>
    
            <td>
                <input type="checkbox" class="updatebeforesend" <?php echo e($additionalItem->beforesend == 1 ? 'checked' : ''); ?> name="before_send" data-id="<?php echo e($additionalItem->id); ?>">
            </td>

            <td>
                <?php ($item_statuses = \Config::get('techplus.item_statuses')); ?>
                <?php 
                    $admin_or_accountant = false;
                ?>

                <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'ACCOUNTANT', 'MANAGER'])) : ?>
                    <?php ($admin_or_accountant = true); ?>
                <?php endif; // Entrust::hasRole ?>

                <?php if(Entrust::can('tch_edit_item_status')): ?>
                    <select class="itemStatusSelect" data-item_sell_price="<?php echo e($additionalItem->real_sell_price); ?>" data-id="<?php echo e($additionalItem->id); ?>">
                        <option value="0"></option>
                        <?php $__currentLoopData = $item_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $istatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php ($key = $key +1); ?>
                            <?php
                                // if( ((!$admin_or_accountant) && $pay_method != 99) ) {
                                //     continue;
                                // } else if($key == 6 && !Auth::user()->hasRole(['MANAGER', 'TECHPLUS_MANAGER', 'SUPER_ADMIN'])){
                                //     continue
                                // }
                            ?>
                            <option value="<?php echo e($key); ?>" <?php echo e($additionalItem->status == $key ? 'selected' : ''); ?>><?php echo e($istatus); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php else: ?>
                    <?php echo e($additionalItem->status ? $item_statuses[$additionalItem->status] : 'არ აქვს'); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php if (\Entrust::can('tch_item_edit')) : ?>
                <button class="btn btn-danger editItemButton" data-id="<?php echo e($additionalItem->id); ?>" > <i class="fa fa-pencil"></i> </button>
                <?php endif; // Entrust::can ?>
            </td>
        </tr>
        <?php endif; ?> 

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <tr style="background: lightgrey" >
        <td></td>
        <td></td>
        <td></td>
        <td id="get_price_sum"><?php echo e($get_price_sum); ?></td>
        <td id="sell_price_sum"><?php echo e($sell_price_sum); ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>



<script>
    $(document).ready(function(){

        $('.supplierIdSelect').off('change');
        $('.supplierpayselect').off('change');
        $('.itemStatusSelect').off('change');
        $('.updateSellPrice').off('change');
        $('.updateGetPrice').off('change');
        $('.deleteItemButton').off('click');
        $('.updateQuantity').off('change');
        $('.updatebeforesend').off('change');

        $('.editItemButton').on('click', function(){
            var itemId = $(this).data('id');

            updateItem({id: itemId, generateeditmodal: true}, function(data){
                $('#edit_single_item_modal').remove();
                $('body').append(data);
                $('#edit_single_item_modal').modal('toggle');
            });

        });

        $('.deleteItemButton').on('click', function(){
            var productId = $(this).data('id');

            if(confirm('ნამდვილად გსურთ ამ ნივთის წაშლა?'))
                updateItem({id:productId, delete:1}, function(response){
                    $('#additional_tab').click();
                    // $('tr[data-id="'+productId+'"]').remove();
                });
        });
        $('.supplierIdSelect').on('change', function(){
            var productId = $(this).data('id');
            var supplier_id =  $(this).val();

            updateItem({id:productId, supplier_id:supplier_id});
        });
        $('.supplierpayselect').on('change', function(){
            var productId = $(this).data('id');
            var supplier_pay =  $(this).val();
            if(supplier_pay  == '' ){
                supplier_pay = null;
            }
            
            updateItem({id:productId, supplier_pay:supplier_pay});
        });

        $('.itemStatusSelect').on('change', function(){
            var productId = $(this).data('id');
            var status =  $(this).val();
            
            updateItem({id:productId, status:status});
        });

        $('.updatebeforesend').on('change', function(e){
            var productId = $(this).data('id');
            var old = !$(this).prop('checked');

            if(confirm('დარწმუნებული ხარ რომ გინდათ გაგზავნამდე სტატუსის შეცვლა?')) {
                updateItem({id:productId, beforesend: $(this).prop('checked') ? 1 : 0});
            } else {
                $(this).prop('checked', old);
            }
        });

        $('.updateSellPrice').on('change', function(){
            var productId = $(this).data('id');
            var sellPrice =  $(this).val();
                        
            updateItem({id:productId, sell_price:sellPrice});
        });

        $('.updateQuantity').on('change', function(){
            var productId = $(this).data('id');
            var quantity =  $(this).val();
                        
            updateItem({id:productId, quantity:quantity});
        });

        $('.updateGetPrice').on('change', function(){
            var productId = $(this).data('id');
            var getprice =  $(this).val();
                        
            updateItem({id:productId, get_price:getprice});
        });

        updateItem = function(data, callback = function(data){}){
            
            var sentdata = { w: 1, ...data};
            swal("აირჩიეთ ჩასწორების ხერხი", {
                buttons: {
                    success: {
                        text: "ყველა",
                        value: "multiple"
                    },
                    confirm: {
                        text: "ჩასწორება",
                        value: "single"
                    },
                    danger: {
                        text: "გამოსვლა",
                        value: "not",
                    }
                }
            })
            .then(function(value){
                var cancel = false;
                switch (value) {
                    case "not":
                        var cancel = true;
                    break;
                
                    case "multiple":
                        sentdata.allitem = true;
                    break;

                    case "single": 
                        var allitem = false ;
                    break;  
                }
                
                if(!cancel) {
                    console.log(sentdata);
                    $.ajax({
                        url: '/techplus/requestitem/editsingle',
                        type: 'post',
                        data: sentdata,
                        success: function(response){
                            console.log(response);
                            callback(response);
                            updateRequestStatus();
                            $('#additional_tab').click();
                        }
                    });
                }
            });
            return;
            
        }
        
    });


    updateRequestStatus = function(){
        $.ajax({
            url: '/techplus/request/getstatus',
            type: 'get',
            data: {s:1, request_id: REQUEST_ID},
            success: function(response){
                if(response.name){
                    $('#inner_status_name').html(response.name);
                }
            }
        });
    }
</script>


<style>
    .swal-button--success { background-color: #e6c835 !important; }
    .swal-button--confirm { background-color: #2fa738 !important; }
    .swal-button--danger  { background-color: #e64942 !important; }
</style>