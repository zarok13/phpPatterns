<?php
    $credostatuses = [
        2 => ['status' => 'გადაგზავნილი', 'color' => '#d0d0d0'],
        3 => ['status' => 'დამტკიცებული', 'color' => '#a3ff7f'],
        4 => ['status' => 'საბოლოოდ დამტკიცებული', 'color' => '#a3ff7f'],
        5 => ['status' => 'წარმატებით დახურული', 'color' => '#8082e0'],
        6 => ['status' => 'დაუარებული', 'color' => '#ff6184'],
        7 => ['status' => 'გაუქმებული', 'color' => '#b9af29']
];

?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <form action="<?php echo e(route('banks.credoapprovals')); ?>" method="get">
                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <div class="form-group">
                            <?php echo csrf_field(); ?>
                            <input type="date" class="form-control col-lg-2" name="date_from" value="<?php echo e(isset($request->date_from) ? $request->date_from :'2018-12-07'); ?>">
                            <input type="date" class="form-control col-lg-2" name="date_to" value="<?php echo e(isset($request->date_to) ? $request->date_to : ''); ?>" >
                            <input type="submit" class="btn btn-success" value="გაფილტვრა" >
                        </div>
                    </div>
                </div>
                
            </form>
            <div class="row">
                <div class="col-md-12" style="margin: 0">
                    <div class="form-group">
                        <button class="btn btn-outline-dark" id="get_all">მონაცემების წამოღება</button>
                        <button class="btn btn-success btn-sm" id="all_yes">ყველას დამტკიცება</button>
                        <button class="btn btn-danger  btn-sm" id="all_no">ყველას უარყოფა</button>
                        <button class="btn btn-danger  btn-sm" id="all_calceled">ყველას გაუქმებულიად მონიშვნა</button>
                    </div>

                    
                    <div class="btn-group" data-toggle="buttons">
                        <?php $__currentLoopData = $credostatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="btn btn-info active">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input filter_checkbox" data-status_id="<?php echo e($key); ?>" checked="">
                                <label class="custom-control-label" style="cursor: pointer" ><?php echo e($cs['status']); ?></label>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="card-body"> 
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>თარიღი</th>
                        <th>სახელი / გვარი</th>
                        <th class="pn"> <span > პ / ნ </span> <button class="btn btn-default btn-xs" id="copy-button" style="display: none">კოპირება</button></th>
                        <th>თანხა</th>
                        <th>შიდა სტატუსი</th>
                        <th>კრედოს სტატუსი</th>
                        <th>მოქმედებები</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $sent_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <tr id="tr-<?php echo e($sr->id); ?>" class="row_tr">
                            <td id="id-<?php echo e($sr->id); ?>"><?php echo e($key + 1); ?></td>
                            <td ><a class="showOrder" data-id="<?php echo e($sr->id); ?>" href="#"><?php echo e($sr->id); ?></a></td>
                            <td><?php echo e($sr->date); ?></td>
                            <td class="nametr"><?php echo e($sr->user_info ? $sr->user_info->name .' '. $sr->user_info->lastname : ''); ?></td>
                            <td class="pntr"><?php echo e($sr->user_info ? $sr->user_info->pn : ''); ?></td>
                            <td> <?php echo e($sr->inv ? $sr->inv : ''); ?> </td>
                            <td id="status-<?php echo e($sr->id); ?>"><?php echo e($sr->innerStatus[0]->name); ?></td>
                            <td id="<?php echo e($sr->id); ?>"></td>
                            <td>
                                <button id="1-<?php echo e($sr->id); ?>" data-id="<?php echo e($sr->id); ?>" class="btn btn-success btn-xs yes">დამტკიცებულია</button>
                                <button id="0-<?php echo e($sr->id); ?>" data-id="<?php echo e($sr->id); ?>" class="btn btn-danger btn-xs no">უარყოფილია</button>
                                <button id="2-<?php echo e($sr->id); ?>" data-id="<?php echo e($sr->id); ?>" class="btn btn-success btn-xs buy" style="display: none">საყიდელია</button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <textarea class="copy" cols="30" rows="10">

    </textarea>
    <button class="copy">დახურვა</button>
    <button class="copy" id="withname">სახელებით</button>

	<script>
        var approveds = [];
        var rejected = [];
        var canceleds = [];
        var statuses = <?php echo json_encode($credostatuses); ?>;

        var show_statuses = [2, 3, 4, 5, 6, 7];
        var hide_statuses = [];
        
        var successed_statuses = [3, 4, 5];
        var rejected_statuses = [6];
        var canceled_statuses = [7];

		$(document).ready(function(){
            $('.filter_checkbox').on('change', function(){
                var status_id = parseInt(
                    $(this).data('status_id')
                );

                if($(this).prop('checked')){
                    show_statuses.push(status_id);
                    if(hide_statuses.indexOf(status_id) > -1) {
                        hide_statuses.splice(hide_statuses.indexOf(status_id), 1);
                    }
                } else {
                    hide_statuses.push(status_id);
                    if(show_statuses.indexOf(status_id) > -1) {
                        show_statuses.splice(show_statuses.indexOf(status_id), 1);
                    }
                }
                
                console.log(hide_statuses, show_statuses);
                filterRows(); 
            })

            copy = function(e, withnames = false){
                var pns = "";
                var selectors = $('tr.row_tr:visible');

                selectors.map(function(idx, s){
                    if(withnames) {
                        pns += $(s).children('.nametr').html() + ' '+ $(s).children('.pntr').html() + "\n";
                    } else {
                        pns += $(s).children('.pntr').html() + "\n";
                    }
                });

                $('textarea.copy').html(pns);
                $('.copy').fadeIn();
                $('button.copy:not(#withname)').click(function(){
                    $('.copy').fadeOut();
                })
            }

            $('#withname').on('click', function(e){
                copy(e, true);
            })

            $('#copy-button').on('click', copy);
            
            filterRows = function(){
                hide_statuses.map(function(status_id){
                    $("tr[data-status_id='"+status_id+"']").hide();
                });

                show_statuses.map(function(status_id){
                    $("tr[data-status_id='"+status_id+"']").show();
                })
            }

            $('.showOrder').on('click', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                showOrder(id);
            })
            
            $('#get_all').click(function(){
                getOrders();
            });
            

            $('.buy').on('click', function(){
                var id = $(this).data('id');
                if(!id) { return alert('შეცდომა');}
                if($('#' + id).html().length < 2) { if(!confirm('ამ განაცხადის კრედოს სტატუსი არ არის ცნობილი. მაინც გსურთ დამტკიცება?')) return; }
                sendToData([id], 2, function(data){
                    if(data.success) {
                        $('#2-'+id).attr('disabled', true);
                        updateStatuses(data.statuses);
                    }
                });
            });

            $('.yes').on('click', function(){
                var id = $(this).data('id');
                if(!id) { return alert('შეცდომა');}
                if($('#' + id).html().length < 2) { if(!confirm('ამ განაცხადის კრედოს სტატუსი არ არის ცნობილი. მაინც გსურთ დამტკიცება?')) return; }
                sendToData([id], 1, function(data){
                    if(data.success) {
                        disableButtons(data.ids);
                        updateStatuses(data.statuses);
                        $('#1-'+id).hide();
                        $('#2-'+id).fadeIn();
                    }
                });
            });

            $('.no').on('click', function(){
                var id = $(this).data('id');
                if(!id) { return alert('შეცდომა');}
                if($('#' + id).html().length < 2) { if(!confirm('ამ განაცხადის კრედოს სტატუსი არ არის ცნობილი. მაინც გსურთ უარყოფა?')) return; }
                sendToData([id], 0, function(data){
                    if(data.success) {
                        disableButtons(data.ids);
                        updateStatuses(data.statuses);
                    }
                });
            });

            $('#all_yes').on('click', function(){
                
                if(approveds.length < 1) {
                    return alert('არცერთი განხადება არ არის მონიშნული დამტკიცებულად');
                }
                if(!confirm('ყველა დამტკიცებული განაცხადის სტატუსი მოინიშნება "დამტკიცებულია კრედო" -თი ')) {
                    return;
                }
                
                sendToData(approveds, 1, function(data){
                    if(data.success) {
                        disableButtons(data.ids);
                        updateStatuses(data.statuses);
                    }
                });
            });


            $('#all_no').on('click', function(){
                if(rejected.length < 1) {
                    return alert('არცერთი განხადება არ არის მონიშნული დაუარებულად');
                }
                if(!confirm('ყველა დაუარებული განაცხადის სტატუსი მოინიშნება "დაუარებულია კრედო" -თი ')) {
                    return;
                }
                sendToData(rejected, 0, function(data){
                    if(data.success) {
                        disableButtons(data.ids);
                        updateStatuses(data.statuses);
                    }
                });
            });

            $('#all_calceled').on('click', function(){
                if(canceleds.length < 1) {
                    return alert('არცერთი განხადება არ არის მონიშნული გაუქმებულიად');
                }
                if(!confirm('ყველა დაუარებული განაცხადის სტატუსი მოინიშნება "გაუქმებულია კრედო" -თი ')) {
                    return;
                }
                sendToData(canceleds, 7, function(data){
                    if(data.success) {
                        disableButtons(data.ids);
                        updateStatuses(data.statuses);
                    }
                });
            });


        });

        updateStatuses = function(statuses){
            statuses.map(function(status){
                $('#status-' + status.id).html(status.inner_status[0].name);
            });
        }

        disableButtons = function(ids) {
            ids.map(function(id){
                $('#1-' + id).attr('disabled', true);
                $('#id-' + id).css('border-left', '5px solid green');
                $('#0-' + id).attr('disabled', true);
            });
        }

        getOrders = function(){
            window.preloader = false;
            
            setTimeout(function(){
                $('#all_no').click();
            }, 5000);
            
            orders.map(function(order){
                getFromCredoUrl(order, function(data){
                    if(data.status == 200) {
                        $('#'+data.orderCode).html(statuses[data.data].status);
                        $('#tr-'+data.orderCode).css('background', statuses[data.data].color);
                        $('#tr-'+data.orderCode).attr('data-status_id', data.data);

                        if(successed_statuses.indexOf(data.data) > -1) {
                            $('#0-' + data.orderCode).attr('disabled', true);
                            approveds.push(data.orderCode);
                        } else if(canceled_statuses.indexOf(data.data) > -1) {
                            canceleds.push(data.orderCode);
                        } else {
                            if(rejected_statuses.indexOf(data.data) > -1) {
                                rejected.push(data.orderCode);
                            }
                            $('#1-' + data.orderCode).attr('disabled', true);
                        }
                    }
                });
            });
            window.proloader = true;
        }
        
        sendToData = function(ids, status, callback) {
            $.ajax({
                type: 'post',
                url: '<?php echo e(route('banks.editcredostatuses')); ?>',
                data: {
                    i: 1,
                    ids: ids,
                    status: status
                },
                success: function(data) {
                    callback(data);
                },
                error: function(data) {
                    console.log(data)
                }
            });
        }

        getFromCredoUrl = function(order, callback){

            $.ajax({
                type: 'get',
                url: 'http://ganvadeba.credo.ge/widget/api.php',
                headers: false,
                data: {
                    merchantId: order.merchant_id,
                    orderCode: order.id
                },
                success: function(data) {
                    data.orderCode = order.id;

                    callback(data);
                },
                error: function(data) {
                    $('#' + order.id).html('ვერ მოხერხდა');
                }
            });
        }


        
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
    </script>
    
    
    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
	<style>
		.card {
			border-radius: 5px !important;
		}
		.expense-table tr td {
			vertical-align: middle;
			text-align: center
		}
		.badge {
			float: right;
			font-size: 20px;
		}
        .container-fluid {
            padding-bottom: 50px;
        }
        .form-group {
            margin-bottom: 10px
        }
        .showOrder {
            display: block;
            width: 100%;
            height: 100%;
            cursor: pointer;
            color: black;
            transition: 0.2s background-color ease-in-out;
        }
        .showOrder:hover {
            background-color: black;
            color: white;
            font-weight: bold;
        }

        .pn:hover span {
            display: none !important;
        }
        .pn:hover #copy-button {
            display: block !important;
        }
        .copy {
            display: none;
        }
    </style>
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <?php
    $orders = [];
    foreach($sent_requests as $s){
        $orders[] = ['id' => $s->id, 'merchant_id' => $s->isCompany('tch') ? 12189 : 10107];
    }
    ?>
    <script>
        // var orders = [<?php foreach($sent_requests as $s) { echo $s['id'].','; } ?>];
        var orders = <?php echo json_encode($orders); ?>;
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>