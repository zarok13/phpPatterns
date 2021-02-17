<div id="editMultipleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="selectedItemsCount"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="multipleeditform">
                        <div class="row p-10" id="multipleEditDiv" >
                            <div class="col-md-12">
                                <?php if (\Entrust::can('tch_edit_item_status')) : ?>
                                <div class="form-group" >
                                    <label for="editItemStatus">სტატუსი</label>
                                    
                                    <select id="editItemStatus" class="form-control">
                                        <?php ($ITEM_STATUSES = \Config::get('techplus.item_statuses')); ?>;
                                        <option value=""></option>
                                        <?php $__currentLoopData = $ITEM_STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key + 1); ?>"><?php echo e($inner); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php endif; // Entrust::can ?>

                                <?php if (\Entrust::can('tch_edit_supplier_pay')) : ?>
                                <div class="form-group" >
                                    <label for="supplierPaySelect">მომწოდებლის ჩარიცხვა</label>
                                    <select id="supplierPaySelect" class="form-control">
                                        <option value=""></option>
                                        <option value="0">ჩასარიცხია</option>
                                        <option value="1">ჩარიცხულია</option>
                                    </select>
                                </div>
                                <?php endif; // Entrust::can ?>

                                <?php if (\Entrust::can('tch_cred_pay_edit')) : ?>
                                <div class="form-group" >
                                    <label for="credPaySelect">კრედიტამაზონის ჩარიცხვა</label>
                                    <select id="credPaySelect" class="form-control">
                                        <option value=""></option>
                                        <option value="0">ჩასარიცხია</option>
                                        <option value="1">ჩარიცხულია</option>
                                    </select>
                                </div>
                                <?php endif; // Entrust::can ?>

                                <?php if (\Entrust::can('tch_agreement_status_edit')) : ?>
                                <div class="form-group" >
                                    <label for="agreement_statusSelect">ხელშეკრულების სტატუსი</label>
                                    <select id="agreement_status" class="form-control">
                                        <option value=""></option>
                                        <option value="0">მოსატანია</option>
                                        <option value="1">მოტანილია</option>
                                        <option value="2">გაგზავნილია</option>
                                    </select>
                                </div>
                                <?php endif; // Entrust::can ?>

                                <?php if (\Entrust::can('tch_rs_status_edit')) : ?>
                                <div class="form-group" >
                                    <label for="editRsStatus">RS სტატუსი</label>
                                    <select id="editRsStatus" class="form-control">
                                        <option value=""></option>
                                        <option value="0">არა</option>
                                        <option value="1">კი</option>
                                    </select>
                                </div>
                                <?php endif; // Entrust::can ?>

                                <?php if (\Entrust::can('tch_crystal_canceled_edit')) : ?>
                                <div class="form-group" >
                                    <label for="crystal_canceled">გასაუქმებელია კრისტალი</label>
                                    <select id="crystal_canceled" class="form-control">
                                        <option value=""></option>
                                        <option value="0">გადასარიცხია</option>
                                        <option value="1">გადარიცხულია</option>
                                    </select>
                                </div>
                                <?php endif; // Entrust::can ?>

                                <?php if (\Entrust::can('tch_item_return_edit')) : ?>
                                <div class="form-group" >
                                    <label for="return_status_select">უკან დაბრუნება</label>
                                    <select id="return_status_select" class="form-control">
                                        <option value=""></option>
                                        <option value="1">უკან დაბრუნება</option>
                                        <option value="2">ზედნადები გაუქმებულია</option>
                                    </select>
                                </div>
                                <?php endif; // Entrust::can ?>

                                <div class="form-group" >
                                    <label for="supplier_multiple_select">მომწოდებელი</label>
                                    <select id="supplier_multiple_select" class="form-control">
                                        <option value=""></option>
                                        <?php ($suppliers = \App\Models\Supplier::orderBy('name')->select('id', 'name')->get()); ?>
                                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group" >
                                    <label for="multiple_get_price">ასაღები ფასი</label>
                                    <input type="text" value="" id="multiple_get_price" class="form-control" />
                                </div>

                                
                            <button class="btn btn-success" style="margin-top: 10px;" data-dismiss="modal" id="editMultipleRequests">შენახვა</button>
                        </div>
                    </form>

                    <button class="btn btn-success" style="margin-top: 10px;" id="generatePDF">რეესტრის გენერირება</button>    
                    <div id="reestri-errors">

                    </div>
                </div>
    
                </div>
                
            </div>
        </div>
    </div>
    
    
    <script>
        $(document).ready(function(){
           
            $('#editMultipleRequests').on('click', function(e){
                e.preventDefault();
                if(confirm('ნამდვილად გსურთ მონიშნული განცხადებების ჩასწორება?')){
    
                    var status = $('#editItemStatus').val();
                    var supplier_pay = $('#supplierPaySelect').val();
                    var rs_status = $('#editRsStatus').val();
                    var cred_pay = $('#credPaySelect').val();
                    var crystal_canceled = $('#crystal_canceled').val();
                    var agreement_status = $('#agreement_status').val();
                    var return_status = $('#return_status_select').val();
                    var supplier_id = $('#supplier_multiple_select').val();
                    var get_price = $('#multiple_get_price').val();
    
                    var data = {
                        ss: 1,
                        updaterowsids: UPDATE_ROWS_ID,
                    };
                    
                    if(status != '') data.status = status;
                    if(supplier_pay != '') data.supplier_pay = supplier_pay;
                    if(rs_status != '') data.rs_status = rs_status;
                    if(rs_status != '') data.rs_status = rs_status;
                    if(cred_pay != '') data.cred_pay = cred_pay;
                    if(crystal_canceled != '') data.crystal_canceled = crystal_canceled;
                    if(agreement_status != '') data.agreement_status = agreement_status;
                    if(return_status != '') data.return_status = return_status;
                    if(supplier_id != '') data.supplier_id = supplier_id;
                    if(get_price != '') data.get_price = get_price;
                    
                    $.ajax({
                        url: '/techplus/buypage/editmultiple',
                        type: 'POST',
                        data: data,
                        success: function(data) {
                            console.log(data);
                            
                            $('#multipleeditform').trigger("reset");
                            updateItemsTable({url: loadTableUrl});
                        }
                    });
                }
            });
            

                
            $('#generatePDF').on('click', function(e){
                e.preventDefault();
                if(UPDATE_ROWS_ID.length == 0) return alert('ერთი ნივთი უნდა მოინიშნოს');                
                $.ajax({
                    url: '/techplus/generatedeliverypdf',
                    type: 'GET',
                    data:{
                        s: 1,
                        ids: UPDATE_ROWS_ID.join(',')
                    },
                    complete : function(){
                        
                        document.location = this.url;
                    }
                })
            });
    
        });
    </script>
    
    <style>
        option .showNone {
            display: none;
        }
    </style>