<div class="row">
    <div class="col-md-6 col-sm-12" >
        <form action="" id="countForm">
			<?php echo csrf_field(); ?>
			<?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER'])) : ?>
            <div class="form-group">
                <label for="name">თავზე გადაწერა:  </label>
                <div class="input-group mb-3">
					<input type="checkbox" name="update" >
                </div>
            </div>
            
            
            <div class="form-group">
                <label for="name">წინასწარი: </label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-cubes"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="წინასწარი:" required="" id="pre" name="pre" value="<?php echo e(isset($req->calculated->pre) ? $req->calculated->pre : 0); ?>">
                </div>
            </div>
            <?php endif; // Entrust::hasRole ?>

            <div class="form-group">
                <label for="name">არა კლიენტი:</label>
                <div class="input-group mb-3">
                    <input type="checkbox" <?php echo e($req->form == 1 ? 'checked=""' : ''); ?> name="client" onchange="updateIsClient(event)" >
                </div>
            </div>

            <div class="form-group" style="display: none;">
                <label for="name">თარიღი:  </label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input type="date" id="date_input" class="form-control" placeholder="თარიღი" required="" name="date" value="<?php echo e(isset($req->calculated->date) ? $req->calculated->date : \Carbon\Carbon::now()->format('Y-m-d')); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="name">ფასი: </label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-cubes"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="ფასი" required="" id="calc_price" name="price" value="<?php echo e(isset($req->calculated->price) ? $req->calculated->price : 0); ?>">
                </div>
            </div>


            <div class="form-group" style="display: none;">
                <label for="name">წონა: </label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-cubes"></i></span>
                    </div>
                    <input type="number" class="form-control" placeholder="წონა" required="" name="weight" value="<?php echo e(isset($req->calculated->weight)?$req->calculated->weight:0); ?>">
                </div>
            </div>
            
            
            <div class="form-group">
                <label for="name">საიტი: </label>
                <div class="input-group mb-3">
                    <select class="form-control" name="site">
                        <option value="0"></option>
                        <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($site->id); ?>" <?php echo e(isset($req->calculated->site)?$site->id == $req->calculated->site?'selected':'':''); ?>><?php echo e($site->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="name">ბანკი: </label>
                <div class="input-group mb-3">
                    <select class="form-control" id="calculator_bank" name="bank">
                        <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($bank->id); ?>" <?php echo e(isset($req->calculated->bank)?$bank->id == $req->calculated->bank?'selected':'':''); ?>><?php echo e($bank->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

        
            <div class="form-group">
                <label for="name">თვეების რაოდენობა: </label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-cubes"></i></span>
                    </div>
                    <input type="number" class="form-control" placeholder="თვე" required="" id="calculator_month" name="month" value="<?php echo e(isset($req->calculated->month) ? $req->calculated->month : 0); ?>">
                </div>
            </div>
            

            <div class="form-group" style="display: none;">
                <label for="name">გარანტია: </label>
                <div class="input-group mb-3">
                    <select class="form-control" name="guarantees" id="guarantee_input" multiple="" >
                        <option value="0"></option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="display: none;">
                <label for="name">გარანტიის რაოდენობა: </label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-cubes"></i></span>
                    </div>
                    <input type="number" class="form-control" placeholder="თვე" required="" id="guarantee_quantity" name="guarantee_quantity" value="1">
                </div>
            </div>
            <?php if (\Entrust::can(['edit-request'])) : ?>
                <div class="form-group">
                    <button type="button" class="btn btn-success waves-effect text-left" onclick="count()" >დათვლა</button>
                </div>
            <?php endif; // Entrust::can ?>
        </form>
    </div>

    
    <div class="col-md-6 col-sm-12" id="counted">

    </div>
</div>

<?php if(isset($req->calculated->month)): ?>
    <script>
        <?php if (\Entrust::can(['edit-request'])) : ?>
            $(document).ready(function(){
                // date_input
                if(editable){
                    count();
                }
                
            });
        <?php endif; // Entrust::can ?>
    </script>
<?php endif; ?>

<?php if (\Entrust::hasRole(['TECHPLUS'])) : ?>
<script>
    $(document).ready(function(){
        
        count();

        var form = document.getElementById("countForm");
        var elements = form.elements;
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].readOnly = true;
        }
    });
</script>
<?php endif; // Entrust::hasRole ?>
<script>

    $('#date_input').datepicker({
        showOn: "focus"
    });

    $('#countForm :input').on('click', function(){
        if($(this).val() == 0){
            $(this).val('');
        }
    });
    $('#countForm :input').on('blur', function(){
        if($(this).val() == ''){
            $(this).val(0);
        }
    });

    $("#calc_price").on('blur', function(){
        $(this).val(eval($(this).val()));
    });
    function getFormData(form){
        var unindexed_array = $(form).serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            if(n['value'] == "" || n['value']=='undefined' || n['value']==null){
                $('[name="'+n['name']+'"]').css('border', '1px solid red');
                // return indexed_array = 0;
            } else {
                $('[name="'+n['name']+'"]').css('border', '1px solid #e9ecef');
                indexed_array[n['name']] = n['value'];
            }
        });

        return indexed_array;
    }

    $('#calculator_month').on('keyup', function(){
        
    });
    

    $('#calculator_month').on('change', function(){
        window.preloader = false;
        count();
        window.preloader = true;
    });

    $('#calculator_bank').on('change', function(){
        window.preloader = false;
        $('#calculator_month').val() > 2 ? count() : null;
        window.preloader = true;
    });


    function count(){
        var formData = getFormData( $('#countForm') );
        formData.request_id = $('#request_id_input').val();
        formData.guarantee = $('#guarantee_input').val();
        // console.log(formData);
        if(formData != 0){
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('operator.calculator.count')); ?>",
                data: formData,
                success: function (response) {
                    $('#preloader').css('display', 'none');
                    $('#counted').empty();
                    $('#counted').html(response.html);
                    // console.log(response);
                }
            });
        }
    }

    function updateIsClient(e){
        var isclient = $(e.target).prop('checked') ? 1 : 0;

        $.ajax({
            type: "POST",
            url: "<?php echo e(route('operator.calculator.updateisclient')); ?>",
            data: {
                request_id: $('#request_id_input').val(), 
                is_client: isclient
            },
            success: function(data){
                console.log(data);
            }
        });
    }
</script>
    