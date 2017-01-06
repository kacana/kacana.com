var blogPackage = {
    blog:{
        page: false,
        init: function(){
            Kacana.homepage.applySlideImage();
            Kacana.homepage.bindEvent();

            setTimeout(function() {
                var callBack = function(data) {
                    console.log('tracking post view is DONE!')
                };
                var errorCallBack = function(data){

                };
                var postId = $('#blog-detail-page').data('id');
                var data = {postId: postId};
                Kacana.ajax.blog.trackUserPostView(data, callBack, errorCallBack);
            }, 3000);
        }
    }
};

$.extend(true, Kacana, blogPackage);