<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>

function productList() {

        var dataList = [];

        var _browsers = $('#browsers').empty();
        var _godownCode = $('#godownCode').val();

        $.post("<?= site_url('sale/retail_sale/productList') ?>", {godown_code: _godownCode}).success(function (data) {

            var _data = JSON.parse(data);
            if (_data.length > 0) {
                _data.forEach(function (row) {
                    dataList.push({
                        id: row.code,
                        text: row.product_model + ' - ' + row.subcategory + ' - ' + row.sell_price + 'Tk',
                    });

                    $('#browsers').append(`<option value="${row.code}"> ${row.product_model} - ${row.subcategory} - ${row.sell_price}Tk</option>`);
                });
            }

            // initialize select2 dropdown
            $('#products').select2({
                data: dataList,
                placeholder: 'search',
                multiple: false,
                query: function (data) {
                    var pageSize, dataset, that = this;
                    pageSize = 20;
                    results = [];
                    if (data.term && data.term !== '') {
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
        });
    };

    productList();
	
	
	function member_dropdown_data() {
        var id_arr = new Array();
        var text_arr = new Array();
        <?php
        $sl = 1;
        if($productList != null){ foreach($productList as $value){
        ?>
        id_arr['<?php echo $sl; ?>'] = '<?php echo $value->code; ?>';
        text_arr['<?php echo $sl; ?>'] = '<?php echo $value->name . '' . $value->product_model; ?>';

        <?php $sl++;  } } ?>
        return _.map(_.range(1,<?php echo count($productList) + 1; ?>), function (i) {
            return {
                id: id_arr[i],
                text: text_arr[i],
            };
        });
    }