<?php
    $users = \App\User::select('id', 'name')->get();
?>

<div id="calleds_edit_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="calleds_multiple_form">

                    <div class="form-group">
                        <label for="multipleTaxStatus">ოპერატორზე გადამისამართება</label>
                        <select name="to_user" class="form-control">
                            <option value=""></option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                </form>
            </div>

            
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" onclick="saveCalledsForm()" id="called_save_button">შენახვა</button>
            </div>
        </div>
    </div>
</div>

<style>
    option .showNone {
        display: none;
    }
</style>

<script>
    saveCalledsForm = function(){
        if(!CALLED_SELECTED_ROWS.length) return alert('არცერთი განაცხადი არ არის მონიშნული');

        var data = {};

        var serialized = $('#calleds_multiple_form').serializeArray();
        for(var i = 0; i< serialized.length; i++) {
            data[serialized[i].name] =serialized[i].value;
        }

        data.log_ids = CALLED_SELECTED_ROWS;
        $.ajax({
            url: '/operator/savemanagermultiple',
            type: 'post',
            data: data,
            success: function(data){
                console.log(data);
            }
        });

    }

</script>