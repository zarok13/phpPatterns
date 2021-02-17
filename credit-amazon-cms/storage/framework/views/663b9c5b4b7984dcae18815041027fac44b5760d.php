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
    <script src="/assets/node_modules/raphael/raphael-min.js"></script>
    <script src="/assets/node_modules/morrisjs/morris.js"></script>
    <link href="/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="m-10">
        
        <?php echo $__env->make('reports.partials.operator_filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


        <button class="btn btn-success" id="filter_button" onclick="$('.filter').slideToggle(100);$('#search_button').slideToggle();" style="margin-bottom: 10px;" >ფილტრი</button>
        <button class="btn btn-danger" id="search_button"  style="margin-bottom: 10px; display: none; " >ძებნა</button>

        

    </div>

    <div class="row">
        <div class="col-md-12" >
            <div class="card">
                <div class="card-body">

                    
                    <table id="reports_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>სახელი/გვარი</th>
                                <th id='called_sum' class="called">დარეკილი</th>
                                <th id='sent_sum' class="sent_sum">გაგზა ვნილი</th>
								<th id='not_r_sum' class="not_r_sum">არ იღებს</th>
                                <th id='incomplete_sum' class="sum">დაუსრუ ლებელი</th>

                                <?php if($isAdmin): ?>
                                <th id='assignedunique' class="sum">გადან.</th>
                                <th id='openedsum' class="sum">გახსნილ</th>
                                <th id='openeduniquesum' class="sum">უნიკ</th>
                                <th id='canceledcgdsum' class="sum">გაუქმ => ჩგდ</th>
                                <?php endif; ?>
								
                                <th id='ganvgayidvasum' class="bank_sum">განვ. გაყიდვა</th>
								<th id='cgdsum' class="bank_sum">ჩგდ</th>
								<th id='chgdchabsum' class="bank_sum">ჩგდ. ჩაბ.</th>
								<th id='jamurigayidvasum' class="bank_sum">ჯამური გაყიდვა</th>
                                <th id='ganvcgdapprovedsum' class="bank_sum">ჩგდ.ჩაბ. + განვ</th>
								<th id='momavliscgdsum' class="bank_sum">მომავლის ჩგდ</th>
								<th id='tbcsum' class="bank_sum">TBC</th>
								<th id='credosum' class="bank_sum">Credo</th>
								<th id='crystalsum' class="bank_sum">Crystal</th>

                            </tr>
                        </thead> 
                        
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>სახელი/გვარი</th>
                                <th id="called_footer">დარეკილი</th>
                                <th>გაგზავნილი</th> 
								<th>არ იღებს</th>
                                <th>დაუსრულებელი</th>
                                <th></th>

                                <?php if($isAdmin): ?>
								<th></th>
                                <th></th>
								<th></th>
								<th></th>
                                <?php endif; ?>

								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div style="width: 100%;" id="report-details">
            
        </div>
    </div>
    </div>


    <script>
        
        called = null;
        sent = null;
        approved = null;
        not_responding = null;

        var sums = {
            calledsum: 0,
            sentsum: 0,
            not_respondingsum: 0,
            incompletesum: 0,
            opened_uniquesum: 0,
            openedsum: 0,
            ganvgayidvasum: 0,
            assigneduniquesum: 0,
            cgdsum:0,
            cgdchabsum: 0,
            momavliscgdsum: 0,
            tbcsum: 0,
            credosum:0,
            ctystalsum: 0,
            canceledcgdsum: 0,
            approved_insum: 0,
            tbcapprovedsum: 0,
            credoapprovedsum: 0,
        }
        
        var summedusers = [];
        
        var reports_table = 0;

        $(document).ready(function() {
            makeDatatable('<?php echo e(route("reports.operators.load")); ?>');

            function filter(){
                var data = $('#filter_form').serialize();
                makeDatatable("<?php echo e(route('reports.operators.filter')); ?>?_token=df&"+data);
            }

            function showUserData(data){
                var formdata = $('#filter_form').serialize();
                $.ajax({
                    type: "GET",
                    url: "/reports/operators/ajax?_token=sdf&" + formdata + '&user_id=' + data.user_id,
                    success: function (response) {
                        $('#report-details').html(response);
                    }
                });
            }

            $('#search_button').on('click', function(){
                filter();
            });

            
            $('#filter_form').on('keyup', function(event){
                if (event.keyCode === 13) {
                    $('#search_button').click();
                }
            });            
            

            $('#reports_table tbody').on('click', 'tr', function () {
                var data = window.reports_table.row( this ).data();
                $('#report-'+data.user_id).remove();
                showUserData(data);
            });
        });
        
        
        
        function makeDatatable(ajax_url){
            

            window.reports_table =  $('#reports_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [
                ],
                displayLength: 20,
                ajax: ajax_url,
                columns: [
                    { "data": "user_id" },               // #
                    { "data": function(val){

                        /** Adding In Sums */
                        if(summedusers.indexOf(val.user_id) == -1){
                            sums.calledsum +=  val.requests;
                            sums.sentsum +=  val.approved;
                            sums.not_respondingsum +=  val.not_respondings;
                            sums.incompletesum +=  val.incomplete;
                            sums.openedsum +=  val.opened;
                            sums.opened_uniquesum +=  val.opened_unique;
                            sums.ganvgayidvasum +=  val.bought;
                            sums.cgdsum +=  val.cgd;
                            sums.assigneduniquesum +=  val.assigned_unique;
                            sums.cgdchabsum +=  val.cgd_approved;
                            sums.momavliscgdsum +=  val.future_cgd;
                            sums.tbcsum +=  val.tbc;
                            sums.credosum +=  val.credo;
                            sums.ctystalsum += val.crystal;
                            sums.canceledcgdsum += val.canceled_cgd;
                            sums.tbcapprovedsum += val.tbc_approved;
                            sums.credoapprovedsum += val.credo_approved;
                        }
                        summedusers.push(val.user_id);
                        return `${val.is_ganvadeba_user ? '*' : '' }${val.name} `
                    } },      // სახელი / გვარი
                    { "data": function(value){
                        return value.requests;
                    } },    // დარეკილი განცხადეებები
                    { "data": function(value){
                        var assignedunique = value.assigned_unique;
                        var sent = value.approved;
                        var percent = assignedunique ? ((sent / assignedunique ) * 100).toFixed(1) : 0;
                        return `${sent} (${percent}%)`;
                    } },    //გაგზავნილი განცხადებები განცხადეებები
					{ "data": function(value){
						var percent = Math.floor((value.not_respondings / value.requests) * 100);
						percent = percent <= 100 ? percent : 0;
                        return value.not_respondings + ' (' + percent + '%) ('+value.sms_sent+')' ;
                    } },    //არ იღებს განცხადეებები
					{ "data": 'incomplete'},    //დაუსრულებელი განცხადეებები
                    <?php if($isAdmin): ?>
                    { "data": "assigned_unique"},    //გახსნილი უნიკალური განცხადებები
					{ "data": function(val){
                        return val.opened;
                    }},    //გახსნილი განცხადებები
                    
					{ "data": "opened_unique"},    //გახსნილი უნიკალური განცხადებები
					{ "data": "canceled_cgd"},    //გახსნილი უნიკალური განცხადებები
                    <?php endif; ?>
					{ "data": 'bought' },    //გაყიდვები
					{ "data": 'cgd' },    //cgd განცხადეებები
					{ "data": 'cgd_approved' }, //cgd ჩაბარებულები
					{ "data": function(val){
                        var assignedunique = val.assigned_unique;
                        var jamurigayidva = val.bought + val.cgd;
                        var percent = assignedunique ? ((jamurigayidva / assignedunique ) * 100).toFixed(1) : 0; 

                        return `${jamurigayidva} (${percent})%`;
                    } }, //cgd ჩაბარებულები
					{ "data": function(val){
                        return val.bought + val.cgd_approved;
                    } }, 
					{ "data": 'future_cgd' },
					{ "data": 'tbc' },
					{ "data": 'credo' },
					{ "data": 'crystal' },
                ],

                'initComplete': function (settings, json){
                    $(this.api().columns('#called_sum').footer()).html(sums.calledsum);
                    $(this.api().columns('#sent_sum').footer()).html(sums.sentsum + calcPercent(sums.sentsum, sums.calledsum));
                    $(this.api().columns('#not_r_sum').footer()).html(sums.not_respondingsum  + calcPercent(sums.sentsum, sums.calledsum));
                    $(this.api().columns('#incomplete_sum').footer()).html(sums.incompletesum);
                    $(this.api().columns('#openedsum').footer()).html(sums.openedsum );
                    $(this.api().columns('#openeduniquesum').footer()).html(sums.opened_uniquesum );
                    $(this.api().columns('#ganvgayidvasum').footer()).html(sums.ganvgayidvasum );
                    $(this.api().columns('#cgdsum').footer()).html(sums.cgdsum + calcPercent(sums.cgdsum, sums.calledsum) );
                    $(this.api().columns('#jamurigayidvasum').footer()).html(sums.cgdsum + sums.ganvgayidvasum + calcPercent(sums.cgdsum + sums.ganvgayidvasum, sums.calledsum) );
                    $(this.api().columns('#ganvcgdapprovedsum').footer()).html(sums.cgdchabsum + sums.ganvgayidvasum + calcPercent(sums.cgdchabsum + sums.ganvgayidvasum, sums.calledsum) );
                    $(this.api().columns('#chgdchabsum').footer()).html(sums.cgdchabsum + calcPercent(sums.cgdchabsum, sums.cgdchabsum) );
                    $(this.api().columns('#tbcsum').footer()).html(`${sums.tbcsum} (${sums.tbcapprovedsum})`);
                    $(this.api().columns('#credosum').footer()).html(`${sums.credosum} (${sums.credoapprovedsum})`);
                    $(this.api().columns('#crystalsum').footer()).html(sums.ctystalsum + calcPercent(sums.ctystalsum, sums.sentsum));
                    $(this.api().columns('#canceledcgdsum').footer()).html(sums.canceledcgdsum );
                    $(this.api().columns('#assignedunique').footer()).html(sums.assigneduniquesum );

					$(function () {
						$('[data-toggle="tooltip"]').tooltip()
					})
                    
                    summedusers = [];
                    sums = {
                        calledsum: 0,
                        sentsum: 0,
                        not_respondingsum: 0,
                        incompletesum: 0,
                        opened_uniquesum: 0,
                        openedsum: 0,
                        ganvgayidvasum: 0,
                        cgdsum:0,
                        cgdchabsum: 0,
                        momavliscgdsum: 0,
                        tbcsum: 0,
                        credosum:0,
                        ctystalsum: 0,
                        canceledcgdsum: 0,
                        tbcapprovedsum: 0,
                        credoapprovedsum: 0,
                    }
                }

            });

            
        }


        calcPercent = function(value, sum){
            if(value && sum) {
                return `(${Math.round( (value * 100) / sum ) }%)`;
            } else {
                return  `(0%)`;
            } 
        }

    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>