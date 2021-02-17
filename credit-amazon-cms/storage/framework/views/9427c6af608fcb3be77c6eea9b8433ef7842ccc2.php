<?php 
    $REQUEST = \App\Models\CreditAmazon\Request::where('id', $id)->first();
    $ADDITIONAL = \App\Models\RequestUrl::where('request_id', $id)->select('id', 'request_id', 'url')->first();
    $urls = [];
    
    if($ADDITIONAL == null){
        foreach($REQUEST->url as $url){
            $urls[] = $url;
        }
    }
    
    if($ADDITIONAL){
        foreach($ADDITIONAL->url as $k => $aurl){
            $urls[] = $aurl;
        } 
    }
    
?>

<div class="modal fade bs-example-modal-md"  data-backdrop="static" id="edit_url_modal" style="margin-top: 50px;" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">    
    <div class="modal-dialog modal-md" >
        <div class="modal-content" style="background: #b9b8b8">
            <div class="modal-header">
                <h6>ჩასწორება</h6>
                <button type="button" data-dismiss="modal" class="close" id="close_url_edit_modal">×</button>
            </div>

            <div class="modal-body">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12 noMargin" style="padding: 0;">
                        <div class="list-group" style="display: block">
                            <?php $__currentLoopData = $REQUEST->url; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item" style="padding: 3px;"> 
                                <a target="_blank" href="<?php echo $link; ?>"><?php echo e($link); ?></a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>


                <form id="urlform">
                    <div class="row">
                        <div class="col-md-12" id="url_inputs_div" style="margin: 0;">
                            <?php $__currentLoopData = $urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input class="editurlinput" name="urls[]" type="text" value="<?php echo $url; ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="col-md-12" style="margin: 0;">
                            <button id="add_url_button" style="margin-top: 10px;" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>

                        <div class="col-md-12" style="margin: 0;">
                            <button id="save_urls_button" style="margin-top: 10px;" class="btn btn-success">შენახვა</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>        
</div>

<script>
    $(document).ready(function(){
        $('#save_urls_button').on('click', function(e){
            e.preventDefault();
            var serialized = $("#urlform").serializeArray();
            
            console.log(serialized);
            $.ajax({
                url: '<?php echo e(route('operator.request.saveurlsfrommodal', ['id' => $id])); ?>',
                type: 'post',
                data: {w: 1, urls: serialized},
                success: function(data){
                    $('#edited-link-block').html(data.newlinks); 
                    console.log(data);
                }
            })
            return;
        });
        
        
        $('#add_url_button').on('click', function(e){
            e.preventDefault();
            html = `<input class="editurlinput" name="urls[]" type="text" placeholder="შეიყვანეთ ლინკი">`
            $('#url_inputs_div').append(html);
        });
        
        
        $('#close_url_edit_modal').click(function(){
            setTimeout(function(){
                $('#edit_url_modal').remove();
                $('body').addClass('modal-open');
            }, 600);
        });

    });

</script>

<style>
    .editurlinput {
        width: 100%;
        margin-top: 2px;
    }
</style>