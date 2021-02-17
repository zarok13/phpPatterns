<?php 
    $hidden_columns = [];
    $visible_columns = [];

    foreach($fields as $k => $fi) {
        $fi['show']==1 ? $visible_columns[] = $k : $hidden_columns[] = $k; 
    }
?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('techplus.buypage.filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;"></div>

    <div class="card" >
        <div class="card-body" style="margin-bottom: 170px;" id="card_body">
                
                <table id="items_table" class="table   table-hover table-striped full-color-table full-dark-table hover-table">
                    <thead class="not">
                        <tr>
                            <th>##</th>
                            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <th class="<?php echo e($ff['className']); ?>"><?php echo e($ff['label']); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody></tbody>    
                    <tfoot >
                        <tr>
                            <th></th>
                            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <th class="<?php echo e($ff['className']); ?>"><?php echo e($ff['label']); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </tfoot>
                </table>

            
        </div>
    </div>




    <script>
        var ITEM_STATUSES =     ['', 'საყიდელია','შეკვეთილია', 'გასაცემია', 'გაცემულია', 'გასაუქმებელია', 'გაუქმებულია'];
        var ITEM_SUPPLIERS =    <?php echo json_encode(\App\Models\Supplier::orderBy('name')->select('id', 'name')->get()); ?>;
        var supplier_pay =      ['ჩასარიცხი', 'ჩარიცხული'];
        var rs_status =         ['არა','კი'];
        var pay_status =        ['ჩასარიცხი','ჩარიცხული'];
        var crystal_canceled =  ['გადასარიცხია', 'გადარიცხულია'];
        var crystal_signature = ['მოსატანია', 'მოტანილია', 'გაგზავნილია'];
        var cred_pay =          ['ჩასარიცხი','ჩარიცხული'];
        
        var pay_method = <?php echo json_encode(\Config::get('techplus.pay_methods')); ?> ;
        var courier =           ['ჩარიცხული', 'ჩასარიცხი'];
        var loadTableUrl =      '/techplus/buypage/load';
        var filterTableUrl =    '/techplus/buypage/filter';
        var UPDATE_ROWS_ID = [];
        var highlighted = false;
        window.already_filtered =0;

        $(document).ready(function(){
            

            var SUPPLIERS = {};
            for(var i=0; i<ITEM_SUPPLIERS.length; i++ ) {
                SUPPLIERS[ITEM_SUPPLIERS[i].id] = ITEM_SUPPLIERS[i].name;
            }
            
            ITEM_SUPPLIERS = SUPPLIERS;

            updateItemsTable({url: loadTableUrl});

            $("#checkall").click(function(){
                var checkboxes = $('.rowCheckbox');
                $.each(checkboxes, function(idx, val){
                    $(val).click();
                });
            });

            
        });
        
        $('.sell_date_filter').on('click', function(e){
            e.preventDefault();
            var from = $(this).data('from');
            var to = $(this).data('to');
            var url = filterTableUrl + '/?d=w&sell_date_filter=1&gacemulia_from='+from+'&gacemulia_to='+to;

            updateItemsTable({url: url});
        });
        $('.gasacemistatusbutton').on('click', function(e){
            e.preventDefault();
            var from = $(this).data('from');
            var to = $(this).data('to');
            var url = filterTableUrl + '/?d=w&added_date_filter=1&added_date_from='+from+'&added_date_to='+to+'&itemstatus=3';

            updateItemsTable({url: url});
        });
        $('.added_date_filter').on('click', function(e){
            e.preventDefault();
            var from = $(this).data('from');
            var to = $(this).data('to');
            var url = filterTableUrl + '/?d=w&added_date_filter=1&added_date_from='+from+'&added_date_to='+to;

            updateItemsTable({url: url});
        });
        $('.address_not_filled').on('click', function(e){
            e.preventDefault();
            var status = $(this).data('status');
            var url = filterTableUrl + '/?d=ws&address_not_filled=1&itemstatus='+status;
            console.log(filterTableUrl);
            updateItemsTable({url: url});
        });
        
        $('#all_ready').on('click', function(e){
            e.preventDefault();
            var url = filterTableUrl + '/?d=w&itemstatus=3';
            updateItemsTable({url: url});
        });
        $('#to_buy').on('click', function(e){
            e.preventDefault();
            var url = filterTableUrl + '/?d=w&itemstatus=1';
            updateItemsTable({url: url});
        });
        $('#misseds').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url: '<?php echo e(route('techplus.get_missed_items')); ?>',
                type: 'get',
                success: function(data){
                    console.log(data);
                }
            });
        });
        $('#all_today').on('click', function(e){
            e.preventDefault();
            var url = filterTableUrl + '/?d=w&sayidelia_from=<?php echo e(\Carbon\Carbon::parse("today midnight")->format("Y-m-d")); ?>';
            updateItemsTable({url: url});
        });
        $('#all_yesterday').on('click', function(e){
            e.preventDefault();
            var url = filterTableUrl + '/?d=w&sayidelia_from=<?php echo e(\Carbon\Carbon::parse("yesterday midnight")->format("Y-m-d")); ?>&sayidelia_to=<?php echo e(\Carbon\Carbon::parse("today midnight")->format("Y-m-d")); ?>';
            updateItemsTable({url: url});
        });


        $('#generatePDF').on('click', function(e){
            e.preventDefault()
            var errorhtml = '';
            items_table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                console.log(data.address_added)
                if(data.status == 3 && UPDATE_ROWS_ID.indexOf(data.request_id) > -1) {
                    if(!data.allready_called){
                        errorhtml += `განცხადებას ID-ით ${data.request_id} არ აქვს შეყვანილი მისამართი<br>`;
                    }
                }
            });
            
            $('#reestri-errors').html(errorhtml)

            if(errorhtml != ''){
                if(!confirm('რამდენიმე განაცხადს არ აქვს შეყვანილი მისამართები. ნამდვილად გსურთ რეესტრის გენერირება?')) return;
            }
            $.ajax({
                url: '/techplus/generatedeliverypdf',
                type: 'GET',
                data:{
                    s: 1,
                    ids: UPDATE_ROWS_ID
                },
                complete : function(){
                    document.location = this.url;
                }
            })
        });

        function showOrder(order_id){
            $.ajax({
                type: "GET",
                url: "/techplus/showrequest/"+order_id+'/',
                success: function (response) {
                    $('#open_modal_button').css('display', 'inline-block ');
                    $('#View_Modal').html(response);
                    $('#View_Modal').modal('toggle');

                    
                    html = $("#modals-here").html();
                    $('body').append(html);
                    $("#modals-here").remove();
                }
            });
        }

        

        updateItemsTable = function(data = {url: loadTableUrl}){
            UPDATE_ROWS_ID =[];
            window.loadTableUrl = data.url;
            window.already_filtered ++;
            already_profited = [];
            window.items_table =  $('#items_table').DataTable({
                destroy: true,
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                stateSave: true,
                order: [[ 3, 'desc' ]],
                stateSaveParams: function(settings, data){
                    data.time = data.time + 2000000000;
                },
                buttons: [
                    { 
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },{
                        text: 'მოქმედებები',
                        action: function () {
                            var count = UPDATE_ROWS_ID.length;
                            var allcount = items_table.data().count();
                            
                            if(count == allcount && $('input[type="search"]').val() == '' &&  window.already_filtered == 1) {
                                if(!confirm('მონიშნულია ყველა განცხადება ამ გვერდზე, ნამდვილად გსურთ განაცხადების ჩასწორება?')) 
                                    return;
                            }
                        
                            if(!count) return alert('ერთი მაინც განცხადება უნდა მოინიშნოს');

                            $('#editMultipleForm').trigger('reset');
                            $('#editMultipleModal').modal('toggle');
                            $('#selectedItemsCount').html('მონიშნულია '+ count +' განცხადება');
                        }
                    },{
                        text: 'მონიშვნა',
                        action: function () {
                            items_table.rows( { selected: true } )[0].length ? 
                                items_table.rows(':visible').deselect() : 
                                items_table.rows(':visible').select();
                        }
                    },
                    <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'TECHPLUS_MANAGER'])) : ?>
                    {
                        text: 'ავტომატური გაცემა',
                        action: function () {
                            var date = $('#automatic_sell_date').val();

                            $.ajax({
                                url: '<?php echo e(route('stock.automatic')); ?>',
                                type: 'GET',
                                data: {i:1, date: date },
                                success: function(data){
                                    console.log(data)
                                },
                            });
                        }
                    },{
                        text: 'გაცემის ერორები',
                        action: function () {
                            window.open('<?php echo e(route('stock.error_log')); ?>')
                        }
                    },
                    <?php endif; // Entrust::hasRole ?>
                    <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'ACCOUNTANT'])) : ?>
                    {
                        text: 'RS - ზე ატვირთვა',
                        action: uploadToRs
                    },
                    <?php endif; // Entrust::hasRole ?>
                    {
                        text: 'დარჩენილი ნივთები',
                        action: function () {
                            $('#left_items_checkbox').attr('checked',true);
                            $('#applyFilter').click();
                            setTimeout(function(){
                                $('#left_items_checkbox').attr('checked',false);
                            }, 3000);
                            return;
                            if(highlighted) {
                                $('tr[role=row].hidden').removeClass('hidden')
                                highlighted = !highlighted
                                return;
                            } 
                            highlighted = !highlighted
                                
                            var all_items = {};
                            items_table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                                var data = this.data();
                                
                                if(all_items[data.request_id]) {
                                    all_items[data.request_id] = {
                                        statuses: [
                                            ...all_items[data.request_id].statuses,
                                            data.status,
                                        ],
                                        rowindex: rowIdx
                                    };
                                } else {
                                    all_items[data.request_id] = {
                                        statuses: [data.status]
                                    }
                                }
                                
                            } );

                            ids = [];
                            Object.keys(all_items).map(function(val, idx){
                                statuses = all_items[val].statuses;
                                gasacemia = false;
                                sayidelia = false;
                                for(var i=0; i < statuses.length; i++) {
                                    if(statuses[i] == 3) {
                                        gasacemia = true;
                                    } else if(statuses[i] == 1){ 
                                        sayidelia = true;
                                    }
                                }
                                
                                if(gasacemia && sayidelia) {
                                    items_table.rows( all_items[val].rowindex ).nodes().to$().addClass( 'highlight' );
                                    ids.push(val);
                                } else {
                                    items_table.rows( all_items[val].rowindex ).nodes().to$().addClass( 'hidden' );                                    
                                }

                            });

                            $('#items_table_info').append('<span style="color: red; font-size: 16px ; font-weight: bold" > | დარჩენილი ნივთიების რაოდენობა: ' + ids.length + '. განაცხადის ID ები: ' + ids.join(',') + '</span>');
                            all_items = [];
                        }
                    },{
                        text: 'რეესტრი',
                        action: function () {
                            window.open('<?php echo e(route('techplus.reestri')); ?>')
                        }
                    },{
                        text: 'გასაცემია რეესტრი',
                        action: function () {
                            window.open('<?php echo route('techplus.reestri', ['i' => 1,'gasacemia' => 1]); ?>')
                        }
                    },{
                        text: 'ახალი მომხმარებლები',
                        action: function () {
                            window.open('<?php echo route('techplus.newusers'); ?>')
                        }
                    },{
                        text: 'გაახლება',
                        action: function () {
                            updateItemsTable({url: window.loadTableUrl});
                        }
                    },
                    {
                        extend:'colvis',
                        text:'ველები'
                    }
                ],             
                
                dom: 'Bfrtip',
                scrollX: true,
                pageLength: 700,
                ajax: data.url,
                rowReorder: true, 
                columns: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0
                    },
                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <?php echo $field['function']; ?>, 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],

                initComplete: function(){
                    
                    initComplete(this);
                    
                    this.api().columns('.sum').every(function(){
                        var column = this;
                        var tosum = column.data();
                        var sum =0;
                        $.each(tosum, function(key, s){
                            sum += parseFloat(s);
                            // console.log(sum)
                        });

                        $(column.footer()).html(sum.toFixed(2) );
                    });
                }

                
                
            });

        }

        async function initComplete(table) {
            
            //hideColumns();

            updateCheckboxSelection();

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            itemCountSelector();

            countUniqueIds();

            openRequestClickListener();
            
        }

        countUniqueIds = function()
        {
            unique_ids = [];
            items_table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                
                if(unique_ids.indexOf(data.request_id) == -1) {
                    unique_ids.push(data.request_id);
                }
            } );

            $('#items_table_info').append(`<span style="color: red" > უნიკალური - ${unique_ids.length}</span> `);
            
        }


        itemCountSelector = function(){
            $('a.item-name').off('mouseover');
            $('a.item-name').on('mouseover', function(){
                var name = $(this).data('name');
                var all_items = $('a.item-name[data-name="'+name+'"]');
                item_count = 0;
                for(var i =0; i<all_items.length; i++){
                    item_count += $(all_items[i]).data('quantity');
                }
                $(this).attr('title', `რაოდენობა:${item_count}, მარაგი: ${$(this).data('stock') || 0 }`);
            });
        }

        //hideColumns =  function(){
//
        //    window.hidden_columns = <?php echo json_encode($hidden_columns); ?>;
            //
        //    if(localStorage.getItem('hiddencolumns')) {
        //        eval(`window.hidden_columns = [${localStorage.getItem('columnview')}]`);
        //    }
//
        //    window.items_table.column(window.hidden_columns).visible(false);
        //}

        updateCheckboxSelection = function(){
            items_table.off( 'select');
            items_table
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = items_table.rows(indexes).data().toArray();
                    $.each(rowData, function(idx, val){
                        addToSelection(val.itid);
                    });
                    console.log(UPDATE_ROWS_ID);
                } )
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = items_table.rows( indexes ).data().toArray();
                    $.each(rowData, function(idx, val){
                        deleteFromSelection(val.itid);
                    });
                    console.log(UPDATE_ROWS_ID);
                } );
        }
        
        openRequestClickListener = function(){
            $('tbody > tr > td:nth-child(2)')
                .on('click', function(e){
                    data = items_table.row( $(this).closest('tr') ).data();
                    showOrder(data.request_id);
                    return;
                })
            
        }

        setTableLengthByFont =  function(){
            var font = 14;
            var table = $('#items_table');
            var body = $('#card_body');
            while(body.width()  <= table.width()){
                table.css('font-size', font+'px');
                font--;
            }
        }

        function showOrder(request_id){
            $.ajax({
                type: "GET",
                url: "/techplus/showrequest/"+request_id+'/',
                success: function (response) {
                    $('#open_modal_button').css('display', 'inline-block ');
                    $('#View_Modal').html(response);
                    $('#View_Modal').modal('toggle');
                }
            });
        }

        
        function addToSelection(ID){
            var index = UPDATE_ROWS_ID.indexOf(ID);
            if( index == -1 ){
                UPDATE_ROWS_ID.push(ID);
            } 
        }
        function deleteFromSelection(ID){
            var index = UPDATE_ROWS_ID.indexOf(ID);
            if( index != -1){
                UPDATE_ROWS_ID.splice(index, 1);
            } 
        }
    </script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script> 
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">

    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
        table.dataTable thead .sorting_asc:after {
            display: none;
        }
        /* thead tr {
            visibility: collapse;
        } */
        .dataTables_scrollBody table thead tr {
            visibility: collapse;
        }
        .rowCheckbox {
            width: 20px;
            height: 20px;
        }

        .even {
            background: #f1f1f1;
        }
        
        .odd {
            background: #c3c3c3;
        }

        .even:hover,
        .odd:hover {
            background: #cacaca !important;
        }
        
        .rowCheckbox {
            width: 17px;
            height: 16px;
        }
        .highlight {
            background-color:yellowgreen !important;
            
        }
        .hidden:not(.highlight) {
            display: none;
        }
        body {
            font-size: 13px !important
        }
        .small-text {
            min-width: 100px;
            font-size: 11px !important;
            word-break: break-all;
            display: block;
        }
        .buttons-columnVisibility.active {
            background-color: #528042 !important
        }
        td.break-all {
            word-break: break-all
        }
    </style>

    <?php echo $__env->make('techplus.buypage.multipleeditmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('techplus.buypage.uploadrsmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.techplus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>