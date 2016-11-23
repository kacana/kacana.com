var layoutPackage = {
    layout:{
        init: function(){
            Kacana.utils.facebook.init();
            Kacana.utils.google.init();
        },
    }
};

$.extend(true, Kacana, layoutPackage);