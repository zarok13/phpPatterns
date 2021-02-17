<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">მომწოდებლის ჩასწორება</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <div class="col-lg-12">
                <form id="supplierform">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="id" value="<?php echo e($supplier->id); ?>">
                    <div class="form-group">
                        <label for="name">სახელი</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="სახელი" required="" name="name" value="<?php echo e($supplier->name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">ტელეფონი</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ტელეფონი" required="" name="number" value="<?php echo e($supplier->number); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">ელ-ფოსტა</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ელ-ფოსტა" required="" name="email" value="<?php echo e($supplier->email); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">საკონტაქტო პირი</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="საკონტაქტო პირი" required="" name="person" value="<?php echo e($supplier->person); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">ანგარიშის ნომერი</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ანგარიშის ნომერი" required="" name="bank_account" value="<?php echo e($supplier->bank_account); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">მისამართი</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="მისამართი" required="" name="address" value="<?php echo e($supplier->address); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">ბუღალტერი</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="სახელი, გვარი"  name="accountant" value="<?php echo e($supplier->accountant); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">ბუღალტრის საკონტაქტო</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ნომერი"  name="accountant_number" value="<?php echo e($supplier->accountant_number); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">იურიდიული დასახელება</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="იურიდიული დასახელება"  name="real_name" value="<?php echo e($supplier->real_name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">საიდენტიფიკაციო კოდი</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ს/კ"  name="code" value="<?php echo e($supplier->code); ?>">
                        </div>
                    </div>
                    
                    <button type="submit" id="editsupplierbutton" class="btn btn-success waves-effect waves-light m-r-10"><?php echo e(isset($creating) ? 'დამატება' : 'ჩასწორება'); ?></button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">დახურვა</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($creating)): ?>

<script>
    $(document).ready(function(){
        $('#editsupplierbutton').on('click', function(e) {
            e.preventDefault();

            var formdata = $('#supplierform').serializeArray();
            var data = {i: 1, action: 'update'};
            $.each(formdata, function(idx, val){
                data[val.name] = val.value;
            });

            $.ajax({
                url: actionurl, 
                type: 'post',
                data: data,
                success: function(response){
                    updateSupplierInFront(response);
                }
            });

            updateSupplierInFront = function(sup) {
                Object.keys(sup).map(function(key, idx){
                    if(sup[key]) {
                        var val = sup[key];
                        $('#sup-tr-' + sup.id +' .sp_'+key).html(val);
                    }
                })
            }
        })
    })
</script>
<?php else: ?> 

<script>
    $(document).ready(function(){
        $('#editsupplierbutton').on('click', function(e) {
            e.preventDefault();

            var formdata = $('#supplierform').serializeArray();
            var data = {i: 1, action: 'save'};
            $.each(formdata, function(idx, val){
                data[val.name] = val.value;
            });

            $.ajax({
                url: actionurl, 
                type: 'post',
                data: data,
                success: function(response){
                    document.location.reload()
                }
            });
        })
    })
</script>
<?php endif; ?>
