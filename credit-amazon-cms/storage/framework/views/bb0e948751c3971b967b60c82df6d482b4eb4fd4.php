<?php 
    $ITEM_STATUSES = \Config::get('techplus.item_statuses');
    $pay_methods = \Config::get('techplus.pay_methods');
    $districts = \App\Models\District::select('id', 'name')->get();
?>

<form id="filterForm" action="#">
<div class="filter" id="filter_div" style="width: 100%; box-shadow: 0px 0px 25px 5px rgba(8, 16, 23, 0.24); background: transparent; border-radius:5px; padding: 5px;margin-bottom: 10px ">
    <input type="checkbox" name="left_items" id="left_items_checkbox"  style="display: none;">
    <div data-hide="no" style="margin-bottom: 10px;">
        <button type="button" class="btn btn-secondary" onclick="showOrHide('#item_statuses')">ნივთის სტატუსები </button>
        <button type="button" class="btn btn-secondary" onclick="showOrHide('#statuses')">გან. სტატუსები</button>
        <button type="button" class="btn btn-secondary" onclick="showOrHide('#sites')">საიტები </button>
        <button type="button" class="btn btn-secondary" onclick="showOrHide('#banks')">გადახდის მეთოდები </button>
        <button type="button" class="btn btn-success"   onclick="showOrHide('#supplier_pay_div')">მომწოდებელი </button>
        <button type="button" class="btn btn-success"   onclick="showOrHide('#buttons')">ღილაკები </button>
        <button type="button" class="btn btn-success"   onclick="showOrHide('#details')">დეტალები </button>
        <button type="button" class="btn btn-success"   onclick="showOrHide('#dates')">თარიღები </button>
        
        
        
    </div>



    <div class="btn-group filter-group" id="item_statuses" style="display: inline-block; column-count: 6; display:none; ">
        <?php $__currentLoopData = $ITEM_STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$istatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="dropdown" style="margin-bottom: 10px; position: unset;" >
                <a class="btn btn-secondary dropdown-checkbox ">
                    <input type="checkbox" name="item_statuses[]" value="<?php echo e($key+1); ?>"><?php echo e($istatus); ?>

                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="dropdown" style="margin-bottom: 10px; position: unset;" >
            <a class="btn btn-secondary dropdown-checkbox ">
                <input type="checkbox" name="beforesend">გაგზავნამდე
            </a>
        </div>

    </div>
    
    <div class="btn-group filter-group" id="supplier_pay_div" style="display: inline-block; column-count: 6; display:none; ">
        <label class="btn btn-success " style="background:darkseagreen">
            <select name="supplier" >
                <option value=""></option>
                <?php $__currentLoopData = $data['suppliers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sup->id); ?>"><?php echo e($sup->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select> მომწოდებელი
        </label>
    </div>

    <div class="btn-group filter-group" id="statuses" style="display: inline-block; column-count: 6; display:none; ">
        <?php ($innerStatus = \App\Models\InnerStatus::all()); ?>
        <?php $__currentLoopData = $innerStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(in_array($inner->id, [19, 20, 29, 38, 49, 46, 22])): ?>
            <div class="dropdown" style="margin-bottom: 10px; position: unset;" >
                <a class="btn btn-secondary dropdown-checkbox ">
                    <input type="checkbox" style="" name="inner_statuses[]" value="<?php echo e($inner->id); ?>"><?php echo e($inner->name); ?>

                </a>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
         
    <div class="btn-grosup" id="buttons" style=" display:none; ">
         <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                შესაყვანი მისამართები
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item address_not_filled" href="#" data-status="1">საყიდელია</a>
                <a class="dropdown-item address_not_filled" href="#" data-status="3">გასაცემია</a>
            </div> 
        </div>   
        <button class="btn btn-success" id="misseds">გამორჩენილები</button>
        <button class="btn btn-success" id="to_buy">ყველა საყიდელი</button>
        <button class="btn btn-success" id="all_today">ყველა დღევანდელი</button>
        <button class="btn btn-success" id="all_yesterday">ყველა გუშინდელი</button>
        <button class="btn btn-success sell_date_filter" 
            data-from="<?php echo e(\Carbon\Carbon::now()->subDay(1)->format('Y-m-d')); ?>"
            data-to="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"
        >გუშინდელი გაცემულია</button>
        <button class="btn btn-success gasacemistatusbutton" 
            data-from="<?php echo e(\Carbon\Carbon::parse('today midnight')->format('Y-m-d')); ?>"
            data-to="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"
        >დღევანდელი გასაცემია</button>
    </div>


    <div class="btn-group filter-group" id="sites" style="display: inline-block; column-count: 6; display:none; ">
        <?php $__currentLoopData = $data['sites']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="btn btn-success" style="background:darkseagreen">
                <input type="checkbox" name="sites[]" value="<?php echo e($site->id); ?>"> <?php echo e($site->name); ?>

            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


    <div class="btn-group filter-group" id="banks" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
        <?php $__currentLoopData = $pay_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kk => $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="btn btn-success " style="background:darkseagreen">
                <input type="checkbox" name="pay_methods[]" value="<?php echo e($kk); ?>"> <?php echo e($pm); ?>

            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
         


    
    <div  class="btn-group filter-group" id="fields" style="display: inline-block;  column-count: 5; margin-top: 15px; display:none;">
        <?php $i = 0; ?>
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="btn btn-success " style="background:darkseagreen; ">
                <input type="checkbox" onchange="showColumn(<?php echo e($i+1); ?>, event.target.checked)" <?php echo e($fff['show'] ? 'checked' :''); ?>  > <?php echo e($fff['label']); ?>

            </label>
        <?php $i ++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <button class="btn btn-danger" id="saveview" style="text-align: center; margin-top: 10px;" >
            შენახვა
        </button>
    </div>

    <div  class="btn-group filter-group" id="dates" style="display: inline-block;  column-count: 4; margin-top: 15px; display:none;">
        <label class="btn btn-success " style="background:darkseagreen">
            <input type="date" name="sayidelia_from" style="margin-right: 3px"/>საყიდელია - დან
        </label>
        <label class="btn btn-success " style="background:darkseagreen">
            <input type="date" name="sayidelia_to" style="margin-right: 3px"/>საყიდელია - მდე
        </label>

        <label class="btn btn-success " style="background:darkseagreen">
            <input type="date" name="gacemulia_from" style="margin-right: 3px"/>გაცემულია - დან
        </label>
        <label class="btn btn-success " style="background:darkseagreen">
            <input type="date" name="gacemulia_to" style="margin-right: 3px"/>გაცემულია - მდე
        </label>

        <label class="btn btn-success " style="background:darkseagreen">
            <input type="date" name="status_from" style="margin-right: 3px"/>სტატუსი - დან
        </label>
        <label class="btn btn-success " style="background:darkseagreen">
            <input type="date" name="status_to" style="margin-right: 3px"/>სტატუსი - მდე
        </label>

        <label class="btn btn-success " style="background:darkseagreen">
            <input type="date" name="automatic_sell_date" id="automatic_sell_date" style="margin-right: 3px" value="<?php echo e(date('Y-m-d')); ?>" />გაცემის თარიღი
        </label>
    </div>

    
    <div class="btn-group filter-group" id="details" style="display: inline-block;  column-count: 3; margin-top: 15px; display:none;">
             
        <label class="btn btn-success " style="background:darkseagreen">
            <select name="district_id" >
                <option value=""></option>
                <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($district->id); ?>"><?php echo e($district->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select> უბანი
        </label>     

        <label class="btn btn-success " style="background:darkseagreen">
            <select name="color" >
                <option value=""></option>
                <?php $__currentLoopData = COLORS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($color); ?>"><?php echo e($name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select> ფერი
        </label>

        <label class="btn btn-success " style="background:darkseagreen">
            <select name="cred_pay" >
                <option value=""></option>
                <option value="0">ჩასარიცხი</option>
                <option value="1">ჩარიცხული</option>
            </select> Cred. ჩარიცხვა
        </label>
        
        <label class="btn btn-success " style="background:darkseagreen">
            <select name="company" >
                <option value=""></option>
                <option value="crd">კრედიტამაზონი</option>
                <option value="tch">ტექპლიუსი</option>
                <option value="ctr" disabled="">ციტრუსი</option>
            </select> კომპანია
        </label>
        
        
        <label class="btn btn-success " style="background:darkseagreen">
            <select name="return_status" >
                <option value="" selected></option>
                <option value="1">უკან დაბრუნება</option>
                <option value="2">ზედნადები გაუქმებულია</option>
            </select> უკან დაბრუნება
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
            <select name="rs_status" >
                <option value="" selected></option>
                <option value="0">არა</option>
                <option value="1">კი</option>
            </select> rs. სტატუსი
        </label>
        <label class="btn btn-success " style="background:darkseagreen">
            <select name="supplier_pay" >
                <option value=""></option>
                <option value="0">ჩასარიცხია</option>
                <option value="1">ჩარიცხულია</option>
            </select> მომწ. ჩარიცხვა
        </label>
        <label class="btn btn-success " style="background:darkseagreen">
            <select name="crystal_canceled" >
                <option value=""></option>
                <option value="0">გადასარიცხია</option>
                <option value="1">გადარიცხულია</option>
            </select> გაუქმებულია კრისტალი
        </label>
        <label class="btn btn-success " style="background:darkseagreen">
            <select name="is_canceling" >
                <option value=""></option>
                <option value="0"></option>
                <option value="1">აუქმებს</option>
                <option value="2">ხელი მოწერილია</option>
            </select> გაუქმების სტატუსი
        </label>
        <label class="btn btn-success " style="background:darkseagreen">
            <input type="text" name="cgd_number" />
            ჩგდ-ს ნომერი
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
            <?php ($onway_statuses = \App\Models\Onway::STATUSES); ?>
            <select name="onway_statuses[]" multiple="" class="form-control" style="width: unset">
                <?php $__currentLoopData = $onway_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($st); ?>"><?php echo e($st); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            Onway სტატუსისთვის
        </label>
    </div>



    
    <div data-hide="no" style="margin-top: 10px; display: inline-block">
        <input  type="text" class="form-control" style="width: unset" name="request_id" id="request_id" placeholder="ID">
        <input  type="text" class="form-control" style="width: unset" name="name" id="name" placeholder="სახელი">
        <input  type="text" class="form-control" style="width: unset" name="lastname" id="lastname" placeholder="გვარი">
        <input  type="text" class="form-control" style="width: unset" name="personal_id" id="personal_id" placeholder="პირადი ნომერი">
        <input  type="text" class="form-control" style="width: unset" name="number" placeholder="ტელეფონის ნომერი">
        <input  type="text" class="form-control" style="width: unset" name="item_name" placeholder="ნივთის სახელი" />

    </div>


</div>
</form>
<div class="row p-10">
    <div class="col-md-12 nomargin">
        <button class="btn btn-danger" id="applyFilter">ფილტრი</button>
    </div>
</div>

<script>

    $(document).ready(function(){
        $('#applyFilter').click(function(){
            formdata = $('#filterForm').serializeArray();
            formdata = $('#filterForm').serialize();

            url = filterTableUrl + '?ss=qw&' + formdata;
        
            updateItemsTable({url: url});
        });
        
        $('#filterForm').on('keypress', function(e){
            console.log(e.keyCode);
            if(e.keyCode === 13){
                e.preventDefault();
                $('#applyFilter').click();
            }
        });

    });



    loadItemStatusSelect = function(selector){
        var html = '';
        ITEM_STATUSES.map(function(val, idx){
            html += `<option value="${idx != 0 ? idx : ''}" >${val}</option>`;
        });
        selector.html(html);
    }

    loadItemSuppliersSelect = function(selector){
        var html = '';
        [{id: '', name: ""}, ...ITEM_SUPPLIERS].map(function(val){
            html += `<option value="${val.id}" >${val.name}</option>`;
        });
        selector.html(html);
    }

    
    function showColumn(index, boolshow){
        columnindex = window.hidden_columns.indexOf(index);

        if(!boolshow) {
            if(columnindex == -1) {
                window.hidden_columns.push(index);
            }
        } else {
            if(columnindex > -1) {
                window.hidden_columns.splice(columnindex, 1);
            }
        }
        
        window.items_table.column(index).visible(boolshow);
        openRequestClickListener();
    }


    $('#saveview').click(function(e){
        e.preventDefault();
        if(confirm('დარწმუნებული ხართ რომ გსურთ ამ წყობის შენახვა?')) {
            localStorage.setItem('hidden_columns', window.hidden_columns);
        }
    });
</script>


<style>
    .nomargin {
        margin:0 !important;
    }
    .form-group {
        margin-left: 5px;
    }
    #multipleeditform {
        display: -webkit-box;
    }
</style>



<style>
.btn-group .btn {width: 100%;text-align: left;padding: 3px;}
.btn-group.filter-group { display: none; }
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