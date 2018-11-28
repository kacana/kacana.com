var utilsPackage = {
    utils:{
        loadingContainer: $('body .content-wrapper'),
        init: function(){
           Kacana.utils.changeStatus();
        },
        showError: function (text) {
            sweetAlert(
                'Oops...',
                text,
                'error'
            )
        },
        generateProductCampaignProductTable: function ($campaignProducts, $product_id, $buttonCreate) {

            var tabble = '';

            if($campaignProducts) {
                tabble = '<table class="product-table-campaign-product" >';

                for(var i = 0; i < $campaignProducts.length; i++){
                    $campaign = $campaignProducts[i];

                    $campaignStart = $campaign.start_date.split(" ");
                    $campaignEnd = $campaign.end_date.split(" ");
                    $discount = '';
                    if($campaign.discount_type == 3) {
                        $discount = '<a target="_blank" href="/product/editProduct/'+$campaign.product_ref.id+'"><img style="width: 50px;" src="'+$campaign.product_ref.image+'" ></a>';
                    } else {
                        $discount = '(-' + Kacana.utils.savingDiscount($campaign.discount_type, $campaign.ref, $campaign.product.sell_price) + ')<br>';
                        $discount += '<span class="color-red">' + Kacana.utils.formatCurrency(Kacana.utils.calculateDiscountPrice($campaign.product.sell_price, $campaign.discount_type, $campaign.ref)) + '</span>'
                    }

                    tabble +='<tr data-campaign-id="'+$campaign.id+'">' +
                        '<td>'+$campaignStart[0]+'<br>'+$campaignStart[1]+'</td>' +
                        '<td>'+$campaignEnd[0]+'<br>'+$campaignEnd[1]+'</td>' +
                        '<td>'+$discount+'</td>' +
                        '<td>' +
                        '<a data-id="'+$campaign.id+'" href="#remove-campaign-product"><i class="fa fa-trash-o" ></i></a><br><br>' +
                        '<a target="_blank" href="/campaign/edit/'+$campaign.campaign_id+'"><i class="fa fa-eye" ></i></a>' +
                        '</td>' +
                        '</tr>';
                }

                tabble +='</table>';
            }

            if($buttonCreate) {
                tabble +='<div><a href="#createCampaignProduct" data-product-id="'+$product_id+'" ><i class="fa fa-plus-circle"></i> Create discount</a></div>';
            }

            return tabble;
        },
        calculateDiscountPrice: function (price, discountType, ref) {

            if(discountType == 1) {
                price = price - ref;
            } else if (discountType == 2) {
                price = price - (price*ref/100);
            } else if (discountType == 4) {
                price = ref;
            }
            return price;
        },
        changeStatus: function(){
            $('body table').on('click', 'a[href="#change-kacana-dropdown"]', function(){

                var value = $(this).data('value');
                var field = $(this).data('field');
                var id = $(this).data('id');
                var tableName = $(this).data('table-name');
                var $kacanaDropdown = $(this).closest('.btn-group').find('.kacana-dropdown');
                var that = $(this);
                Kacana.utils.loading();
                var callBack = function(data){
                    console.log('done!', data);
                    Kacana.utils.closeLoading();
                    if (data.ok){
                        $kacanaDropdown.html(that.html()+' <span class="caret"></span>');
                    }
                };

                var errorCallBack = function(){
                    // do something here if error
                };

                Kacana.ajax.admin.changeStatus(id, value, field, tableName, callBack, errorCallBack);
            });
        },
        loading: function($container){
            if ($container) {
                Kacana.utils.loadingContainer = $container;
            }

            Kacana.utils.loadingContainer.waitMe({
                effect : 'win8',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : 20,
                source : ''
            });
        },
        closeLoading: function(){
            Kacana.utils.loadingContainer.waitMe("hide");
            Kacana.utils.loadingContainer = $('body .content-wrapper');
        },
        formatCurrency: function(num){
            var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
            if(str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for(var j = 0, len = str.length; j < len; j++) {
                if(str[j] != ",") {
                    output.push(str[j]);
                    if(i%3 == 0 && j < (len - 1)) {
                        output.push(",");
                    }
                    i++;
                }
            }
            formatted = output.reverse().join("");
            return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : "") + " đ");
        },
        savingDiscount: function(discountType, ref, price){
            var name = '';
            if(discountType == 1) {
                name = Kacana.utils.formatCurrency(ref);
            } else if (discountType == 2) {
                name = ref+'%';
            } else if (discountType == 4){
                name =  Kacana.utils.formatCurrency(price-ref);
            }  else if (discountType == 3){
                name = '';
            }
            return name;
        },
        dealType: function ($type) {
            var typeName = '';
            switch ($type) {
                case 1:
                    typeName = 'giảm giá tiền';
                    break;
                case 2:
                    typeName = 'giảm giá %';
                    break;
                case 3:
                    typeName = 'mua 1 tặng 1';
                    break;
                case 4:
                    typeName = 'đồng giá';
                    break;
            }
            return typeName;
        },
        dealRef: function ($type, $ref) {
            var refName = '';
            switch ($type) {
                case 1:
                    refName = Kacana.utils.formatCurrency($ref);
                    break;
                case 2:
                    refName = $ref+'%';
                    break;
                case 3:
                    refName = '<a href="/product/editProduct/'+$ref+'" target="_blank" >sản phẩm</a>';
                    break;
                case 4:
                    refName = Kacana.utils.formatCurrency($ref);
                    break;
            }
            return refName;
        },
        KPusher: function () {
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;
            // var pusherKey = '21054d1ab37cab6eb74f'; // development key
            var pusherKey = '65bb7e6aa3cfdd3b4b63'; // production key

            var pusher = new Pusher(pusherKey, {
                cluster: 'ap1',
                encrypted: true
            });

            return pusher;
        }
    }
};

$.extend(true, Kacana, utilsPackage);