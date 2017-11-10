<script id="template-sale-row" type="template">
    <tr>
        <td>${item.id}</td>
        <td>${item.product.name}</td>
        <td>Cái</td>
        <td><input type="number" min="1" value="1" ></td>
        <td>${Kacana.utils.formatCurrency(item.price)}</td>
        <td>${Kacana.utils.formatCurrency(item.product.discount)}</td>
        <td>${Kacana.utils.formatCurrency(item.price - item.product.discount)}</td>
        <td><a href="#remove-product-order"><i class="text-red fa fa-times" ></i></a></td>
    </tr>
</script>