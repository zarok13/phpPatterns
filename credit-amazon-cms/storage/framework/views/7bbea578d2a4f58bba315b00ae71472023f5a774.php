<?php 
    $techplus = $data['order'];    
    $supplier_pay = ['ჩასარიცხი','ჩარიცხული'];
    $rs_status = ['არა','კი'];
    $pay_status = ['ჩასარიცხი','ჩარიცხული'];
    $cred_pay = ['ჩასარიცხი','ჩარიცხული'];
    $return_status = ['', 'უკან დაბრუნება','ზედნადები გაუქმებულია'];

    $pay_method = \Config::get('techplus.pay_methods');
    
    $courier = ['ჩარიცხული', 'ჩასარიცხი'];
    $cities = \App\Models\City::select('id', 'name')->get();
    $crystal_signature = ['მოსატანია', 'მოტანილია', 'გაგზავნილია'];
    $unipay = \App\Models\Unipay::where('request_id', $techplus->request_id)->first();
?>


<?php ($cgd = $techplus->cgd == 1 ? true : false ); ?>
<?php ($user_info = $techplus->request->user_info   ); ?>
<?php ($request = $techplus->request ); ?>
<?php ($calculated = $request->calculated); ?>


<div class="tab-pane p-20 " id="additional" role="tabpanel">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            
            <table class="table">
                <tr>
                    <td>
                        <table> 
                            <tr><td>თარიღი</td><td><?php echo e($techplus->date); ?></td></tr>
                            <tr><td>გასაყიდი ფასი</td><td><?php
                                $invoice_amount = 0;
                                $sale = 0;
                                if($calculated){
                                    $explodedInvoiceAmount = explode('*', $calculated->paid_money);
                                    if(count($explodedInvoiceAmount) == 2){
                                        $multipleTo = 1/(double)$explodedInvoiceAmount[1]; // 0.9 იქნება სავარაუდოდ
                                    } else {
                                        $multipleTo = 1;
                                    }

                                    eval('$invoice_amount = (float)'.$calculated->paid_money.';');   

                                    $sale = $invoice_amount * $multipleTo - $invoice_amount;
                                }
                            ?>
                            
                            
                            <?php if(Entrust::can('tch_invoice_amount_edit')): ?>
                            <input class="form-control" type="text" id="invoice_amount_paid_money" value="<?php echo e($invoice_amount); ?>">
                            <?php else: ?>
                            <?php echo e($invoice_amount); ?>

                            <?php endif; ?>
                            
                            
                            </td></tr>
                            
                            <?php if($unipay): ?>
                            <tr><td>Unipay</td><td><span style="font-weight: bold"><?php echo e($unipay->hash); ?></span> / <?php echo e($unipay->status); ?></td></tr> 
                            <?php endif; ?>

                            <?php if(Entrust::can('tch_profit_tax_view')): ?>
                            <tr><td>მოგება დღგ-ს გარეშე</td><td><input class="form-control" type="text" id="profit"></td></tr>
                            <?php endif; ?>

                            <?php if(Entrust::can('tch_profit_view')): ?>
                            <tr><td>მოგება დღგ-თი</td><td><input class="form-control" type="text" id="profit_tax"></td></tr>
                            <?php endif; ?>

                            <tr><td>პირადი ნომერი</td><td>
                                <input class="form-control custom" type="text" id="personal_id_input" value="<?php echo e($user_info->personal_id); ?>">
                            </td></tr>

                            <?php if(Entrust::can('tch_phone_number_edit')): ?>
                                <tr>
                                    <td>ტელეფონის ნომერი</td>
                                    <td>
                                        <input class="form-control custom" type="text" id="details_number" value="<?php echo e($techplus->number); ?>">
                                    </td>
                                </tr>
                            <?php elseif(Entrust::can('tch_phone_number_view')): ?>
                                <tr><td>ტელეფონის ნომერი</td><td><?php echo e($techplus->number); ?></td></tr>
                            <?php endif; ?>

                            <?php 
                                $items = $techplus->request->items;
                                
                                $request_rs_status = 1;
                                foreach ($items as $it){
                                    if($it->rs_status == 0 && $it->isset == 0){
                                        $request_rs_status = 0;
                                    }
                                }
                            ?>
                            <?php if(Entrust::can('tch_rs_status_edit')): ?>
                                <tr>
                                    <td>rs სტატუსი</td>
                                    <td>
                                    
                                        <select class="form-control customSelect" id="details_rs_status">
                                            <?php $__currentLoopData = $rs_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rskey => $rs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($rskey); ?>" <?php echo e($rskey == $request_rs_status ? 'selected' :''); ?>><?php echo e($rs); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php elseif(Entrust::can('tch_rs_status_view')): ?>
                                <tr><td>rs სტატუსი</td><td>
                                    <?php echo e(isset($rs_status[$request_rs_status]) ? $rs_status[$request_rs_status] : ''); ?>

                                </td></tr>
                            <?php endif; ?>

                            <tr>
                                <td>წინასწარ გადახდილი</td>
                                <td>
                                    <input class="form-control custom" type="text" id="paid_already_input" value="<?php echo e($techplus->paid_already); ?>">
                                </td>
                            </tr>
                            
                        </table>
                    </td>



                    <td>
                        <table>
                        
                            <?php if(Entrust::can('tch_cred_pay_edit')): ?>
                                <tr>
                                    <td>კრედიტამაზონის ჩარიცხვა</td>
                                    <td>
                                        <select class="form-control customSelect" id="details_cred_pay">
                                            <?php $__currentLoopData = $cred_pay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crkey => $cred): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($crkey); ?>" <?php echo e($crkey == $calculated->cred_pay ? 'selected' :''); ?>><?php echo e($cred); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php elseif(Entrust::can('tch_cred_pay_view')): ?>
                                <tr><td>კრედიტამაზონის ჩარიცხვა</td><td>
                                    <?php echo e(isset($cred_pay[$calculated->cred_pay]) ? $cred_pay[$calculated->cred_pay] : ''); ?>

                                </td></tr>
                            <?php endif; ?>
                                
                            <tr>
                                <td>გაუქმების სტატუსი</td>
                                <td>
                                    <select id="details_is_canceling_status" name="is_canceling" class="form-control customSelect">
                                        <option value="0" <?php echo e($techplus->is_canceling == 0 ? 'selected' : ''); ?>></option>
                                        <option value="1" <?php echo e($techplus->is_canceling == 1 ? 'selected' : ''); ?>>აუქმებს</option>
                                        <option value="2" <?php echo e($techplus->is_canceling == 2 ? 'selected' : ''); ?>>ხელი მოწერილია</option>
                                    </select>
                                </td>
                            </tr>

                            <?php if(Entrust::can('tch_pay_method_edit')): ?>
                                <tr>
                                    <td>გადახდის მეთოდი</td>
                                    <td>
                                        <select class="form-control customSelect" id="details_pay_method">
                                            <?php $__currentLoopData = $pay_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mthdkey => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($mthdkey); ?>" <?php echo e($mthdkey == $techplus->pay_method ? 'selected' :''); ?>><?php echo e($method); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php elseif(Entrust::can('tch_pay_method_view')): ?>
                                <tr><td>გადახდის მეთოდი</td><td>
                                    <?php echo e(isset($pay_method[$techplus->pay_method]) ? $pay_method[$techplus->pay_method] : ''); ?>

                                </td></tr>                    
                            <?php endif; ?>

                            <?php if(Entrust::can('tch_agreement_status_edit')): ?>
                            <tr>
                                <td>ხელშეკრულების სტატუსი</td>
                                <td>
                                    <select class="form-control customSelect" id="details_crystal_signature">
                                        <?php $__currentLoopData = $crystal_signature; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crskey => $crs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($crskey); ?>" <?php echo e($crskey == $techplus->crystal_signature ? 'selected' :''); ?>><?php echo e($crs); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                            </tr>
                            <?php elseif(Entrust::can('tch_agreement_status_view')): ?>
                                <tr><td>ხელშეკრულების სტატუსი</td><td>
                                    <?php echo e(isset($crystal_signature[$techplus->crystal_signature]) ? $crystal_signature[$techplus->crystal_signature] : ''); ?>

                                </td></tr>                    
                            <?php endif; ?>

                            <?php if(Entrust::can('tch_crystal_canceled_edit')): ?>
                                <tr>
                                    <td>გასაუქმებელია კრისტალი</td>
                                    <td>
                                        <select class="form-control customSelect" id="crystal_canceled">
                                            <option value="0" <?php echo e($calculated->crystal_canceled == 0 ? 'selected' :''); ?>>გადასარიცხია</option>
                                            <option value="1" <?php echo e($calculated->crystal_canceled == 1 ? 'selected' :''); ?>>გადარიცხულია</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php elseif(Entrust::can('tch_crystal_canceled_view')): ?>
                                <tr><td>გასაუქმებელია კრისტალი</td><td><?php echo e($calculated->crystal_canceled == 0 ? 'გადასარიცხია' :'გადარიცხულია'); ?></td></tr>                    
                            <?php endif; ?>

                            <?php if(Entrust::can('tch_item_return_edit')): ?>
                                <tr>
                                    <td>უკან დაბრუნება</td>
                                    <td>
                                        <select class="form-control customSelect" id="return_status">
                                            <option value="0" <?php echo e($techplus->return_status == 0 ? 'selected' :''); ?>></option>
                                            <option value="1" <?php echo e($techplus->return_status == 1 ? 'selected' :''); ?>>უკან დაბრუნება</option>
                                            <option value="2" <?php echo e($techplus->return_status == 2 ? 'selected' :''); ?>>ზედნადები გაუქმებულია</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php elseif(Entrust::can('tch_item_return_view')): ?>
                                <tr><td>უკან დაბრუნება</td><td>
                                    <?php echo e(isset($return_status[$calculated->return_status]) ? $return_status[$calculated->return_status] : ''); ?>

                                </td></tr>
                            <?php endif; ?>


                            <tr>
                                <td>ქალაქი</td>
                                <td>
                                    <select class="form-control customSelect" id="city_id">
                                        <option></option>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>" <?php echo e($user_info->city_id == $city->id ? 'selected=""' : ''); ?>><?php echo e($city->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>უბანი</td>
                                <td>
                                    <select class="form-control" >
                                        <option><?php echo e(optional($user_info->district)->name); ?></option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>მისამართი</td>
                                <td>
                                    <input class="form-control custom" type="text" id="details_address" maxlength="50" value="<?php echo e($user_info->address); ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>ჩგდ-ს ნომერი</td>
                                <td>
                                    <input class="form-control custom" type="text" id="cgd_number_input" value="<?php echo e($techplus->cgd_number); ?>">
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
            </table>


        </div>
        
    </div>

    <?php if (\Entrust::can('tch_edit_request_details')) : ?>
    <button class="btn btn-success" id="save_details" style="margin-bottom: 20px; padding: 15px 35px;">ჩასწორება</button>
    <?php endif; // Entrust::can ?>
    <?php echo $__env->make('techplus.requests.partials.additionalItemsTable', ['pay_method' => $techplus->pay_method], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>


<script>
    $(document).ready(function(){

        $('#invoice_amount_paid_money').on('blur', function(){
            selector = $(this);
            if(selector.val().length > 2){
                try {
                    selector.val(eval(selector.val()));
                } catch (e) {
                    return selector.css('border', '3px solid red');
                }
                selector.css('border', '1px solid #e9ecef');

            }

            if(selector.val() == ''){
                selector.css('border', '3px solid red');
            } else {
                selector.css('border', '1px solid #e9ecef');
            }

        });

        

        var sell_price = parseFloat($('#sell_price_sum').html());
        var get_price = parseFloat($('#get_price_sum').html());
        window.profit = sell_price - get_price;
 
        $('#profit').val( ((sell_price - get_price) - (((sell_price - get_price) / 1.18) * 0.18 )).toFixed(2));
        $('#profit_tax').val( (sell_price - get_price) );

        $('body').addClass('modal-open');

        $('#save_details').on('click', function(){
            var pn = $('#details_pn').val();
            var number = $('#details_number').val();
            var rs_status = $('#details_rs_status').val();
            var cred_pay = $('#details_cred_pay').val();
            var invoice_amount_paid_money = $('#invoice_amount_paid_money').val();
            var pay_method = $('#details_pay_method').val();
            var is_canceling = $('#details_is_canceling_status').val();
            var courier = $('#details_courier').val();
            var crystal_signature = $('#details_crystal_signature').val();
            var address = $('#details_address').val();
            var crystal_canceled = $('#crystal_canceled').val();
            var return_status = $('#return_status').val();
            var personal_id = $('#personal_id_input').val();
            var cgd_number = $('#cgd_number_input').val();
            var override_price = $('#override_price_input').val();
            var paid_already = $('#paid_already_input').val();
            var city_id = $('#city_id').val();
            
            $.ajax({
                url: '/techplus/request/updatedetails',
                type: 'POST',
                data: {
                    pn: pn,
                    number: number,
                    rs_status: rs_status,
                    cred_pay: cred_pay,
                    pay_method: pay_method,
                    courier: courier,
                    crystal_signature: crystal_signature,
                    crystal_canceled: crystal_canceled,
                    return_status: return_status,
                    address: address,
                    is_canceling: is_canceling,
                    personal_id: personal_id,
                    invoice_amount_paid_money,
                    request_id: REQUEST_ID,
                    techplus_id: TECHPLUS_ID,
                    cgd_number: cgd_number,
                    paid_already: paid_already,
                    city_id: city_id,
                },
                success: function(response){
                    if(typeof updateItemsTable != "undefined") {
                        updateItemsTable();
                    }
                }
            });
        });
    });
</script>