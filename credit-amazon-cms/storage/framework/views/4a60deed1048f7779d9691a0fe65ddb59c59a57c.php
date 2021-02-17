<?php $__env->startSection('content'); ?>
    
<div class="row">
    <div class="col-3 col-xs-12">
        
        <div class="col-xs-12 mb-3">
            <form action="" id="reportform" >
                <?php echo csrf_field(); ?>
                <select name="reportname" class="form-control" onchange="$('#reportform').submit()">
                    <option value="creditamazon" <?php echo e(request('reportname') == 'creditamazon' ? 'selected=""' : ''); ?>>Creditamazon</option>
                    <option value="techplus" <?php echo e(request('reportname') == 'techplus' ? 'selected=""' : ''); ?>>Techplus</option>
                    
                </select>
            </form>
        </div>

        <div class="col-xs-12">
            <table class="table table-hover table-striped table-bordered full-color-table full-dark-table hover-table">
                <tr>
                    <td>დღეს შეკვეთები:</td>
                    <td><?php echo e($_each_day[0]['requests']); ?></td>
                    
                </tr>
                <tr>
                    <td>გუშინ შეკვეთები:</td>
                    <td><?php echo e($_each_day[1]['requests']); ?></td>
                    
                </tr>
                <tr>
                    <td>გუშინ ამ დროს:</td>
                    <td><?php echo e($data['yesterday_this_time']); ?></td>
                </tr>
            </table>
        </div>

        <div class="col-xs-12">
            <table class="table table-hover table-striped table-bordered full-color-table full-dark-table hover-table">
                <tr>
                    <th>#</th>
                    <th>თარიღი</th>
                    <th>რაოდენობა</th>
                    <?php $can_see_spent = false; ?>
                    <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MARKETING_MANAGER'])) : ?>
                    <?php $can_see_spent = true; ?>
                    <th>ხარჯი</th>
                    <?php endif; // Entrust::hasRole ?>
                </tr> 

                <?php $__currentLoopData = $_each_day; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="checkbox" id="<?php echo e($key); ?>" class="table_checkbox" data-show="<?php echo e($key); ?>"></td>
                        <td><?php echo e($day['date']); ?></td>
                        <td><?php echo e($day['requests']); ?></td>
                        <?php if($can_see_spent): ?>
                        <td><?php echo e($day['spent']); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>

        <div class="col-xs-12">
            <form action="" method="get" style="margin: 20px 0px;">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input type="datetime-local" name="from" id="from">
                    <label for="from">საიდან</label>
                </div>
                <div class="form-group">
                    <input type="datetime-local" name="to" id="from">
                    <label for="to">სანამდე</label>
                </div>
                <button type="submit" class="btn btn-success">ნახვა</button>
            </form>
        </div>
    </div>
    <div class="col-9 col-xs-12" >
       
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        
    
        <div class="col-12 col-xs-12" style="margin-top: 20px;">
            <div class="row">
                <style>
                    .day_div {
                        display: none;
                        border-radius: 0 !important; 
                        padding: 10px !important;
                    }
                    .day_table {
                        margin: 0;
                    }
                </style>
                <?php $__currentLoopData = $_each_day; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="card day_div col-md-6"  id="day_div_<?php echo e($key); ?>">
                        <h3><?php echo e($day['date']); ?>  <a href="#" class="showitems" style="color:blue; font-size: 15px;" data-date="<?php echo e($day['date']); ?>">ნივთების მიხედვით</a></h3>
                        <table class="table day_table table-hover table-striped table-bordered full-color-table full-dark-table hover-table ">
                            <?php $all=0; ?>
                            <?php $__currentLoopData = $day['sites']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site => $quantity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php
                                        $all+=$quantity;
                                        $exp = explode('www.', $site);
                                        $sitename = sizeof($exp) > 1 ? $exp[1] : $exp[0];
                                        // sizeof($exp) < 1 ?: $quantity += $day['sites']['www.'.$sitename];
                                        sizeof($exp) < 1 ?: $day['sites']['www.'.$sitename] = 0;
                                        if($quantity != 0)
                                            echo $sitename;
                                    ?>
                                </td>
                                <td><?php echo e($quantity!=0?$quantity:''); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>სულ: </td>
                                <td><?php echo e($all); ?></td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>      
        </div>

        <div style="padding: 0; margin-bottom: 15px; display: none" id="itemsdiv" class="col-12">
            <table id="itemstable" class="table   table-hover table-striped full-color-table full-dark-table hover-table">
                <thead>
                    <tr>
                        <th>დასახელება</th>
                        <th>რაოდენობა</th>
                        <th>სტატუსები</th>
                        <th>საიტი</th>
                        <th>კრედო</th>
                    </tr>
                </thead>
                <tbody id="itemstablebody">

                </tbody>
            </table>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<script>
    var urls = <?php echo json_encode($urls); ?>;
    var products = {};
    var sendlinks = {};
    var items = {};
    var count = 0;
    var items_table = null;
    var request_ids = {};

    $(document).ready(function(e){
        
        $('.showitems').on('click', function(e){
            e.preventDefault();
            $('#itemsdiv').slideUp(200);
            products = {
                'combo.ge': {},
                'duo.ge'  : {},
                'swiss.ge': {},
                'cosmo.ge': {},
                'york.ge' : {}
            };
            request_ids = {
                'combo.ge': {},
                'duo.ge'  : {},
                'swiss.ge': {},
                'cosmo.ge': {},
                'york.ge' : {}
            };
            credo_products = {
                'combo.ge': {},
                'duo.ge'  : {},
                'swiss.ge': {},
                'cosmo.ge': {},
                'york.ge' : {}
            };
            links = {};
            items = {};
            count = 0;
            items_table != null ? items_table.destroy() : null;
            var date = $(this).data('date');
            getItems(date);
        });


        getItems = function(date){
            var links = urls[date] != undefined ? urls[date] : [];
            
            links.map(function(link){
                var a = $('<a>', { href: link.url } )[0];
                var hostname = a.hostname.replace('www.', '');
                console.log(hostname)
                if(typeof products[hostname] != undefined) {
                    var prid = getParameterByName('product_id', link.url.replace('&amp;', '&'));
                    if(prid) {
                        if(products[hostname][prid] && request_ids[hostname][prid] ){
                            products[hostname][prid] = products[hostname][prid] + 1;
                            request_ids[hostname][prid] = [...request_ids[hostname][prid], link.rid];
                        } else {
                            products[hostname][prid] = 1;
                            request_ids[hostname][prid] = [link.rid];
                        }
                    }
                    console.log(link.pp)
                    if(link.pp == 3){
                        if(credo_products[hostname][prid]){
                            credo_products[hostname][prid] ++;
                        } else {
                            credo_products[hostname][prid] = 1;
                        }
                    }
                }
            });
            
            
            Object.keys(products).map(function(key) {
                var link = (key == 'combo.ge' ? 'https://' : 'http://')  + key + '/index.php?route=feed/product&creditamazon_api=true&product_ids[]=0';
                var addlink = false;
                Object.keys(products[key]).map(function(id) {
                    addlink = true;
                    link += '&product_ids[]='+ parseInt(id);
                });
                addlink ? link += '&cache='+ makeid(8) : null;
                sendlinks[key] = link;
            });

            getItemsFromLink(sendlinks);
            
        }
    })

    getItemsFromLink = function(linkobject) {
        
        Object.keys(linkobject).map(function(idx,val){
            items[idx] = [];
            var errors = [];
            getFromUrl(linkobject[idx], function(data) {
                try {
                    var pros = JSON.parse(data);
                } catch (objError) {
                    console.log(objError);
                    var pros = {
                        products: []
                    };
                    errors.push('ვერ მოხერხდა მონაცემების წამოღება. საიტი: ' + idx);
                }
                var its = pros.products;
                
                for(var i=0, l = its.length; i<l; i++) {
                    
                    if( products[idx][its[i].id]) {
                        
                        var product = { 
                            name: its[i].name,
                            site: idx,
                            id: its[i].id,
                            quantity: products[idx][its[i].id] 
                        }

                        items[idx].push(product);
                    }
                    
                }
                
                count++;

                makeTable(items);

                for(var k = 0; k<errors.length; k++ ) {
                    alert(errors[k]);
                }
            })
        });

        
    }

    makeTable = function(items, q) {
        
        if(count != Object.keys(products).length){
            return;
        }

        var html = '';
        
        Object.keys(items).map(function(site){
            
            for(var i = 0, l = items[site].length; i < l; i++ ) {
                var credo = 0;
                item = items[site][i];
                
                if(credo_products[site] && credo_products[site][item.id]){
                    credo = credo_products[site][item.id];
                }
                html += `<tr><td><a target="_blank" href="${site == 'combo.ge' ? 'https://' : 'http://'}${site}/index.php?route=product/product&product_id=${item.id}">${item.name}</a></td><td>${item.quantity}</td> <td class="statuses" data-id="${item.id}" data-site=${site} id="status_${item.id}"></td> <td>${site}</td><td>${credo}</td></tr>`;
            }
        });
        
        $('#itemstablebody').html(html);
        $('#itemsdiv').slideDown(2000);
        items_table = $('#itemstable').DataTable({
            destroy: true,                
            dom: 't',
            scrollX: true,
            paging:false,
            displayLength: 1000,
            "order": [[ 1, "desc" ]],
            initComplete: function(){
                updateStatusListeners();
            }
        });

    }

    updateStatusListeners = function() {
        $('.statuses').off('mouseover');
        $('.statuses').on('mouseover', function(){
            if($(this).html().length >2) return;
            var item_id = $(this).data('id');
            var site = $(this).data('site');
            var data = {
                i:1,
                item_id: item_id,
                request_ids: request_ids[site][item_id]
            };
            
            getStatuses('<?php echo e(route('reports.byday.statuses')); ?>', function(response){
                $('#status_' + response.item_id).html(response.html);
                console.log(data);
            }, data);
        });

    }

    getFromUrl = function(url, callback = function(){return;}, data ={}, method ='GET') {
        $.ajax({
            url: url,
            data: {...data},
            type: method,
            headers: null,
            success: function(data) {
                callback(data);
            }
        });
    } 


    getStatuses = function(url, callback = function(){return;}, data ={}, method ='GET') {
        window.preloader = false;

        $.ajax({
            url: url,
            data: {...data},
            type: method,
            headers: null,
            success: function(data) {
                callback(data);
            }
        });

        window.preloader = true;

    } 

    function makeid(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
</script>



<script>
    $(document).ready(function () {

        $('.table_checkbox').on('click', function(){
            id = $(this).data('show');
            console.log(id);
            display = $(this).prop('checked') ? $('#day_div_'+id).fadeIn() : $('#day_div_'+id).fadeOut();
            
        });


        var today = <?php echo json_encode($data['today_chart']); ?>;
        var yesterday = <?php echo json_encode($data['yesterday_chart']); ?>;
        
        data_today = [];
        data_yesterday = [];
        
        for(var i = 0; i<24; i++){
            if(i<10){
                data_today[i] = {x: parseInt('0'+i) , y: today['0'+i] ?  today['0'+i].length : null };
                data_yesterday[i] = { x: parseInt('0'+i), y: yesterday['0'+i] ?  yesterday['0'+i].length : null };
            } else {
                data_today[i] = {x: i, y: today[i] ? today[i].length : null};
                data_yesterday[i] ={x: i, y: yesterday[i] ?  yesterday[i].length : null};
            }
        }
        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title:{
                text: "შეკვეთების რაოდენობის შედარება"
            },
            axisX: {
            },
            axisY: {
                title: "შეკვეთების რაოდენობა",
                includeZero: false,
            },
            legend:{
                cursor: "pointer",
                fontSize: 16,
                itemclick: toggleDataSeries
            },
            toolTip:{
                shared: true
            },
            data: [{
                name: "დღევანდელი",
                type: "column",
                yValueFormatString: "####",
                showInLegend: true,
                dataPoints: data_today
            },
            {
                name: "გუშინდელი",
                type: "column",
                yValueFormatString: "####",
                showInLegend: true,
                dataPoints: data_yesterday
            }]
            
        });

        // console.log(data_yesterday);
            chart.render();
            function toggleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
    
    });
</script>


<script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
<link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">

<style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
        /* thead tr {
            visibility: collapse;
        } */
        .dataTables_scrollBody table thead tr {
            visibility: collapse;
        } .even {
            background: #f1f1f1;
        }
        
        .odd {
            background: #c3c3c3;
        }

        .even:hover,
        .odd:hover {
            background: #cacaca !important;
        }

        tr td a:hover{
            color: blue;
        }
        .dataTables_wrapper  {
            margin-top: -15px;
        }
        .statuses {
            font-size: 9pt;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>