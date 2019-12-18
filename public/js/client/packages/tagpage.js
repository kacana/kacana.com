tagpagePackage = {
    tagpage:{
        init: function(){
            Kacana.tagpage.loadProduct();
            Kacana.tagpage.showFilter();
            //Kacana.tagpage.loadFilter();
            Kacana.tagpage.showSortOptions();
            Kacana.tagpage.sort();
            Kacana.tagpage.showLoading();
            Kacana.tagpage.removeLoading();
            Kacana.tagpage.bindEvent();
        },
        bindEvent: function(){
            $('#listProductPage .tag-description').hover(function () {
                $(this).addClass('expand');
            }, function () {
                $(this).removeClass('expand');
            });
        },
        showLoading: function(){
            $("#as-search-results").addClass('as-search-fade');
            $(".loader-response").show();
        },
        removeLoading: function(){
            $("#as-search-results").removeClass('as-search-fade');
            $(".loader-response").hide();
        },
        loadProduct: function(){
            var is_busy = false;
            var page = 1;
            var stopped = false;
            var $element = $("#content");

            //$(window).scroll(function(){
            //    $tagId = $("#tag-id").val();
            //    $colorId = $("#color-id").val();
            //    $brandId = $("#brand-id").val();
            //    $sort = $("#sort").val();
            //
            //    if($(this).scrollTop()>= $element.height()){
            //        //neu dang gui ajax thi ngung
            //        if(is_busy == true){
            //            return false;
            //        }
            //        //neu het du lieu thi ngung
            //        if(stopped == true){
            //            Kacana.tagpage.removeLoading();
            //            return false;
            //        }
            //        //thiet lap dang gui ajax
            //        is_busy = true;
            //        //tang so trang len
            //        page++;
            //        //hien thi loading
            //        Kacana.tagpage.showLoading();
            //        //gui ajax
            //        var callBack = function(data) {
            //            if(data!=''){
            //                $element.append(data);
            //                Kacana.homepage.init();
            //                Kacana.tagpage.removeLoading();
            //                is_busy = false;
            //            }else{
            //                stopped=true;
            //                Kacana.tagpage.removeLoading();
            //            }
            //
            //        };
            //        var errorCallBack = function(data){};
            //        options = 'tagId='+$tagId+"&color="+$colorId+"&brand="+$brandId+"&page="+page+"&sort="+$sort;
            //        Kacana.ajax.tagpage.loadProduct(options, callBack, errorCallBack);
            //        return false;
            //    }
            //})
        },
        showFilter:function(){
            $(".as-filter-button").click(function(){
                if($(this).attr('aria-expanded')=='false'){
                    $("#as-search-filters").removeClass('as-filter-animation');
                    $("#as-search-filters").css({"position":"relative"});
                    $(".as-search-filters").attr('aria-hidden', false);
                    $("#content").addClass('col-sm-9');
                }else{
                    $("#as-search-filters").addClass('as-filter-animation');
                    $("#as-search-filters").css({"position":"fixed"});
                    $(".as-search-filters").attr('aria-hidden', true);
                    $("#content").removeClass('col-sm-9');
                }
            });

            $(".as-search-accordion-header").on('click',function(){
                if($(this).hasClass("as-accordion-isexpanded")){
                    $(this).removeClass('as-accordion-isexpanded');
                    $(this).next().addClass('ase-materializer-gone ase-materializer-hide').removeClass("ase-materializer-show");
                }else{
                    $(this).addClass('as-accordion-isexpanded');
                    $(this).next().addClass('ase-materializer-show').removeClass("ase-materializer-gone").removeClass("ase-materializer-hide");
                }
            })

            $(".as-search-filter-child").on('click', function(){
                link_id = $(this).data('id');
                if($("#as-seach-filter-childs"+link_id).hasClass('ase-materializer-gone')){
                    $("#as-seach-filter-childs"+link_id).removeClass('ase-materializer-gone');
                }else{
                    $("#as-seach-filter-childs"+link_id).addClass('ase-materializer-gone');
                }
            })
        },
        loadFilter: function(){
            //$.urlParam = function(name, url){
            //    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            //    if($.isArray(results)){
            //        return results[1];
            //    }else{
            //        return 0;
            //    }
            //},
            //$.removeParam = function(key, sourceURL) {
            //    var rtn = sourceURL.split("?")[0],
            //        param,
            //        params_arr = [],
            //        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
            //    if (queryString !== "") {
            //        params_arr = queryString.split("&");
            //        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            //            param = params_arr[i].split("=")[0];
            //            if (param === key) {
            //                params_arr.splice(i, 1);
            //            }
            //        }
            //        rtn = rtn + "?" + params_arr.join("&");
            //    }
            //    return rtn;
            //},
            //$(".as-filter-option").click(function(e){
            //    Kacana.tagpage.showLoading();
            //    var datatype = $(this).attr('data-type');
            //    $parents = $(this).parents('.'+datatype).find('.as-filter-item');
            //    $parents.removeClass('as-filter-active current');
            //
            //    if($(this).attr('aria-checked') == 'true'){
            //        $(this).parent('.as-filter-item').removeClass('as-filter-active current');
            //        $(this).attr('aria-checked', 'false');
            //    }else{
            //        $parents.find('a').attr('aria-checked', 'false');
            //        $(this).parent('.as-filter-item').addClass('as-filter-active current');
            //        $(this).attr('aria-checked', 'true');
            //        datatype = '';
            //    }
            //    e.preventDefault();
            //
            //    var pageUrl = $(this).attr('href');
            //    var dataPost = '';
            //
            //    var tag = $.urlParam('tag', pageUrl);
            //    var color = $.urlParam('color', pageUrl);
            //    var brand = $.urlParam('brand', pageUrl);
            //    var sort = '';
            //
            //    if(color == 0){
            //        color = $.urlParam('color', location.href);
            //    }
            //
            //    if(brand == 0){
            //        brand = $.urlParam('brand', location.href);
            //    }
            //
            //    if(tag == 0){
            //        tag = $.urlParam('tag', location.href);
            //    }
            //
            //    sort = $.urlParam('s', location.href);
            //    console.log(sort);
            //
            //    if(tag!=0 && pageUrl.indexOf('tag')==-1){
            //        pageUrl = $.removeParam("brand", location.href);
            //        pageUrl = $.removeParam('color', pageUrl);
            //    }
            //
            //    if(color!=0 && pageUrl.indexOf('color')==-1){
            //        pageUrl += '&color='+color;
            //    }
            //
            //    if(brand!=0 && pageUrl.indexOf('brand')==-1){
            //        pageUrl += '&brand='+brand;
            //    }
            //
            //    if(sort!='' && pageUrl.indexOf('sort') == -1){
            //        pageUrl += '&s='+sort;
            //    }
            //
            //    if(datatype=='brand'){
            //        brand="";
            //        pageUrl = $.removeParam("brand", pageUrl);
            //    }else if(datatype=='color'){
            //        color = "";
            //        pageUrl = $.removeParam("color", pageUrl);
            //    }else if(datatype == 'tag'){
            //        tag="";
            //        pageUrl = $.removeParam("tag", pageUrl);
            //    }
            //
            //    $("#brand-id").val(brand);
            //    $("#color-id").val(color);
            //    $("#tag-id").val(tag);
            //
            //    dataPost += 'tagId='+tag+'&color='+color+"&brand="+brand+"&sort="+sort;
            //
            //    var callBack = function(data) {
            //        $("#content").html(data);
            //        Kacana.tagpage.removeLoading();
            //        Kacana.homepage.init();
            //    };
            //    var errorCallBack = function(data){};
            //    Kacana.ajax.tagpage.loadFilter(dataPost, callBack, errorCallBack);
            //
            //    if(pageUrl != window.location){
            //        window.history.pushState({path:pageUrl}, '',pageUrl);
            //    }
            //    return false;
            //
            //});
        },
        showSortOptions: function(){
            $("#as-sort-button").click(function(){
                if($(this).attr('aria-expanded')=='false'){
                   $("#as-sort-drawer").addClass('as-open-drawer');
                    $("#angle-change").removeClass('fa-angle-down').addClass('fa-angle-up');
                }else{
                    $("#as-sort-drawer").removeClass('as-open-drawer');
                    $("#angle-change").removeClass('fa-angle-up').addClass('fa-angle-down');
                }
            })
        },
        sort: function(){

        }

    }
};

$.extend(true, Kacana, tagpagePackage);