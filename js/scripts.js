(function($){

    function multiply (ele1, ele2) {
            var price = parseInt($('.' + ele1).val(), 10),
                qty = parseInt($('.' + ele2).val() , 10);
                if(!isNaN(price) && !isNaN(qty)){
                    return price * qty;
                }
    }

    function set_value(ele, val) {
        $('.' + ele).val(val);
    }

    function calc_total () {
        var priceval  = parseInt($('.price_field').val(), 10),
            qtyvalue = parseInt($('.quantity_field').val(), 10);

        if(!isNaN(priceval)) {
            if(!isNaN(qtyvalue)) {
                 set_value('total_field',multiply('price_field', 'quantity_field'));
            } else {
                alert('份数必须输入数字！')
            }
        } else {
            alert('单价必须输入数字！');
        }
    }

    var qty = $('.quantity_field'),
        price = $('.price_field'),
        plus = $('.plus_btn'),
        minus = $('.minus_btn');

    plus.on('click', function() {
        if(!isNaN(parseInt(qty.val(), 10))) {
            qty.val(parseInt(qty.val(), 10) + 1);
            if(price.val().length > 0) {
                calc_total();
            }
        }  else {
                alert('份数请输入数字！');
                qty.val('');
        }
    });

    minus.on('click', function() {
        if(!isNaN(parseInt(qty.val(), 10))) {
            if(qty.val() > 1) {
                qty.val(parseInt(qty.val(), 10) - 1);
                if(price.val().length > 0) {
                    calc_total();
                }
            }
        }  else {
                alert('份数请输入数字！');
                qty.val('');
        }
    });

    $('.eatsame').on('click', function(e) {
        e.preventDefault();
        var name = $.trim($(this).closest('tr').find('.td_fan').html()),
            price = $.trim($(this).closest('tr').find('.td_price').html()),
            caifield = $('.cai_field'),
            pricefield = $('.price_field');

        caifield.val(name);
        pricefield.val(price);

        calc_total();
    });

    $('.price_field').bind('change',  function() {
        if(!isNaN(parseInt($(this).val(), 10)) && $('.quantity_field').val() != "") {
            calc_total();
        } else {
            alert('请输入数字！')
            $(this).val('');
        }
    })
    $('.quantity_field').bind('change',  function() {
        if(!isNaN(parseInt($(this).val(), 10)) && $('.price_field').val() != "") {
            calc_total();
        } else {
            alert('请输入数字！')
            $(this).val('');
        }
    })

})(jQuery)