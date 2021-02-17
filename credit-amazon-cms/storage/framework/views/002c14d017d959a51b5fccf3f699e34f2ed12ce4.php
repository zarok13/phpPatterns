<form action="#" id="filter_form">
    <?php echo csrf_field(); ?>
    <style>
    .btn-group .btn {width: 100%;text-align: left;padding: 3px;}
    .btn-group {display: none;}
    .buttons_button {
        margin: 3px;
    }
    </style>
    <script>

        function showOrHide(div_id){
            var filter = $('#filter_div').children();

            if($(div_id).css('display')=="block"){
                $(div_id).css('display', 'none');
                return;
            }
            
            $.each(filter, function(key, value){
                if(value.dataset.hide != 'no' && value.dataset.id != div_id){
                    value.style.display = 'none';
                }
            });
            $(div_id).fadeToggle();
        }

        function showColumn(index, event){
            window.filter_table.column(index).visible(event.target.checked);
        }

		$(document).ready(function(){
			$('.dropdown-checkbox').on('click', function(){
				input = $(this).find('input');
				if(input.prop('checked') == false){
					input.prop('checked', true);
					if($(this).data('is_parent') == 1){
						$('.'+$(this).data('key')).prop('checked', true);
					}
				} else {
					input.prop('checked', false);
					if($(this).data('is_parent') == 1){
						$('.'+$(this).data('key')).prop('checked', false);
					}
				}
				
			});
		});
        
    </script>
    <div class="filter" id="filter_div" style="display: none; width: 100%; box-shadow: 0px 0px 25px 5px rgba(8, 16, 23, 0.24); background: transparent; border-radius:5px; padding: 5px;margin-bottom: 10px ">

        <div data-hide="no" style="margin-bottom: 10px;">
            <button type="button" class="btn btn-secondary" onclick="showOrHide('#statuses')">სტატუსები </button>
            <button type="button" class="btn btn-secondary" onclick="showOrHide('#sites')">საიტები </button>
            <button type="button" class="btn btn-secondary" onclick="showOrHide('#banks')">ბანკები </button>
            <button type="button" class="btn btn-secondary" onclick="showOrHide('#cities')">ქალაქები </button>
            <button type="button" class="btn btn-secondary" onclick="showOrHide('#ages')">ასაკი </button>
            <button type="button" class="btn btn-secondary" onclick="showOrHide('#genders')">სქესი </button>
            <button type="button" class="btn btn-success" onclick="showOrHide('#details')">დეტალები </button>
            <button type="button" class="btn btn-success" onclick="showOrHide('#fields')">ველები </button>
            <button type="button" class="btn btn-success" onclick="showOrHide('#buttons')">ღილაკები </button>
            <button type="button" class="btn btn-danger" 
                onclick="makeDatatable('<?php echo e(route('reports.filter.ajax')); ?>?k=r&buy_filter=1&inner_statuses%5B%5D=19&from_date=<?php echo e(\Carbon\Carbon::parse('today midnight')); ?>')">
                დღევანდელი საყიდელია 
            </button>
            <button type="button" class="btn btn-danger" 
                onclick="makeDatatable('<?php echo e(route('reports.filter.ajax')); ?>?k=r&buy_filter=1&inner_statuses%5B%5D=19&from_date=<?php echo e(\Carbon\Carbon::parse('today midnight')->subDays(1)); ?>&to_date=<?php echo e(\Carbon\Carbon::parse('today midnight')); ?>')">
                გუშინდელი საყიდელია 
			</button>

			
        </div>

        <div class="btn-group" id="statuses" style="display: inline-block; column-count: 6; display:none; ">
			
			<?php ($innerstatuses = \App\Models\InnerStatus::all()); ?>

			<?php $__currentLoopData = $innerstatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$istatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php ($child_statuses = $innerstatuses->filter(function($ista) use ($istatus){
					return $ista->parent_id == $istatus->id;
				})); ?>
				<?php if($istatus->parent_id == 0): ?>
				<div class="dropdown" style="margin-bottom: 10px; position: unset;" >
					<a class="btn btn-secondary dropdown-checkbox 
						<?php echo e(count($child_statuses) > 0 ? ' dropdown-toggle ' : ''); ?>" 
						<?php echo count($child_statuses) > 0 ? ' data-toggle="dropdown" data-is_parent=1' : 'data-is_parent=0'; ?> 
						id="inner_status_<?php echo e($istatus->id); ?>" 
						aria-haspopup="true" aria-expanded="false" data-key=<?php echo e('parent'.$key); ?>>
						
						<input type="checkbox" style="" name="inner_statuses[]" value="<?php echo e($istatus->id); ?>"><?php echo e($istatus->name); ?>

					</a>
					<ul class="dropdown-menu">
						<?php if(count($child_statuses) > 0): ?>
							<?php $__currentLoopData = $child_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li>&nbsp;&nbsp;<a href="#" tabIndex="-1"><input type="checkbox" class="<?php echo e('parent'.$key); ?>" name="inner_statuses[]" value="<?php echo e($child_status->id); ?>"/>&nbsp;<?php echo e($child_status->name); ?></a></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</ul>
				</div>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div id="buttons" style=" display:none; ">
            <button type="button" class="btn btn-danger buttons_button" 
                onclick="makeDatatable('<?php echo e(route('reports.filter.ajax')); ?>?k=r&s=r&late_statuses=1&late_status=1')">
                დაგვიანებების ნახვა
			</button>

            <button type="button" class="btn btn-danger buttons_button" 
                onclick="makeDatatable('<?php echo e(route('reports.filter.ajax')); ?>?k=r&s=r&all_buy_date=1&')">
                ყველა საყიდელია
			</button>

            <button type="button" class="btn btn-danger buttons_button" 
                onclick="makeDatatable('<?php echo e(route('reports.filter.ajax')); ?>?k=r&s=r&approveds=1')">
                დღევანდელი დამტკიცებულები
            </button>
        </div>
        
        
        <div class="btn-group" id="sites" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
            <?php $__currentLoopData = $data['sites']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="btn btn-success " style="background:darkseagreen">
                    <input type="checkbox" name="sites[]" value="<?php echo e($site->id); ?>"> <?php echo e($site->name); ?>

                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="btn-group" id="banks" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
            <?php $__currentLoopData = $data['banks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="btn btn-success " style="background:darkseagreen">
                    <input type="checkbox" name="banks[]" value="<?php echo e($bank->id); ?>"> <?php echo e($bank->name); ?>

                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="btn-group" id="cities" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
            <?php $__currentLoopData = $data['cities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="btn btn-success " style="background:darkseagreen">
                    <input type="checkbox" name="cities[]" value="<?php echo e($city->id); ?>"> <?php echo e($city->name); ?>

                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>


        <div class="btn-group" id="ages" style="display: inline-block;  column-count: 4; margin-top: 15px; display:none;">
            <label class="btn btn-success " style="background:darkseagreen">
                <input type="number" name="age_from"> ასაკი საიდან
            </label>
            
            <label class="btn btn-success " style="background:darkseagreen">
                <input type="number" name="age_to"> ასაკი სანამდე
            </label>
        </div>

        <div class="btn-group" id="genders" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
            <label class="btn btn-success " style="background:darkseagreen">
                <select name="company" >
                    <option value=""></option>
                    <option value="crd">კრედიტამაზონი</option>
                    <option value="tch">ტექპლიუსი</option>
                    <option value="ctr" disabled="">ციტრუსი</option>
                </select> კომპანია
            </label>
        </div>

        <div class="btn-group" id="genders" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
            <label class="btn btn-success " style="background:darkseagreen">
                <select name="company" >
                    <option value=""></option>
                    <option value="m">მამრობითი</option>
                    <option value="f">მდედრობითი</option>
                </select> სქესი
            </label>
        </div>


        <div class="btn-group" id="details" style="display: inline-block;  column-count: 3; margin-top: 15px; display:none;">
            <label class="btn btn-success " style="background:darkseagreen">
                <select name="color" >
                    <option value=""></option>
                    <?php $__currentLoopData = COLORS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($color); ?>"><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select> ფერი
            </label>

            <label class="btn btn-success " style="background:darkseagreen">
                <select name="tax_status" >
                    <option value=""></option>
                    <option value="1">გადახდილია</option>
                    <option value="0">გადასახდელია</option>
                </select> განბაჟება
            </label>

            <label class="btn btn-success " style="background:darkseagreen">
                <select name="isclient" >
                    <option value=""></option>
                    <option value="1">კი</option>
                    <option value="0">არა</option>
                </select> არა კლიენტი
            </label>

            <label class="btn btn-success " style="background:darkseagreen">
                <select name="credo_client" >
                    <option value=""></option>
                    <option value="1">კი</option>
                    <option value="0">არა</option>
                </select> კრედოს კლიენტი
            </label>

            <label class="btn btn-success " style="background:darkseagreen">
                <input type="checkbox" id="withlinks" name="withlinks" > ლინკებით
            </label>
            <label class="btn btn-success " style="background:darkseagreen">
                <input type="checkbox" id="nolimit" name="nolimit" > ლიმიტის გარეშე
            </label>
            
            <label class="btn btn-success " style="background:darkseagreen">
                <select name="pay_status" >
                    <option value=""></option>
                    <option value="0">ჩასარიცხი</option>
                    <option value="1">ჩარიცხული</option>
                </select> თანხის სტატუსი
            </label>
            
            <label class="btn btn-success " style="background:darkseagreen">
                <select name="cred_pay" >
                    <option value=""></option>
                    <option value="0">ჩასარიცხი</option>
                    <option value="1">ჩარიცხული</option>
                </select> ტექპლიუსის ჩარიცხვა
            </label>
            
            <label class="btn btn-success " style="background:darkseagreen">
                <select name="late_status" >
                    <option value=""></option>
                    <option value="0">არა</option>
                    <option value="1">დაგვიანებული</option>
                </select> დაგვიანება
			</label>
            <label class="btn btn-success " style="background:darkseagreen">
                <input type="text" name="flight_number" > ფრენის ნომერი
			</label>
			
            <label class="btn btn-success " style="background:darkseagreen">
                <select name="agreement_status" >
                    <option value="" selected></option>
                    <option value="0">მოსატანია</option>
                    <option value="1">მოტანილია</option>
                    <option value="2">გაგზავნილია</option>
                </select> ხელშეკრულება
            </label>

             <label class="btn btn-success " style="background:darkseagreen">
                <select name="comment_user_id">
                    <option value="" selected></option>

                    <?php $__currentLoopData = $data['users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                პირველი კომენტარი
            </label>

            <label class="btn btn-success " style="background:darkseagreen">
                <input type="text" name="comment_filter" >
                კომენტარი
            </label>
            

        </div>

        <div  class="btn-group" id="fields" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
            <?php $i = 0; ?>
            <?php $__currentLoopData = $data['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="btn btn-success " style="background:darkseagreen">
                    <input type="checkbox" onchange="showColumn(<?php echo e($i+1); ?>, event)" <?php echo e($field['show'] ? 'checked' :''); ?> name="fields" name="<?php echo e($field['name']); ?>" > <?php echo e($field['label']); ?>

                </label>
            <?php $i ++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    

    




        <div data-hide="no" style="margin-top: 10px; display: inline-block">

            <input  type="text" class="form-control" style="width: unset" name="request_id" id="request_id" placeholder="ID" value="<?php echo e(is_array(request('ids')) ? join(',', request('ids')) : ''); ?>">
            <input  type="text" class="form-control" style="width: unset" name="name" id="name" placeholder="სახელი">
            <input  type="text" class="form-control" style="width: unset" name="lastname" id="lastname" placeholder="გვარი">
            <input  type="text" class="form-control" style="width: unset" name="regname" id="regname" placeholder="რეგისტრაციის სახელი/გვარი">
            <input  type="text" class="form-control" style="width: unset" name="personal_id" id="personal_id" placeholder="პირადი ნომერი">
            <input  type="text" class="form-control" style="width: unset" name="number" placeholder="ტელეფონის ნომერი">
            <input  type="date" class="form-control" style="width: unset" name="from_date" placeholder="ტელეფონის ნომერი">
            <input  type="date" class="form-control" style="width: unset" name="to_date" placeholder="ტელეფონის ნომერი">
            
			<label for="buy_filter">
				<input  type="checkbox" class="form-control" style="display: inline-block; width: 15px;" name="buy_filter" >
				საყიდელია-თარიღი
			</label>
        </div>
            
    </div>
    
</form>