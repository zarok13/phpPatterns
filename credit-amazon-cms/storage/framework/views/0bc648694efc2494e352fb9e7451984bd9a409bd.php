<?php ($isAdmin = false); ?>

<?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER'])) : ?>
    <?php ($isAdmin = true); ?>
<?php endif; // Entrust::hasRole ?>

<?php $__env->startSection('scripts'); ?>
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="m-10">
        <div class="card filter" style="display: none">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <form action="">
                            <div class="form-group">
                                <label for="">დან</label>
                                <input type="date" id="date_from" value="<?php echo e(now()->format('Y-m-d')); ?>" class="form-control" name="date_from">
                            </div>
                            <div class="form-group">
                                <label for="">მდე</label>
                                <input type="date" id="date_to" value="<?php echo e(now()->format('Y-m-d')); ?>" class="form-control" name="date_to">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-success" id="filter_button" onclick="$('.filter').slideToggle(100);$('#search_button').slideToggle();" style="margin-bottom: 10px;" >ფილტრი</button>
        <button class="btn btn-danger" onclick="filterDatatable()" id="search_button" style="margin-bottom: 10px; display: none; " >ძებნა</button>

        
    </div>

    <div class="row">
        <div class="col-md-12" >
            <div class="card">
                <div class="card-body">

                    
                    <table id="solditems_table" class="table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ნივთის სახელი</th>
                                <th>საიტი</th>
                                <th class="sum">გაყიდვების რაოდენობა</th>
                                <th class="sum">გაგზავნამდე გაუქმება</th>
                                <th class="sum">გაუქმ</th>
                                <th class="percents">ჩაბარების rate</th>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    </div>

    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>

    <script>
        var filterurl = '<?php echo e(route("reports.solditems.load")); ?>';

        $(document).ready(function() {
            makeDatatable(filterurl);
        });
        

        filterDatatable = function() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();

            var url = filterurl + `?i=1&date_from=${date_from}&date_to=${date_to}`;

            makeDatatable(url);
        }
        
        var sums = {
            sell_sum: 0,
            return_sum: 0
        }

        function makeDatatable(ajax_url){
            sums = {
                sell_sum: 0,
                return_sum: 0
            }
            var iteration =0;
            window.solditems_table =  $('#solditems_table').DataTable({
                destroy: true,
                dom: 'Bfrtip',
                displayLength: 50,
                ajax: ajax_url,
                aaSorting: [[3, 'desc']],
                bSortable: true,
                buttons: [
                    { 
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                columns: [
                    { "data": "id" },
                    { "data": null,
                    render: function(val){
                        return `<a target"_blank" href='${val.site == 'combo.ge' ? 'https://' : 'http://'}${val.site}/index.php?route=product/product&product_id=${val.id}' > ${val.item_name} </a>`;
                    } },
                    { "data": "site" },
                    { "data": "sell_count" },
                    { "data": "beforesendsum" },
                    { "data": "cancel_count" },
                    {"data": null, render: function(val){
                        iteration ++;
                        sums.sell_sum += parseInt(val.sell_count)
                        sums.return_sum += parseInt(val.cancel_count)
                        if(val.sell_count == 0) return 0;
                        return (1 - (val.cancel_count / val.sell_count)).toFixed(2);
                    }}
                ],
                initComplete: function(){
                    this.api().columns('.sum').every(function(){
                        var column = this;
                        var tosum = column.data();
                        var sum =0;
                        $.each(tosum, function(key, s){
                            sum += s*1;
                        });

                        $(column.footer()).html(sum);
                    });

                    this.api().columns('.percents').every(function(){
                        var column = this;
                        var rate = 1 - ( (sums.return_sum /iteration) / (sums.sell_sum /iteration))
                        $(column.footer()).html(rate.toFixed(2));
                    });
                }
            });
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>