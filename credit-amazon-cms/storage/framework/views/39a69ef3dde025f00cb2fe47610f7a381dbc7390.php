<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <script src="//static.jstree.com/3.3.5/assets/dist/jstree.min.js"></script>

    <link rel="stylesheet" href="//static.jstree.com/3.3.5/assets/dist/themes/default/style.min.css" />
    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
        .rowCheckbox {
            width: 17px;
            height: 16px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="m-10">
        
        <?php echo $__env->make('reports.partials.filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <button class="btn btn-success" id="filter_button" onclick="$('.filter').slideToggle(100);$('#search_button').slideToggle();" style="margin-bottom: 10px;" >ფილტრი</button>
        <button class="btn btn-danger" id="search_button" onclick="filter()" style="margin-bottom: 10px; display: none; " >ძებნა</button>
        <button class="btn btn-info" style="display: none" id="open_modal_button" onclick="$('#View_Modal').modal('toggle');">ბოლო განცხადების გახსნა</button>

    </div>

    <?php echo $__env->make('reports.partials.editMultipleModal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="#" type="checkbox" id="selectAll">ყველა</a>
                    <table id="filter_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>##</th>
                                <?php $__currentLoopData = $data['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <th class="<?php echo e($field['className']); ?>"><?php echo e($field['label']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <th>##</th>
                                <?php $__currentLoopData = $data['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <th ><?php echo e($field['label']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;"></div>



    <script>
        var CHANGE_REQUEST_IDS =[];
        var filter_table = 0;

        function filter(){
            var data = $('#filter_form').serialize();
            var data2 = $('#filter_form').serializeArray();
            console.log(data2);
            // return;
            makeDatatable("<?php echo e(route('reports.filter.ajax')); ?>?"+data);
        }
        function hideColumns(){
            <?php $i =0; ?> 
            <?php $__currentLoopData = $data['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                window.filter_table.column( <?php echo e($i+1); ?> ).visible( <?php echo e($field['show']==1 ? 'true' :'false'); ?> );
                <?php $i++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
        }


        $(document).ready(function() {
            makeDatatable('<?php echo e(route("reports.filter", ["count"=>100])); ?>');


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

            $('#filter_table tbody').off('click');
            $('#filter_form').off('keyup');
            

            $('#filter_table tbody').on('mousedown', 'tr', function (e) {
                if(e.which == 3 ){
                    var data = window.filter_table.row( this ).data();
                    showOrder(data.id);
                } else {
                    if(e.target.dataset.id){
                        showOrder(e.target.dataset.id);
                    }
                }
            });


            $('#filter_form').on('keyup', function(event){
                if (event.keyCode === 13) {
                    $('#search_button').click();
                }
            });     
        });
        

        function addToSelection(ID){
            var index = CHANGE_REQUEST_IDS.indexOf(ID);
            if( index == -1 ){
                CHANGE_REQUEST_IDS.push(ID);
            } 
        }
        function deleteFromSelection(ID){
            var index = CHANGE_REQUEST_IDS.indexOf(ID);
            if( index != -1){
                CHANGE_REQUEST_IDS.splice(index, 1);
            } 
        }

       
       function makeDatatable(ajax_url){
            var data = $('#filter_form').serialize();

            if($('#withlinks').prop('checked')){
                ajax_url += '&withlinks=true';
            }

            // ajax_url += ajax_url.indexOf('?') != -1 ? '&' + data : '?' + data;

            CHANGE_REQUEST_IDS = [];
            window.filter_table =  $('#filter_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                stateSave: true,
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                buttons: [{
                    extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },{
                        text: 'მოქმედებები',
                        action: function () {
                            var count = CHANGE_REQUEST_IDS.length;
                            if(!count) return alert('ერთი მაინც განცხადება უნდა მოინიშნოს');
                            $('#editMultipleForm').trigger('reset');
                            $('#editMultipleModal').modal('toggle');
                            $('#selectedItemsCount').html('მონიშნულია '+ count +' განცხადება');
                        }
                    },{
                        text: 'მონიშვნა',
                        action: function () {
                            filter_table.rows( { selected: true } )[0].length ? 
                                filter_table.rows().deselect() : 
                                filter_table.rows().select();
                        }
                    }
                ],
                displayLength: 20,
                ajax: ajax_url,
                columns: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0
                    },
                    <?php $__currentLoopData = $data['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <?php echo $field['function']; ?>, 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                'initComplete': function (settings, json){
                    window.invoice_amounts = [];

                    this.api().columns('.sum').every(function(){
                        var column = this;
                        var tosum = column.data();
                        var sum =0;
                        $.each(tosum, function(key, s){
                            sum += s*1;
                        });

                        $(column.footer()).html(sum);
                    });
                    this.api().columns('.average').every(function(){
                        var column = this;
                        var tosum = column.data();
                        var sum =0;
                        var length = 0;
                        $.each(tosum, function(key, s){
                            sum += s*1;
                            length++;
                        });
                        var average = sum/length;
                        $(column.footer()).html(average.toFixed(1));
                    });

                    this.api().columns('.invoice_amount').every(function(){
                        window.invoice_amounts = this.data();
                    });

                    this.api().columns('.average_sum').every(function(){
                        var column = this;
                        var tosum = column.data();
                        var sum =0;
                        var this_sum = 0;
                        $.each(tosum, function(key, s){
                            sum += s*window.invoice_amounts[key];
                            this_sum += window.invoice_amounts[key]*1;
                        });
                        console.log(this_sum);
                        console.log(sum);

                        var average = parseInt(sum)/parseInt(this_sum);
                        $(column.footer()).html(average.toFixed(1)+'%');
                    });

                }
            });
            
            filter_table
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = filter_table.rows(indexes).data().toArray();
                    $.each(rowData, function(idx, val){
                        addToSelection(val.id);
                    });
                    console.log(CHANGE_REQUEST_IDS);
                } )
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = filter_table.rows( indexes ).data().toArray();
                    $.each(rowData, function(idx, val){
                        deleteFromSelection(val.id);
                    });
                    console.log(CHANGE_REQUEST_IDS);
                } );
            hideColumns();
        }

    </script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>