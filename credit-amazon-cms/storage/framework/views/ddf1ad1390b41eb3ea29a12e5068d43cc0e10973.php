<div id="uploadRsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="selectedItemsCount">აიტვირთა: <span id="progress_count"></span>/<span id="all_count"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-12" style="margin-bottom: 0" id="errors_div" style="display: none">
            			<div class="alert alert-danger">პრობლემური განაცხადები: <span id="error_ids" style="word-break: break-all;"></span></div>
            		</div>
            		<div class="col-md-12" style="margin-bottom: 0">
        				<table class="table" id="response_table">
        					<thead>
	        					<tr>
	        						<th>ID</th>
	        						<th>სტატუსი</th>
                                    <th>თარიღი</th>
	        					</tr>
        					</thead>
        					<tbody></tbody>
        				</table>
            		</div>
            	</div>
            </div>
            
        </div>
    </div>
</div>


<script type="text/javascript">
	var rs_modal = $('#uploadRsModal');

	function uploadToRs () {
        $.ajax({
            url: '<?php echo e(route('techplus.rs.generatewaybills')); ?>',
            type: 'GET',
            data: {i:1, ids: UPDATE_ROWS_ID, return_ids: 1 },
            success: function(data){
            	if(data.ids){
	                startUploadingToRs(data.ids)
            	}
            },
        });
    }


    function startUploadingToRs(ids){
    	rs_modal.find('#all_count').html(ids.length);
    	rs_modal.find('#errors_div').hide();
    	rs_modal.find('#errors_div').hide('');
    	rs_modal.find('#error_ids').html('');
    	rs_modal.find('#response_table tbody').html('');
    	rs_modal.modal('show');

    	var i =0;
    	var interval = setInterval(function(){
    		window.preloader = false;
	    	var id = ids[i++];
	    	if(id == undefined) return finishedUploading();

	    	rs_modal.find('#progress_count').html(i);

    		$.ajax({
	            url: '<?php echo e(route('techplus.rs.generatewaybills')); ?>',
	            type: 'GET',
	            data: {i:1, request_id: id },
	        }).always(function(data){
	        	window.preloader = false;
	        	uploadedToRs(data);
	        });
    	}, 300);

        function finishedUploading(){
            clearInterval(interval)
            rs_modal.find('#response_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { 
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
        }
    }

    function uploadedToRs(data){
    	var template = `<tr style="background: ${!data.success ? '#ff8a8a' : '#89ff6c'}">
			<th>${data.request_id}</th>
			<th>${data.message}</th>
            <th>${new Date().toDateString()}</th>
		</tr>`;

		rs_modal.find('#response_table tbody').prepend(template)

    	if(!data.success){
    		rs_modal.find('#error_ids').append(data.request_id + ',');
    		rs_modal.find('#errors_div:hidden').show();
    	}
    }
</script>