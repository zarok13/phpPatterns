<div class="modal fade bs-example-modal-lg"  data-backdrop="static" id="add_single_item_modal" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">    
    <div class="modal-dialog modal-lg"  style="max-width: 80%; min-width: 80% !important">
        <div class="modal-content" style="background: #b9b8b8">
            <div class="modal-header">
                <h6>ნივთის დამატება</h6>
                <button type="button" class="close" id="close_request_x_single">×</button>
            </div>

            <div class="modal-body" id="create_request_body" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_input_single" placeholder="ჩაწერეთ ლინკი" style="max-width: 70%">
                            <button class="btn btn-success" id="add_single_item_button">გახსნა</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <table id="single_item_table">
                            
                        </table>
                        
                        <button class="btn btn-success" id="save_single_item_button" style="display: none">შენახვა</button>

                    </div>
                </div>
            </div>

        </div>
    </div>        
</div>


<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="add_set_item_modal" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">    
    <div class="modal-dialog modal-lg"  style="max-width: 80%; min-width: 80% !important">
        <div class="modal-content" style="background: #838383">
            <div class="modal-header">
                <h6>სეტის დამატება</h6>
                <button type="button" class="close" id="close_request_x_set">×</button>
            </div>

            <div class="modal-body" id="create_request_body" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="link_input_set" placeholder="ჩაწერეთ სეტის ლინკი" style="max-width: 70%">
                            <button class="btn btn-success" id="add_set_item_link">გახსნა</button>
                        </div>
                        <div class="form-group adSetItemsDiv" style="display:none">
                            <input type="text" class="form-control" id="link_input_setitems" placeholder="ჩაწერეთ ლინკი ან სახელი" style="max-width: 70%">
                            <button class="btn btn-success" id="add_item_to_set_suggested_items_button">ძებნა</button>
                        </div>
                        <div class="form-group adSetItemsDiv" >
                            <select id="setsuggestedItems" class="form-control" style="max-width: 70%"></select>
                            <button class="btn btn-success" id="add_product_from_suggested_to_set">დამატება</button>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <table id="set_single_item_table" class="table table-dark">
                            
                        </table>
                        
                        <button class="btn btn-success" id="save_set_item_button" style="display: none">შენახვა</button>

                    </div>
                </div>
                <button class="btn btn-danger" id="add_item_from_set_modal" style="margin-top: 10px;">ნივთის დამატება</button>

                <div class="row">
                    <table class="table table-dark" style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th>სახელი</th>
                                <th>საიტი</th>
                                <th>ID</th>
                                <th>ასაღები ფასი</th>
                            </tr>
                        </thead>

                        <tbody id="setsetitemstable">
                            
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>        
</div>


<script>
        <?php ($suppliers = \App\Models\Supplier::orderBy('name')->select('id', 'name')->get()->pluck('name', 'id')); ?>;

        var SEARCHEDITEMS = [];
        var SAVEITEM = [];
        var SETITEM = [];
        var SETITEMITEMS = [];
        var SETSUGGESTEDITEMS = [];
        var SUPPLIERS = <?php echo $suppliers; ?>;
        var SUPPLIER_SELECT = `
            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        `;
        $(document).ready(function(){

            updateListenersSingleItem();

            $('#add_single_item').on('click', function(){
                $('#add_single_item_modal').modal('toggle');
            });
            
            $('#add_item_from_set_modal').on('click', function(){
                $('#add_single_item_modal').modal('toggle');
                $('#add_single_item_modal').css('z-index', '9999');
            });
            
            $('#save_single_item_button').on('click', function(){
                $.ajax({
                    type: "GET",
                    url: '/techplus/items/saveitem/',
                    data: {
                        item: SAVEITEM, 
                    },
                    success: function(response){
                        console.log(response);
                    }
                });
            });
            $('#save_set_item_button').on('click', function(){
                $.ajax({
                    type: "GET",
                    url: '/techplus/items/saveitem/',
                    data: {
                        setitem: SETITEM, 
                        set: 1,
                        setitems: SETITEMITEMS
                    },
                    success: function(response){
                        console.log(response);
                    }
                });
            });
            $('#add_set_item').on('click', function(){
                $('#add_set_item_modal').modal('toggle');
            });
            $('#close_request_x_single').on('click', function(){
                $('#add_single_item_modal').modal('toggle');
                $('#single_item_table').html('');
                $('#save_single_item_button').css('display', 'none');
            });
            $('#close_request_x_set').on('click', function(){
                $('#add_set_item_modal').modal('toggle');
                $('#set_single_item_table').html('');
                $('#save_set_item_button').css('display', 'none');

                $('div.adSetItemsDiv').css('display', 'none');
                // $('#add_item_to_set_suggested_items_button').css('display', 'none');
            });
            
            $('#add_single_item_button').on('click', function(){ 
                var link = $('#link_input_single').val();
                var url = '';
                var hostname = getHostName(link);
                var product_id = getParameterByName('product_id', link);        
                if(parseInt(product_id) > 0){
                    url = (hostname == 'combo.ge' ? 'https://' : 'http://') + hostname + '/index.php?route=feed/product&creditamazon_api=true&product_ids[0]=' + product_id + '&kksd'+makeid(4);                    
                } else if(getCitrusApiUrl(link)) {
                    url = getCitrusApiUrl(link);
                } else {
                    return alert('ლინკი არასწორია')
                }

                getFromUrl(url, function (response) {
                    console.log(response);
                    var response = JSON.parse(response);
                    if(Array.isArray(response.products)){
                        for(var i = 0, length = response.products.length; i < length; i++){

                            checkAddition( {
                                item_id: response.products[i].id,
                                hostname: hostname,
                                response: response.products[i]
                            }, 
                            
                            function(item, res){
                                
                                SAVEITEM = {
                                    ...item,
                                    item_id: item.item_id,
                                    get_price: item.get_price
                                };
                                updateSaveItemTable(SAVEITEM);
                                $('#single_item_table').css('background', '#acd4a2')
                            }, 
                            function(item, res) {
                                
                                SAVEITEM = {
                                    ...res,
                                    item_id: res.id,
                                    sell_price: parseFloat(res.price),
                                    get_price: 0,
                                    site: hostname,
                                    citrus_slug: res.slug,
                                    supplier_id: 1,
                                    weight: 0,
                                };
                                updateSaveItemTable(SAVEITEM);
                                $('#single_item_table').css('background', '#b8b6b7')
                            }
                            )

                        }
                    }
                });
            });
            
            checkAddition = function(itemdata, ifitem, ifnotitem){
                $.ajax({
                    url: '/techplus/item/getbyidandsitename',
                    type: 'GET',
                    data: {s:1, site: itemdata.hostname, item_id: itemdata.item_id},
                    success: function(data){
                        console.log('checkedition', data);
                        if(data.item){
                            return ifitem(data.item, itemdata.response ? itemdata.response : null);
                        } else {
                            return ifnotitem(data, itemdata.response ? itemdata.response : null);
                        }
                    }
                });
            }

            function makeid(length) {
                var text = "";
                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                for (var i = 0; i < length; i++)
                    text += possible.charAt(Math.floor(Math.random() * possible.length));

                return text;
            }
            
            $('#add_set_item_link').on('click', function(){ 
                var link = $('#link_input_set').val();
                var url = '';
                var hostname = getHostName(link);
                var product_id = getParameterByName('product_id', link);        
                if(parseInt(product_id) > 0){
                    url = (hostname == 'combo.ge' ? 'https://' : 'http://') + hostname + '/index.php?route=feed/product&creditamazon_api=true&product_ids[0]=' + product_id + '&kksdf='+makeid(3);
                } else if(getCitrusApiUrl(link)) {
                    url = getCitrusApiUrl(link);
                } else {
                   return alert('ლინკი არასწორია')
                }


                getFromUrl(url, function (response) {
                    var response = JSON.parse(response);
                    if(Array.isArray(response.products)){
                        for(var i = 0, length = response.products.length; i < length; i++){
                            
                            SETITEM = {
                                ...response.products[i],
                                item_id: response.products[i].id,
                                sell_price: parseFloat(response.products[i].price),
                                isset: 1,
                                get_price: 0,
                                site: hostname,
                                supplier_id: 1
                            };
                            updateSetSingleItemTable(SETITEM);
                            $('.adSetItemsDiv').css('display', 'block');
                        }
                    }
                });
            });
        });
        
        $('#add_product_from_suggested_to_set').on('click', function(){
            var id = $('#setsuggestedItems').val();
            var should_add = true;
            var item = SETSUGGESTEDITEMS[id];
            should_add = true;

            SETITEMITEMS.map(function(val){
                if(item.item_id == val.item_id){
                    should_add = false;
                }
            });
            
            should_add ? SETITEMITEMS.push({
                ...item,
                quantity: 1,
                status: 1,
                request_id: REQUEST_ID
            }) : null;

            updateSetItemItems(SETITEMITEMS);
        });

        updateSetItemItems = function(){
            var html = '';
            for(var i = 0; i< SETITEMITEMS.length; i++){
                html += `
                    <tr>
                        <td>${SETITEMITEMS[i].name}</td>
                        <td>${SETITEMITEMS[i].site}</td>
                        <td>${SETITEMITEMS[i].item_id}</td>
                        <td>${SETITEMITEMS[i].get_price}</td>
                        <td data-id="${i}" class="deletefromsetitems">წაშლა</td>
                    <tr>
                `;
            }

            $('#setsetitemstable').html(html);
            $('.deletefromsetitems').off('click');
            $('.deletefromsetitems').on('click',function(){
                var id = $(this).data('id');
                SETITEMITEMS.splice(id, 1);
                updateSetItemItems(SETITEMITEMS);
            });
        }

        updateSetSuggestedItemsSelect = function(items){
            var html = '';
            items.map(function(val, idx){
                html += 
                `<option value="${idx}">${val.name} ${val.created_at} </option>`;
                return;
            });
            $('#setsuggestedItems').html(html);
        }
        // reated_at: "2018-10-24 15:30:12"
        // get_price: 
        // id: 6
        // isset: 0
        // item_id: 3820
        // name: "გერმანული ჭურჭლის ნაკრები Maghsoud 12 პერსონაზე ANDORA195) + ჩაის სერვისი საჩუქრად!"
        // sell_price: 299
        // setids: null
        // site: "combo.ge"
        // supplier_id: 2
        // updated_at: "2018-10-24 15:30:12"
        
        $('#add_item_to_set_suggested_items_button').on('click', function(){
            console.log('clicked');
            var link = $('#link_input_setitems').val();
            var url = '';
            if(link.length < 3 ){
                return alert('შეიყვანეთ მინიმუმ 3 სიმბოლო');
            }
            
            var product_id = getParameterByName('product_id', link);        
            if(parseInt(product_id) > 0){
                var hostname = getHostName(link);  
                url = (hostname == 'combo.ge' ? 'https://' : 'http://') + hostname + '/index.php?route=feed/product&creditamazon_api=true&product_ids[0]=' + product_id + '&kk' + makeid(3);
            } else if(getCitrusApiUrl(link)) {
                url = getCitrusApiUrl(link);
            } else {
                url = '/techplus/items/getitemsforrequest/?Asd=w&needle='+link;
                
                return getFromUrl(url, function(data){
                    console.log(data);
                    SETSUGGESTEDITEMS = [];
                    SETSUGGESTEDITEMS = data.products;
                    
                    
                    updateSetSuggestedItemsSelect(SETSUGGESTEDITEMS);
                });
            }
            

            return SET_getLinksFromRequestUrl([url], function(item, data){
                console.log(item, data);
                SETSUGGESTEDITEMS = [];
                SETSUGGESTEDITEMS.push({
                    ...item
                });

                updateSetSuggestedItemsSelect(SETSUGGESTEDITEMS);
            });
        
        
        });
        


        updateSetSingleItemTable = function(item){
            var supplier = '<select class="form-control"  id="set_item_supplier_edit">';
            // Object.keys(SUPPLIERS).map(function(val){
            //     supplier+=`<option value="${val}" >${SUPPLIERS[val]}</option>`
            // });
            supplier += SUPPLIER_SELECT;
            supplier += '</select>';
            console.log(supplier);
            var html = `
                <tr><td>დასახელება</td><td>${SETITEM.name}</td></tr>
                <tr>
                    <td>გასაყიდი ფასი</td>
                    <td><input type="number" class="form-control" step="any" value="${SETITEM.sell_price}" id="change_set_sell_price"/></td>
                </tr>
                <tr>
                    <td>ასაღები ფასი</td>
                    <td><input type="number" class="form-control" step="any" value="${SETITEM.get_price}" id="change_set_get_price"/></td>
                </tr>
                <tr><td>საიტი</td><td>${SETITEM.site}</td></tr>
                <tr><td>მომწოდებელი</td><td>${supplier}</td></tr>
                <tr><td>ციტრუსთან დაკავშირების ID</td><td><input type="number" class="form-control" step="any" value="" id="citrus_set_id_input"/></td></tr>
            `;
            $('#set_single_item_table').html(html);
            $('#set_item_supplier_edit').off('click');
            $('#change_set_get_price').off('click');
            $('#change_set_sell_price').off('click');
            $('#citrus_set_id_input').off('change');

            $('#change_set_get_price').on('change', function(){
                SETITEM.get_price = parseInt($(this).val());
                console.log('setitem',SETITEM);
            });
            $('#citrus_set_id_input').on('change', function(){
                SETITEM.citrus_id = parseInt($(this).val());
                console.log('setitem',SETITEM);
            });
            $('#change_set_sell_price').on('change', function(){
                SETITEM.sell_price = parseInt($(this).val());
                console.log('setitem',SETITEM);
            });
            
            $('#set_item_supplier_edit').on('change', function(){
                SETITEM.supplier_id = parseInt($(this).val());
                console.log('setitem',SETITEM);
            });
            
            $('#save_set_item_button').css('display', 'inline-block');
        }

        
        updateSaveItemTable = function(item){
            var supplier = '<select class="form-control"  id="single_item_supplier_edit">';
            // Object.keys(SUPPLIERS).map(function(val){
            //     supplier+=`<option value="${val}" >${SUPPLIERS[val]}</option>`
            // });
            supplier += SUPPLIER_SELECT;
            supplier += '</select>';

            var html = `
                <tr><td>დასახელება</td><td>${SAVEITEM.name}</td></tr>
                <tr>
                    <td>გასაყიდი ფასი</td>
                    <td><input type="number" class="form-control" step="any" value="${SAVEITEM.sell_price}" id="change_single_sell_price"/></td>
                </tr>
                <tr>
                    <td>ასაღები ფასი</td>
                    <td><input type="number" class="form-control" step="any" value="${SAVEITEM.get_price}" id="change_single_get_price"/></td>
                </tr>
                <tr>
                    <td>წონა</td>
                    <td><input type="number" class="form-control" step="any" value="${SAVEITEM.weight ? SAVEITEM.weight : 0}" id="change_single_weight"/></td>
                </tr>
                <tr><td>საიტი</td><td>${SAVEITEM.site}</td></tr>
                <tr><td>მომწოდებელი</td><td>${supplier}</td></tr>
                <tr><td>ციტრუსთან დაკავშირების ID</td><td><input type="number" class="form-control" step="any" value="" id="citrus_single_id_input"/></td></tr>
            `;
            $('#single_item_table').html(html);
            $('#single_item_supplier_edit').off('click');
            $('#change_single_get_price').off('click');
            $('#change_single_sell_price').off('click');
            $('#citrus_single_id_input').off('change');

            $('#change_single_get_price').on('change', function(){
                SAVEITEM.get_price = parseInt($(this).val());
                console.log(SAVEITEM);
            });
            $('#citrus_single_id_input').on('change', function(){
                SAVEITEM.citrus_id = parseInt($(this).val());
                console.log(SAVEITEM);
            });
            $('#change_single_sell_price').on('change', function(){
                SAVEITEM.sell_price = parseInt($(this).val());
            });
            $('#change_single_weight').on('change', function(){
                SAVEITEM.weight = $(this).val();
            });
            
            $('#single_item_supplier_edit').on('change', function(){
                SAVEITEM.supplier_id = parseInt($(this).val());
            });
            
            $('#save_single_item_button').css('display', 'inline-block');
        }
    
        updateListenersSingleItem = function(){
    
            $('#search_item').on('click', function(){
                var needle = $('#needle_input').val();
                var url = '/techplus/items/getitemsforrequest/?as=s&needle='+needle;
                getFromUrl(url, function(data){
                    var items = data.products;
    
                    for(var i = 0, length = items.length; i < length; i++){
                        var should_add = true;
    
                        SEARCHEDITEMS.map(function(val){
                            if(items[i].item_id == val.item_id){
                                should_add = false;
                            }
                        });
                        
                        should_add ? SEARCHEDITEMS.push({
                            ...items[i]
                        }) : null;
                    }
                    
                    updateSearchedItems(SEARCHEDITEMS);
                })
                
            });
        }
    
    
        updateSearchedItems = function(items){
            var html = '';
            items.map(function(val, idx){
                html += `
                    <tr data-idx="${val.idx}">
                        <td>${val.name}</td>
                        <td>${val.item_id}</td>
                        <td>${val.get_price}</td>
                        <td>${val.isset == 1 ? 'კი' : 'არა'}</td>
                        <td>${val.sell_price}</td>
                        <td>${val.site}</td>
                    </tr>
                `;
                return;
            });
            $('#SearchedItemsTable').html(html);
        }


        /***** OVERRIDE METHODS MAY NOT WORK *****/
        getFromUrl = function(url, callback){
            window.preloader = false;
            
            $.ajax({
                type: "GET",
                url: url,
                headers: null,
                success: function(response){
                    callback(response);
                }
            });

            window.preloader = false;
        };

        
        SET_getLinksFromRequestUrl = function(urls, callback = null){
            for(var i = 0, length = urls.length; i < length; i++){
                var hostname = getHostName(urls[i]);
                var product_id = getParameterByName('product_ids[0]', urls[i]);
                
                $.ajax({
                    url: '/techplus/item/getbyidandsitename',
                    type: 'GET',
                    data: {s:1, site: hostname, item_id: product_id},
                    success: function(data){
                        var should_add = true;
                        console.log(data);
                        /** es callback mchirdeba suggestedshi nivtis linkidan wamosagebad */
                        if(callback){
                            if(data.item){
                                var callbackdata = {
                                    "hostname" : hostname,
                                    "item_id" :  product_id
                                };
                                return callback(data.item, callbackdata);
                            } else {
                                console.log(data);
                                return alert('ეს ნივთი ვერ მოიძებნა ჩვენს ბაზაში');
                            }
                            
                        }
                        
                        ITEMS.map(function(val){
                            if(val.id == product_id){
                                should_add = false;
                            }
                        });

                        if(data.success){
                            should_add ? ITEMS.push({
                                ...data.item,
                                item_id: data.item.item_id,
                                request_id: REQUEST_ID,
                                sell_price: parseFloat(data.item.sell_price),
                                quantity: 1,
                                // site: hostname,
                                isgift: 0,
                                isset: 0,
                                status: 1,
                            }) : null;
                        } 

                        itemsdownloadsuccess = true;
                        updateAllItems(ITEMS);
                    }
                });
            } // endfor
            return;
        } 

        /***** --END-- OVERRIDE METHODS MAY NOT WORK *****/

    </script>


<style>
    .adSetItemsDiv {
        display: none;
    }

    #add_single_item_modal {
        margin-top: 90px;
        margin-bottom: 100px;
    }

    #add_set_item_modal {
        margin-top: 90px;
        margin-bottom: 100px;
    }
</style>