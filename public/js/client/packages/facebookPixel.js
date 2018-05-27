var facebookPixelPackage = {
    facebookPixel: {
        content_type:'product',
        currency: 'VND',
        viewProductContent: function (value, content_ids) {
            console.log(content_ids);
            fbq('track', 'ViewContent', {
                value: value,
                currency: Kacana.facebookPixel.currency,
                content_ids: content_ids,
                content_type: Kacana.facebookPixel.content_type
            });
        },
        searchProductContent: function (search_string, content_ids) {
            fbq('track', 'Search', {
                search_string: search_string,
                content_ids: content_ids,
                content_type: Kacana.facebookPixel.content_type
            });

        },
        checkout: function (value) {
            fbq('track', 'InitiateCheckout', {
                value: value,
                currency:Kacana.facebookPixel.currency
            });
        },
        purchase: function (value, content_ids) {
            fbq('track', 'Purchase', {
                value: value,
                currency: Kacana.facebookPixel.currency,
                content_ids: content_ids,
                content_type: Kacana.facebookPixel.content_type
            });
        },
        addToCart: function (value, content_id) {
            fbq('track', 'AddToCart', {
                value: value,
                currency: 'VND',
                content_ids: content_id,
                content_type: 'product'
            });

        }
    }
};

$.extend(true, Kacana, facebookPixelPackage);