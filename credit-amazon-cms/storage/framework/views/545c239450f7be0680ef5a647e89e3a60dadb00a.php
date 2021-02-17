<div class="tab-pane p-20" id="calculator" role="tabpanel"></div>

<script>
    /**
        კალკულატორის ტაბის დაჭერისას ვარდება კალკულატორის ფორმა იქ რომელი დივიც გადაეცემა პარამეტრად
    */
    function get_calculator($div_id){
        // if ( $($div_id).html().length == 0 ) {
            $.ajax({  
                type: "GET",
                url: "<?php echo e(route('operator.calculator.load')); ?>",
                data: {token:'not',request_id: $('#request_id_input').val()},
                success: function (response) {
                    $($div_id).html(response.html);
                }
            });
        // }
    }
</script>