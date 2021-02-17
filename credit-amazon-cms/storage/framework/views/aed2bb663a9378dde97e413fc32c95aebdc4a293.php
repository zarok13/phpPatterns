<?php $supplier_id = isset($supplier_id) ? $supplier_id : null; ?>
<?php $product_id = isset($product_id) ? $product_id : null; ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('stocks.stocksmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials.assetTemplates.bootstrapTable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials.assetTemplates.typeahead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="row" >
    <div class="col-md-12" style="margin-bottom: 100px">
        <div class="card">
        	<div class="card-header">
    			<form id="return_log_filter" onsubmit="event.preventDefault(); refreshTable()">
	        		<div class="row">
						<div class="col-md-3">
							<div class="form-grop">
								<label>თარიღი</label>
								<input type="date" class="form-control" name="date_from" value="<?php echo e(now()->subDays(3)->format('Y-m-d')); ?>">
							</div>
							<div class="form-grop">
								<label>თარიღი</label>
								<input type="date" class="form-control" name="date_to" value="<?php echo e(date('Y-m-d')); ?>">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-grop">
								<label>მომწოდებელი</label>
								<input type="text" class="form-control" id="supplier_search_suggestion_input">
								<input type="hidden" name="supplier_id" id="supplier_search_id_input">
							</div>

                            <div class="form-group">
                                <label>ნივთი</label>
                                <input class="form-control" type="text" id="product_search_suggestion_input" >
                                <input type="hidden" id="product_search_id_input" name="product_id" value="<?php echo e($product_id); ?>" >
                            </div>

						</div>	
						<div class="col-md-3">
							<div class="form-grop">
								<label>ტიპი</label>
								<select class="form-control" name="type">
									<option></option>
									<option value="stock_not_found">ვერ იპოვა</option>
									<option value="out_of_stock">არ არის მარაგში</option>
								</select>
							</div>
						</div>
	        		</div>

	    			<div class="row">
	    				<button type="submit" class="btn btn-success mt-4 ml-2">ფილტრი</button>
	    			</div>
    			</form>
        	</div>
            <div class="card-body">
                <table class="table" id="return_log_table">
                    <thead>
                        <th data-field="request_id">ID</th>
                        <th data-field="date">თარიღი</th>
                        <th data-field="item_name" >ნივთი</th>
                        <th data-field="supplier_name">მომწოდებელი</th>
                        <th data-field="comment">კომენტარი</th>
                        <th data-field="get_price">ფასი</th>
                        <th data-field="quantity">რაოდენობა</th>
                    </thead>
					<tbody>
						
					</tbody>
					<tfoot>
					</tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
	var METADATA = {};
	$(document).ready(function(){
		$('#return_log_table').bootstrapTable({
	        ajax: stockErrorLogTableRequest,
	        sortable: true,
	        sidePagination: 'server',
	        pagination: true,
	        showColumns: true,
	        showRefresh: true,
	        checkboxHeader: true, 
	        clickToSelect: true,
	        totalField: 'count',
	        dataField: 'data',
	        showFooter: true, 
	        pageSize: 100,
	        pageList: [20, 50, 100, 200, 500],
	    });
	});

	stockErrorLogTableRequest = function(params) {
        var url = '<?php echo e(route('stock.return_log')); ?>';
	    var urlParams = $('#return_log_filter').serialize();

	    $.post(url + '?' + $.param(params.data) + '&' + urlParams).then(function (res) {
	        METADATA = res.metadata;
	        $('.fixed-table-loading').remove()
	        params.success(res)
	    })
	}



	refreshTable = function(){
		$('#return_log_table').bootstrapTable('refresh')
	}
	

    $(document).ready(function(){
		$('.fa.fa-sync').removeClass('fa-sync').addClass('fa-refresh')
		
        $('#product_search_suggestion_input').typeahead({
            minLength: 2,
            highlight: true,
        },{
            name: 'product_id',
            display: 'name',
            source: Suggestions.getProductSearch()
        }).on('typeahead:selected', function (e, suggestion, name) {
            $('#product_search_id_input').val(suggestion.id)
        })

        $('#supplier_search_suggestion_input').typeahead({
            minLength: 0,
            highlight: true,
        },{
            name: 'supplier_id',
            display: 'name',
            limit: 30,
            source: Suggestions.getSupplierSearch()
        }).on('typeahead:selected', function (e, suggestion, name) {
            $('#supplier_search_id_input').val(suggestion.id)
        })
    })


    filterProduct = function(event) {
    	var el = $(event.target);
		$('#product_search_suggestion_input').val(el.data('product_name'))
		$('#product_search_id_input').val(el.data('product_id'))
		refreshTable();
    }
</script>
<?php $__env->stopPush(); ?>





<?php $__env->startPush('styles'); ?>
<style type="text/css">
	span[data-product_id] {
		cursor: pointer;
	}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.newapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>