<div class="modal-dialog modal-lg" id="opened_modal" style="max-width: 80%; min-width: 80% !important">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel"><?php echo e($item->name); ?></h4>
            <button type="button" class="close" id="close_request_x" data-dismiss="modal" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">            
                <div class="col-md-12 noMargin">
                        
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#maintab" role="tab" aria-selected="true"> <span class="hidden-xs-down">ინფორმაცია</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" id="edittab_tab" data-toggle="tab" href="#edittab" role="tab" aria-selected="true"> <span class="hidden-xs-down">ჩასწორება</span></a> </li>
                    </ul>
  
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane p-20 active " id="maintab" role="tabpanel"></div>
                        <div class="tab-pane p-20 " id="edittab" role="tabpanel"></div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal-footer"></div>

    </div>
</div>

<script>
    var selected_item_id = <?php echo e($item->id); ?>;
    var selected_item_item_id = <?php echo e($item->item_id); ?>;
    var itemmodalurl = '<?php echo e(route('techplus.suppliers.itemmodal')); ?>';
    var SETITEMS = [];

    $(document).ready(function(){
        getWithAjax(itemmodalurl, {partial: 'maintab'}, function(resp){
            $('#maintab').html(resp);
        });

        $('#edittab_tab').on('click', function(){
            editItemModal(selected_item_id);
        });


    });


   
</script>


