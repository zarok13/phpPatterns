<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">


                <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'TECHPLUS', 'TECHPLUS_MANAGER', 'TECHPLUS_OPERATOR', 'ACCOUNTANT'])) : ?>					
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo e(route('techplus.requests')); ?>"><i class="fa fa-phone"></i><span class="hide-menu">განცხადებები</a>
                </li>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo e(route('techplus.index')); ?>"><span class="hide-menu">მთავარი</a>
                </li>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo e(route('techplus.buypage')); ?>"><span class="hide-menu">საყიდელია</a>
                </li>
                    <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'TECHPLUS', 'TECHPLUS_MANAGER', 'ACCOUNTANT'])) : ?>					
                        <li> 
                            <a class="waves-effect waves-dark" href="<?php echo e(route('techplus.suppliers.index')); ?>"><span class="hide-menu">მომწოდებლები</a>
                        </li>
                    <?php endif; // Entrust::hasRole ?>
                <?php endif; // Entrust::hasRole ?>					
             


                <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER', 'TECHPLUS_MANAGER'])) : ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-bar-chart-o"></i>რეპორტები </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER'])) : ?>
                        <li><a href="<?php echo e(route('techplus.reports.unipay')); ?>">Unipay</a></li>
                        <li><a href="<?php echo e(route('reports.other')); ?>">ზოგადი</a></li>
                        <li><a href="<?php echo e(route('techplus.reports.operators')); ?>">ოპერატორების მიხედვით</a></li>
                        <?php endif; // Entrust::hasRole ?>
                        <li><a href="<?php echo e(route('techplus.reports.byitems')); ?>">ნივთების მიხედვით</a></li>
                        <li><a href="<?php echo e(route('reports.byday')); ?>">განაცხადების მიხედვით</a></li>
                        <li><a href="<?php echo e(route('techplus.suppliers.page')); ?>">ყველა ნივთი</a></li>
                    </ul>
                </li>
                <?php endif; // Entrust::hasRole ?>

                <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'ACCOUNTANT', 'TECHPLUS_MANAGER'])) : ?>
                    <li><a class="waves-effect waves-dark" href="<?php echo e(route('stock.index')); ?>"><span class="hide-menu">მარაგები</a></li>
                <?php endif; // Entrust::hasRole ?>

            <?php if(Auth::check()): ?>

            <?php if (\Entrust::hasRole(['SUPER_ADMIN','ACCOUNTANT', 'MANAGER','TECHPLUS_OPERATOR', 'TECHPLUS_MANAGER'])) : ?>
            <li style="position: absolute; right:160px;"> <a class="waves-effect waves-dark" href="<?php echo e(url('/operator')); ?>"><i class="fa fa-recycle"></i><span class="hide-menu">კრედიტამაზონი </a></li>
            <?php endif; // Entrust::hasRole ?>
            <li style="position: absolute; right:10px; width: 150px;"> <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">გამოსვლა: <?php echo e(Auth::user()->name); ?></a></li>
            <?php else: ?>
                <?php (redirect('/')); ?>
            <?php endif; ?> 
            </ul>

            </ul>
        </nav>
    </div>
</aside>
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>