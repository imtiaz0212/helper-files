<style>
   @media print{
   aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
   .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
   .hide{display: block !important;}
   }
   .wid-100{width: 100px;}
   #loading{text-align: center;}
   #loading img{display: inline-block;}
</style>
<div class="container-fluid">
   <div class="row">
      <div class="panel panel-default none">
         <div class="panel-heading">
            <div class="panal-header-title pull-left">
               <h1>Search Stock</h1>
            </div>
         </div>
         <div class="panel-body">
            <?php echo form_open('', ['id' => 'searchForm']); ?>
            <div class="row">
               <?php if(checkAuth('super')) { ?>
               <div class="col-md-3">
                   <div class="form-group">
                        <select name="godown_code" id="godownCode" class="form-control">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                   </div>
               </div>
               <?php }else{ ?>
                    <input type="hidden" name="godown_code" id="godownCode" value="<?php echo $this->data['branch']; ?>">
               <?php } ?>
			   
               <div class="col-md-3">
                   <div class="form-group">
                        <input  name="code" id="productList" class="form-control" placeholder="Select Name"  /> 
                    </div>
               </div>
               
               <div class="col-md-3">
                   <div class="form-group">
                      <select name="" id="categorySearch" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                         <option value="" selected disabled>-- Category --</option>
                         <?php if($category != null){ foreach($category as $key => $row){ ?>
                         <option value="<?php echo $row->category; ?>">
                            <?php echo filter($row->category); ?>
                         </option>
                         <?php }} ?>
                      </select>
                   </div>
               </div>
               
               <div class="col-md-3">
                   <div class="form-group">
                      <select name="" id="subcategory" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                         <option value="" selected disabled>-- Brand  Name--</option>
                         <?php if($subcategory != null){ foreach($subcategory as $key => $row){ ?>
                         <option value="<?php echo $row->subcategory; ?>">
                            <?php echo filter($row->subcategory); ?>
                         </option>
                         <?php }} ?>
                      </select>
                   </div>
               </div>
               <div class="col-md-2">
                   <div class="form-group">
                      <div class="btn-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary" style="margin-right: 15px;">
                            <a href="<?php echo current_url(); ?>" class="btn btn-warning">Refresh</a>
                      </div>
                   </div>
               </div>
            </div>
            <?php echo form_close(); ?>
         </div>
         <div class="panel-footer">&nbsp;</div>
      </div>
      <div class="panel panel-default">
         <div class="panel-heading">
            <div class="panal-header-title">
               <h1 class=" pull-left">Stock
                  <?php 
                     $code = $this->input->post('godown_code');
                     if($code !='' && $code !='all'){
                        echo '-';
                        echo get_name('godowns','name',array('code' => $code));
                     }
                     ?>
               </h1>
               <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>
         </div>
         <div class="panel-body">
            <!-- Print banner -->
            <?php $this->load->view('print', $this->data); ?>
            
            <h4 class="hide text-center" style="margin-top: 0px;">
               Stock  
            </h4>
            <div class="table-responsive">
               <table class="table table-bordered" id="dataList">
                  <thead>
                      <tr>
                         <th style="width: 40px;">SL</th>
                         <th>Product Name</th>
                         <th>SL No</th>
                         <th>Category</th>
                         <th>Subcategory</th>
                         <th>Quantity</th>
                         <th>Purchase Price</th>
                         <th>T.Cost</th>
                         <th>Sell Price</th>
                         <th>Purchase Amount</th>
                         <th>Sell Amount</th>
                         <?php if(checkAuth('super')) { ?>
                         <th width="130" class="none">Showroom</th>
                         <?php } ?>
                      </tr>
                  </thead>
                  <tbody></tbody>
                  <tfoot></tfoot>
               </table>
            </div>
            
            <div class="text-center loadingData">
                <span class="btn btn-default" onClick="stockData()">Loading data....</span>
            </div>
         </div>
         <div class="panel-footer">&nbsp;</div>
      </div>
   </div>
</div>
<!-- Select Option 2 Script -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<script> 
   (function () {
      // initialize select2 dropdown
      $('#productList').select2({
          data: dropdown_data(),
          placeholder: 'search',
          multiple: false,
          // creating query with pagination functionality.
          query: function (data) {
              var pageSize,
                      dataset,
                      that = this;
              pageSize = 20; // Number of the option loads at a time
              results = [];
              if (data.term && data.term !== '') {
                  // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                  results = _.filter(that.data, function (e) {
                      return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                  });
              } else if (data.term === '') {
                  results = that.data;
              }
              data.callback({
                  results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                  more: results.length >= data.page * pageSize,
              });
          },
      });
   })();
   
   <?php $products = get_left_join('stock', 'products', 'stock.code=products.product_code',  ['stock.quantity >'=> 0, 'stock.trash'=> 0], ['stock.code', 'stock.name', 'stock.product_model', 'products.item_code']) ?>
   
   function dropdown_data() {
   var id_arr = new Array();
   var text_arr = new Array();
    <?php 
    $sl = 1;
    if(!empty($products)){ foreach($products as $value){ 
    ?>
   id_arr['<?php echo $sl; ?>']   = '<?php echo $value->code; ?>';
   text_arr['<?php echo $sl; ?>'] = '<?php echo filter($value->name).' ( '.filter($value->product_model).' )'; ?> - <?=($value->item_code)?>';
   <?php $sl++;  } } ?>
   
      return _.map(_.range(1,<?php echo count($products)+1; ?>), function (i) {
          return {
              id:   id_arr[i],
              text: text_arr[i],
          };
      });
   } 
   
   
   /* load stock data */
   var _limit  = 1000;
   var _offset = 0;
   var counter = 1;
   var purchaseTotal = saleTotal = totalQuantity = totalTransportCost = 0;
   
   
   $('.loadingData').hide();
   
   function stockData(){
       
       $('.loadingData').show();
       
       // search data
       var _godownCode  = document.getElementById('godownCode').value;
       var _code        = document.getElementById('productList').value;
       var _category    = document.getElementById('categorySearch').value;
       var _subcategory = document.getElementById('subcategory').value;
       
       $.post("<?= site_url('stock/stock/stockData') ?>", {
           godown_code: _godownCode,
           code       : _code,
           category   : _category,
           subcategory: _subcategory,
           limit      : _limit,
           offset     : _offset,
       }).success(function(response){
           
           var data = JSON.parse(response);
            if (data.length > 0) {

                $('#dataList tfoot').empty();

                if(data.length < _limit){
                    $('.loadingData').hide();
                }else{
                  $('.loadingData').show();  
                }
                
                $('.loadingData span').text('Click and load more data.');
                
                var itemData = data.map(function (row) {
                    
                    var purchaseAmount = saleAmount = 0;
                    purchaseAmount = parseFloat(row.purchase_price + row.transport_cost) * parseFloat(row.quantity);
                    saleAmount     =  parseFloat(row.sell_price) * parseFloat(row.quantity);
                    
                    totalQuantity += parseFloat(row.quantity);
                    totalTransportCost += parseFloat(row.transport_cost);
                    purchaseTotal += purchaseAmount;
                    saleTotal += saleAmount;
                    return (`
                        <tr>
                            <td>${(counter++)}</td>
                            <td>${strFilter(row.product_model)}</td>
                            <td>${row.item_code}</td>
                            <td>${strFilter(row.category)}</td>
                            <td>${strFilter(row.subcategory)}</td>
                            <td class="text-right">${row.quantity}</td>
                            <td class="text-right">${row.purchase_price}</td>
                            <td class="text-right">${row.transport_cost}</td>
                            <td class="text-right">${row.sell_price}</td>
                            <td class="text-right">${purchaseAmount.toFixed(2)}</td>
                            <td class="text-right">${saleAmount.toFixed(2)}</td>
                             <?php if (checkAuth('super')){ ?>
                            <td>${row.godown_name}</td>
                            <?php } ?>
                        </tr>
                    `);
                });

                _offset += _limit;

                $('#dataList tbody').append(itemData);

                // load footer data
                var tfooter = `
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th class="text-right">${totalQuantity}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-right">${purchaseTotal.toFixed(2)}</th>
                        <th class="text-right">${saleTotal.toFixed(0)}</th>
                    </tr>
                `;
                $('#dataList tfoot').append(tfooter);
            }else{
                $('.loadingData').hide();
            }
       });
   }
   
   
   // load default data
   stockData();
   
   
    // form submit and search data
    $( "#searchForm" ).submit(function( event ) {
      event.preventDefault();
      $('#dataList tbody').empty();
      $('#dataList tfoot').empty();
      _offset = 0;
	  counter = 1;
      stockData();
    });
    
    
    // text filter
    function strFilter(string) {
        if (string) {
            var text = string.replace(/_/g, " ");
            return text.replace(/^\w/, c => c.toUpperCase());
        }
        return '';
    }
</script>