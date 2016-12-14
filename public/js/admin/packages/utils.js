var utilsPackage = {
    utils:{
        loadingContainer: $('body .content-wrapper'),
        init: function(){
           Kacana.utils.changeStatus();
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
                maxSize : '',
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
    }
};

$.extend(true, Kacana, utilsPackage);