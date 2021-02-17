<?php ($isAdmin = false); ?>

<?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
    <?php ($isAdmin = true); ?>
<?php endif; // Entrust::hasRole ?>



<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-md-12" >
            <div class="card">
                <form action="" onsubmit="event.preventDefault(); refreshTable()" id="filter_form">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>თარიღი -დან</label>
                                    <input type="date" class="form-control" name="date_from" value="<?php echo e(date('Y-m-d')); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>თარიღი -დან</label>
                                    <input type="date" class="form-control" name="date_to" value="<?php echo e(date('Y-m-d')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-success" style="margin: 1rem">ძებნა</button>
                        </div>
                    </div>
                </form>
                <div class="card-body">

                    
                    <table id="reports_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>სახელი/გვარი</th>
                                <th class="sum">დამატებული</th>
                                <th class="sum">დამატებული ჩგდ</th>
                                <th class="sum">დამატებული განვადება</th>
                                <th class="sum">გაყიდული ჯამში</th>
								
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th data-field="added"></th>
                                <th data-field="added_cgds"></th>
                                <th data-field="added_installments"></th>
                                <th data-field="sold_sum"></th>
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4" id="report-details">

        </div>
    </div>
    </div>


<script>
    
    var reports_table = 0;
    
    function refreshTable(){
        var data = $('#filter_form').serialize();
        makeDatatable("<?php echo e(route('techplus.reports.operators.filter')); ?>?_token=df&"+data);
    }
    

    $(document).ready(function() {
        refreshTable();
        $('#search_button').on('click', function(){
            refreshTable();
        });
        
        $('#filter_form').on('keyup', function(event){
            if (event.keyCode === 13) {
                $('#search_button').click();
            }
        });
    });
    
    
    called = null;
    sent = null;
    approved = null;
    not_responding = null;

    
    
    function makeDatatable(ajax_url){
        window.reports_table =  $('#reports_table').DataTable({
            destroy: true,
            dom: 'Bfrtip',
            displayLength: 20,
            ajax: ajax_url,
            xhr: function(data){
                console.log('data', data)
            },
            columns: [
                { data: "user_id" },
                { data: "name" },
                { data: "added" },
                {   
                    data: null, 
                    render: function(v){
                        return `${v.added_cgds} (${v.added_cgds_rate}%)`
                    } 
                },
                {   
                    data: null, 
                    render: function(v){
                        return `${v.added_installments} (${v.added_installments_rate}%)`
                    } 
                },
                { 
                    data: null, 
                    render: function(v){
                        return `${v.sold_sum} (${v.sold_sum_rate}%)`
                    }
                }
            ],
            initComplete: function(){
                window.reports_table.columns( '.sum' ).every( function () {
                    var sum = $(this.footer()).data('field')
                    
                    $( this.footer() ).html( window.sums[sum] );
                } );
            }
        });   

        window.reports_table.on('xhr', function(){
            var json = reports_table.ajax.json();
            window.sums = json.sums
        })
    }

</script>
<?php $__env->stopSection(); ?>



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
<?php echo $__env->make('layouts.techplus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>