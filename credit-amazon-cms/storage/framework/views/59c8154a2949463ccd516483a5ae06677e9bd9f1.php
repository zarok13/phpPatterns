<?php $__env->startSection('content'); ?>

<?php echo $__env->make('stocks.stocksmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials.assetTemplates.typeahead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form action="<?php echo e(route('stock.stock_adjustment')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    მარაგების კორექტირება
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>კორექტირების ტიპი</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="redundance">ზედმეტობა</option>
                                    <option value="shortage">დანაკლისი</option>
                                    <option value="move_from_defective">წუნდებულიდან გადატანა მარაგში</option>
                                    <option value="move_from_stock">მარაგიდან გადატანა წუნდებულში</option>
                                    <option value="correction">კორექტირება</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>ნივთი</label>
                                <input class="form-control" type="text" id="product_suggestion_input" required>
                                <input type="hidden" id="product_id_input" name="product_id" >
                            </div>

                            <div class="form-group">
                                <label>მომწოდებელი</label>
                                <input type="text" class="form-control" id="supplier_search_suggestion_input">
                                <input type="hidden" name="supplier_id" id="supplier_search_id_input">
                            </div>
                            <div class="form-group">
                                <label>რაოდენობა</label>
                                <input class="form-control" value="0" name="quantity" step="1" type="number" onkeyup="calculateGetPriceSum()">
                            </div>

                            <div class="form-group">
                                <label>მიღების თარიღი</label>
                                <input class="form-control" type="date" name="date" value="<?php echo e(date('Y-m-d')); ?>">
                            </div>

                            <div class="form-group" style="padding-top: 2rem">
                                <input type="checkbox" name="defective" id="defective">
                                <label for="defective">წუნდებული</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">დამატება</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    მარაგის ინფორმაცია
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <th>მომწოდებელი</th>
                                    <th>მარაგი</th>
                                    <th>წუნდებული</th>
                                </thead>
                                <tbody id="stock_info">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>


<style type="text/css">
    .col-md-12 {
        margin: 0;
    }
    .form-group {
        margin-bottom: 10px;
    }
</style>



<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script src="/assets/node_modules/typeahead.js-master/dist/typeahead.bundle.min.js"></script>

<script type="text/javascript">
    window.preloader = false;

    $(document).ready(function(){
        $('#product_suggestion_input').typeahead({
            minLength: 2,
            highlight: true,
        }, {
            name: 'product_id',
            display: 'name',
            source: Suggestions.getProductSearch()
        }).on('typeahead:selected', function (e, suggestion, name) {
            loadStocksBySuppliers(suggestion.stock_history.product_id);
            $('#product_id_input').val(suggestion.id)
            // $('#get_price_input').val(suggestion.get_price).trigger('keyup') 
            $('#supplier_id_select').val(suggestion.supplier_id)
        });

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
        });

        $('select#type').change(function(){
            if($(this).find(":selected").val() === 'move_from_defective' || $(this).find(":selected").val() === 'move_from_stock'){
                $('#defective').attr('disabled', true);
            } else {
                $('#defective').attr('disabled', false);
            }
           
        })
    })

    function loadStocksBySuppliers(product_id){
        var url = '<?php echo e(route('stock.stock_by_suppliers', ['product_id' => '__EXAMPLE__'])); ?>'
        url = url.replace('__EXAMPLE__', product_id)

        $.ajax({
            url: url,
            success: function(data){
                $('#stock_info').html(data.response);
            }   
        })
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<link href="/assets/node_modules/typeahead.js-master/dist/typehead-min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.newapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>