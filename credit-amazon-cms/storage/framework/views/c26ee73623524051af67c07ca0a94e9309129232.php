<?php if($supplier): ?>
<div class="col-md-12 noMargin">
                    
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" id="items_tab" href="#items_tab_div" role="tab" aria-selected="true"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">ნივთები</span></a> </li>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#short_info_tab" role="tab" aria-selected="true"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">მოკლე ინფორმაცია</span></a> </li>
    </ul>


    <div class="tab-content tabcontent-border">
        <div class="tab-pane p-20" id="short_info_tab" role="tabpanel">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <table class="table">
                        <tr><td>სახელი:</td> <td> <div class="label label-table label-success"><?php echo e($supplier->name); ?></div></td></tr>
                        <tr><td>ტელეფონი:</td> <td> <div class="label label-table label-success"><?php echo e($supplier->number); ?></div></td></tr>
                        <tr><td>საკონტაქტო პირი:</td> <td> <div class="label label-table label-success"><?php echo e($supplier->person); ?></div></td></tr>
                        <tr><td>ანგარიშის ნომერი:</td> <td> <div class="label label-table label-success"><?php echo e($supplier->bank_account); ?></div></td></tr>
                        <tr><td>მისამართი:</td> <td> <div class="label label-table label-success"><?php echo e($supplier->address); ?></div></td></tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-12">
                    <table class="table">
                        <tr><td>სულ ნივთები:</td> <td> <div class="label label-table label-success"><?php echo e($items_count + $set_items_count); ?></div></td></tr>
                        <tr><td>სეტის ნივთები:</td> <td> <div class="label label-table label-success"><?php echo e($set_items_count); ?></div></td></tr>
                        <tr><td>ჩვეულებრივი ნივთები:</td> <td> <div class="label label-table label-success"><?php echo e($items_count); ?></div></td></tr>
                        <tr><td>აქტიური ნივთები:</td> <td> <div class="label label-table label-success"><?php echo e($active_items_count); ?></div></td></tr>
                    </table>
                </div>
            </div>
        </div>



        <div class="tab-pane active p-20" id="items_tab_div" role="tabpanel">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="supplier_items_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>დასახელება</th>
                                <th>ასაღები ფასი</th>
                                <th>გასაყიდი ფასი</th>
                                <th>მარჟა</th>
                                <th>მომწოდებელი</th>
                                <th>სეტი</th>
                                <th>საიტი</th>
                                <th>ნივთის ID</th>
                                <th>უნიკალური ID</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php else: ?>
 <div class="row">
    <div class="col-md-12 col-sm-12">
        <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="supplier_items_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>დასახელება</th>
                    <th>ასაღები ფასი</th>
                    <th>გასაყიდი ფასი</th>
                    <th>მარჟა</th>
                    <th>მომწოდებელი</th>
                    <th>სეტი</th>
                    <th>საიტი</th>
                    <th>ნივთის ID</th>
                    <th>უნიკალური ID</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php endif; ?>


<script>
    var supplier_items_table = null;
    var partialsurl = '<?php echo e(route('techplus.suppliers.partials', ['supplier_id' => $supplier ? $supplier->id  : '' ])); ?>';
    var loaditemurl = '<?php echo e(route('techplus.suppliers.loaditem')); ?>';
    var selectedsupplier = '<?php echo e($supplier ? $supplier->id  : ''); ?>';

    $(document).ready(function(){
        $('#items_tab').click(function(){
            create_supplier_items_table();
        });

        create_supplier_items_table();
    })

    createItemsUrl = function(){
        return partialsurl + '?s=1&partial=getitems';
    }

    create_supplier_items_table = function() {

        supplier_items_table = $('#supplier_items_table').DataTable({
            destroy: true,                
            dom: 'Bfrtip',
            scrollX: true,
            paging:true,
            displayLength: 100,
            ajax: createItemsUrl(),
            columns: [
                { "data": function(value){
                    return value.id;
                } },
                { "data": function(value){
                    return value.name;
                }, className: 'break-all'},
                { "data": function(value){
                    return value.get_price;
                } },
                { "data": function(value){
                    return value.sell_price;
                } },
                { "data": function(value){
                    return `${value.avg_price}%`;
                } },
                { "data": function(value){
                    return value.supplier_name;
                } },
                { "data": function(value){
                    return value.isset ? 'კი' : 'არა';
                } },
                { "data": function(value){
                    return value.site;
                } },
                { "data": function(value){
                    return value.item_id;
                } },
                { "data": function(value){
                    return value.unique_id;
                } }
            ]
        });


        $('#supplier_items_table tbody').off('click');
        $('#supplier_items_table tbody').on('click', 'tr', function () {
            var data = window.supplier_items_table.row( this ).data();
            showItem(data.id);
        });

    }

    showItem = function(id) {
        $.ajax({
            url: loaditemurl + '/' +id,
            type: "get",
            data: {},
            success: function(response) {
                $('#Item_Modal').html(response);
                $('#Item_Modal').modal('toggle');
            }
        });
    }
</script>

<style>
    #supplier_items_table tbody tr:hover { 
        cursor: pointer;
        background-color: #7b93ab;
    }
    td.break-all {
        word-break: break-all;
    }
</style>