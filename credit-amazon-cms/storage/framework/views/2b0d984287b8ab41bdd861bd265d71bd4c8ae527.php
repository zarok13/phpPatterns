
<?php ($user = Auth::user()); ?>
<?php ($canSeeStocks = $user->hasRole(['ACCOUNTANT', 'SUPER_ADMIN', 'TECHPLUS_MANAGER'])); ?>

<?php echo $__env->make('partials.assetTemplates.bootstrapTable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials.assetTemplates.typeahead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $supplier_id = isset($supplier_id) ? $supplier_id : null; ?>
<?php $product_id = isset($product_id) ? $product_id : null; ?>

<?php ($types = ['return' => 'დაბრუნება', 'restock' => 'მიღება']); ?>

<div class="row" >
    <div class="col-md-12" style="margin-bottom: 100px">
        <div class="card">
        	<div class="card-header">
    			<form id="stock_filter_form" onsubmit="event.preventDefault(); refreshTable()">
    				<?php if(!$supplier_id && !$product_id): ?>
						<input type="hidden" name="hide_empty" value="1">
    				<?php endif; ?>
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
								<input type="hidden" name="supplier_id" value="<?php echo e($supplier_id); ?>" id="supplier_search_id_input">
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
									<option value="return">უკან დაბრუნება</option>
									<option value="restock">მიღება</option>
								</select>
							</div>
							
							<div class="form-grop">
								<label>მომწოდებელზე გადასვლა</label>
								<input type="text" class="form-control" id="goto_supplier_search_suggestion_input">
								<input type="hidden" name="supplier_id" value="<?php echo e($supplier_id); ?>" id="goto_supplier_search_id_input">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-grop">
								<label>დღის დახურვა</label>
								<select class="form-control" name="not_verified">
									<option></option>
									<option value="1">დაუხურავი</option>
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
                <table class="table" id="stock_history_table">
                    <thead>
                        <th data-field="date">თარიღი</th>
                        <th data-field="type" data-formatter="sourceFormatter">ტიპი</th>
                        <th data-field="product_name" data-formatter="productNameFormatter">ნივთი</th>
                        <th data-field="product_code" >კოდი</th>
                        <?php if($canSeeStocks): ?>
                        <th data-field="stock" data-formatter="productStockFormatter">ნივთის მარაგი</th>
                        <?php endif; ?>
                        <th data-field="supplier_name" data-formatter="supplierFormatter">მომწოდებელი</th>
                        <th data-field="quantity" data-footer-formatter="footerFromMeta">რაოდენობა</th>
                        <th data-field="get_price" data-footer-formatter="footerFromMeta">ასაღები ფასი</th>
                        <th data-field="get_price_sum" data-footer-formatter="footerFromMeta">ჯამური ფასი</th>
                        <th data-field="" data-formatter="editColumnFormatter">?</th>
                    </thead>
					<tbody>
						
					</tbody>
					<tfoot>
					</tfoot>
                </table>
            </div>
            <div class="col-md-12 ">
            	<button class="btn btn-success mt-2 mb-2" onclick="closeDay()">დღის დახურვა</button>
                <button class="btn btn-success" onclick="$('#stock_history_table').tableExport({type:'excel'});">Export</button>
            </div>
        </div>
    </div>
	
</div>

<div class="modal fade bs-example-modal-sm" id="edit_stock_history_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;"></div>  


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript" src="/dist/js/bootstraptableexport.js"></script>
<script type="text/javascript" src="/dist/js/bootstraptableexportfilesaver.js"></script>
<script type="text/javascript" src="/dist/js/bootstraptableexportexcel.js"></script>

<script type="text/javascript">
	var METADATA = {};
	$(document).ready(function(){
		$('#stock_history_table').bootstrapTable({
	        ajax: stockHistoryTableRequest,
	        sortable: true,
	        sidePagination: 'server',
	        pagination: true,
	        search: true,
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

	stockHistoryTableRequest = function(params) {
        var url = '<?php echo e(route('stock.stock_history_api')); ?>';
	    var urlParams = $('#stock_filter_form').serialize();

	    $.get(url + '?ii=1&' + $.param(params.data) + '&' + urlParams).then(function (res) {
	        METADATA = res.metadata;
	        $('.fixed-table-loading').remove()
	        params.success(res)
	    })
	}


    sourceFormatter = function(val){
    	if(val == 'restock') {
    		return '<label class="label label-success">მიღება</label>'
    	} else if(val == 'return') {
    		return '<label class="label label-success">დაბრუნება</label>'
    	}
    }


    supplierFormatter = function(val, row){
    	var url = '<?php echo e(route('stock.supplier.index', ['id' => '__EXAMPLE_ID__'])); ?>'
		if(!val) return '-';
		url = url.replace('__EXAMPLE_ID__', row.supplier_id)

    	return `<a target="blank" href="${url}" >${val}</a>`
    }

    productStockFormatter = function(val) {
    	return `<label class="label label-success">${val}</label>`
    }

	editColumnFormatter = function(val, row){
		
		return `
			<i class="pointer font_larger fa fa-pencil" onclick="editStockHistory(${row.id})"></i>
			<i class="pointer font_larger fa fa-trash text-danger" onclick="deleteStockHistory(${row.id})"></i>
		`;
	}

    productNameFormatter = function(val, row) {
    	return `<span data-product_name="${val}" data-product_id="${row.product_id}" onclick="filterProduct(event)">${val}</span>`;
    }

	footerFromMeta = function(data){
	    var field = this.field;
	    if(METADATA[this.field]) {
	        return METADATA[this.field];
	    } else {
	        return '';
	    }
	}

	refreshTable = function(){
		$('#stock_history_table').bootstrapTable('refresh')
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
            minLength: 2,
            highlight: true,
        },{
            name: 'supplier_id',
            limit: 30,
            display: 'name',
            source: Suggestions.getSupplierSearch()
        }).on('typeahead:selected', function (e, suggestion, name) {
            $('#supplier_search_id_input').val(suggestion.id)
            <?php if($supplier_id): ?>
            	var route = '<?php echo e(route('stock.supplier.index', ['id' => '__EXAMPLE_ID__'])); ?>';
            	window.location.href = route.replace('__EXAMPLE_ID__', suggestion.id)
            <?php endif; ?>
        });
        $('#goto_supplier_search_suggestion_input').typeahead({
            minLength: 2,
            highlight: true,
        },{
            name: 'supplier_id',
            limit: 30,
            display: 'name',
            source: Suggestions.getSupplierSearch()
        }).on('typeahead:selected', function (e, suggestion, name) {
            $('#goto_supplier_search_id_input').val(suggestion.id)
        	var route = '<?php echo e(route('stock.supplier.index', ['id' => '__EXAMPLE_ID__'])); ?>';
        	window.location.href = route.replace('__EXAMPLE_ID__', suggestion.id)
        })
    })


    filterProduct = function(event) {
    	var el = $(event.target);
		$('#product_search_suggestion_input').val(el.data('product_name'))
		$('#product_search_id_input').val(el.data('product_id'))
		refreshTable();
    }

    closeDay = function() {
    	$('<input>')
    		.attr({
		      type: 'hidden',
		      id: 'verify_date_input',
		      name: 'verify_date',
		      value: '1',
		    })
		    .appendTo('#stock_filter_form')
	
		refreshTable();
		setTimeout(function(){
			refreshTable();
		}, 200)
		$('#verify_date_input').remove();
    }

    editStockHistory = function(id){
		$.ajax({
			type: 'POST',
			url: actionurl, 
			data: {_id: id, _action: 'edit'},
		})
		.done(function(data){
			$('#edit_stock_history_modal').html(data).modal('show')
		})
    }

	deleteStockHistory = function(id){
		if(confirm('დარწმუნებული ხართ რომ ნამდვილად გინდათ ამ მიღების წაშლა?')) {
			$.ajax({
				type: 'POST',
				url: actionurl, 
				data: {_id: id, _action: 'delete'},
				success: function(data){
					console.log(data)
				}
			})
		}
	}

	var actionurl = '<?php echo e(route('stock.actions', ['i' => 1])); ?>' 
</script>

<?php $__env->stopPush(); ?>





<?php $__env->startPush('styles'); ?>
<style type="text/css">
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
<?php $__env->stopPush(); ?>