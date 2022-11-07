$(document).ready(function () {

    //add product to order list
    $('.add-product-btn').on('click', function (e) {
        e.preventDefault();
        let name = $(this).data('name');
        let id = $(this).data('id');
        let price = $.number($(this).data('price'), 2); //$.number plugin add commas to number

        $(this).removeClass('btn-success').addClass('btn-default disabled');

        let html =
            `<tr>
              <!--  <input type="hidden" name="products_ids[]" value="${id}"> -->
                <td>${name}</td>
                <td><input type="number" name="products[${id}][quantity]" data-price="${price}" class="form-control product-quantity" min="1" required></td>
                <td class="product-price">${price}</td>
                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
            <tr/>`
        $('.order-list').append(html);
        calculateTotal();
    });//end of add product to order list


    //to prevent duplicate jquery selector
    let body = $('body');


    //disabled added product
    body.on('click', '.disabled', function (e) {
        e.preventDefault();
    });//end of disabled added product


    //remove product from order list
    body.on('click', '.remove-product-btn', function (e) {
        e.preventDefault();
        let  id = $(this).data('id');
        $(this).closest('tr').remove();
        $('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');
        calculateTotal();
    });//end of remove product from order list

    //calculate price with product quantity change
    body.on('keyup change', '.product-quantity', function () {
        let quantity = Number($(this).val());
        let unitPrice = parseFloat($(this).data('price').replace(/,/g, ''));//parseFloat to convert string number with commas to number
        $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice, 2));
        calculateTotal();
    });//end of calculate price with product quantity change

    //list all order product
    $('.order-products').on('click', function (e) {

        e.preventDefault()

        $('#loader').css('display', 'flex')

        let url= $(this).data('url');
        let method= $(this).data('method');
        $.ajax({
            url: url,
            method: method,
            success: function (data) {
                $('#loader').css('display', 'none');
                $('#oder-product-list').empty();
                $('#oder-product-list').append(data);
            }
        });
    });//end of list all order products

    //print order
    $(document).on('click', '.print-btn', function () {
       $('#print-area').printThis();
    });


});//end of document ready


//calculate total function
function calculateTotal() {
    let price = 0;
    $('.order-list .product-price').each(function (index) {
        price += parseFloat($(this).html().replace(/,/g, '')); //parseFloat to convert string number with commas to number
        // price += Number($(this).html());
    });
    $('.total-price').html($.number(price, 2));

    if(price > 0){
        $('#add-order-form-btn').removeClass('disabled');
    }else{
        $('#add-order-form-btn').addClass('disabled');
    }
}//end of calculate total function
