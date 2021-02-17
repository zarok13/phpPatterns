<?php $__env->startSection('scripts'); ?>
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <script src="/assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

    <link href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>

    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
       
    </style>

    <script>
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons'); ?>
    
<?php $__env->stopSection(); ?>
<?php
    $isManager = false;
    $isOperator = false;
    $isAdmin = false;
    $isTechplusManager = false;

    if(Auth::user()->hasRole('MANAGER')) {
        $isManager = true;
    } elseif(Auth::user()->hasRole(['OPERATOR', 'TECHPLUS_OPERATOR', 'SIGNATURE_OPERATOR'])) {
        $isOperator = true;
    } elseif(Auth::user()->hasRole('SUPER_ADMIN')) {
        $isAdmin = true;
    } elseif(Auth::user()->hasRole('TECHPLUS_MANAGER')){
        $isTechplusManager = true;
    }

    if(!$isManager && !$isOperator && !$isAdmin && !$isTechplusManager) {
        die('არ გაქვთ ამ  გვერდის ნახვის უფლება');
    }
?>


<?php $__env->startSection('content'); ?>
    


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body ">
                   
                    <ul class="nav nav-tabs customtab2" role="tablist">
                        <?php if($isAdmin || $isManager): ?>
                        <li class="nav-item"> <a class="nav-link " onclick="createCalledsTable()" data-toggle="tab" href="#calleds" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">დარეკილი განაცხადები</span></a> </li>
                        <?php endif; ?>
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#calls" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">დასარეკები</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" id="not_responding_tab" href="#not_responding" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">არ იღებს</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" id="not_approved_tab" href="#not_approved" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">დაუარებულები</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" id="history_tab" href="#history" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">ისტორია</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" id="thinking_tab" href="#thinking" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">მოიფიქრებები</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" id="notifications_tab" href="#notifications" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">შეხსენებები</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" id="incomplete_tab" href="#incomplete" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">დაუსრულებლები</span></a> </li>
                        <?php if($isManager || $isAdmin): ?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" id="active_users_tab" href="#active_users" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">ოპერატორები</span></a> </li>
                        <?php endif; ?>
                    </ul>
                    

                    <div class="tab-content">
                        <?php
                            $users = \App\User::select('id', 'name')->orderBy('enabled', 'desc')->where('enabled', 1)->get();
                            $statuses = \App\Models\InnerStatus::select('id', 'name')->get();
                        ?>
                        <div class="tab-pane" id="calleds" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12" style="margin: 10px 0px">
                                    <form id="calleds_filter_form">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <select multiple name="user_id[]" class="form-control">
                                                    <option value="">ოპერატორი</option>
                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <select name="old_status" class="form-control">
                                                    <option value="">საწყისი სტატუსი</option>
                                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($status->id); ?>"><?php echo e($status->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <select name="new_status" class="form-control">
                                                    <option value="">მინიჭებული სტატუსი</option>
                                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($status->id); ?>"><?php echo e($status->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <select name="inner_status" class="form-control">
                                                    <option value="">განაცხადის სტატუსი</option>
                                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($status->id); ?>"><?php echo e($status->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <input type="date" class="form-control" name="date_from" style="max-width: 45%; float: left;margin-right: 5px;" >
                                            <input type="date" class="form-control" name="date_to" style="max-width: 45%;float: left; ">
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            
                                            <div class="form-group">
                                                <input type="checkbox" name="cancel_date">
                                                <label for="">გაუქმების თარიღით</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="canceled_call">
                                                <label for="">გაუქმებებთან დარეკვა</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="request_date">
                                                <label for="">გამოგზავნის თარიღით</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="status_date">
                                                <label for="">ბოლო მოქმედების თარიღით</label>
                                            </div>
                                        
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="show_lockeds">
                                                <label for="">დაუსრულებელი განაცხადები</label>
                                            </div>                                        
                                            <div class="form-group">
                                                <input type="checkbox" name="enabled_notif">
                                                <label for="">შეხსენებით</label>
                                            </div>                                        
                                            <div class="form-group">
                                                <input type="checkbox" name="late_notif">
                                                <label for="">დაგვიანებული შეხსენება</label>
                                            </div>                                        
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                
                                <div class="col-md-12" style="margin: 10px 0x">
                                    <table id="calleds_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>###</th>
                                                <th>ID</th>
                                                <th>დარეკვის თარიღი</th>
                                                <th>სახელი /გვარი /ნომერი</th>
                                                <th>ოპერატორი</th>
                                                <th>საწყისი სტატუსი</th>
                                                <th>მინიჭებული სტატუსი</th>
                                                <th>სტატუსი</th>
                                                <th>შეხს.</th>
                                            </tr>
                                        </thead>
                                        <tbody id="calleds_table_body">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>###</th>
                                                <th>ID</th>
                                                <th>დარეკვის თარიღი</th>
                                                <th>სახელი/გვარი/ნომერი</th>
                                                <th>ოპერატორი</th>
                                                <th>საწყისი სტატუსი</th>
                                                <th>მინიჭებული სტატუსი</th>
                                                <th>სტატუსი</th>
                                                <th>შეხს.</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane active" id="calls" role="tabpanel">
                            <div class="m-10" style="float: right">
                                <?php if($isOperator): ?>
                                <button class="btn btn-success" id="start_working" >მუშაობის დაწყება</button>
                                <button class="btn btn-danger" id="finish_working" style="">გაჩერება</button>
                                <button class="btn btn-info" style="display: none" id="open_modal_button" onclick="$('#View_Modal').modal('toggle');">ბოლო განცხადების გახსნა</button>
                                <?php endif; ?>
                                <button class="btn btn-info" id="refresh_calls" style="">გაახლება</button>
                            </div>
                            <table id="Call_table"  class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <?php if($isAdmin || $isManager): ?>
                                        <th>ოპერატორი</th> 
                                        <?php endif; ?>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody id="Call_table_body">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <?php if($isAdmin || $isManager): ?> 
                                        <th></th>  
                                        <?php endif; ?>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="redirecteds" role="tabpanel">
                            <table id="redirecteds_table"  class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody id="">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="notifications" role="tabpanel">
                            <table id="notifications_table"  class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>შეხსენება</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>შეხსენება</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>



                       
                        <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                            
                        </div>

                        
                        <?php echo $__env->make('operator.partials.add_operator_request_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                        <div class="modal fade bs-example-modal-lg" data-backdrop="static" id="create_request_modal" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">            
                            <div class="modal-dialog modal-lg"  style="max-width: 80%; min-width: 80% !important">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6>ჩგდ-ს დამატება</h6>
                                        <button type="button" class="close" data-dismiss="modal" >×</button>
                                    </div>

                                    <div class="modal-body" id="create_request_body" >   
                                        <?php echo $__env->make('techplus.requests.create_request', ['edit_links' => true, 'script' => 'document.location.reload();'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>

                                </div>
                            </div>        
                        </div>



                        <div class="tab-pane p-20" id="not_responding" role="tabpanel">
                            <table id="not_responding_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane p-20" id="not_approved" role="tabpanel">
                            <select id="changenotapprovedtable">
                                <option value="24">TBC ბანკი</option>
                                <option value="52">VTB ბანკი</option>
                                <option value="55">კრისტალი</option>
                                <option value="26">კრედო ბანკი</option>
                                <option value="65">გაუქმებულია კრედო</option>
                            </select>

                            <table id="not_approved_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>გაგზავნის თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="tab-pane p-20" id="called" role="tabpanel">3</div>

                        <div class="tab-pane p-20" id="history" role="tabpanel">
                            <table id="history_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>ხანგრძლივობა</th>
                                        <th>შენიშვნა</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>ხანგრძლივობა</th>
                                        <th>შენიშვნა</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="tab-pane p-20" id="incomplete" role="tabpanel">
                            <table id="incomplete_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="tab-pane p-20" id="thinking" role="tabpanel">
                            <table id="thinking_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>თარიღი</th>
                                        <th>სახელი/გვარი</th>
                                        <th>ტელეფონის ნომერი</th>
                                        <th>შენიშვნა</th>
                                        <th>ფასი</th>
                                        <th>შიდა სტატუსი</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        
                        <?php if($isAdmin || $isManager): ?>
                        <div class="tab-pane p-20" id="active_users" role="tabpanel">
                            <table id="active_users_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>სახელი</th>
                                        <th>განაცხადები</th>
                                        <th>ჩართვა</th>
                                        <th>დაპაუზება</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php ($users = \App\User::where('enabled', 1)->orderBy('is_working', 'DESC')->select('id', 'name', 'is_working', 'is_ganvadeba_user', 'opened_requests')->get()); ?>
                                    <?php ($userrequests = \App\Http\Controllers\Operator\RequestController::getUserRequests()); ?>

                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->hasRole(['OPERATOR'])): ?>
                                        <tr>
                                            <td><?php echo e($user->id); ?></td>
                                            <td><?php echo e($user->name); ?> <label class="label label-<?php echo e($user->is_ganvadeba_user ? 'primary' : 'success'); ?>"><?php echo e($user->is_ganvadeba_user ? 'განვადება' : 'ჩგდ'); ?></label></td>
                                            
                                            <td><?php echo e(isset($userrequests[$user->id]) ? $userrequests[$user->id] : ''); ?></td>
                                            <td>
                                                ჩართული: <input class="user_checkbox" data-user_id="<?php echo e($user->id); ?>" type="checkbox" <?php echo $user->is_working ? 'checked=""' : ''; ?> />
                                            </td>
                                            <td>
                                                დაპაუზებული: <input class="user_checkbox_pausing" data-pause="1" data-user_id="<?php echo e($user->id); ?>" type="checkbox" <?php echo !$user->is_working ? 'checked=""' : ''; ?> />
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                            <script>
                                $(document).ready(function(){
                                    $('.user_checkbox').on('change', function(){
                                        var checked = $(this).prop('checked') ? 1 : 0;
                                        var user_id = $(this).data('user_id');
                                        
                                        $.ajax({
                                            url: '/changeuserstate',
                                            type: 'POST',
                                            data: {i:1, is_working: checked, user_id: user_id},
                                        });
                                    });
                                    $('.user_checkbox_pausing').on('change', function(){
                                        var checked = !$(this).prop('checked') ? 1 : 0;
                                        var user_id = $(this).data('user_id');
                                        
                                        $.ajax({
                                            url: '/changeuserstate',
                                            type: 'POST',
                                            data: {i:1, is_working: checked, user_id: user_id, pausing: 1},
                                        });
                                    });

                                });
                            </script>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <?php echo $__env->make('operator.partials.calleds_edit_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
</div>


<?php if (\Entrust::hasRole(['OPERATOR'])) : ?>
    <script>
        window.show_names = false;
    </script>
<?php endif; // Entrust::hasRole ?>
<?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
    <script>
        $(document).ready(function(){
            create_calls_table();
        });
        window.show_names = true;
    </script>
<?php endif; // Entrust::hasRole ?>
    <script>
        CALLED_SELECTED_ROWS = [];
        
        $(document).ready(function(){
            // $('#start_working').click();
        });
        createCalledsTable = function(){
            var url = $('#calleds_filter_form').serialize();
            
            window.calleds_table = $('#calleds_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                displayLength: 50,
                ajax: '/operator/loadmanager?i=1&'+url,
				"aaSorting": [
					[0, "DESC" ]
				],
                select: {
                    style:    'multi', 
                    selector: 'td:first-child'
                },
                buttons: [
                    {
                        text: 'მონიშვნა',
                        action: function () {
                            calleds_table.rows( { selected: true } )[0].length ? 
                                calleds_table.rows(':visible').deselect() : 
                                calleds_table.rows(':visible').select();
                        }
                    },{
                        text: 'მოქმედებები',
                        action: function () {
                            $('#calleds_edit_modal').modal('toggle');
                        }
                    },{
                        text: 'ძებნა',
                        action: function () {
                            createCalledsTable();
                        }
                    },
                    'colvis', 
                ],  
                columns: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    },
                    {"data":  "request_id" },
                    {"data":  "created_at" },
                    {"data":  "name" },
                    {"data":  "caller.name" },
                    {"data":  function(val){
                        if(val.old_status) {
                            return val.old_status;
                        } else {
                            return 'არ აქვს';
                        }
                    } },
                    {  "data":  function(val){
                        if(val.new_status) {
                            return val.new_status;
                        } else {
                            return 'არ აქვს';
                        }
                    } },
                    {  "data":  'inner_status_name'},
                    { "data": "notif_time"},     
                ],
                initComplete: function(){
                    updateCheckboxSelection();
                }
            });

            $('#calleds_table tbody').off('click');
            $('#calleds_table tbody').on('click', 'tr', function () {
                var data = calleds_table.row( this ).data();
                showOrder(data.request_id);
            });
            return ;

        }
        

        updateCheckboxSelection = function(){
            calleds_table.off( 'select');
            calleds_table
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = calleds_table.rows(indexes).data().toArray();
                    $.each(rowData, function(idx, val){
                        addToSelection(val.log_id);
                    });
                    console.log(CALLED_SELECTED_ROWS);
                } )
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = calleds_table.rows( indexes ).data().toArray();
                    $.each(rowData, function(idx, val){
                        deleteFromSelection(val.log_id);
                    });
                    console.log(CALLED_SELECTED_ROWS);
                } );
        }



        function addToSelection(ID){
            var index = CALLED_SELECTED_ROWS.indexOf(ID);
            if( index == -1 ){
                CALLED_SELECTED_ROWS.push(ID);
            } 
        }
        function deleteFromSelection(ID){
            var index = CALLED_SELECTED_ROWS.indexOf(ID);
            if( index != -1){
                CALLED_SELECTED_ROWS.splice(index, 1);
            } 
        }











        var elapsed_seconds = 0; 
        var timer = 0;
        function create_calls_table(){
            $('#Call_table_body').empty();
            $('#Call_table tbody').off( 'click', 'tr');
            $('#Call_table').DataTable().destroy();
			
            table = $('#Call_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [{
                    text: 'ჩგდ-ს დამატება',
                    action: function () {
                        return $('#create_request_modal').modal('toggle');
                    }
                }, {
                    text: 'ახალი განაცხადი',
                    action: function () {
                        return $('#add_request_operator_modal').modal('toggle');
                    }
                }],  
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                displayLength: 20,
                ajax: '/operator/loadcalls',
				order: [
					[1, "ASC" ]
				],
                <?php if(\Auth::user()->id): ?>
                ordering: false,
                <?php endif; ?>
                columns: [
                    { "data": function(val){
                        return `<span class="${val.priority == 5 ? 'priority' : ''} ${val.color && 'id-color-' + val.color}" >${val.id}</span>`;
                    }, },               // #
                    { "data": function(value){
                        return window.show_names ? value.people.name : '';
                    } },      // სახელი / გვარი
                    { "data": function(val) {
                        <?php if (\Entrust::hasRole(['OPERATOR'])) : ?>
                            return val.people.number.substring(0, val.people.number.length - 3) + '***';
                        <?php endif; // Entrust::hasRole ?>
                        return val.people.number;
                    } },    // ტელეფონის ნომერი
                    { "data": function(value){
                        return '';
                        return value.text.slice(0, 30) + '...';
                    } },                            // შენიშვნა
                    <?php if($isAdmin || $isManager): ?>
                    { "data": function(value){
                        return value.assigneduser ? value.assigneduser.name : '';
                    } },      
                    <?php endif; ?>
                    { "data":  function(value){
                        if(value.inner_status == 'undefined' || value.inner_status == null){
                            return 'არ აქვს';
                        } else if(value.inner_status.length < 1) {
                            return 'არ აქვს';   
                        } else {
                            return value.inner_status[0].name;   
                        }
                    } },                            // შიდა სტატუსი
                ],
                rowCallback: function(row, data, index) {
                    if(!data.is_locked){
                        $(row).addClass('color')
                    }
                },
                initComplete: function(){
                    edittableinfo = function(){
                        var info = $('#Call_table_info').html();
                        var new_info = info.split('დან');
                        var new_info = new_info[0] + ' დან ' + '<?php echo e($count); ?>';
                        $('#Call_table_info').html(new_info);
                    }
                    $('#Call_table_paginate').off('click');
                    $('#Call_table_paginate').on('click', function(){
                        edittableinfo();
                    });
                    edittableinfo();
                }
            });

            
            $('#Call_table tbody').on('click', 'tr', function () {
                var data = table.row( this ).data();
                showOrder(data.id);
            });
            return ;
        }
        
        

        $('#refresh_calls').on('click', function(){
            // alert('call_clicked');
            // if(elapsed_seconds){
                create_calls_table();
            // }
        });

        $('#start_working').on('click', function(){
            
            create_calls_table();

            
            timer = setInterval(function() {
                if(elapsed_seconds < 900){
                    elapsed_seconds = elapsed_seconds + 1;
                    $('#start_working').text(get_elapsed_time_string(elapsed_seconds));
                }
                // else {
                //     $.ajax({
                //         type: "GET",
                        
                //         url: "/operator/time_elapsed/",
                //         success: function (response) {
                //             $('#open_modal_button').css('display', 'inline-block ');
                //             $('#View_Modal').html(response);
                //             $('#View_Modal').modal('toggle');
                //         }
                //     });
                // }
            }, 1000);
            $(this).prop('disabled', true);
            $(this).css('color', 'black');
            
            
            animate_timer = 0;
            
        });
        
        $('#not_responding_tab').on('click', function(){
            $('#not_responding_table tbody').off( 'click', 'tr');

            var not_responding_table = $('#not_responding_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [],
                order: [[0, 'desc']],
                displayLength: 20,
                ajax: '/operator/load_not_respondings',
                columns: [
                    { "data": "id" },  // #
                    //{ "data": "date" }, // თარიღი
                    { "data": "people.name" }, // სახელი /გვარი
                    { "data": "people.number" }, // ტელეფონის ნომერი
                    { "data": function(value){
                        return value.text.slice(0,10) + '...';
                    } }, // შენიშვნა
                    { "data": "price" }, // ფასი
                    { "data":  function(value){
                        if(value.inner_status == 'undefined' || value.inner_status == null){
                            return 'არ აქვს';
                        }
                        else if(value.inner_status.length < 1) {
                            return 'არ აქვს';   
                        } else {
                            return value.inner_status[0].name;   
                        }
                    } }, // შიდა სტატუსი
                ]
            });

            $('#not_responding_table tbody').on('click', 'tr', function () {
                window.not_responding_request = true;
                var data = not_responding_table.row( this ).data();
                showOrder(data.id);
            });
            
        });
        

        
        function createNotApprovedTable(){
            var statusId = $('#changenotapprovedtable').val();
            
            $('#not_approved_table tbody').off( 'click', 'tr');
            
            var not_approved_table = $('#not_approved_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [
                ],
                displayLength: 20,
                ajax: '/operator/load_not_approveds?k=2&statusid='+statusId,
                columns: [
                    { "data": "id" },  // #
                    { "data": "date" }, // თარიღი
                    { "data": "created_at" }, // თარიღი გაგაზ
                    { "data": "people.name" }, // სახელი /გვარი
                    { "data": "people.number" }, // ტელეფონის ნომერი
                    { "data": function(value){
                        return value.text.slice(0,30) + '...';
                    } }, // შენიშვნა
                    { "data": "price" }, // ფასი
                    { "data":  function(value){
                        if(value.inner_status == 'undefined' || value.inner_status == null){
                            return 'არ აქვს';
                        }
                        else if(value.inner_status.length < 1) {
                            return 'არ აქვს';   
                        } else {
                            return value.inner_status[0].name;   
                        }
                    } }, // შიდა სტატუსი
                ]
            });

            $('#not_approved_table tbody').off('click');
            
            $('#not_approved_table tbody').on('click', 'tr', function () {
                var data = not_approved_table.row( this ).data();
                showOrder(data.id);
            });
            
        };

        $('#changenotapprovedtable').on('change', createNotApprovedTable);

        $('#not_approved_tab').on('click', createNotApprovedTable);
        

        $('#incomplete_tab').on('click', function(){
            $('#incomplete_table tbody').off( 'click', 'tr');

            var incomplete_table = $('#incomplete_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [
                ],
                displayLength: 20,
                ajax: '/operator/load_incomplete',
                columns: [
                    { "data": "id" },  // #
                    { "data": "date" }, // თარიღი
                    { "data": "people.name" }, // სახელი /გვარი
                    { "data": "people.number" }, // ტელეფონის ნომერი
                    { "data": function(value){
                        return value.text ? value.text.slice(0,30) + '...' : '';
                    } }, // შენიშვნა
                    { "data": "price" }, // ფასი
                    { "data":  function(value){
                        if(value.inner_status == 'undefined' || value.inner_status == null){
                            return 'არ აქვს';
                        }
                        else if(value.inner_status.length < 1) {
                            return 'არ აქვს';   
                        } else {
                            return value.inner_status[0].name;   
                        }
                    } }, // შიდა სტატუსი
                ]
            });

            $('#incomplete_table tbody').on('click', 'tr', function () {
                var data = incomplete_table.row( this ).data();
                showOrder(data.id);
            });
            
        });

        $('#notifications_tab').on('click', function(){
            $('#notifications_table tbody').off( 'click', 'tr');
            $(this).css('background', 'unset');

            var notifications_table = $('#notifications_table').DataTable({
                destroy: true,                
                dom: 'frtip',
                displayLength: 20,
                ajax: '/operator/load_notifications',
                order: [[1, 'ASC']],
                columns: [
                    {
                        data: null,
                        render: function(val){
                            return `<span style="color:${val.active ? 'red' : 'green'}"> ${val.id}</span>`;
                        }
                    },  // #
                    { "data": "date" }, // თარიღი
                    { "data": "people.name" }, // სახელი /გვარი
                    { "data": "people.number" }, // ტელეფონის ნომერი
                    { "data": function(value){
                        return value.text ? value.text.slice(0,30) + '...' : '';
                    } }, // შენიშვნა
                    { "data": "notiftext" }, // შენიშვნა
                    { "data": "price" }, // ფასი
                    { "data":  function(value){
                        if(value.inner_status == 'undefined' || value.inner_status == null){
                            return 'არ აქვს';
                        }
                        else if(value.inner_status.length < 1) {
                            return 'არ აქვს';   
                        } else {
                            return value.inner_status[0].name;   
                        }
                    } }, // შიდა სტატუსი
                ]
            });

            $('#notifications_table tbody').on('click', 'tr', function () {
                var data = notifications_table.row( this ).data();
                showOrder(data.id);
            });
            
        });

        $('#thinking_tab').on('click', function(){
            $('#thinking_table tbody').off( 'click', 'tr');
            
            var thinking_table = $('#thinking_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [
                ],
                displayLength: 20,
                ajax: '/operator/load_thinkings',
                columns: [
                    { "data": "id" },  // #
                    { "data": "date" }, // თარიღი
                    { "data": "people.name" }, // სახელი /გვარი
                    { "data": "people.number" }, // ტელეფონის ნომერი
                    { "data": function(value){
                        return value.text.slice(0,30) + '...';
                    } }, // შენიშვნა
                    { "data": "price" }, // ფასი
                    { "data":  function(value){
                        if(value.inner_status == 'undefined' || value.inner_status == null){
                            return 'არ აქვს';
                        }
                        else if(value.inner_status.length < 1) {
                            return 'არ აქვს';   
                        } else {
                            return value.inner_status[0].name;   
                        }
                    } }, // შიდა სტატუსი
                ]
            });

            $('#thinking_table tbody').on('click', 'tr', function () {
                var data = thinking_table.row( this ).data();
                showOrder(data.id);
            });
            
        });


        $('#history_tab').on('click', function(){
            $('#history_table tbody').off( 'click', 'tr');
            
            var history_table = $('#history_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [
                ],
                
				"aaSorting": [
					[0, "DESC" ]
				],
                displayLength: 20,
                ajax: '/operator/loadHistory',
                columns: [
                    { "data": "updated_at" }, // თარიღი
                    { "data": "request.people.name" }, // სახელი /გვარი
                    { "data": "request.people.number" }, // ტელეფონის ნომერი
                    { "data": "call_duration" }, // ხანგრძლივობა
                    { "data": function(value){
                        if(value.request){
                            return value.request.text ? value.request.text.slice(0,30) + '...' : 'norequest';
                        }
                    } }, // შენიშვნა
                    { "data":  function(value){
                        if(!value.request) {
                            return;
                        }
                        if(value.request.inner_status[0] == 'undefined' || value.request.inner_status[0] == null){
                            return 'არ აქვს';
                        }
                        else return value.request.inner_status[0].name;
                    } }, // შიდა სტატუსი
                ] 
            });

            $('#history_table tbody').on('click', 'tr', function () {
                var data = history_table.row(this).data();
                showOrder(data.request_id);
            });
            
        });

    
        $('#finish_working').on('click', function(){
            clearTimeout(timer);
            $('#finish_working').text('გაგრძელება');
            // $.ajax({
            //     type: "GET",
            //     url: "/operator/time_elapsed/",
            //     success: function (response) {
            //         $('#open_modal_button').css('display', 'inline-block ');
            //         $('#View_Modal').html(response);
            //         $('#View_Modal').modal('toggle');
            //     }
            // });
        });


        


        function showOrder(order_id){
            $.ajax({
                type: "GET",
                url: "/operator/showOrder/"+order_id+'/',
                success: function (response) {
                    $('#open_modal_button').css('display', 'inline-block ');
                    $('#View_Modal').html(response);
                    $('#View_Modal').modal('toggle');
                }
            });
        }

        checkNotification = function(){
            $.ajax({
                url: '<?php echo e(route('operator.checknotif')); ?>',
                success: function(data) {
                    if(data.notifications) {
                        $('#notifications_tab').css('background', '#a9a5a5');
                        $.toast({
                            "heading": 'შეხსენება',
                            "text": data.text,
                            "position": 'center-right',
                            "loaderBg": '#00782D',
                            "icon": 'success',
                            "hideAfter": 30000, 
                            "stack": 8
                        });
                    }

                    if(data.log) {
                        $('#redirecteds_tab').css('background', '#a9a5a5');
                        $.toast({
                            "heading": data.log + ' გადმომისამართებული განცხადება',
                            "text": '',
                            "position": 'center-right',
                            "loaderBg": '#00782D',
                            "icon": 'success',
                            "hideAfter": 3000, 
                            "stack": 8
                        });
                    }
                }
            });
        }
        checkNotification();
        setInterval(checkNotification, 1000 * 60 * 5)
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

    <style>
        .priority { background-color: red}
        .calleds_table * {
            cursor: initial !important;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>