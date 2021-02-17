<?php $__env->startSection('content'); ?>

    <div class="card" >
        <div class="card-header" >


        </div>


        <div class="card-body">
            <?php if(count($users)): ?>
            <div class="row">
                <div class="col-md-3">
                    <select id="user_selector">
                        <option value=""></option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <option value="<?php echo e($key); ?>"> <?php echo e($user); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>დამატების თარიღი</th>
                            <th>პროდუქტის ID</th>
                            <th>პროდუქტის სახელი</th>
                            <th>საიტი</th>
                            <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $int): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="pcount" style="font-size: 10px"><?php echo e($int->from); ?> - <?php echo e($int->to); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody id="productstable">
                        
                    </tbody>
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>სახელი</th>
                            <th>საიტი</th>
                            <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $int): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="pcount" style="font-size: 10px" id="interval-<?php echo e($key); ?>"></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                </table>
            </div>
        
        </div>
    </div>

    
    <script>
        var FROM_DATE = '<?php echo e($from); ?>';
        var TO_DATE = '<?php echo e($to); ?>';
        var SITES = <?php echo json_encode($sites); ?>;
        var USERNAME = '<?php echo e($data_user); ?>';
        var intervals = <?php echo json_encode($intervals); ?>

        var products = {};

        $(document).ready(function(){
            
            if(USERNAME) {
                runUserQuery();
            } else {
                $('#user_selector').on('change', function(){
                    USERNAME = $(this).val();
                    runUserQuery();
                })
            }

        });


        runUserQuery = function() {
            for(var i =0; i<SITES.length; i++) {
                site = SITES[i];
                getFromUrl(generateGetTableUrl(site), site, function(data, prsite){
                    for(var j = 0, pl = data.products.length; j<pl; j++) {
                        pr = data.products[j];
                        appendToTable(pr.product_id, pr.name, pr.add_date, prsite)
                    }
                });
            }
        }


        getProductCount = function(id, site, date, callback) {
            
            $.ajax({
                url: '<?php echo e(route('reports.upcount.getcount')); ?>',
                data: {i: 1, id: id, site: site, date: date, date_from: FROM_DATE, date_to: TO_DATE},
                success: function(data){
                    if(callback){
                        callback(data);
                    }
                    $(`#pr-${site.replace('.', '')}-${id}`).html(data.count);
                }
            });

        }

        addListeners = function(){
            counttables = $('.pcount');

            $.each(counttables, function(idx, ct){
                var id = $(ct).data('id');
                var site = $(ct).data('site');

                getProductCount(id, site);
            });
        }


        getFromUrl = function(url, site, callback){
            return $.ajax({
                url: url,
                headers: null,
                success: function(data) {
                    if(callback){
                        callback(data, site)
                        console.log(data);
                    }
                }
            })
        }


        generateGetTableUrl = function(site){
            return `${site == 'combo.ge' ? 'https://' : 'http://'}${site}/index.php?route=feed/product/userproductsapi&userid=${USERNAME}&from=${FROM_DATE}&to=${TO_DATE}&ss=${Math.round(Math.random()* 5000)}`
        }

        sum = [0,0,0, 0];
        appendToTable = function(id, name, date, site){
            
            getProductCount(id, site, date, function(data){
                var counts = '';
                for(var i=0; i<data.length; i++) {
                    console.log(data);
                    var price = '';
                    if(parseInt(data[i].sell_price_sum) > 1) {
                        sum[i] = sum[i] + parseInt(data[i].sell_price_sum);
                        price = ' / ' + parseInt(data[i].sell_price_sum) + ' GEL'
                    }

                    counts += `<td class="pcount" data-site="${site}" data-id="${id}" id="pr-${site.replace('.', '')}-${id}">${data[i].count} ${price}</td>`
                }
                $('#productstable').append(
                    `<tr>
                        <td>${date}</td>
                        <td>${id}</td>
                        <td>${name}</td>
                        <td>${site}</td>
                        ${counts}
                    </tr>`
                );
                
                $('#interval-0').html(sum[0]);
                $('#interval-1').html(sum[1]);
                $('#interval-2').html(sum[2]);
                $('#interval-3').html(sum[3]);
            })
    
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