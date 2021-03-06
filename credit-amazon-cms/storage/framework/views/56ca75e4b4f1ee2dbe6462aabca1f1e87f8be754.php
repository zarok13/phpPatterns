<form action="#" id="filter_form">
        <?php echo csrf_field(); ?>
        <style>
        .btn-group .btn {width: 100%;text-align: left;padding: 3px;}
        .btn-group {display: none;}
        </style>
        <script>
            var showOrHide = function (div_id){
                    filter = $('#filter_div').children();
                    $.each(filter, function(key, value){
                        if(value.dataset.hide != 'no' && value.dataset.id != div_id){
                            value.style.display = 'none';
                        }
                    });
                    $(div_id).show();
                }
                
            $(document).ready(function(){
                
				$('[data-toggle="tooltip"]').tooltip();
				$('[data-toggle="popover"]').popover();
		
                function showColumn(index, event){
                    window.filter_table.column(index).visible(event.target.checked);
                }
            });
            
        </script>
        <div class="filter" id="filter_div" style="display: none; width: 100%; box-shadow: 0px 0px 25px 5px rgba(8, 16, 23, 0.24); background: transparent; border-radius:5px; padding: 5px;margin-bottom: 10px ">
    
            <div data-hide="no" style="margin-bottom: 10px;">
				<button type="button" class="btn btn-secondary" onclick="showOrHide('#bydates')">თარიღების მიხედვით </button>
				
				<button type="button" class="btn btn-success"  data-toggle="tooltip" 
					title="<?php echo e(\Carbon\Carbon::parse('today midnight')); ?> -დან <?php echo e(\Carbon\Carbon::parse('tomorrow midnight')); ?> -მდე"
					onclick="makeDatatable('<?php echo e(route('reports.banks.in_range', 
						[ 'from' => \Carbon\Carbon::parse('today midnight'), 'to' => \Carbon\Carbon::parse('tomorrow midnight') ] )); ?>')">მხოლოდ დღევანდელი</button>
				
				<button type="button" class="btn btn-success" data-toggle="tooltip" 
					title="<?php echo e(\Carbon\Carbon::parse('yesterday midnight')); ?> -დან <?php echo e(\Carbon\Carbon::parse('today midnight')); ?> -მდე"
					onclick="makeDatatable('<?php echo e(route('reports.banks.in_range', 
						[ 'from' => \Carbon\Carbon::parse('yesterday midnight'), 'to' => \Carbon\Carbon::parse('today midnight') ] )); ?>')">მხოლოდ გუშინდელი</button>

				<button type="button" class="btn btn-success" data-toggle="tooltip" 
					title="<?php echo e(\Carbon\Carbon::now()->startOfMonth()); ?> -დან <?php echo e(\Carbon\Carbon::now()->endOfMonth()); ?> -მდე"
					onclick="makeDatatable('<?php echo e(route('reports.banks.in_range', 
						[ 'from' => \Carbon\Carbon::now()->startOfMonth(), 'to' => \Carbon\Carbon::now()->endOfMonth() ] )); ?>')">მხოლოდ ამ თვის</button>

				<button type="button" class="btn btn-success" data-toggle="tooltip" 
					title="<?php echo e(\Carbon\Carbon::parse('first day of last month')); ?> -დან <?php echo e(\Carbon\Carbon::parse('last day of last month')); ?> -მდე"
					onclick="makeDatatable('<?php echo e(route('reports.banks.in_range', 
						[ 'from' => \Carbon\Carbon::parse('first day of last month'), 'to' => \Carbon\Carbon::parse('last day of last month') ] )); ?>')">მხოლოდ წინა თვის</button>

            </div>
            
            <div class="btn-group" id="bydates" style="display: inline-block; column-count: 4; display:none; ">
                <label class="btn btn-success " style="background:darkseagreen">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"> 
                </label>
                <label class="btn btn-success " style="background:darkseagreen">
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"> 
                </label>
            </div>
    
            
    
            <div data-hide="no" style="margin-top: 10px; display: inline-block">
                <label for="user_id">ბანკის დასახელება</label>
                <select class="form-control" name="bank_id" >
                    <option ></option>
                    <?php $__currentLoopData = $data['banks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
                
        </div>
        
    </form>