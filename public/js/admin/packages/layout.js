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

            $('body').on('keyup', 'input.form-control, textarea.form-control', function () {
                var formGroup = $(this).parents('.form-group');
                var wordCountShow = formGroup.find('.word-count');
                var wordCount = $(this).val().length;

                wordCountShow.html(wordCount);
            });
        },
    }
};

$.extend(true, Kacana, layoutPackage);