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
        /* tbody tr {
            cursor: zoom-in !important;
        } */
       
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="m-10">
        
        <?php echo $__env->make('reports.partials.banks_filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <button class="btn btn-success" id="filter_button" onclick="$('.filter').slideToggle(100);$('#search_button').slideToggle();" style="margin-bottom: 10px;" >ფილტრი</button>
        <button class="btn btn-danger" id="search_button"  style="margin-bottom: 10px; display: none; " >ძებნა</button>
        <button class="btn btn-danger" id="show_requests"  style="margin-bottom: 10px; display: none; " >განაცხადების ამოღება</button>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
               
                    <table id="banks_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>##</th>
                                <th>#</th>
                                <th>ბანკის დასახელება</th>
                                <th class="sum">გაგზავნილი განცხადებები</th>
                                <th class="explode_sum">დამტკიცებული განცხადებები</th>
                                <th class="money">სულ თანხა</th>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <th>##</th>
                                <th>#</th>
                                <th>ბანკის დასახელება</th>
                                <th>გაგზავნილი განცხადებები</th>
                                <th>დამტკიცებული განცხადებები</th>
                                <th>სულ თანხა</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
    <div class="row" id="request_table_row" style="display: none; ">
        <div class="col-md-12" id="report-details" style="margin-bottom: 0px; padding-bottom: 100px;">
            <div class="card">
                <div class="card-body">
               
                    <table id="bank_requests_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>სტატუსი</th>
                                <th>პირადი ნომერი</th>
                                <th>სახელი/გვარი</th>
                                <th>ტელეფონის ნომერი</th>
                                <th>დაბადების თარიღ</th>
                            </tr>
                        </thead>
                        
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



                       
    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                            
    </div>

    <script>
        
        var banks_table = 0;
        var BANKS = [];

        $(document).ready(function() {
            makeDatatable('<?php echo e(route("reports.banks.load")); ?>');

            function filter(){
                var data = $('#filter_form').serialize();
                makeDatatable("<?php echo e(route('reports.banks.filter')); ?>?_token=df&"+data);
            }

            $('#search_button').on('click', function(){
                filter();
            });

            
            $('#filter_form').on('keyup', function(event){
                if (event.keyCode === 13) {
                    $('#search_button').click();
                }
            });            
            

        });
        
        
        function makeRequestDatatable(bank_id){
            var data = $('#filter_form').serialize();
            
            var url = '/reports/banks/bybank?s=1&'+data;
            for(var i=0; i<BANKS.length; i++){
                url += '&banks[]='+BANKS[i];
            }
            console.log(url);
            // return;
            window.bank_requests_table =  $('#bank_requests_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }],
                displayLength: 20,
                ajax: url,
                columns: [
                    {"data":"request_id"},
                    {"data": function(val){
                        if(val.request.inner_status[0]){
                            return val.request.inner_status[0].name;
                        } else {
                            return 'არ აქვს';
                        }
                    }},
                    {"data":function(val){
                        if(val.request.user_info){
                            return val.request.user_info.personal_id;
                        }
                    }},
                    {"data": function(val){
                        if(val.request.user_info){
                            return val.request.user_info.name + ' '+ val.request.user_info.lastname;
                        }
                    }},
                    {"data": function(val){
                        if(val.request.people){
                            return val.request.people.number;
                        }
                    }},
                    {"data":function(val){
                        if(val.request.user_info){
                            return val.request.user_info.birthdate;
                        }
                    }}
                ],
                initComplete: function(){
                    $('#request_table_row').css('display', 'block');
                }
            });

            $('#bank_requests_table tbody').on('off');

            $('#bank_requests_table tbody').on('click', 'tr', function () {
                var data = bank_requests_table.row( this ).data();
                showOrder(data.request_id);
            });
            

        }
        
        window.sent = 0;
        window.approved = 0;
		
        function makeDatatable(ajax_url){
            window.banks_table =  $('#banks_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [
                    
                ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                displayLength: 20,
                ajax: ajax_url,
                columns: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    },
                    { "data": "bank_id" },               // ბანკის ნომერი
                    { "data": null,
                    "render": function(val){
                        return `<a href="#" class="getbank" data-bank_id="${val.bank_id}" > ${val.name} </a>`;
                    } },      // ბანკის დასახელება
                    { "data": "sent" },    // ბანკში გაგზავნილი განცხადებები
                    { "data": function(value){
                        return value.approved.toString()+' (' + Math.floor((value.approved / value.sent) * 100)+'%)';
                    } },    // დამტკიცებული განცხდადებები
                    { "data": "amount"},    // სრულ თანხის ოდენობა
                ],
				'initComplete': function (settings, json){
                    
                    $('.getbank').off('click');
                    $('.getbank').on('click', function () {
                        var bank_id = $(this).data('bank_id');
                        makeRequestDatatable(bank_id);
                    });

                    this.api().columns('.sum').every(function(){
                        var column = this;

                        var tosum = column.data();
                        var this_sum = 0;
                        $.each(tosum, function(key, s){
                            value = s;
                            this_sum += value;
                        });
                        window.sent = this_sum;
                        $(column.footer()).html(this_sum);
                    });

					this.api().columns('.explode_sum').every(function(){
                        var column = this;

                        var tosum = column.data();
                        var this_sum = 0;
						
                        $.each(tosum, function(key, s){
                            splited = s.split(' ');
                            value = parseInt(splited[0]);
                            this_sum += value;
                        });
                        
						var percent = this_sum / window.sent * 100;
						$(column.footer()).html(this_sum + ' (' + percent.toFixed(1) + '%)' );
                    });
                    

					this.api().columns('.money').every(function(){
                        var column = this;

                        var tosum = column.data();
                        var this_sum = 0;
                        $.each(tosum, function(key, s){
                            value = s;
                            this_sum += value;
                        });

                        $(column.footer()).html(this_sum);
                    });

                }
            });
            
            banks_table
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = banks_table.rows(indexes).data().toArray();
                    $.each(rowData, function(idx, val){
                        BANKS.push(val.bank_id);
                    });
                    console.log(BANKS);
                } )
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = banks_table.rows(indexes).data().toArray();
                    $.each(rowData, function(idx, val){
                        if(BANKS.indexOf(val.bank_id) > -1){
                            BANKS.splice(BANKS.indexOf(val.bank_id), 1);
                        }
                    });
                    console.log(BANKS);
                } );
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>