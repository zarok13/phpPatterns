<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Elite Admin Template - The Ultimate Multipurpose admin template</title>
    <link href="<?php echo e(asset('/dist/css/pages/login-register-lock.css')); ?>" rel="stylesheet">
    <link href="/dist/css/style.min.css" rel="stylesheet">
</head>

<body class="horizontal-nav boxed skin-megna card-no-border">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">CreditAmazon.Ge</p>
        </div>
    </div>
    
    <section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <img src="/assets/images/logo.png" alt="" style="width: 100%;">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" type="text" required="" placeholder="ელ-ფოსტა" name="email"  value="<?php echo e(old('email')); ?>">  
                            </div>
                            <?php if($errors->has('email')): ?>
                                <span class="invalid-feedback">
                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" type="password" required="" placeholder="პაროლი" > 
                            </div>
                            <?php if($errors->has('password')): ?>
                                <span class="invalid-feedback">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="customCheck1">დამიმახსოვრე</label>
                            </div>
                        </div>
                        
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">შესვლა</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
  

    <script src="/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="/assets/node_modules/popper/popper.min.js"></script>
    <script src="/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    
</body>


</html>