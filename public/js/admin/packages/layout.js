var layoutPackage = {
    layout:{
        init: function(){
            Kacana.layout.initConfig();
            // Kacana.layout.parseTable();
        },
        initConfig: function() {
            //Add csrf token for any submit
            $('body').on('submit', 'form', function () {
                $(this).append('<input name="_token" class="hide" value="' + $('meta[name="csrf-token"]').attr('content') + '">');
            });
        },
    }
};

$.extend(true, Kacana, layoutPackage);