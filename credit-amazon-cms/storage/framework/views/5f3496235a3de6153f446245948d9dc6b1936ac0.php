<?php $techplus = $data['order'];  ?>
<script>
    var role = '<?php echo isset(Auth::user()->roles[0]->name) ? Auth::user()->roles[0]->name :''; ?>';
    var REQUEST_ID = <?php echo e($techplus->request_id); ?>;
    var TECHPLUS_ID = <?php echo e($techplus->id); ?>;
</script>

<style>
    .noMargin {
        margin-bottom: 0;
    }
</style>


<?php ($cgd = $techplus->cgd == 1 ? true : false ); ?>
<?php ($user_info = $techplus->request->user_info   ); ?>
<?php ($request = $techplus->request ); ?>
<?php ($calculated = $request->calculated); ?>
            


    
<input type="hidden" id="request_id_input" value="<?php echo e($techplus->request_id); ?>">
<input type="hidden" id="techplus_id_input" value="<?php echo e($techplus->id); ?>">

<div class="modal-dialog modal-lg" id="opened_modal" style="max-width: 80%; min-width: 80% !important">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel"><?php echo e($techplus->request->user_info->name .' '. $techplus->request->user_info->lastname); ?>, <?php echo e($techplus->number); ?></h4>

            <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER', 'TECHPLUS_OPERATOR'])) : ?>
                <?php echo $__env->make('partials.open_modal.edit-request-color', ['color' => $techplus->request->color ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; // Entrust::hasRole ?>

            <h6 style="left:0;margin: 10px 0 0 20px">
                <?php if($techplus->parent): ?>
                    ორიგინალი:
                    <a href="javascript:void(0)" onclick="showRequest(<?php echo e($techplus->parent); ?>)">
                        <?php echo e(!empty($techplus->parent) ? $techplus->parent : ''); ?>

                    </a>
                <?php endif; ?>
                <?php if(count($techplus->childrens)): ?>
                    დუპლიკატები:
                    <?php $__currentLoopData = $techplus->childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="javascript:void(0)" onclick="showRequest(<?php echo e($children->request_id); ?>)">
                            <?php echo e($children->request_id); ?>

                        </a>
                        <?php if(!$loop->last): ?>
                            ,
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </h6>
            <button type="button" class="close" id="close_request_x" data-dismiss="modal" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">            
                <div class="col-md-12 noMargin">
                        
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#request" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">ინფორმაცია</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#items" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">ნივთები</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#additional" id="additional_tab" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">დამატებითი ინფორმაცია</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#comments" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">კომენტარები</span></a> </li>
                        <?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER', 'TECHPLUS_MANAGER'])) : ?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#calculated" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">დეტალები</span></a> </li>
                        <?php endif; // Entrust::hasRole ?>
                        <li class="nav-item" onclick="loadCourierTab()"> <a class="nav-link" data-toggle="tab" href="#couriertab" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">საკურიერო</span></a> </li>
                    </ul>
  
                    <div class="tab-content tabcontent-border">

                        <?php echo $__env->make('techplus.requests.partials.items', ['text' => isset($techplus->request->text) ? $techplus->request->text : null], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                
                        <div class="tab-pane p-20 " id="additional" role="tabpanel">
                            
                        </div>

                        <?php echo $__env->make('techplus.requests.partials.details', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <div class="tab-pane" id="calculated" role="tabpanel">
                            <?php echo $__env->make('techplus.requests.partials.calculatedTabPartial', ['calculated' => $calculated], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        
                        <div class="tab-pane active show" id="request" role="tabpanel">
                            <div class="p-10 row">

                                <div class="col-md-6">
                                    <table class="table">
                                        <tbody>
                                            <tr><td>სახელი / გვარი</td><td><?php echo e($user_info->name. ' '.$user_info->lastname); ?></td></tr>
                                            <tr><td>ნომერი</td><td><?php echo e($techplus->number); ?></td></tr>
                                            <tr><td>მისამართი</td><td><?php echo e($techplus->address); ?></td></tr>
                                            <tr><td>სტატუსი</td><td><?php echo e($request->innerStatus[0]->name); ?></td></tr>
                                            <tr><td>მისამართი: </td><td><?php echo e($user_info->address); ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    
                                        <div class="col-md-12 noMargin">
                                            <textarea style="border: 2px solid grey;resize: vertical;" name="order_text" placeholder="შენიშვნა" id="order_text" class="form-control"><?php echo e($techplus->text); ?></textarea>
                                            <button id="save_order_text" class="btn btn-info" >შენიშვნის შენახვა</button>
                                        </div>
                                    
                                </div>

                            </div>
                            
                            <?php echo $__env->make('operator.request.partials.urls', ['urls' => $techplus->request->url, 'id' => $techplus->request->id], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        </div>
                        





                        <div class="tab-pane p-20" id="comments" role="tabpanel">
                            <div class="col-md-8">
                                <ul class="list-unstyled" id="user_comments">
                                    <?php $__currentLoopData = $techplus->request->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <div class="row" style="<?php echo e($comment->pullRight() ? 'direction: rtl; text-align: right;' : null); ?>">
                                            <li class="media p-20">
                                                <img class="d-flex m-2" src="/assets/images/users/1.jpg" width="60" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-1"><?php echo e($comment->user->name); ?></h5> 
                                                    <?php echo e($comment->text); ?><br>
                                                    <span style="font-size: 12px"><?php echo e($comment->created_at); ?></span>
                                                </div>
                                            </li>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="text"></label>
                                <textarea name="text" placeholder="შეიყვანეთ კომენტარი" id="text" class="form-control"  rows="3"></textarea>
                                <button type="button" onclick="save_comment()" class="btn waves-effect text-left" >დამატება</button>
                            </div>
                            <script>
                                function save_comment(){
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo e(route('operator.comment.store')); ?>",
                                        data: { text:$('#text').val(), request_id: <?php echo e($techplus->request_id); ?> },
                                        success: function (response) {
                                            $('#preloader').css('display', 'none');
                                            $('#user_comments').append(
                                                response.html
                                            );
                                        }
                                    });
                                }
                            </script>
                        </div>


                        <div class="tab-pane p-20" id="couriertab" role="tabpanel"> </div>
                    
                    </div>
                </div>
            </div>
        </div>



        <div class="modal-footer" style="display: block">
            
            <?php if($cgd): ?>
                <button type="button" class="btn btn-danger waves-effect text-left pull-left" id="delete_request_button" >გაუქმება</button>
            <?php endif; ?>
            <div class="col-md-6 pull-right">
                <label for="name">შიდა სტატუსი:</label>
                <span id="inner_status_name" style="font-size: 18px"><?php echo e(isset($request->innerStatus[0]) ? $request->innerStatus[0]->name : ' არ აქვს'); ?></span>
            </div>

        </div>

    </div>
</div>



<script>
    window.talk_time = 0;

    window.counter_timer = setInterval(function(){
        window.talk_time++;
    }, 1000);
    
    
    $(document).ready(function(){
        
        
        $('.close').on('click', function(){
            if( updateRequestsTable != undefined) {
                if(window.items_added && window.items_added_saved ) {
                    updateRequestsTable({url: window.techplustableurl, items_added: true});
                }
            }
        });
        

        $('#additional_tab').on('click', function(){
            $.ajax({
                url: '/techplus/getadditionalinfo',
                type: 'get',
                data: {
                    w: 1,
                    request_id: REQUEST_ID
                },
                success: function(response){
                    // console.log(response);
                    $('#additional').html(response);
                }
            });
        });


        $('#edit_request_status').on('click', function(){
            var innerStatus = $('#inner_status_select').val();
            
            $.ajax({
                url: '/techplus/request/editstatus',
                type: 'post',
                data: {
                    w: 1,
                    status_id: innerStatus,
                    request_id: REQUEST_ID
                },
                success: function(response){
                    console.log(response);
                }
            });

        });

        $('#delete_request_button').on('click', function(){

            if(confirm('დარწმუნებული ხართ რომ ნამდვილად გსურთ ამ განცხადების გაუქმება?')) { 
                $.ajax({
                    url: '/techplus/request/cancel',
                    type: 'post',
                    data: {
                        r: 1,
                        request_id: REQUEST_ID
                    },
                    success: function(response){
                        console.log(response);
                    }
                });
            }
        });

        $('#save_order_text').click(function(){
            
            var order_id = $('#request_id_input').val();
            var order_text = $('#order_text').val();
            $.ajax({
                type: "POST",
                url: "/operator/request/saveordertext",
                data: { request_id: order_id, order_text: order_text}
            });
        });

    });

    function loadCourierTab(){
        var order_id = $('#request_id_input').val();

        return $.ajax({
            type: "GET",
            url: "/techplus/getcouriertab",
            data: { i:1, request_id: order_id}
        }).done(function(res){
            $('#couriertab').html(res);
            console.log(res);
        });
    }

    function showRequest(request_id){
            $.ajax({
                type: "GET",
                url: "/techplus/showrequest/"+request_id+'/',
                success: function (response) {
                    $('#open_modal_button').css('display', 'inline-block ');
                    $('#View_Modal').html(response);
                    // $('#View_Modal').modal('toggle');
                }
            });
        }
    
</script>


