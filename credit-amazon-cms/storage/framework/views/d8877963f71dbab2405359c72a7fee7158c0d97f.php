<table class="table" id="product_history_table">
	<thead>
		<th data-field="created_at">თარიღი</th>
		<th data-field="request_id">ID</th>
		<th data-field="supplier_name">მომწოდებელი</th>
		<th data-field="comment">კომენტარი</th>
		<th data-field="defective" data-formatter="defectiveFormatter">წუნდებული</th>
		<th data-field="quantity">რაოდენობა</th>
	</thead>
	<tbody>

	</tbody>
</table>

<script>
$(document).ready(function(){

	productHistoryTableRequest = function(params) {
        var url = '<?php echo e(route('stock.product_history_api', ['product_id' => $product_id])); ?>';
	  
	    $.get(url + '?ii=1&' + $.param(params.data)).then(function (res) {
	    	METADATA = res.metadata;
	        $('.fixed-table-loading').remove()
	        params.success(res)
	    })
	}

	defectiveFormatter = function(defective){
		if(defective) {
			return '<label class="label label-danger">კი</label>';
		}
		return 'არა'
	}

	$('#product_history_table').bootstrapTable({
		ajax: productHistoryTableRequest,
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
        pageList: [50, 100, 200, 500, 1000, 5000],
	});



});
</script>

<style>
	.bootstrap-table.bootstrap4 {
		width: 100%;
	}
	span[data-product_id] {
		cursor: pointer;
	}
	.pointer {
		cursor: pointer;
	}
	.font_larger {
		padding: 5px;
		font-size: larger;
	}
</style>