<?php ($user = Auth::user()); ?>
<?php ($canSeeStocks = $user->hasRole(['ACCOUNTANT', 'OPERATOR', 'SUPER_ADMIN', 'TECHPLUS_MANAGER'])); ?>
<?php ($onlySeeStocks = $user->hasRole(['OPERATOR', 'SIGNATURE_OPERATOR', 'TECHPLUS_OPERATOR', 'MANAGER', 'MARKETING_MANAGER'])); ?>


<?php echo $__env->make('partials.assetTemplates.bootstrapTable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials.assetTemplates.typeahead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

<?php if(!$onlySeeStocks): ?>
    <?php echo $__env->make('stocks.stocksmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php if(!$onlySeeStocks): ?>
                <form actions="" method="get" id="product_stocks_table_filter" onsubmit="formSubmited(event)">
                    <input type="hidden" name="i" value="true">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>ნივთი</label>
                                <input type="text" value="<?php echo e(request('name', null)); ?>" id="product_search_suggestion_input" class="form-control">
                                <input type="hidden" name="product_id" id="product_search_id_input" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label>მომწოდებელი</label>
                            <input type="text" class="form-control" id="supplier_search_suggestion_input">
                            <input type="hidden" name="supplier_id" id="supplier_search_id_input">
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>აღწერის თარიღი</label>
                                <input name="review_date" type="date" value="" class="form-control">
                            </div>
                        </div>

                        <div class="form-group mt-3" >
                            არ არის მარაგში: <input type="checkbox" name="show_nulls" ><br>
                            აღწერის გარეშე: <input type="checkbox" name="without_reviews" >
                        </div>
                        <div class="form-group mt-3" >
                            სხავობით: <input type="checkbox" name="show_only_different_stock" ><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <button type="submit" class="btn btn-success">ძებნა</button>
                        </div>
                    </div>
                </form>
                <?php else: ?>
                <h6>ბოლო აღწერის თარიღი: <?php echo e(now()->diffInDays(\Carbon\Carbon::parse($last_review_date))); ?> დღის წინ</h6>
                <?php endif; ?>

            </div>




            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="product_stocks_table">
                            <thead>
                                <th data-field="id">ID</th>
                                <th data-field="unique_id">#</th>
                                <th data-field="item_name" data-formatter="productNameFormatter">ნივთი</th>
                                <?php if(!$onlySeeStocks): ?>
                                    <th data-field="supplier_names">მომწოდებლები</th>
                                    <th data-field="get_price">ასაღები ფასი</th>
                                    <th data-field="price_sum">ნაშთი</th>
                                <?php endif; ?>
                                <th data-sortable="true" data-field="stock" data-formatter="stockFormatter" >მარაგი</th>
                                <?php if(!$onlySeeStocks): ?>
                                    <th data-field="defective_stock" data-formatter="defectiveStockFormatter">წუნდებული</th>
                                <?php endif; ?>
                                <th data-field="last_review_date" >აღწ.თარიღი</th>
                                <?php if(!$onlySeeStocks): ?>
                                    <th data-sortable="true" data-field="was_stock" data-formatter="reviewStockFormatter">აღწ.მარაგი</th>
                                    <th data-sortable="true" data-field="stock_diff" data-formatter="reviewFormatterStock">აღწერა</th>
                                    <th data-sortable="true" data-field="defective_diff" data-formatter="reviewFormatterDefective">აღწერა.წ</th>
                                <?php endif; ?>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" >
                        <?php if(!$onlySeeStocks): ?>
                        <button class="btn btn-success" onclick="$('#product_stocks_table').tableExport({type:'excel'});">Export</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12" >
        <div class="card">
            <div class="card-body" id="history_div">
                
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript" src="/dist/js/bootstraptableexport.js"></script>
<script type="text/javascript" src="/dist/js/bootstraptableexportfilesaver.js"></script>
<script type="text/javascript" src="/dist/js/bootstraptableexportexcel.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#product_stocks_table').bootstrapTable({
            ajax: productStocksTableRequest,
            search: true, 
            sortable: true,
            sidePagination: 'server',
            pagination: true,
            showColumns: true,
            showRefresh: true,
            checkboxHeader: true, 
            clickToSelect: true,
            totalField: 'count',
            dataField: 'data',
            pageSize: <?php echo e($onlySeeStocks ? 1500 : 50); ?>,
            pageList: [20, 50, 100, 200, 500, 1000, 1500, 5000],
        });
    });

    stockFormatter = function (val, row) {
        return `
            <span id="product_stock_${row.product_id}" class="pointer" 
            <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'TECHPLUS_MANAGER'])) : ?>
            onclick="
                $('#edit_stock_${row.product_id}').show(); 
                $(this).hide()
            "
            <?php endif; // Entrust::hasRole ?>
        >${val}</span>

            <form action="/" id="edit_stock_${row.product_id}" onsubmit="
                event.preventDefault();
                editStockSubmitted(this);
                $('#product_stock_${row.product_id}').show();
            " style="display: none">
                <input type="hidden" name="ii" value="ii" />
                <input type="hidden" name="product_id" value="${row.product_id}" />
                <input type="hidden" name="old_stock" value="${val}" />
                <input type="number" value="${val}" onchange="$('#product_stock_${row.product_id}').html($(this).val())" name="edited_stock" />
                <button class="btn btn-xs mt-1 btn-success">ჩასწორება</button>
            </form>
        `
    }

    defectiveStockFormatter = function (val, row) {
        return `
            <span id="defective_product_stock_${row.product_id}" class="pointer red" 
            <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'TECHPLUS_MANAGER'])) : ?>
             onclick="
                $('#edit_defective_stock_${row.product_id}').show(); 
                $(this).hide()
            " 
            <?php endif; // Entrust::hasRole ?> 
            >${val}</span>

            <form action="/" id="edit_defective_stock_${row.product_id}" onsubmit="
                event.preventDefault();
                editDefectiveStockSubmitted(this);
                $('#defective_product_stock_${row.product_id}').show();
            " style="display: none">
                <input type="hidden" name="ii" value="ii" />
                <input type="hidden" name="product_id" value="${row.product_id}" />
                <input type="hidden" name="old_stock" value="${val}" />
                <input type="number" value="${val}" onchange="$('#defective_product_stock_${row.product_id}').html($(this).val())" name="edited_stock" />
                <button class="btn btn-xs mt-1 btn-success">ჩასწორება</button>
            </form>
        `
    }

    productStocksTableRequest = function(params){
        var url = '<?php echo e(route('stock.product_stocks_api')); ?>';
        var urlParams = $('#product_stocks_table_filter').serialize();

        $.get(url + '?ssi=1&' + $.param(params.data) + '&' + urlParams).then(function (res) {
            METADATA = res.metadata;
            $('.fixed-table-loading').remove()
            params.success(res)
        });
    }

    productNameFormatter = function(val, row){
        return `<span class="pointer" onclick="loadProductHistory(${row.product_id})">${val}</span>`
    }

    reviewFormatterStock = function(val, row){
        var html = `
            <form data-review_form id="product_edit_form_${row.id}" onsubmit="event.preventDefault(); reviewFormSubmited(event)">
                <input type="hidden" value="${row.id}" name="product_id" />
                <input onchange="changedAgwerebisInput(event)" name="agw_quantity" 
                    class="review_input" type="number" value="${row.last_review_stock || 0}" onkeyup="calculateReviewStock(event)" data-product_id="${row.id}" data-defective="${row.defective_stock}" data-stock="${row.stock}" /> 
                <?php if($canSeeStocks): ?>
                <span data-product_id="${row.id}" class="stock_diff">${parseInt(-row.stock + (row.last_review_stock || 0))}</span>
                <input name="agw_diff" class="stock_diff_input" type="hidden" data-product_id="${row.id}" value="${parseInt(-row.stock)}" />
                <?php endif; ?>
            </form>
        `;
        return html;
    }
    
    reviewFormatterDefective = function(val, row){
        var html = `
            <form data-review_form id="def_product_edit_form_${row.id}" onsubmit="event.preventDefault(); reviewFormSubmited(event)">
                <input type="hidden" value="${row.id}" name="product_id" />
                <input type="hidden" value="1" name="defective" />
                <input onchange="changedAgwerebisInput(event)" name="agw_quantity" 
                    class="def_review_input" type="number" value="${row.last_review_defective || 0}" onkeyup="calculateReviewDefective(event)" data-product_id="${row.id}" data-defective="${row.defective_stock}" data-stock="${row.stock}" /> 
                <?php if($canSeeStocks): ?>
                <span data-product_id="${row.id}" class="def_stock_diff">${parseInt(-row.defective_stock + (row.last_review_defective || 0))}</span>
                <input name="agw_diff" class="def_stock_diff_input" type="hidden" data-product_id="${row.id}" value="${parseInt(-row.defective_stock)}" />
                <?php endif; ?>
            </form>
        `;
        return html;
    }
    
    
    calculateReviewStock = function(e){
        var el = $(e.target);
        var stock = parseInt(el.data('stock'))
        var product_id = parseInt(el.data('product_id'))
        var val = parseInt(el.val())
        var allstock = stock;
        var diff = val - allstock;
        var diff_selector = $(`.stock_diff[data-product_id=${product_id}]`);
        var diff_input_selector = $(`input.stock_diff_input[data-product_id=${product_id}]`);
        var html_diff = diff;

        e.target.value = val
        if(!val) {
            html_diff = -stock
            e.target.value = 0
        }
        <?php if($canSeeStocks): ?>
        diff_selector.html(html_diff)
        <?php endif; ?>
        diff_input_selector.val(html_diff)
    }

    calculateReviewDefective = function(e){
        var el = $(e.target);
        var stock = parseInt(el.data('stock'))
        var defective = parseInt(el.data('defective'))
        var product_id = parseInt(el.data('product_id'))
        var val = parseInt(el.val())
        var allstock = defective;
        var diff = val - allstock;
        var diff_selector = $(`.def_stock_diff[data-product_id=${product_id}]`);
        var diff_input_selector = $(`input.def_stock_diff_input[data-product_id=${product_id}]`);
        var html_diff = diff;

        e.target.value = val
        if(val == NaN) {
            html_diff = -defective
            e.target.value = 0
        }
        <?php if($canSeeStocks): ?>
        diff_selector.html(html_diff)
        <?php endif; ?>
        diff_input_selector.val(html_diff)
    }


    reviewFormSubmited = function(e){
        var form = $(e.target);
        var data = {i: 1}
        form.serializeArray().map(function(val){
            return data[val.name] = val.value 
        });
        var url = '<?php echo e(route('stock.review_product')); ?>'
        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            success: function(data){
                console.log(data)
            }
        })
    }

    loadProductHistory = function(product_id){
        var url = '<?php echo e(route('stock.product_history', ['product_id' => '__EXAMPLE__'])); ?>'
        url = url.replace('__EXAMPLE__', product_id)

        $.ajax({
            url: url,
            success: function(data){
                $('#history_div').html(data.html);
            }   
        })
    }

    reviewStockFormatter = function(val, row){
        return `${row.was_stock || 0} / ${row.was_stock_defective || 0}`;
    }
    
    changedAgwerebisInput = function(e){
        var el = $(e.target);
        preloader = false
        el.closest('form').submit();
        preloader = true
    }

    formSubmited = function(e) {
        e.preventDefault();
        $('#product_stocks_table').bootstrapTable('refresh');
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
            limit: 30,
            display: 'name',
            source: Suggestions.getSupplierSearch()
        }).on('typeahead:selected', function (e, suggestion, name) {
            $('#supplier_search_id_input').val(suggestion.id)
        })
    })

    editStockSubmitted = function(form) {
        var formdata = getFormDataObject($(form))
        $(form).hide();

        <?php if(auth()->user()->id == 70): ?>
        $.ajax({
            url: '<?php echo route('stock.actions', ['i' => 1, '_action' => 'edit_product_stock_']); ?>',
            data: formdata,
            type: 'POST',
            success: function(data){
                console.log(data)
            }
        })
        <?php endif; ?>
    }
    editDefectiveStockSubmitted = function(form) {
        var formdata = getFormDataObject($(form))
        $(form).hide();

        $.ajax({
            url: '<?php echo route('stock.actions', ['i' => 1, '_action' => '_edit_defective_product_stock_' ]); ?>',
            data: formdata,
            type: 'POST',
            success: function(data){
                console.log(data)
            }
        })
    }
</script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('styles'); ?>
<style type="text/css">
    .pointer {
        cursor: pointer;
    }

    .stock_diff, 
    .def_stock_diff {
        float: left;
    } 

    .review_input, 
    .def_review_input {
        float: left;
        margin-right: 3px;
        width: 50px;
    }
    .col-md-12 {
        margin-bottom: 0;
    }
    .red {
        color: #ff0000;
        text-decoration: underline;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.newapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>