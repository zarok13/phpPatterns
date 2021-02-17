<div class="modal-dialog modal-md" >
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel"><?php echo e($item->name); ?></h4>
            <button type="button" class="close" id="close_request_x" data-dismiss="modal" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">

                <div class="col-lg-12 col-sm-12">
                    <form id="itemeditform">
                        <?php echo e(csrf_field()); ?>

                        
                        <div class="form-group">
                            <label for="name">დასახელება</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="დასახელება" name="name" value="<?php echo e($item->name); ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name">ასაღები ფასი</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="ასაღები ფასი" name="get_price" value="<?php echo e($item->get_price); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">გასაყიდი ფასი</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="გასაყიდი ფასი" name="sell_price" value="<?php echo e($item->sell_price); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">საიტი</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="საიტი" name="site" value="<?php echo e($item->site); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">წონა</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="წონა" name="weight" value="<?php echo e($item->weight); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">სეტი</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="isset" id="isset">
                                    <option value="0" <?php echo e((int) $item->isset == 0 ? 'selected' : ''); ?>>არა</option>
                                    <option value="1" <?php echo e((int) $item->isset == 1 ? 'selected' : ''); ?>>კი</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">მომწოდებელი</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="supplier_id" >
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>" <?php echo e((int) $item->supplier_id == $s->id ? 'selected' : ''); ?>><?php echo e($s->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">დაბეგვრის ტიპი</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="vat_type" >
                                    <option value="0" <?php echo e($item->vat_type == 0 ? 'selected' : ''); ?>>ჩვეულებრივი</option>
                                    <option value="1" <?php echo e($item->vat_type == 1 ? 'selected' : ''); ?>>ნულოვანი</option>
                                    <option value="2" <?php echo e($item->vat_type == 2 ? 'selected' : ''); ?>>დაუბეგრავი</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">პროდუქტის კოდები</label>
                            <div class="input-group mb-3">
                                <input type="text" value="<?php echo e(implode(',', $item->codes()->pluck('code')->toArray())); ?>" class="form-control" style="width: 100%" id="supplier_codes_input" placeholder="მომწოდებლის კოდები" name="supplier_codes" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">პროდუქტის გათიშვა</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="disabled" >
                                    <option value="0" <?php echo e($item->disabled == 0 ? 'selected' : ''); ?>>ჩართული</option>
                                    <option value="1" <?php echo e($item->disabled == 1 ? 'selected' : ''); ?>>გათიშული</option>
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10 edititembutton">ჩასწორება</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


    $(document).ready(function(){
        $('#supplier_codes_input').tagsinput();
        $('.edititembutton').on('click', function(e) {
            e.preventDefault();

            var formdata = $('#itemeditform').serializeArray();
            var data = {};
            $.each(formdata, function(idx, val){
                data[val.name] = val.value; 
            });

            getWithAjax(itemmodalurl, {partial: 'saveitem',  ...data}, null, function(){
                if(confirm('სერვერზე მოხდა შეცდომა, გნებავთ თუ არა ფორმის რესეტი?')) {
                    $('#itemeditform').trigger('reset');
                }
            });
        });
    });
</script>
