var c = {
    'log':function(el){return console.log(el);},
    'dir':function(el){return console.dir(el);}
}

$(function(){
    $(".fancybox-thumb").fancybox({
        prevEffect	: 'elastic',
        nextEffect	: 'elastic',
        openEffect	: 'fade',
        closeEffect	: 'fade',
        closeBtn	: false,
        helpers	: {
            title	: {
                type: 'float'
            },
            thumbs	: {
                width	: 75,
                height	: 75
            }
        }
    });

    // Cart PopUp
    $(".various").fancybox({
        fitToView	: false,
        autoSize	: true,
        closeClick	: false,
        closeBtn	: false,
        openEffect	: 'fade',
        closeEffect	: 'fade',
        type: 'ajax',
        // Show cart form
        afterShow: function(){

            // Remove item from cart
            $('button[name="remove"]').on('click',function(e){
                e.preventDefault();
                cart.remove($(this).attr('id'));
                $(this).parent().parent().fadeOut('fast');
                setTimeout(function(){
                    if($('#cart').find('tr:visible').size() == 1)
                        $.fancybox.close();
                },300);
            });

            // Update cart
            $('input[name^="item"]').on('keyup',function(){

                if(cart.check_num(this)){
                    $.fancybox.showLoading();
                    cart.edit(
                        $(this).attr('id'),
                        Number($(this).val())
                    );
                    if($(this).val() == 0)
                        $(this).parent().parent().fadeOut('fast');
                    setTimeout(function(){
                        $.fancybox.hideLoading();
                    },300);
                }
            });

            // Clear cart
            $('button[name="clear"]').on('click',function(){
                cart.clear();
                $.fancybox.close();
            });

        }
    });
});

/* Cart functional
----------------------------------------------------------------------------------------------------------------------*/

var items = {};
var cart = {
    add: function(id,num,price,name,img){
        var el_item = $('span.item'),
            el_total = $('span.total'),
            count = Number(el_item.text()),
            total = Number(el_total.text());

        //c.log(name);

        el_total.text((total+(price*num)).toFixed(2));
        if(typeof items[id] != 'undefined'){
            items[id].count = items[id].count + num;
            items[id].price = price;
            items[id].total = items[id].total + price*num;
            items[id].name = name;
            items[id].img = img;
        } else {
            items[id] = {
                count:num,
                price:price,
                total:price*num,
                name:name,
                img:img
            };
            el_item.text(count+1);
        }
        this.sync();
    },
    remove: function(id){
        delete items[id];
        this.recalculate();
    },
    clear: function(){
        items = {};
        this.recalculate();
    },
    edit: function(id,count){
        if(count == 0){
            this.remove(id);
            return false;
        }
        items[id].count = count;
        items[id].total = items[id].price * count;
        this.recalculate();
    },
    recalculate: function(){
        var el_item = $('span.item'),
            el_total = $('span.total'),
            item = 0,
            total = 0;
        $.each(items,function(i) {
            total += Number(this.total);
            item++;
        });
        el_item.text(item);
        el_total.text(total);
        this.sync();
    },
    check_num: function(el){
        var re = /^[0-9]{1,10}$/i;
        if(!re.test($(el).val()) || $(el).val() == 0){
            $(el).val(1);
            return false;
        }
        return true;
    },
    sync: function(){
        if($.isEmptyObject(items))
            $.post('/cart/',{data:'empty'});
        else
            $.post('/cart/',{data:items});
    },
    init: function(){
        $.getJSON('/cart/init/',{},function(data,status){
            if(status && !$.isEmptyObject(data))
                items = data;
            else
                items = {};
        });
    }
};

// Start cart
cart.init();

// Add product to cart
$(".add").on('click',function(){
    var el = $(this).parent().find('input:text');

    // Check Num
    if(cart.check_num(el)){
        cart.add(
            Number(el.attr('data-id')),
            Number(el.val()),
            Number(el.attr('data-price')),
            el.attr('data-name'),
            el.attr('data-img')
        );
    }

});

// Go Back Button
$('.go_back').on('click',function(){
    history.back(1);
});