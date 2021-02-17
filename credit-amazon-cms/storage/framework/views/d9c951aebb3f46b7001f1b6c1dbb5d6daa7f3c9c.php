<?php $__env->startSection('content'); ?>

<?php echo $__env->make('stocks.stocksmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials.assetTemplates.typeahead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form action="<?php echo e(route('stock.restock')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    მარაგები
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ტიპი</label>
                                <select class="form-control" name="type">
                                    <option value="restock">მიღება</option>
                                    <option value="return">უკან დაბრუნება</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>მიღების თარიღი</label>
                                <input class="form-control" type="date" name="date" value="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label>ნივთი</label>
                                <input class="form-control" type="text" id="product_suggestion_input" >
                                <input type="hidden" id="product_id_input" name="product_id" >
                            </div>

                            <div class="form-group">
                                <label>მომწოდებელი</label>
                                <input type="text" class="form-control" id="supplier_search_suggestion_input">
                                <input type="hidden" name="supplier_id" id="supplier_search_id_input">
                            </div>
                            
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ასაღები ფასი</label>
                                <input required="" class="form-control" name="get_price" type="number" step="any" id="get_price_input" onkeyup="calculateGetPriceSum()">
                                <p style="color: red; margin-left:10px;" id="old_get_price"></p>
                            </div>
                        
                            <div class="form-group">
                                <label>რაოდენობა</label>
                                <input class="form-control" value="1" name="quantity" step="1" type="number" onkeyup="calculateGetPriceSum()">
                            </div>
                       
                            <div class="form-group">
                                <label>ჯამური ფასი</label>
                                <input class="form-control" id="get_price_sum_input" type="number" readonly="" value="0">
                            </div>

                            <div class="form-group" style="padding-top: 2rem">
                                <input type="checkbox" name="defective">
                                <label>წუნდებული</label>
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


<script type="text/javascript">
    function calculateGetPriceSum(){
        var get_price = $('input[name=get_price]').val() || 0
        var quantity = $('input[name=quantity]').val() || 0
        var get_price_sum = get_price * quantity;

        $('#get_price_sum_input').val(get_price_sum);
        $('#left_money_input').val(get_price_sum)
        return get_price_sum
    }


    function calculateLeftMoney(){
        var get_price_sum = calculateGetPriceSum()
        var paid_money = $('#paid_money_input').val() || 0
        var left_money = get_price_sum - paid_money;
        if(left_money < 0) {
            $('#paid_money_input').closest('.form-group').addClass('error')
            $('#left_money_input').closest('.form-group').addClass('error')
        } else {
            $('#paid_money_input').closest('.form-group').removeClass('error')
            $('#left_money_input').closest('.form-group').removeClass('error')
        }
        $('#left_money_input').val(left_money)
        return left_money
    }
</script>
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
            $('#old_get_price').html('ბოლო მიღების ფასი: ' + suggestion.stock_history.get_price);
            $('#product_id_input').val(suggestion.id)
            // $('#get_price_input').val(suggestion.get_price).trigger('keyup') 
            $('#supplier_id_select').val(suggestion.supplier_id)
        })

        $('#product_suggestion_input').focusin(function(){
            $('#old_get_price').html('');
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
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<link href="/assets/node_modules/typeahead.js-master/dist/typehead-min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.newapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>