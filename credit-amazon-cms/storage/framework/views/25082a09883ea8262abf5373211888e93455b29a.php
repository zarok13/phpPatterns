<?php 
use App\Helpers\Currency;
?>


<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">
                    <input type="hidden" name="i" value="1">
                    <div class="row">
                        <div class="col-md-1">
                            <label>მთავარი</label>
                            <select class="form-control" name="main_currency">
                                <option value="GEL" <?php echo e(MAIN_CURRENCY == 'GEL' ? 'selected' : ''); ?>>GEL</option>
                                <option value="USD" <?php echo e(MAIN_CURRENCY == 'USD' ? 'selected' : ''); ?>>USD</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>დან - </label>
                            <input class="form-control" type="date" name="date_from" value="<?php echo e($date_from); ?>">
                        </div>
                        <div class="col-md-2">
                            <label>- მდე</label>
                            <input class="form-control" type="date" name="date_to" value="<?php echo e($date_to); ?>">
                        </div>
                        <div class="col-md-1">
                            <label>კრედ. </label>
                            <input class="form-control" type="number" step="any" name="creditamazon_coeficient" value="<?php echo e(CRED_COEFICIENT); ?>">
                        </div>
                        <div class="col-md-1">
                            <label>ტექ. </label>
                            <input class="form-control" type="number" step="any" name="techplus_coeficient" value="<?php echo e(TECH_COEFICIENT); ?>">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-success">გაახლება</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4>ტექპლიუსის ხარჯი</h4>
                <table class="table">
                    <tr>
                        <th>სახელი</th>
                        <th>დღიური</th>
                        <th>თვიური</th>
                        <th>ხარჯი</th>
                    </tr>
                    
                    <?php $__currentLoopData = $techplus_expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($daily = round($exp->getDailyCharge(), 2)); ?>
                        <?php ($monthly = round($exp->getMonthlyCharge(), 2)); ?>
                        <?php ($tech_expense = round($exp->getActualCharge($days), 2)); ?>

                        <tr>
                            <td><?php echo e($exp->expense_name); ?></td>
                            <td><?php echo e($daily); ?> <?php echo e($exp->currency); ?> x <?php echo e($days); ?></td>
                            <td><?php echo e($monthly); ?> <?php echo e($exp->currency); ?></td>
                            <td><?php echo e($tech_expense); ?> <?php echo e(MAIN_CURRENCY); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <tr style="font-weight: bold">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> <?php echo e(array_reverse(array_values($expenses['techplus']))[0]['sum']); ?> <?php echo e(MAIN_CURRENCY); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4>კრედიტამაზონის ხარჯი</h4>
                <table class="table">
                    <tr>
                        <th>სახელი</th>
                        <th>დღიური</th>
                        <th>თვიური</th>
                        <th>ხარჯი</th>
                    </tr>

                    <?php $__currentLoopData = $creditamazon_expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($daily        = round($exp->getDailyCharge(), 2)       ); ?>
                        <?php ($monthly      = round($exp->getMonthlyCharge(), 2)     ); ?>
                        <?php ($cred_expense = round($exp->getActualCharge($days), 2) ); ?>

                        <tr>
                            <td><?php echo e($exp->expense_name); ?></td>
                            <td><?php echo e($daily); ?> <?php echo e($exp->currency); ?> x <?php echo e($days); ?></td>
                            <td><?php echo e($monthly); ?> <?php echo e($exp->currency); ?></td>
                            <td><?php echo e($cred_expense); ?> <?php echo e(MAIN_CURRENCY); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <tr style="font-weight: bold">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> <?php echo e(array_reverse(array_values($expenses['creditamazon']))[0]['sum']); ?> <?php echo e(MAIN_CURRENCY); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div> 



    <div class="col-md-12">
        <form action="<?php echo e(route('balances.index')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="card">
                <div class="card-body"  style="overflow-x: auto; overflow: auto; " >
                    <h4>ბალანსები</h4>
                    <table class="table" id="balances_table">           
                        <thead>
                            <th></th>
                            <th colspan="8">ტექპლუსი</th>
                            <th colspan="7">კრედიტამაზონი</th>
                            <th colspan="5">ჯამური</th>
                        </thead>        
                        <thead>
                            <th>თარიღი</th>

                            <th>ტექ.FB. ხარჯი</th>
                            <th>ტექ. ხარჯი</th>
                            <th>ტექ. საკურიერო</th>
                            <th>ტექ. ჯამ. ხარჯი</th>
                            <th>ტექ. შემოსავალი</th>
                            <th>ტექ. მოგება</th>
                            <th>ტექ. შენახული</th>
                            <th>ტექ. მოგება კოეფ</th>
                            
                            <th>კრედ. FB. ხარჯი</th>
                            <th>კრედ. ხარჯი</th>
                            <th>კრედ. ჯამ. ხარჯი</th>
                            <th>კრედ. შემოსავალი</th>
                            <th>კრედ. მოგება</th>
                            <th>კრედ. შენახული</th>
                            <th>კრედ. მოგება.კოეფ</th>

                            <th>ჯამ. ხარჯი</th>
                            <th>ჯამ. შემოსავალი</th>
                            <th>ჯამ. შენახული</th>
                            <th>ჯამ. მოგება</th>
                            <th>ჯამ. მოგება.კოეფ</th>
                        </thead>
                        <tbody>

                        <?php 
                            $save_array = [];
                            $tech_fb_spend_sum = 0;
                            $cred_fb_spend_sum = 0;
                            $tech_income_sum = 0;
                            $cred_income_sum = 0;
                        ?>

                        <?php foreach(array_reverse($dates) as $date): ?>
                            <?php 
                                $tech_coef = TECH_COEFICIENT;
                                $cred_coef = CRED_COEFICIENT;

                                $curs = isset($expenses['techplus'][$date]) ? $expenses['techplus'][$date]['kursi'] : 0;

                                $tech_fb_spend = isset($fb_spends['techplus'][$date]) ? (
                                    MAIN_CURRENCY == 'USD' ? $fb_spends['techplus'][$date] : $fb_spends['techplus'][$date] * $curs
                                ) : 0;

                                $tech_income = isset($techplus_incomes[$date]) ? $techplus_incomes[$date]['profit'] : 0;
                                // $tech_income = isset($techplus_incomes[$date]) ? $techplus_incomes[$date]['act_profit'] : 0;
                                $tech_daily_expense = isset($expenses['techplus'][$date]) ? $expenses['techplus'][$date]['sum'] : 0;
                                $tech_count = isset($techplus_incomes[$date]) ? $techplus_incomes[$date]['count'] : 0;
                                $tech_sakuriero = (isset($expenses['techplus'][$date]) ? $expenses['techplus'][$date]['sakuriero'] : 0);
                                $tech_sakuriero_expense = $tech_sakuriero * $tech_count;
                                $tech_old_profit = isset($old_balances[$date], $old_balances[$date]['techplus']) ? $old_balances[$date]['techplus']: 0;
                                $tech_old_b = isset($techplus_incomes[$date]) ? $techplus_incomes[$date]['act_profit']: 0;
                                $tech_sum_spend = $tech_fb_spend + $tech_daily_expense + $tech_sakuriero_expense;
                                $tech_profit = $tech_income - $tech_sum_spend;

                                $cred_fb_spend = isset($fb_spends['creditamazon'][$date]) ? (
                                    MAIN_CURRENCY == 'USD' ? $fb_spends['creditamazon'][$date] : $fb_spends['creditamazon'][$date] * $curs
                                ) : 0;

                                $cred_daily_expense = isset($expenses['creditamazon'][$date]) ? $expenses['creditamazon'][$date]['sum'] : 0;
                                $cred_income = isset($creditamazon_incomes[$date]) ? $creditamazon_incomes[$date]['profit_tax'] : 0;
                                $cred_sum_spend = $cred_fb_spend + $cred_daily_expense;
                                $cred_profit = $cred_income - $cred_sum_spend;
                                $cred_old_profit = isset($old_balances[$date], $old_balances[$date]['creditamazon']) ? $old_balances[$date]['creditamazon']: 0;
                                $cred_old_b = isset($creditamazon_incomes[$date]) ? $creditamazon_incomes[$date]['profit_tax']: 0;
                                
                                if($tech_income == 0){
                                    $tech_coef = 1;
                                }
                                if($cred_income == 0){
                                    $cred_coef = 1;
                                }

                                if(isset($old_balances[$date], $old_balances[$date]['techplus'])) {
                                    $tech_profit_coef = round($old_balances[$date]['techplus'] > 0 ? $old_balances[$date]['techplus'] * $tech_coef : $old_balances[$date]['techplus'] / $tech_coef, 2);
                                } else {
                                    // $tech_profit_coef = round($tech_profit > 0 ? ($tech_income - $tech_sum_spend) * $tech_coef : $tech_profit / $tech_coef, 2);
                                    $tech_profit_coef = round($tech_profit > 0 ? $tech_old_b * $tech_coef - $tech_sum_spend : $tech_profit / $tech_coef, 2);
                                }

                                if(isset($old_balances[$date], $old_balances[$date]['creditamazon'])) {
                                    $cred_profit_coef = round($old_balances[$date]['creditamazon'] > 0 ? 
                                        $old_balances[$date]['creditamazon'] * $cred_coef : 
                                        $old_balances[$date]['techplus'] / $cred_coef, 2);
                                } else {
                                    // $cred_profit_coef = round($cred_profit > 0 ? ($cred_income - $cred_sum_spend) * $cred_coef : $cred_profit / $cred_coef, 2);
                                    $cred_profit_coef = round($cred_profit > 0 ? 
                                        $cred_old_b * $cred_coef - $cred_sum_spend : 
                                        $cred_profit / $cred_coef, 2);
                                }
                                
                                // $tech_profit_coef = round($tech_profit > 0 ? $tech_profit * $tech_coef : $tech_profit / $tech_coef, 2);
                                // $cred_profit_coef = round($cred_profit > 0 ? $cred_profit * $cred_coef : $cred_profit / $cred_coef, 2);
                                $tech_shemosavali = $tech_fb_spend + $tech_daily_expense + $tech_sakuriero_expense;
                                $cred_shemosavali = $cred_income;
                            ?>
                            <?php 
                                $tech_fb_spend_sum += $tech_fb_spend;
                                $cred_fb_spend_sum += $cred_fb_spend;
                                $tech_income_sum += $tech_income;
                                $cred_income_sum += $cred_income;
                            ?>
                            <tr>
                                <td data-notsum="true"><?php echo e($date); ?>/<small><span style="font-weight: bold;"><?php echo e($curs); ?></span></small></td>  

                                <td class="spend"><?php echo e($tech_fb_spend); ?></td>
                                <td class="spend"><?php echo e($tech_daily_expense); ?></td>
                                <td class="spend"><?php echo e($tech_sakuriero_expense); ?> / <small><?php echo e($tech_count); ?></small></td>
                                <td class="spend"><?php echo e($tech_shemosavali); ?></td>
                                <td class="profit"><?php echo e($tech_income); ?></td>
                                <td class="profit_bold_light"><?php echo e($tech_profit); ?></td>
                                <td class="profit"><small><?php echo e($tech_old_b); ?> / <?php echo e(round($tech_old_b - $tech_income, 2)); ?></small></td>
                                <td class="profit_bold"><?php echo e($tech_old_profit != 0 ? $tech_old_profit : $tech_profit_coef); ?> </td>

                                <td class="spend"><?php echo e($cred_fb_spend); ?></td>
                                <td class="spend"><?php echo e($cred_daily_expense); ?></td>
                                <td class="spend"><?php echo e($cred_fb_spend + $cred_daily_expense); ?></td>
                                <td class="profit"><?php echo e($cred_income); ?></td>
                                <td class="profit_bold_light"><?php echo e($cred_profit); ?></td>
                                <td class="profit"><small><?php echo e($cred_old_b); ?> / <?php echo e(round($cred_old_b - $cred_profit, 2)); ?></small></td>
                                <td class="profit_bold"><?php echo e($cred_old_profit != 0 ? $cred_old_profit : $cred_profit_coef); ?></td>

                                <td class="spend"><?php echo e($cred_fb_spend + $cred_daily_expense + $tech_fb_spend + $tech_daily_expense + $tech_sakuriero_expense); ?></td>
                                <td class="profit"><?php echo e($cred_income + $tech_income); ?></td>
                                <td class="profit"><small><?php echo e($cred_old_b + $tech_old_b); ?></small> / <small><?php echo e(round(( $cred_old_b + $tech_old_b ), 2) - round(($cred_profit + $tech_profit), 2)); ?></small></td>
                                <td class="profit_bold_light"><?php echo e(round($cred_profit + $tech_profit, 2)); ?> </td>
                                
                                <td class="profit_bold"><?php echo e(($cred_old_b * CRED_COEFICIENT) + ($tech_old_b * TECH_COEFICIENT) - $tech_sum_spend - $cred_sum_spend); ?></td>
                            </tr>
                            <?php if($date != date('Y-m-d')): ?>
                                <input type="hidden" name="balance[<?php echo e($date); ?>][tech_coeficient]" value="<?php echo e($tech_profit_coef); ?>">
                                <input type="hidden" name="balance[<?php echo e($date); ?>][cred_coeficient]" value="<?php echo e($cred_profit_coef); ?>">
                                <input type="hidden" name="balance[<?php echo e($date); ?>][cred_profit]" value="<?php echo e($cred_profit); ?>">
                                <input type="hidden" name="balance[<?php echo e($date); ?>][tech_profit]" value="<?php echo e($tech_profit); ?>">

                                <?php if($save_balances): ?>
                                    <?php 
                                        $save_array[$date] = [
                                            'tech_coeficient' => $tech_profit_coef,
                                            'cred_coeficient' => $cred_profit_coef,
                                            'cred_profit' => $cred_profit,
                                            'tech_profit' => $tech_profit,
                                        ];
                                    ?>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <input type="hidden" name="currency" value="<?php echo e(MAIN_CURRENCY); ?>">
                        <input type="hidden" name="curs" value="<?php echo e($current_curs); ?>">

                        </tbody>
                        <tfoot>
                            <tr></tr>
                        </tfoot>
                    </table>

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" type="subimt">შენახვა</button>
                </div>
            </div>
        </form>
    </div>
</div>













<?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div id="<?php echo e($date); ?>_details" style="display: none">
        <div class="card">
            <div class="card-body">
                <div class="row p20">
                    <?php if(isset($expenses[$date])): ?>
                        <div class="col-md-6">
                            <h5>Expenses</h5>
                            <table>
                                <?php ($expenses_sum = 0); ?>
                                <?php $__currentLoopData = $expenses[$date]['expenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php ($expenses_sum += $expense); ?>
                                    <tr>
                                        <td><?php echo e($name); ?></td>
                                        <td><?php echo e(round($expense,2)); ?> <?php echo e(MAIN_CURRENCY); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr style="font-weight: bold">
                                    <td></td>
                                    <td><?php echo e(round($expenses_sum, 2)); ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($days_info[$date])): ?>
                        <?php ($info = $days_info[$date]); ?>
                        <div class="col-md-6">
                            <h5>General Info</h5>
                            <table>
                                <tr><td>Total Requests: </td><td><?php echo e($info['count']); ?></td></tr>
                                <tr><td>Active Requests: </td><td><?php echo e($info['boughts']); ?></td></tr>
                                <tr><td>Canceled Requests: </td><td><?php echo e($info['canceled_requests']); ?></td></tr>
                                <tr><td>Total Products: </td><td><?php echo e($info['products_count']); ?></td></tr>
                                <tr><td>Canceled Products: </td><td><?php echo e($info['canceled_products']); ?></td></tr>
                                <tr><td>Get Prices: </td><td><?php echo e($info['get_price_sum']); ?></td></tr>
                                <tr><td>Sell Prices: </td><td><?php echo e($info['sell_price_sum']); ?></td></tr>
                                <tr><td>Profit: </td><td><?php echo e($info['sell_price_sum'] - $info['get_price_sum']); ?></td></tr>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        calculateSums();
    });

    function dayDetailsFormatter(index, row) {
        var date = row.date;
        var html = $(`#${date}_details`).html()
        return html;
        return html.join('')
    }
    
    function calculateSums(){
        var table = document.querySelector('#balances_table')
        var foot = table.querySelector('tfoot tr:nth-child(1)')
        var trs = table.querySelectorAll('tbody tr')
        var sums = [];
        
        for(var i=0; i<trs.length; i++){
            var tds = trs[i].querySelectorAll(`td`)
            for(var j=0; j<tds.length; j++){
                var innerText = tds[j].innerText
                if(tds[j].hasAttribute('data-notsum')) {
                    sums[j] = '';
                    continue
                } else if (innerText.indexOf('/') != -1) {
                    var data = innerText.split('/')
                    var value = parseFloat(data[0])
                } else {
                    var value = parseFloat(innerText)
                }

                if(sums[j] == undefined) {
                    sums[j] = value
                } else {
                    sums[j] += value
                }
            }
        }

        for(var i=0; i<sums.length; i++){
            foot.innerHTML = foot.innerHTML + `<td>${Math.round(sums[i],2)}</td>`
        }
        console.log(sums)
    }
</script>

<style type="text/css">
    .col-md-12 {
        margin-bottom: 0 !important;
    }
    tr td {
        border: 2px solid #fff;
    }
    th[colspan]{
        text-align: center;
        font-weight: bold !important;
        border-left: 1px solid black;
        border-right: 1px solid black;
    }
    .profit, .profit_bold, .spend, tfoot tr td {
        text-align: center;
        vertical-align: middle;
    }
    .profit_bold_light {
        background-color: #85f185
    }
    .profit {
        background-color: #c1f9c1
    }
    .profit_bold {
        background-color: #66c366
    }
    .spend {
        background-color: #ffded3
    }
</style>
<?php $__env->stopSection(); ?>



<?php
    /**
     * Save Balances For crons
     */
    if($save_balances && count($save_array)) {
        $save_request = new \Illuminate\Http\Request();
        $save_request->setMethod('POST');
        $save_request->request->add([
            'balance' => $save_array,
            'currency' => MAIN_CURRENCY,
            'curs' => $current_curs,
            'from_save_balances' => 1,
        ]);

        (new App\Http\Controllers\Balances\BalancesController)->index($save_request);
    }
?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>