<div class="tab-pane p-10 " role="tabpanel">
   
    <div id="suggestionItemsDivRequestForm" style="display: none">
        <select id="suggestedItemsrequestform" class="form-control" style="max-width: 70%"></select>
        <button class="btn btn-info" id="add_product_from_suggested_request_form">პროდუქტებში დამატება</button>
    </div>
    
    <input type="text" class="form-control col-md-4" style="margin: 5px 0px;margin-left: -10px;" placeholder="ჩაწერეთ ლინკი" id="link_input_request_form" >
    <button class="btn btn-success" id="add_link_button_request_form">დამატება</button>
    <button class="btn btn-danger" id="save_items_button_request_form">შენახვა</button>
    
    <?php ($items = isset($data['items'])? $data['items'] : []); ?>
    <?php if(sizeof($items) > 0): ?> ლინკები შენახულია <?php endif; ?>
    <div class="row">
        <div class="col-md-12 noMargin" style="padding: 0;">
            <table class="table table-hovered" id="all_items_request_form"></table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 noMargin" style="padding: 0;">
            <table class="table table-hovered" id="all_links_request_form"></table>
        </div>
    </div>
</div>


<script id="addrequestformscript">
    window.items_saved = false;
    
    var FORMURLS = [];
    var FORMITEMS = [];
    var SUGGESTEDFORMITEMS = [];
    var itemsdownloadsuccessform = false;
    var ITEM_STATUSES =     ['', 'საყიდელია','შეკვეთილია', 'გასაცემია', 'გაცემულია', 'გასაუქმებელია', 'გაუქმებულია'];
    var REQUEST_ID_FORM =null;
    var FORMLINKS = [];
    
    $(document).ready(function(){
        updateListenersForm();

        if(FORMITEMS.length === 0){
            getLinksFromRequestUrlForm(FORMURLS);
        } else {
            updateAllItemsForm(FORMITEMS);
        }     
                 
    });
    

    getSuggestedItemsForm = function(url){
        
        getFromUrlForm(url, function (response) {
            var products = response.products;
            if(Array.isArray(response.products)){
                SUGGESTEDFORMITEMS = [];
                $('#suggestionItemsDivRequestForm').css('display', 'block');
                for(var i = 0, length = response.products.length; i < length; i++){
                    var should_add = true;
                    
                    SUGGESTEDFORMITEMS.map(function(val){
                        if(val.item_id == response.products[i].item_id){
                            should_add = false;
                        }
                    });
                    SUGGESTEDFORMITEMS.push(response.products[i]);
                }
                
                updateSuggestedItems(SUGGESTEDFORMITEMS);
                
            }
        });

    }

    $('#add_link_button_request_form').on('click', function(){
        var link = $('#link_input_request_form').val();
        var url = '';
        var hostname = getHostName(link);
        if(link.length < 5 ){
            return alert('შეიყვანეთ მინიმუმ 5 სიმბოლო');
        }
        var product_id = getParameterByName('product_id', link);        
        if((isOnlyLink && !isSearch) || isOtherLink ){
            if(FORMLINKS.indexOf(link) == -1){
                FORMLINKS.push(link);
                updateLinksForm();
                return alert('ლინკი დაემატა');
            } else {
                if(confirm('ეს ლინკი უკვე დამატებულია, გსურთ ხელმეორედ დამატება?')){
                    FORMLINKS.push(link);
                    updateLinksForm();
                } else {
                    return;
                }
            }
        } else {
            url = '/techplus/items/getitemsforrequest/?Asd=w&needle='+link;
            return getSuggestedItemsForm(url);
        }
        
        getLinksFromRequestUrlForm([url]);
    });

    
    var isOnlyLink = false;
    var isSearch = false;
    var isOtherLink = false;

    $('#link_input_request_form').on('keyup', function(){
        var product_id = getParameterByName('product_id', $(this).val());        
        if(parseInt(product_id) > 0){
            isSearch = false;
            isOnlyLink = true;    
            isOtherLink = false;
            $('#add_link_button_request_form').html('ლინკებში დამატება');
        } else {
            var hostname = getHostName($(this).val());
            if(!hostname){
                isSearch = true;
                isOnlyLink = false;
                $('#add_link_button_request_form').html('ძებნა');
            } else {
                isOtherLink = true;
                $('#add_link_button_request_form').html('ლინკებში დამატება');
            }
        }
    });



    $('#save_items_button_request_form').on('click', function(){
        $.ajax({
            type: "POST",
            url: '/techplus/items/saveforrequest/',
            data: {
                asfs: 0,
                request_id: REQUEST_ID_FORM,
                items: FORMITEMS, 
            },
            success: function(response){
                console.log(response);
                // window.items_saved = true;
            }
        });
    });

    updateLinksForm = function(){
        html = '';
        for(var i=0; i< FORMLINKS.length; i++){
            link = FORMLINKS[i];
            html += `<tr><td>${link}</td><td><a href="#" class="delete_link" data-id="${i}">წაშლა</a></td></tr>`;
        }
        $('#all_links_request_form').html(html);


        $('.delete_link').off('click');
        $('.delete_link').on('click', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            console.log('here');
            if(typeof FORMLINKS[id] != undefined){
                FORMLINKS.splice(id, 1);
            }
            updateLinksForm();
        });

        $('#link_input_request_form').val('');
    }
    

    updateAllItemsForm = function(items){
        var html = '';
        console.log(items);
        FORMITEMS.map(function(val, idx){
            var checked = parseInt(val.isgift) == 1 ? 'checked=""' : '';
            var set = parseInt(val.isset) == 1 ? 'green' : 'red';
            var gift = val.isgift == 1 ? 'green' : 'red';
            var status_id = val.status;
            var requestitemstyle = '';
            if(val.id){
                requestitemstyle='background-color: #97c2a7;'
            }

            html += 
            `<tr id="itemli-${val.id}" style="${requestitemstyle}" > 
                <td>
                    ${val.name}
                </td>
                <td> 
                    <a href="#" class="badge badge-info ml-auto check_as_gift" data-id="${idx}" style="cursor: pointer; background-color: ${gift}">საჩუქარი</a>
                    <a href="#" class="badge badge-info ml-auto delete_from_items" data-id="${idx}" style="cursor: pointer;" >წაშლა</a>
                    <a href="#" class="badge badge-info ml-auto check_as_set" data-id="${idx}" style="cursor: pointer; background-color: ${set}">სეტი</a>
                </td> 
                <td>
                    <input type="number" step="any" data-id="${idx}" class="change_item_price" value="${parseFloat(val.sell_price)}"/>
                    <select class="change_item_status" data-id="${idx}">
                        <option value="0" ${val.status == 0 ? 'selected' : ''}></option>
                        <option value="1" ${val.status == 1 ? 'selected' : ''}>საყიდელია.</option>
                        <option value="2" ${val.status == 2 ? 'selected' : ''}>შეკვეთილია.</option>
                        <option value="3" ${val.status == 3 ? 'selected' : ''}>გასაცემია.</option>
                        <option value="4" ${val.status == 4 ? 'selected' : ''}>გაცემულია.</option>
                    </select>
                </td>
            </tr>`;
            return;
        });

        $('#all_items_request_form').html(html);
        updateListenersForm();
    }

    updateSuggestedItems = function(items){
        var html = '';
        items.map(function(val, idx){
            html += 
            `<option value="${idx}">${val.name} ${val.created_at} </option>`;
            return;
        });
        $('#suggestedItemsrequestform').html(html);
    }

    getFromUrlForm = function(url, callback){
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
    
    getSetItemsForm = function(idx){
        $.ajax({
            type: "GET",
            url: '/techplus/items/getset',
            data: {
                s:0,
                request_id: REQUEST_ID_FORM,
                item: FORMITEMS[idx]
            },
            headers: null,
            success: function(response){
                if(FORMITEMS[idx].isset > 0){
                    if(response.items.length > 0){
                        for(var i = 0, length = response.items.length; i < length; i++){
                            var customdata = response.items[i];
                            customdata.item_id = response.items[i].item_id;
                            customdata.request_id = REQUEST_ID_FORM;
                            customdata.sell_price = parseFloat(response.items[i].sell_price);
                            customdata.quantity = 1;
                            customdata.site = response.items[i].site;
                            customdata.isgift = 0;
                            customdata.isset = 0;
                            customdata.status = 1;
                            FORMITEMS.splice( 1, 0, customdata);
                            removeFromLink(response.items[i].site, response.items[i].item_id);
                        }
                        updateAllItemsForm(FORMITEMS);
                    }    
                } else {
                    if(response.items.length > 0){
                        for(var i = 0, length = response.items.length; i < length; i++){
                            var splice_index = null;
                            FORMITEMS.map(function(val, idx){
                                if(response.items[i].item_id == val.item_id){
                                    splice_index = idx;
                                }
                            });
                            
                            if(splice_index != null){
                                FORMITEMS.splice(splice_index, 1);
                                removeFromLink(response.items[i].site, response.items[i].item_id);
                            } 
                        }
                    }
                }
                
                updateAllItemsForm(FORMITEMS);
            }
        
        });
    }

    addToLinkForm = function(hostname, product_id){
        var allowedhostnames = ['combo.ge','duo.ge', 'swiss.ge', 'cosmo.ge', 'york.ge'];
        if(allowedhostnames.indexOf(hostname) != -1){
            var link = `${hostname == 'combo.ge' ? 'https://' : 'http://'}${hostname}/index.php?route=product/product&product_id=${product_id}`;
            if(FORMLINKS.indexOf(link) == -1){
                FORMLINKS.push(link);
            } else {
                alert('ეს ლინკი უკვე დამატებულია');
            }
        } else {
            if(confirm('ეს ლინკი არ არის ქართული საიტის ლინკი, ნამდვილად გსურთ დამატება?')){
                if(FORMLINKS.indexOf(link) == -1){
                    FORMLINKS.push(link);
                } else {
                    alert('ეს ლინკი უკვე დამატებულია');
                }
            }
        }

        updateLinksForm();
        console.log('links', FORMLINKS);
    }

    removeFromLink = function(hostname, product_id){
        var link = `${hostname == 'combo.ge' ? 'https://' : 'http://'}${hostname}/index.php?route=product/product&product_id=${product_id}`;
        var index = FORMLINKS.indexOf(link);
        if(index != -1){
            FORMLINKS.splice(index, 1);
            updateLinksForm();
        }
        console.log('removelinks', FORMLINKS);
    }

    $('#add_product_from_suggested_request_form').on('click', function(){
        var id = $('#suggestedItemsrequestform').val();
        var should_add = true;
        var item = SUGGESTEDFORMITEMS[id];
        var index = null;
        should_add = true;

        FORMITEMS.map(function(val, idx){
            if(item.item_id == val.item_id){
                should_add = false;
                index = idx;
            }
        });
        
        if(should_add){
            var cdata = item;
            cdata.quantity = 1;
            cdata.status = 1;
            cdata.request_id = REQUEST_ID_FORM;
            FORMITEMS.push(cdata);

            addToLinkForm(item.site, item.item_id);
        }
        
        updateAllItemsForm(FORMITEMS);
    });



    updateListenersForm = function(){
        $('.delete_from_items').off('click');
        $('.check_as_gift').off('click');
        $('.check_as_set').off('click');
        $('.change_item_status').off('click');
        $('.change_item_price').off('click');

        $('.delete_from_items').on('click', function(){
            var id = $(this).data('id');
            removeFromLink(FORMITEMS[id].site, FORMITEMS[id].item_id);
            FORMITEMS.splice(id, 1);

            updateAllItemsForm(FORMITEMS);
            return;
        });
        
        $('.change_item_status').on('change', function(){
            var id = $(this).data('id');
            FORMITEMS[id].status = FORMITEMS[id].status = parseInt($(this).val());
            updateAllItemsForm(FORMITEMS);
            return;
        });

        $('.change_item_price').on('change', function(){
            var id = $(this).data('id');
            FORMITEMS[id].price = FORMITEMS[id].price = parseFloat($(this).val());
            FORMITEMS[id].sell_price = FORMITEMS[id].sell_price = parseFloat($(this).val());
            updateAllItemsForm(FORMITEMS);
            return;
        });

        $('.check_as_set').on('click', function(){
            var idx = $(this).data('id');
            FORMITEMS[idx].isset = FORMITEMS[idx].isset == 0 ? 1 : 0;
            getSetItemsForm(idx);
            return;
        });

        $('.check_as_gift').on('click', function(){
            var id = $(this).data('id');
            FORMITEMS[id].isgift = FORMITEMS[id].isgift == 0 ? 1 : 0;
            updateAllItemsForm(FORMITEMS);
            return;
        });
    }


    getLinksFromRequestUrlForm = function(urls){
        for(var i = 0, length = urls.length; i < length; i++){
            var hostname = getHostName(urls[i]);
            getFromUrlForm(urls[i], function (response) {
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
                                
                                FORMITEMS.map(function(val){
                                    if(val.id == responseProduct.id){
                                        should_add = false;
                                    }
                                });

                                if(data.success){
                                    console.log(data.item);
                                    var ccdata = data.item;
                                    ccdata.item_id = data.item.item_id;
                                    ccdata.request_id = REQUEST_ID_FORM;
                                    ccdata.sell_price = parseFloat(data.item.sell_price);
                                    ccdata.quantity = 1;
                                    ccdata.isgift = 0;
                                    ccdata.isset = 0;
                                    ccdata.status = 1;
                                    should_add ? FORMITEMS.push(ccdata) : null;

                                    addToLinkForm(hostname, data.item.item_id);

                                } 

                                itemsdownloadsuccessform = true;
                                
                                updateAllItemsForm(FORMITEMS);
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
</style>
