<div class="modal-dialog modal-md" >
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">ნივთის დამატება</h4>
            <button type="button" class="close" id="close_request_x" data-dismiss="modal" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">

                <div class="col-lg-12 col-sm-12">
                    <form id="createitemform">
                        <?php echo e(csrf_field()); ?>

                        
                        <div class="form-group">
                            <label for="name">დასახელება</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="დასახელება" name="name" value="">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name">ასაღები ფასი</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="ასაღები ფასი" name="get_price" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">გასაყიდი ფასი</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="გასაყიდი ფასი" name="sell_price" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">საიტი</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="საიტი" name="site" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">წონა</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="წონა" name="weight" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">სეტი</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="isset" id="isset">
                                    <option value="0" >არა</option>
                                    <option value="1" >კი</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">მომწოდებელი</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="supplier_id" >
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>" ><?php echo e($s->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">დაბეგვრის ტიპი</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="vat_type" >
                                    <option value="0" >ჩვეულებრივი</option>
                                    <option value="1" >ნულოვანი</option>
                                    <option value="2" >დაუბეგრავი</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">პროდუქტის კოდები</label>
                            <div class="input-group mb-3">
                                <input type="text" value="" class="form-control" style="width: 100%" id="create_supplier_codes_input" placeholder="მომწოდებლის კოდები" name="supplier_codes" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Citrus ID</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="ციტრუსის ID" name="citrus_id" value="">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10 createitembutton">ჩასწორება</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


    $(document).ready(function(){
        $('#create_supplier_codes_input').tagsinput();
        $('.createitembutton').on('click', function(e) {
            e.preventDefault();

            var formdata = $('#createitemform').serializeArray();
            var data = {};
            $.each(formdata, function(idx, val){
                data[val.name] = val.value; 
            });

            $.ajax({
                url: itemmodalurl,
                data: {i: 1,partial: 'createitem',  ...data},
                success: function(){
                    alert('ნივთი წარმატებით დაემატა');
                }
            })
            
        });
    });
</script>
