<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <title><?php echo $__env->yieldContent('title', 'CreditAmazon'); ?></title>

    <link href="/dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('custom/styles/main.css')); ?>"/>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
</head>

<body class="horizontal-nav skin-default-dark fixed-layout">
    
    <div class="preloader" id="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">CreditAmazon</p>
        </div>
    </div> 

    <div id="main-wrapper">
        <?php echo $__env->make('partials.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <?php echo $__env->make('partials.flash_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>                
                
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
    
</body>

<script type="text/javascript" src="/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo e(url('custom/scripts/custom.js')); ?>"></script>
<script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    setInterval(function(){
        preloader = false;
        $.ajax({
            url: '/assignreqeust',
        });
        preloader = true
    }, 10000)
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
<?php echo $__env->yieldPushContent('styles'); ?>

</html>