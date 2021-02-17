<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">


                <li> <a class="waves-effect waves-dark" href="<?php echo e(route('search.index')); ?>"><i class="fa fa-search"></i><span class="hide-menu">ძებნა </a>
                </li>

            
				<?php if (\Entrust::hasRole(['SUPER_ADMIN', 'OPERATOR', 'SIGNATURE_OPERATOR', 'MANAGER'])) : ?>					
                <li> <a class="waves-effect waves-dark" href="<?php echo e(route('operator.calls')); ?>"><i class="fa fa-phone"></i><span class="hide-menu">დასარეკები </a>
                </li>
                <?php endif; // Entrust::hasRole ?>		
                		
                
            
                

                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-bar-chart-o"></i><span class="hide-menu">რეპორტები <span class="badge badge-pill badge-cyan ml-auto">4</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                    <?php if (\Entrust::hasRole('MARKETING_MANAGER')) : ?>
                        <li><a href="<?php echo e(route('reports.byday')); ?>">განაცხადების მიხედვით</a></li>
                        <li><a href="/stocks/products">მარაგები</a></li>
                        <li><a href="/reports/solditems/old">გაყიდვების რეპორტი</a></li>
                    <?php endif; // Entrust::hasRole ?>

                    <?php if (\Entrust::hasRole(['SUPER_ADMIN','ACCOUNTANT', 'MANAGER', 'TECHPLUS_MANAGER', 'SIGNATURE_OPERATOR'])) : ?>
						<li><a href="<?php echo e(route('reports.index')); ?>">მთლიანი</a></li>
                        <li><a href="<?php echo e(route('reports.byday')); ?>">განაცხადების მიხედვით</a></li>

                        <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'TECHPLUS_MANAGER'])) : ?>
                        <li><a href="/reports/solditems/old">გაყიდვების რეპორტი</a></li>
    	                    <?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>					
                            
                            <li><a href="<?php echo e(route('reports.other')); ?>">სხვა</a></li>
                            <li><a href="<?php echo e(route('reports.general')); ?>">გენერალური რეპორტი</a></li>
                            <li><a href="<?php echo e(route('reports.upcount')); ?>">პროდუქტ მენეჯერი</a></li>
    						<li><a href="<?php echo e(route('report.item.index')); ?>">ნივთები</a></li>
    						<li><a href="<?php echo e(route('transactions.approveds')); ?>">ჩარიცხვები</a></li>
    						<?php endif; // Entrust::hasRole ?>
                        <?php endif; // Entrust::hasRole ?>
                    <?php endif; // Entrust::hasRole ?>
                    
                    <?php if (\Entrust::hasRole(['SUPER_ADMIN','ACCOUNTANT', 'SIGNATURE_OPERATOR', 'MANAGER'])) : ?>
                        <li><a href="<?php echo e(route('transactions.index')); ?>">ტრანზაქციები</a></li>                        
                    <?php endif; // Entrust::hasRole ?>
                    

                    <?php if (\Entrust::hasRole(['SIGNATURE_OPERATOR', 'MANAGER', 'SUPER_ADMIN', 'OPERATOR'])) : ?>
                        <?php if (\Entrust::hasRole([ 'SUPER_ADMIN', 'SIGNATURE_OPERATOR', 'MANAGER'])) : ?>
                            <li><a href="<?php echo e(route('banks.credoapprovals')); ?>">კრედოს დამკიცებები</a></li>
                        <?php endif; // Entrust::hasRole ?>
                        <li><a href="<?php echo e(route('reports.banks')); ?>">ბანკების მიხედვით</a></li>
						<li><a href="<?php echo e(route('reports.operators')); ?>">ოპერატრორების მიხედვით</a></li>
					<?php endif; // Entrust::hasRole ?>

                    <?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
                        <li><a href="<?php echo e(route('reports.bymonth')); ?>">მენეჯმენტის რეპორტი</a></li>
					<?php endif; // Entrust::hasRole ?>
                    </ul>
                </li>


            
            <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'SIGNATURE_OPERATOR', 'MANAGER','TECHPLUS_OPERATOR'])) : ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-gears"></i><span class="hide-menu">მართვა <span class="badge badge-pill badge-cyan ml-auto">4</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                    <?php if (\Entrust::hasRole(['SIGNATURE_OPERATOR', 'SUPER_ADMIN', 'MANAGER', 'TECHPLUS_OPERATOR'])) : ?>
                    <li><a href="<?php echo e(route('admin.cur.index')); ?>">          ვალუტის კურსი     </a></li>
                    <?php endif; // Entrust::hasRole ?>
                    <?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
                        <li><a href="<?php echo e(route('admin.bank.index')); ?>">         ბანკები             </a></li>
                        <li><a href="<?php echo e(route('admin.bankinput.index')); ?>">    ბანკის ცვლადები     </a></li>
                        <li><a href="<?php echo e(route('admin.bankcomission.index')); ?>">ბანკის საკომისიოები </a></li>
                        <li><a href="<?php echo e(route('admin.sitefield.index')); ?>">    საიტის ცვლადები    </a></li>
                        <li><a href="<?php echo e(route('admin.site.index')); ?>">         საიტები             </a></li>
                        <li><a href="<?php echo e(route('admin.innerstatus.index')); ?>">  სტატუსები           </a></li>
                        <li><a href="<?php echo e(route('admin.ip.index')); ?>">           IP მისამართები      </a></li>
                        <li><a href="<?php echo e(route('admin.user.index')); ?>">         მომხმარებლები       </a></li>
                        <li><a href="<?php echo e(route('admin.permission.index')); ?>">   უფლებები            </a></li>
                        <li><a href="<?php echo e(route('admin.role.index')); ?>">         მომხმარებლის ტიპები </a></li>
                    <?php endif; // Entrust::hasRole ?>
                    </ul>
                </li>
            <?php endif; // Entrust::hasRole ?>


            <?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">ბალანსი<span class="badge badge-pill badge-cyan ml-auto">4</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo e(route('balances.index')); ?>">ბალანსი</a></li>						
                        <li><a href="<?php echo e(route('balances.expenses')); ?>">ხარჯები</a></li>                      
                    </ul>
                </li>
            <?php endif; // Entrust::hasRole ?>

            <?php if (\Entrust::hasRole(['OPERATOR', 'SIGNATURE_OPERATOR', 'TECHPLUS_OPERATOR', 'MANAGER'])) : ?>
            <li> <a class="waves-effect waves-dark" href="/stocks/products"><i class="fa fa-money"></i><span class="hide-menu">მარაგები </a> </li>
            <?php endif; // Entrust::hasRole ?>
			
            <?php if(Auth::check()): ?>
            <?php if (\Entrust::hasRole(['SUPER_ADMIN','ACCOUNTANT', 'MANAGER','TECHPLUS_OPERATOR', 'TECHPLUS_MANAGER'])) : ?>
                <li style=" position: absolute; right:160px;"> <a class="waves-effect waves-dark" href="<?php echo e(route('techplus.index')); ?>"><i class="fa fa-recycle"></i><span class="hide-menu">ტექპლიუსი </a></li>
            <?php endif; // Entrust::hasRole ?>
            <li style=" position: absolute; right:10px; width: 150px;"> <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">გამოსვლა: <?php echo e(Auth::user()->name); ?></a>
                </li>
            <?php else: ?>
                <?php (redirect('/')); ?>
            <?php endif; ?>
            </ul>

        </nav>
    </div>
</aside>
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>