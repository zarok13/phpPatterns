
<div class="modal fade" id="add_request_operator_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <form id="addrequestformsubmit" onsubmit="return addOperatorRequest(event)">
        <?php echo csrf_field(); ?>
        <div class="modal-dialog " >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ახალი განაცხადი</h4>
                    
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>


                <div class="modal-body">
                    <div class="row">            
                        <div class="col-md-12 noMargin">
                            <div class="form-group">
                                <label>სახელი/გვარი</label>
                                <input class="form-control" type="text" placeholder="სახელი/გვარი" required name="fullname">
                            </div>
                            <div class="form-group">
                                <label>ტელეფონის ნომერი</label>
                                <input class="form-control" type="text" placeholder="ტელეფონის ნომერი" required name="phone_number">
                            </div>
                            <div class="form-group" id="formated_links" style="display: none">
                                <input type="text" disabled>
                            </div>
                            <div class="form-group">
                                <label>ლინკები</label>
                                <textarea class="form-control"  name="links" id="input_links" onchange="formatlinks(this)" cols="150" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label>შენიშვნა</label>
                                <textarea class="form-control"  name="text" cols="150" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="type" value="cgd" checked/>
                                <label>ჩგდ</label>
                                <br>
                                <input type="radio" name="type" value="ganv"/>
                                <label>განვადება</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="sumbit" class="btn btn-danger waves-effect text-left">დამატება</button>
                </div>


            </div>
        </div>


    </form>
</div>


<script>
    getaddedlinks = function(){
        var links = $('#input_links').val();

        var array = links.split("\n");

        return array;
    }

    formatlinks = function(e){
        var links = getaddedlinks();
        var linkscontainer = $('#formated_links').empty();

        for(var i=0; i<links.length; i++){
            linkscontainer.show().append('<input class="form-control" style="margin-top: 10px" disabled type="text" value="' + links[i] + '"/><br/>')
        }
    }

    addOperatorRequest = function(e){
        e.preventDefault();
        var data = $('#addrequestformsubmit').serializeArray();
        var submitdata = {};
        for(var i=0; i< data.length; i++){
            submitdata[data[i].name] = data[i].value
        }
        submitdata.i = 'iii';
        submitdata.links_array = getaddedlinks();

        $.ajax({
            url: '<?php echo e(route('operator.addoperatorrequest')); ?>',
            type: 'POST',
            data: submitdata,
            success: function(data){
                console.log(data);
            }
        });
    }
</script>