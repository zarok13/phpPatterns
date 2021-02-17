<?php
    $sites  = [
        'combo.ge',
        'duo.ge',
        'swiss.ge',
        'york.ge',
        'cosmo.ge'
    ];

    $send_urls = [];
    $send_sites = [];
    
    // index.php?route=feed%2Fproduct&credutamazon_api=true&product_ids[]=1
    
    $urls = $request->url;
    $additionalurl = \App\Models\RequestUrl::where('request_id', $request->id)->select('id', 'request_id', 'url')->first();
    if($additionalurl){
        $urls = $additionalurl->url;
    }

    foreach($urls as $url){
        $parsed = parse_url($url);
        if(!isset($parsed['host']) || !isset($parsed['query'])){                
            continue;
        } else {
            $PRODUCT_ID = explode('product_id=', $parsed['query']);
            $PRODUCT_ID = isset($PRODUCT_ID[1]) ? $PRODUCT_ID[1] : null;
            if($PRODUCT_ID){
                $PRODUCT_ID = explode('&', $PRODUCT_ID)[0];
            } else {
                continue;
            }

            if(isset($PRODUCT_ID)){
                if(isset($send_sites[$parsed['host']])){
                    if(  !in_array((int)$PRODUCT_ID,  $send_sites[$parsed['host']])   ){
                        array_push($send_sites[$parsed['host']], (int)$PRODUCT_ID);
                    } else {continue;}
                } else {
                    $send_sites[$parsed['host']] = [];
                    array_push($send_sites[$parsed['host']], (int)$PRODUCT_ID);
                } 
            } 
        }
    }

    
    foreach($send_sites as $key => $product_ids){
        $send_url = ($key == 'combo.ge' ? 'https://' : 'http://')  .$key.  "/index.php?route=feed/product&creditamazon_api=true";
        
        foreach($product_ids as $pid){
            $send_url = $send_url. '&product_ids[]='. $pid . '&kk';
        }
        
        $send_urls[] = $send_url;
    }
?>


<div class="tab-pane p-10 " id="items" role="tabpanel">
    <div class="row">
        <div class="col-md-9">
            <?php if (\Entrust::can('tch_item_edit')) : ?>
            <div id="suggestionItemsDiv" style="display: none">
                <select id="suggestedItems" class="form-control"></select>
                <button class="btn btn-info" id="add_product_from_suggested">პროდუქტებში დამატება</button>
            </div>
            <?php endif; // Entrust::can ?>

            
            <input type="text" class="form-control "  style="margin: 5px 0px;margin-left: -10px; max-width: 50%;" placeholder="ჩაწერეთ ლინკი" id="link_input" />
            <button class="btn btn-success" id="add_link_button">დამატება</button>
            <button class="btn btn-danger" id="save_items_button">შენახვა</button>
            
        </div>
        <div class="col-md-3">
            <textarea cols="30" rows="4" class="form-control" placeholder="შენიშვნა..."><?php echo isset($text) ? $text : ''; ?></textarea>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12 noMargin" style="padding: 0;">
            <?php ($items = $data['items']); ?>
            <?php if(sizeof($items) > 0): ?> <span style="margin-bottom: 10px; display: block">  ლინკები შენახულია </span> <?php endif; ?>
            <table class="table table-hovered" id="all_items">
                
            </table>
        </div>
    </div>
</div>


<script>
    window.items_saved = false;
    window.items_added_saved = false;
    var URLS = <?php echo json_encode($send_urls); ?>;
    var ITEMS = <?php echo json_encode($items); ?>;
    var SUGGESTEDITEMS = [];
    var itemsdownloadsuccess = false;
    var ITEM_STATUSES =     ['', 'საყიდელია','შეკვეთილია', 'გასაცემია', 'გაცემულია', 'გასაუქმებელია', 'გაუქმებულია'];
    var IMPORTED_SETS = [];
    
    <?php if(sizeof($items) > 0): ?>
    var already_imported = true;
    <?php else: ?> 
    var already_imported = false;
    <?php endif; ?>

    $(document).ready(function(){
        updateListeners();

        if(ITEMS.length === 0){
            getLinksFromRequestUrl(URLS);
        } else {
            // already_imported = true;
            updateAllItems(ITEMS);
        }     

        $('#refresh_items').on('click', function(){
            updateListeners();

            if(ITEMS.length === 0){
                getLinksFromRequestUrl(URLS);
            } else {
                // already_imported = true;
                updateAllItems(ITEMS);
            }     
        });
    });
    
    

    getSuggestedItems = function(url){
        
        getFromUrl(url, function (response) {
            var products = response.products;
            if(Array.isArray(response.products)){
                SUGGESTEDITEMS = [];
                $('#suggestionItemsDiv').css('display', 'block');
                for(var i = 0, length = response.products.length; i < length; i++){
                    var should_add = true;
                    
                    SUGGESTEDITEMS.map(function(val){
                        if(val.item_id == response.products[i].item_id){
                            should_add = false;
                        }
                    });
                    SUGGESTEDITEMS.push(response.products[i]);
                }
                
                updateSuggestedItems(SUGGESTEDITEMS);
                
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

    $('#add_link_button').on('click', function(){

        var link = $('#link_input').val();
        var url = '';
        var hostname = getHostName(link);
        if(link.length < 5 ){
            return alert('შეიყვანეთ მინიმუმ 5 სიმბოლო');
        }
        var product_id = getParameterByName('product_id', link);        
        if(parseInt(product_id) > 0){
            url = (hostname == 'combo.ge' ? 'https://' : 'http://') + hostname + '/index.php?route=feed/product&creditamazon_api=true&product_ids[0]=' + product_id + '&kk' + makeid(3);
        } else if(getCitrusApiUrl(link)) {
            url = getCitrusApiUrl(link);
        } else {
            url = '/techplus/items/getitemsforrequest/?Asd=w&needle='+link;
            return getSuggestedItems(url);
        }
        
        getLinksFromRequestUrl([url]);
    });




    $('#save_items_button').on('click', function(){
        var senditems = [];
        
        for(var i=0; i<ITEMS.length; i++){
            senditems.push({
                ...ITEMS[i],
                name: 'ss'
            });
        }
        console.log(senditems);
        
        
        $.ajax({
            type: "POST",
            url: '/techplus/items/saveforrequest/',
            data: {
                asfs: 0,
                request_id: REQUEST_ID,
                items: senditems, 
            },
            success: function(response){
                window.items_added_saved = true;

                for(var i=0; i<ITEMS.length; i++){
                    if(ITEMS[i].override_sell_price){
                        delete ITEMS[i].override_sell_price;
                    }
                }
                console.log(response);
                // window.items_saved = true;
            }
        });
    });



    updateAllItems = function(items){
        var html = '';
        console.log(items);
        ITEMS.map(function(val, idx){
            var checked = parseInt(val.isgift) == 1 ? 'checked=""' : '';
            var set = parseInt(val.isset) == 1 ? 'green' : 'red';
            var gift = val.isgift == 1 ? 'green' : 'red';
            var status_id = val.status;
            var requestitemstyle = '';
            
            var already_added = '';    
            
            if(val.id){
                requestitemstyle='background-color: #97c2a7;'
            }

            if(typeof val.rs_status == "undefined") {
                already_added = `<span class="editsellpricetosave"> 
                    <input type="checkbox" data-id="${idx}" class="sell_price_edit_checkbox" /> <span id="sell_price_edit_${idx}" > ფასის ჩასწორება </span>
                    <input class="sell_price_edit_input" style="max-width: 60px; display: none" data-id="${idx}" id="sell_price_edit_input_${idx}" type="number" value="${val.sell_price}"> <span>`;
            }

            console.log(val.rs_status);
            console.log(val)
            html += 
            `<tr id="itemli-${val.id}" style="${requestitemstyle}" > 
                <td>
                    ${val.name}
                </td>
                <td>
                    ${already_added}
                </td>
                <td> 
                    <a href="#" class="badge badge-info ml-auto check_as_gift" data-id="${idx}" style="cursor: pointer; background-color: ${gift}">საჩუქარი</a>
                    <a href="#" class="badge badge-info ml-auto delete_from_items" data-id="${idx}" style="cursor: pointer;" >წაშლა</a>
                    <a href="#" class="badge badge-info ml-auto check_as_set" data-id="${idx}" style="cursor: pointer; background-color: ${set}">სეტი</a>
                </td> 
                <td>
                    
                    <input type="number" step="any" data-id="${idx}" class="change_item_quantity" value="${val.quantity}"/>
                    <select class="change_item_status" data-id="${idx}">
                        <option value="0" ${val.status == 0 ? 'selected' : ''}></option>
                        <option value="1" ${val.status == 1 ? 'selected' : ''}>საყიდელია.</option>
                        <option value="2" ${val.status == 2 ? 'selected' : ''}>შეკვეთილია.</option>
                        <option value="3" ${val.status == 3 ? 'selected' : ''}>გასაცემია.</option>
                        <option value="4" ${val.status == 4 ? 'selected' : ''}>გაცემულია.</option>
                        <option value="4" ${val.status == 5 ? 'selected' : ''}>გასაუქმებელია.</option>
                        <option value="4" ${val.status == 6 ? 'selected' : ''}>გაუქმებულია.</option>
                    </select>
                </td>
            </tr>`;
            return;
        });

        $('#all_items').html(html);
        updateListeners();
        clickIfSet();
    }


    clickIfSet = function(){
        if(already_imported) {
            console.log('imported');
        } else {
            console.log('not Imported');
        }
        // // console.log('here')
        // ITEMS.map(function(item){
        //     console.log(item);
        // });
    }

    updateSuggestedItems = function(items){
        var html = '';
        items.map(function(val, idx){
            html += 
            `<option value="${idx}">${val.name} ${val.created_at} </option>`;
            return;
        });
        $('#suggestedItems').html(html);
    }

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
    
    getSetItems = function(idx){
        $.ajax({
            type: "GET",
            url: '/techplus/items/getset',
            data: {
                s:0,
                request_id: REQUEST_ID,
                item: ITEMS[idx]
            },
            headers: null,
            success: function(response){
                if(ITEMS[idx].isset > 0){
                    if(response.items.length > 0){
                        for(var i = 0, length = response.items.length; i < length; i++){
                            ITEMS.splice( 1, 0, { 
                                ...response.items[i],
                                item_id: response.items[i].item_id,
                                request_id: REQUEST_ID,
                                sell_price: parseFloat(response.items[i].sell_price),
                                quantity: 1,
                                site: response.items[i].site,
                                isgift: 0,
                                isset: 0,
                                status: 1
                            });
                        }
                        updateAllItems(ITEMS);
                    }    
                } else {
                    if(response.items.length > 0){
                        for(var i = 0, length = response.items.length; i < length; i++){
                            var splice_index = null;
                            ITEMS.map(function(val, idx){
                                if(response.items[i].item_id == val.item_id){
                                    splice_index = idx;
                                }
                            });
                            splice_index != null ? ITEMS.splice(splice_index, 1) : null;
                        }
                    }
                }
                updateAllItems(ITEMS);
            }
        
        });
    }


    $('#add_product_from_suggested').on('click', function(){
        var id = $('#suggestedItems').val();
        var should_add = true;
        var item = SUGGESTEDITEMS[id];
        should_add = true;

        ITEMS.map(function(val){
            if(item.item_id == val.item_id){
                should_add = false;
            }
        });
        
        should_add ? ITEMS.push({
            ...item,
            quantity: 1,
            status: 1,
            request_id: REQUEST_ID
        }) : null;

        updateAllItems(ITEMS);
    });



    updateListeners = function(){
        $('.delete_from_items').off('click');
        $('.check_as_gift').off('click');
        $('.check_as_set').off('click');
        $('.change_item_status').off('click');
        $('.change_item_price').off('click');
        $('.sell_price_edit_checkbox').off('click');

        $('.sell_price_edit_checkbox').on('change', function(){
            var idx = $(this).data('id');
            var checked = $(this).prop('checked');

            if(checked){
                $('#sell_price_edit_' + idx).css('display', 'none');
                $('#sell_price_edit_input_' + idx).css('display', 'block');
            } else {
                $('#sell_price_edit_' + idx).css('display', 'block');
                $('#sell_price_edit_input_' + idx).css('display', 'none');
                if( typeof ITEMS[idx].override_sell_price != undefined) {
                    delete ITEMS[idx].override_sell_price;
                }
            }

            $('.sell_price_edit_input').on('change', function(){
                var idx = $(this).data('id');
                ITEMS[idx].override_sell_price = $(this).val();
            });
            
        });


        $('.delete_from_items').on('click', function(){
            var id = $(this).data('id');
            ITEMS.splice(id, 1);
            updateAllItems(ITEMS);
            return;
        });
        
        $('.change_item_status').on('change', function(){
            var id = $(this).data('id');
            ITEMS[id].status = ITEMS[id].status = parseInt($(this).val());
            updateAllItems(ITEMS);
            return;
        });

        $('.change_item_price').on('change', function(){
            var id = $(this).data('id');
            ITEMS[id].price = ITEMS[id].price = parseFloat($(this).val());
            ITEMS[id].sell_price = ITEMS[id].sell_price = parseFloat($(this).val());
            updateAllItems(ITEMS);
            return;
        });
        
        $('.change_item_quantity').on('change', function(){
            var id = $(this).data('id');
            ITEMS[id].quantity = parseInt($(this).val());
            updateAllItems(ITEMS);
        });

        $('.check_as_set').on('click', function(){
            var idx = $(this).data('id');
            ITEMS[idx].isset = ITEMS[idx].isset == 0 ? 1 : 0;
            if(IMPORTED_SETS.indexOf(idx) < 0) {
                IMPORTED_SETS = [...IMPORTED_SETS, idx];
            } else {
                IMPORTED_SETS.splice(IMPORTED_SETS.indexOf(idx), 1);
            }
            console.log(ITEMS);
            getSetItems(idx);
            return;
        });

        $('.check_as_gift').on('click', function(){
            var id = $(this).data('id');
            ITEMS[id].isgift = ITEMS[id].isgift == 0 ? 1 : 0;
            updateAllItems(ITEMS);
            return;
        });
    }


    getLinksFromRequestUrl = function(urls, callback = null){
        for(var i = 0, length = urls.length; i < length; i++){
            var hostname = getHostName(urls[i]);
            console.log(urls[i]);
            getFromUrl(urls[i]+'&'+makeid(4), function (response) {
                var response = JSON.parse(response);
                if(Array.isArray(response.products)){
                    for(var i = 0, length = response.products.length; i < length; i++){
                        var responseProduct = response.products[i];
                        $.ajax({
                            url: '/techplus/item/getbyidandsitename',
                            type: 'GET',
                            data: {s:1, site: hostname, item_id: responseProduct.id},
                            success: function(data){
                                var should_add = true;
                                console.log(data);
                                /** es callback mchirdeba suggestedshi nivtis linkidan wamosagebad */
                                if(callback){
                                    if(data.item){
                                        
                                        var callbackdata = {
                                            "hostname" : hostname,
                                            "item_id" :  responseProduct.id
                                        };
                                        return callback(data.item, callbackdata);
                                    } else {
                                        return alert('ეს ნივთი ვერ მოიძებნა ჩვენს ბაზაში');
                                    }
                                    
                                }
                                   
                                ITEMS.map(function(val){
                                    if(val.id == responseProduct.id){
                                        should_add = false;
                                    }
                                });

                                if(data.success){
                                    console.log(data.item);
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
                        

                    }
                }
            });
        }
    } //end get products

</script>

<style>
    .items {
        margin:  3px 0px !important;
        padding: 3px;
    }
    
    .badge-info {
        background-color: red;
    }

    .change_item_price, .change_item_quantity{
        width: 50px;
    }
    .modal-content {
        min-height: 300px;
    }
</style>
