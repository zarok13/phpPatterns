<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">

    <title><?php echo $__env->yieldContent('title', 'Techplus'); ?></title>
    <link href="/dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="/assets/node_modules/popper/popper.min.js"></script>
    <script src="/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="/dist/js/waves.js"></script>
    <script src="/dist/js/sidebarmenu.js"></script>
    <script src="/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="/assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <script src="/dist/js/custom.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="/custom.js"></script>
    <script src="/notification.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
    <?php echo $__env->yieldContent('styles'); ?>

    <style>
        .table td, .table th {
            padding: 0.25rem !important;
        }
        .col-md-12 {
            margin-bottom: 100px;
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <?php echo $__env->make('partials.sharedstyleandscripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
</head>

<body class="horizontal-nav skin-default-dark fixed-layout">
    
    <div class="preloader" id="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Techplus</p>
        </div>
    </div> 
    <div id="main-wrapper">
        
         <?php echo $__env->make('partials.techplus_menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><?php echo $__env->yieldContent('breadcumb', ''); ?></h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <?php echo $__env->yieldContent('buttons'); ?>
                        </div>
                    </div>
                </div> 

                <?php echo $__env->yieldContent('content'); ?>
                
            </div>
        </div>

        
    </div>


</body>


</html>