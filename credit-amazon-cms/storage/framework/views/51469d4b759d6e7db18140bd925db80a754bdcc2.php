<div id="editMultipleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="selectedItemsCount"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="editMultipleForm">
                    <div class="form-group">
                        <label for="multipleInnerStatus">სტატუსი</label>
                        
                        <?php ($minnerstatuses = \App\Models\InnerStatus::select('id', 'name', 'parent_id')->get()); ?>
                        <?php ($parents = []); ?>
                        <select id="multipleInnerStatusParent" class="form-control">
                            <option value=""></option>
                            <?php $__currentLoopData = $minnerstatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mInnerStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!in_array($mInnerStatus->parent_id, $parents)): ?>
                                    <?php ($parents[] = $mInnerStatus->parent_id); ?>
                                <?php endif; ?>
                                <?php if($mInnerStatus->parent_id == 0): ?>
                                    <option value="<?php echo e($mInnerStatus->id); ?>" ><?php echo e($mInnerStatus->name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <select id="multipleInnerStatus" style="display: none; margin-top: 10px;" class="form-control">
                            <option value=""></option>

                            <?php $__currentLoopData = $minnerstatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mInnerStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <option
                                    class="showNone"
                                    data-parent_id="<?php echo e((int)$mInnerStatus->parent_id == 0 ? $mInnerStatus->id : $mInnerStatus->parent_id); ?>" 
                                    value="<?php echo e($mInnerStatus->id); ?>"><?php echo e($mInnerStatus->name); ?></option>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>

                    <div class="form-group">
                        <label for="multipleTaxStatus">განბაჟების სტატუსი</label>
                        <select id="multipleTaxStatus" class="form-control">
                            <option value=""></option>
                            <option value="0">გადასახდელია</option>
                            <option value="1">გადახდილია</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="multipleTechplusStatus">ტექპლიუსის ჩარიცხვა</label>
                        <select id="multipleTechplusStatus" class="form-control">
                            <option value=""></option>
                            <option value="0">ჩასარიცხია</option>
                            <option value="1">ჩარიცხულია</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="multiplePayStatus">თანხის სტატუსი</label>
                        <select id="multiplePayStatus" class="form-control">
                            <option value=""></option>
                            <option value="0">ჩასარიცხია</option>
                            <option value="1">ჩარიცხულია</option>
                        </select>
                    </div>


                    <div class="form-group" id="skippeds_div" style="display: none;">
                        <textarea  class="form-control" id="skippeds" ></textarea>
                    </div>

                </form>

                <div class="form-group" style="margin-top: 10px;">
                    <button class="btn btn-success" id="multipleMoveToTechplus">ტექპლიუსზე გადატანა</button>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" id="multipleEditButton">ჩასწორება</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        window.selectedParent = null;
        var parents = <?php echo json_encode($parents); ?>;

        $('#multipleInnerStatusParent').on('change', function(){
            window.selectedParent = null;
            var childSelect = $('#multipleInnerStatus');
            
            if( parents.indexOf(parseInt($(this).val())) != -1 ){
                var parent_id = $(this).val();
                
                if(parent_id == '') return childSelect.css('display', 'none');
            
                childSelect.css('display', 'initial');
                $('.showNone').css('display', 'none');
                $('option[data-parent_id="'+parent_id+'"]').css('display', 'block');
                return;
            } else {
                childSelect.css('display', 'none');
                window.selectedParent = $(this).val();
                return;
            }
            
        });



        $('#multipleEditButton').on('click', function(){
            if(!confirm('ნამდვილად გსურთ მონიშნული განცხადებების ჩასწორება?')) return;

            var status_id = window.selectedParent ? window.selectedParent : $('#multipleInnerStatus').val();
            var tax_status = $('#multipleTaxStatus').val();
            var pay_status = $('#multiplePayStatus').val();
            var techplus_pay_status = $("#multipleTechplusStatus").val();
            var data = {w: 1, ids: CHANGE_REQUEST_IDS};

            status_id != '' ? data.status_id = status_id : null;
            tax_status != '' ? data.tax_status = tax_status : null;
            pay_status != '' ? data.pay_status = pay_status : null;
            techplus_pay_status != '' ? data.techplus_pay_status = techplus_pay_status : null;
            
            $.ajax({
                url: '/reports/editmultiple',
                type: 'post',
                data: data,
                success: function(response){
                    console.log(response);
                }
            });
            
        });


        $('#multipleMoveToTechplus').on('click', function(){
            if(!confirm('ნამდვილად გსურთ მონიშნული განცხადებების ტექპლიუსზე გადატანა?')) return;

            var data = {w: 1, ids: CHANGE_REQUEST_IDS}; 

            $.ajax({
                url: '/reports/multiplemovetechplus',
                type: 'post',
                data: data,
                success: function(response){
                    if(response.error_ids){
                        $('#skippeds_div').css('display', 'block');
                        for(var i = 0; i<response.error_ids.length; i++){
                            $('#skippeds').val($('#skippeds').val() + ', '+ response.error_ids[i]);
                        }
                    }
                }
            });
        });



    });
</script>

<style>
    option .showNone {
        display: none;
    }
</style>