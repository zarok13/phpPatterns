<?php $__env->startSection('content'); ?>

    <div class="card" >
        <div class="card-header" >
            
            <form method="get" id="filterform">
                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <div class="form-group">
                            <input type="date" class="form-control col-lg-2" name="date_from" value="<?php echo e(\Carbon\Carbon::now()->subMonth(3)->format('Y-m-d')); ?>">
                            <input type="date" class="form-control col-lg-2" name="date_to" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>" >
                        </div>
                    </div>
                </div>
                


                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <h5 id="inner_statuses_switch">სტატუსები</h5>                      
                        <div class="btn-group" id="inner_statuses_div" data-toggle="buttons" data-visible="0" style="display: none; column-count: 4;">
                            
                            <?php $__currentLoopData = $data['innerstatuses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $is): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="statuslabel btn btn-info inner_status_label">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input inner_status" id="inner_status<?php echo e($is->id); ?>" name="inner_statuses[<?php echo e($is->id); ?>]" >
                                    <label class="custom-control-label" style="cursor: pointer" ><?php echo e($is->name); ?></label>
                                </div>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <h5>მოკლე სტატუსები</h5>                      
                        <div class="btn-group" data-toggle="buttons">
                            <label class="statuslabel btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2" data-toggle="tooltip" data-placement="top" title="<?php echo e($approvedstatusestext); ?>" >
                                    <input type="checkbox" class="custom-control-input short_statuses" id="approved_requests" name="approved" >
                                    <label class="custom-control-label" style="cursor: pointer" >დამტკიცებულები</label>
                                </div>
                            </label>
                            <label class="statuslabel btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2" data-toggle="tooltip" data-placement="top" title="<?php echo e($sentstatusestext); ?>">
                                    <input type="checkbox" class="custom-control-input short_statuses" id="sent_requests" name="sent">
                                    <label class="custom-control-label" style="cursor: pointer" >გაგზავნილები</label>
                                </div>
                            </label>
                            <label class="statuslabel btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2" data-toggle="tooltip" data-placement="top" title="<?php echo e($rejectedstatusestext); ?>">
                                    <input type="checkbox" class="custom-control-input short_statuses" id="sent_requests" name="rejected">
                                    <label class="custom-control-label" style="cursor: pointer" >გაუქმებულია</label>
                                </div>
                            </label>
                            <label class="statuslabel btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2"  data-toggle="tooltip" data-placement="top" title="<?php echo e($registeredstatusestext); ?>">
                                    <input type="checkbox" class="custom-control-input short_statuses" id="sent_requests" name="registered">
                                    <label class="custom-control-label" style="cursor: pointer" >რეგისტრირებული</label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <h5>რეპორტები</h5>                      
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="users_checkbox" name="users" >
                                    <label class="custom-control-label" style="cursor: pointer" >მომხმარებლები</label>
                                </div>
                            </label>
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="items_checkbox" name="items">
                                    <label class="custom-control-label" style="cursor: pointer" >ნივთები</label>
                                </div>
                            </label>
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="sellings_checkbox" name="sellings">
                                    <label class="custom-control-label" style="cursor: pointer" >გაყიდვები</label>
                                </div>
                            </label>
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="cities checkbox" name="cities">
                                    <label class="custom-control-label" style="cursor: pointer" >რეგიონები და ქალაქები</label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <h5>დაყოფა</h5>                      
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="month_checkbox" name="split_days" >
                                    <label class="custom-control-label" style="cursor: pointer" >დღეების მიხედვით</label>
                                </div>
                            </label>
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="month_checkbox" name="split_months" >
                                    <label class="custom-control-label" style="cursor: pointer" >თვეების მიხედვით</label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <h5>დიაგრამები</h5>                      
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="selling_charts" name="selling_charts" >
                                    <label class="custom-control-label" style="cursor: pointer" >განაცხადები და თანხა</label>
                                </div>
                            </label>

                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="user_charts" name="user_charts" >
                                    <label class="custom-control-label" style="cursor: pointer" >მომხმარებლები</label>
                                </div>
                            </label>
                            <label class="btn btn-info ">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="item_charts" name="item_charts" >
                                    <label class="custom-control-label" style="cursor: pointer" >ნივთები</label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="display: none; margin-top: 10px" id="item_link_div">
                    <div class="col-md-4" >
                        <textarea name="item_link" id="item_link" class="form-control" cols="30" placeholder="შეიყვანეთ ნივთის ლინკი, მაქს. 5, ხაზებით დაშორებული" rows="5"></textarea>
                    </div>
                </div>

            </form>
            
            <div class="row" style="margin-top: 10px">
                <div class="col-md-6">
                    <button class="btn btn-danger" data-hidden="0" id="hide_button">ფილტრის დამალვა</button>
                    <button class="btn btn-default" id="filter_button">გაფილტვრა</button>
                </div>
            </div>
        </div>
    </div>

    <div id="charts-row" style="display: none; margin-bottom: 100px;">

    </div>


    <div class="row" id="reports" >
        <div class="col-lg-12">
            <div id="accordion">            
                
            </div>
        </div>
    </div>
    
    
    

    <script>
    
        var actionsRoute = '<?php echo e(route('reports.general.actions')); ?>';
        var chartsRoute = '<?php echo e(route('reports.general.charts')); ?>';

        $(document).ready(function(){

            $('#item_charts').change(function(){
                checked = $(this).prop('checked');
                checked ? $('#item_link_div').slideDown() : $('#item_link_div').slideUp();
            });

            $('#filter_button').click(function(e){
                e.preventDefault();
                var data = getFormData();
                console.log(data);
                $('#accordion').html('');
                

                if(data.selling_charts || data.user_charts || data.item_charts){
                    getCharts(data, function(html, senddata){
                        $('#charts-row').html(html);
                        $('#charts-row').slideDown('fast');
                    })

                }




                if(data.split_months || data.split_days) {
                    window.preloader = false;

                    if(data.split_days) {
                        dates = dateRange('day', data.date_from, data.date_to);
                    } else if(data.split_months){
                        dates = dateRange('month', data.date_from, data.date_to);
                    }
                    
                    
                    for(var i = 0; i < dates.length; i++) {
                        datacopy = {...data};
                        datacopy.date_from = dates[i];
                        if(dates[i+1]) {
                            datacopy.date_to = dates[i+1];
                            console.log(dates[i+1]);
                        } else {
                            datacopy.date_to = data.date_to;
                        }
                        datacopy.index = i;
                        
                        callAction(datacopy, function(data, datacopy){
                            header = datacopy.date_from+' - '+ datacopy.date_to;
                            addToAccordion('mainreports'+datacopy.index, header, false,  data);
                        });
                    }

                    window.preloader = true;
                }

                else {
                    callAction(data, function(data){
                        addToAccordion('mainreports', '', true,  data);
                    });
                }
                
            });
            

            $('#inner_statuses_switch').click(function(){
                visible = $(this).data('visible');
                $(this).data('visible', visible ? 0 : 1);
                visible ? $('#inner_statuses_div').css('display', 'none') : $('#inner_statuses_div').css('display', 'inline-block');
            })



            $('#hide_button').click(function(e){
                e.preventDefault();
                $('#filterform').slideToggle('fast');
                $(this).data('hidden') == 0 ? $(this).data('hidden',1) : $(this).data('hidden', 0);
                $('#filter_button').fadeToggle('fast');
                if($(this).data('hidden')) {
                    $(this).html('ფილტრის გამოჩენა');
                } else {
                    $(this).html('ფილტრის დამალვა');
                }
            });



            $('#all_requests').change(function(){
                var enabled =  $(this).prop('checked');
            
                if(enabled) {
                    $('.short_statuses').prop('checked', true);
                    $('.statuslabel').addClass('active')
                } else {
                    $('.short_statuses').prop('checked', false);
                    $('.statuslabel').toggleClass('active')
                }
            })


            
            $('[data-toggle="tooltip"]').tooltip();
        });



        getCharts = function(senddata, callback) {
            $.ajax({
                url: chartsRoute,
                type: 'get',
                data: senddata,
                success: function(data){
                    callback(data, senddata);
                }
            });
        }

        callAction = function(senddata, callback) {
            $.ajax({
                url: actionsRoute,
                type: 'get',
                data: senddata,
                success: function(data){
                    callback(data, senddata);
                }
            });
        }



        setdaterange = function(selector, from, to){
            $(selector).html(from+ ' - ' +to);
        }

        addToAccordion = function(id, header, show = false, html = ''){
            html = 
                `<div class="card">
                    <a class="card-header" id="heading11">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse${id}" aria-expanded="true" aria-controls="collapse${id}">
                            <h5 class="mb-0" id="daterange${id}">${header}</h5>
                        </button>
                    </a>
                    <div id="collapse${id}" class="collapse ${show ? 'show' : ''}" aria-labelledby="heading11" data-parent="#accordion-3">
                        <div class="card-body">
                            <div class="row" id="reports${id}" style="margin-bottom: 100px;">${html}</div>
                        </div>
                    </div>
                </div>`;
            $('#accordion').append(html);
            return;
        }

        getFormData = function(){
            
            var formdata = $('#filterform').serializeArray();
            var data = {i:1};
            for(var i=0; i<formdata.length; i++) {
                fd = formdata[i];
                data[fd.name] = fd.value;
            }

            return data;
        }


        function dateRange(spliter, startDate, endDate) {
            var
                    arr = new Array(),
                    dt = new Date(startDate),
                    end = new Date(endDate);

            if(spliter === 'month') {

                var start      = startDate.split('-');
                var end        = endDate.split('-');
                var startYear  = parseInt(start[0]);
                var endYear    = parseInt(end[0]);
                var dates      = [];

                for(var i = startYear; i <= endYear; i++) {
                    var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
                    var startMon = i === startYear ? parseInt(start[1])-1 : 0;
                    for(var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j+1) {
                    var month = j+1;
                    var displayMonth = month < 10 ? '0'+month : month;
                    dates.push([i, displayMonth, '01'].join('-'));
                    }
                }
                return dates;
            }

            if(spliter === 'day') {
                

                while (dt <= end) {
                    date = new Date(dt)
                    month = date.getMonth();
                    day = date.getDate();
                    var displayMonth = parseInt(month) < 10 ? '0'+month : month;
                    var displayDay = parseInt(day) < 10 ? '0' + day : day;
                    
                    stringdate = date.getFullYear() + '-' + displayMonth + '-' + displayDay;
                    arr.push(stringdate);
                    dt.setDate(dt.getDate() + 1);
                }

                return arr;
            }
            return dates;
        }
    </script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
	<style>
		.card {border-radius: 5px !important;}
		.expense-table tr td {vertical-align: middle;text-align: center}
		.badge {float: right;font-size: 20px;}
        .container-fluid {padding-bottom: 50px;}
        .form-group {margin-bottom: 10px}
        .showOrder {display: block;width: 100%;height: 100%;cursor: pointer;color: black;transition: 0.2s background-color ease-in-out;}
        .showOrder:hover {background-color: black;color: white;font-weight: bold;}
        .pn:hover span {display: none !important;}
        .pn:hover #copy-button {display: block !important;}
        .copy { display: none; }
        small { font-size: 100% ;}
        .userinfo:not(.selected) {display: none !important}
        .cityli {margin: 0 !important}
        #inner_statuses_switch {cursor: pointer}
        .inner_status_label {width: 100%;margin-bottom: 2px;text-align: left;}
    </style>
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <script src="/assets/node_modules/raphael/raphael-min.js"></script>
    <script src="/assets/node_modules/morrisjs/morris.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>