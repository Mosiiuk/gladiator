// (function($) {

// burger menu func



console.log('asd')

const $headerNav = jQuery('.header_aside');

const $burger = jQuery('.js-burger');

const $body = jQuery('body');



const slickFilterParams = {

    infinite: true,

    slidesToShow: 4,

    slidesToScroll: 1,

    arrows: true,

    responsive: [{

            breakpoint: 991,

            settings: {

                slidesToShow: 3

            }

        },

        {

            breakpoint: 767,

            settings: {

                slidesToShow: 2,

                arrows: false

            }

        },

        {

            breakpoint: 565,

            settings: {

                slidesToShow: 1,

                arrows: false

            }

        }

    ]

}





function openBurgerMenu() {

    $headerNav.addClass('active');

    $burger.addClass('active');

    $body.addClass('body_fixed');

}



function closeBurgerMenu() {

    $headerNav.removeClass('active');

    $burger.removeClass('active');

    $body.removeClass('body_fixed');

}



$burger.on('click', function() {

    if ($burger.hasClass('active')) {

        closeBurgerMenu();

    } else {

        openBurgerMenu();

    }

})



// burger menu func end



// rotate effect and scroll



function rotateBg() {

    let scrollOfset = jQuery(window).scrollTop();



    return scrollOfset;

}



// rotate effect and scroll end





// filter func



const best_deals_element = jQuery('.js-filter-body-element')

let filter_buttons = jQuery('.js-filter-head').append(jQuery('<li class="active"><a href="#" data-filter="all">All</a></li>'))

let filter_buttons_set = new Array()

let filter_Body = jQuery('.js-filter-body')



best_deals_element.each(function() {

    filter_buttons_set.push(jQuery(this).data('category'))

});

filter_buttons_set = new Set(filter_buttons_set)



for (let category of filter_buttons_set) {

    filter_buttons.append(jQuery(`<li><a href="#" data-filter="${category}">${category}</a></li>`))

}



function initFilterSlick() {

    filter_Body.slick(slickFilterParams)

    init_home_slider()

}



filter_buttons.find('a').on('click', function(event) {

    event.preventDefault();



    let category = jQuery(this).data('filter');



    jQuery('.js-filter-head li').removeClass('active');

    jQuery(this).parents().addClass('active');



    filter_Body.animate({
        opacity: '0'
    }, 200);



    setTimeout(function() {

        filter_Body.slick('unslick');



        if (category == 'all') {

            filter_Body.html(best_deals_element)

        } else {

            filter_Body.html(best_deals_element.filter(`[data-category="${category}"]`))

        }

        initFilterSlick()

        setTimeout(function() {

            filter_Body.animate({
                opacity: '1'
            }, 200);

        }, 300)



    }, 200)







})

// filter func end

// quantiti func



// quantiti func

function initCart() {

    jQuery('.js-product-cart').each(function() {

        const $elm = jQuery(this);

        const $quantityArrowMinus = $elm.find(".js-quantity-arrow-minus");

        const $quantityArrowPlus = $elm.find(".js-quantity-arrow-plus");

        const $quantityNum = $elm.find(".js-quantity-num");

        const $productPrice = $elm.find('.js-price');

        const $productClose = $elm.find('.js-close-product');

        const productPriceVal = Number($productPrice.text());







        function quantityMinus() {

            if ($quantityNum.val() > 1) {

                $quantityNum.val(+$quantityNum.val() - 1);

                $quantityNum.trigger("change");

                jQuery("[name='update_cart']").trigger("click");

            }

        }



        function quantityPlus() {

            $quantityNum.val(+$quantityNum.val() + 1);

            $quantityNum.trigger("change");

            jQuery("[name='update_cart']").trigger("click");

        }



        function productPrice() {

            let count = $quantityNum.val();



            newProductPriceVal = productPriceVal * count;



            $productPrice.text(newProductPriceVal.toFixed(2));

        }



        function deleteProductRow() {

            $elm.remove();



            if (jQuery('.js-product-cart').length == 0) {

                jQuery('.js-table-cart').append('<div class="attention__cart">The Cart is empty!</div>')

            }

        }



        $productClose.on('click', deleteProductRow);



        $quantityArrowMinus.on('click', function(event) {

            event.preventDefault();

            quantityMinus();

            productPrice();

        })



        $quantityArrowPlus.on('click', function(event) {

            event.preventDefault();

            quantityPlus();

            productPrice();

        })

    });

}

initCart()

jQuery(document.body).on('updated_cart_totals', function() {

    jQuery('.woocommerce-notices-wrapper').addClass('res_animation')

    setTimeout(function() {
        jQuery('.woocommerce-notices-wrapper').removeClass('res_animation')
    }, 100)

    initCart()

    jQuery('#coupon_code').on('change', function() {

        jQuery('button[name="apply_coupon"]').trigger("click");

    })

})





// quantiti func end



// form apply



jQuery('.js-form-apply').each(function() {

    const $elm = jQuery(this);

    const $input = $elm.find('input');





    function defaultForm() {

        $elm.removeClass('active');

    }



    function applyForm() {

        $elm.addClass('active');

    }



    $input.on('change', function() {

        if (jQuery(this).val().length > 0) {

            applyForm();

        } else {

            defaultForm();

        }

    })



})



// form apply end





// tab select 



function js_tab_head_init() {

    jQuery('.js-tab-head-box').on('click', '.js-tab-head', function(event) {

        // console.log('asd')

        event.preventDefault();



        const $tabHead = jQuery(this);

        const tabData = $tabHead.data('target');

        const $tabBody = jQuery(tabData);



        jQuery('#' + $tabHead.parent().attr('for')).prop('checked', true);

        jQuery('#' + $tabHead.parent().attr('for')).trigger('click')



        jQuery('.js-tab-head').removeClass('active');

        $tabHead.addClass('active');

        jQuery('.js-tab-body').slideUp(500);

        $tabBody.slideDown(500);

    });

}

js_tab_head_init()

// tab select end





// show number stat 



function showNumbersStat() {

    var show = true;

    var countbox = ".js-section-stat";

    jQuery(window).on("scroll load resize", function() {

        if (!show) return false;

        var w_top = jQuery(window).scrollTop();

        var e_top = jQuery(countbox).offset().top;

        var w_height = jQuery(window).height();

        var d_height = jQuery(document).height();

        var e_height = jQuery(countbox).outerHeight();

        if (w_top + 500 >= e_top || w_height + w_top == d_height || e_height + e_top < w_height) {

            jQuery('.js-stat-value').css('opacity', '1');

            jQuery('.js-stat-title').css('opacity', '0.1');

            jQuery('.js-stat-value').spincrement({

                thousandSeparator: "",

                duration: 3200

            });



            show = false;

        }

    });

}



// show number stat





// cart height func 



function setCartHeight() {

    const $cart = jQuery('.js-table-cart');

    let productsCount = jQuery('.js-product-cart').length;

    let productHeight = jQuery('.js-product-cart').innerHeight();

    $cart.css('min-height', productsCount * productHeight);

}





// cart height func end





// popup func



function showDarkOverlay() {

    jQuery('.js-dark-overlay').fadeIn(500);

    jQuery('body').addClass('fixed');

}



function hideDarkOverlay() {

    jQuery('.js-dark-overlay').fadeOut(500);

    jQuery('body').removeClass('fixed');

}



let dealFlag = false;



function openDealPopUp() {

    showDarkOverlay();

    jQuery('.js-popup-deal').show();

    dealFlag = true;

}



function hideDealPopUp() {

    hideDarkOverlay();

    jQuery('.js-popup-deal').hide();

    jQuery('.js-popup-deal-img').children().remove();

    jQuery('.js-popup-deal-info').children().remove();

    dealFlag = false;

}



function init_home_slider() {

    jQuery('.js-filter-body li').each(function() {

        const $elm = jQuery(this);

        const $image = $elm.find('.js-deals-img');

        const $innerContent = $elm.children();

        const $detailsBtn = $elm.find('.js-details');





        $detailsBtn.on('click', function(e) {

            e.preventDefault()

            let filterSection = jQuery('.js-section-deals').offset().top;

            openDealPopUp();

            $image.clone().appendTo(jQuery('.js-popup-deal-img'));

            $innerContent.clone().appendTo(jQuery('.js-popup-deal-info'));



            jQuery('html, body').animate({

                scrollTop: filterSection

            }, 0);

        });

    });

}



jQuery('.js-modal-deal-close').on('click', function() {

    hideDealPopUp();

});



jQuery(document).mouseup(function(e) {

    var div = jQuery(".js-popup-deal");

    if (!div.is(e.target) && div.has(e.target).length === 0) {

        hideDealPopUp();

    }

});



// popup func end



// ready functions



jQuery(document).ready(function() {


    const numItems = jQuery('.mega_menu_item').length;

    if (numItems > 4) {

        let windowWidth = jQuery(window).width();
        let isSlickInitialized = false;

        function initializeSlick() {
            jQuery('.mega_menu_list_js').slick({
                slidesToShow: 4,
                infinite: false,
                arrows: true,
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 1525,
                    settings: {
                        slidesToShow: 3
                    }
                }, ]
            });

            jQuery(window).resize();
            isSlickInitialized = true;
        }

        function destroySlick() {
            jQuery('.mega_menu_list').slick('unslick');
            isSlickInitialized = false;
        }

        function handleSlickInitialization() {
            if (windowWidth > 992 && !isSlickInitialized) {
                initializeSlick();
            } else if (windowWidth < 992 && isSlickInitialized) {
                destroySlick();
            }
        }

        // Визначення, чи треба ініціалізувати чи вимкнути слайдер при завантаженні
        handleSlickInitialization();

        // Реагування на зміну розміру вікна
        jQuery(window).resize(function() {
            var newWindowWidth = jQuery(window).width();

            if (windowWidth !== newWindowWidth) {
                windowWidth = newWindowWidth;
                handleSlickInitialization();
            }
        });

    }

    // jQuery('.dropdown').on('click', function() {

    //     if(jQuery(window).width() < 991) {

    //         jQuery(this).toggleClass('open');

    //     }

    // });





    var d = new Date();

    jQuery('.copyright').text(d.getFullYear());



    jQuery('select:not(.product_select)').niceSelect();



    jQuery(window).on('scroll', function() {

        jQuery('.js-circle').css('transform', 'translateX(-50%) rotate(' + rotateBg() / 10 + 'deg)')

    });





    jQuery('.js-review-slider').slick({

        infinite: true,

        slidesToShow: 3,

        slidesToScroll: 1,

        arrows: false,

        dots: false,

        autoplay: true,

        autoplaySpeed: 2000,

        responsive: [{



                breakpoint: 991,

                settings: {

                    slidesToShow: 2

                }

            },

            {

                breakpoint: 767,

                settings: {

                    slidesToShow: 1

                }

            }

        ]

    });



    if (jQuery('.js-section-stat').length > 0) {

        showNumbersStat();

    }



    initFilterSlick()





    //--------------------------------------------------



    jQuery('.js-filter-body').slick({

        infinite: true,

        slidesToShow: 4,

        slidesToScroll: 1,

        arrows: true,

        responsive: [

            {

                breakpoint: 991,

                settings: {

                    slidesToShow: 3

                }

            },

            {

                breakpoint: 767,

                settings: {

                    slidesToShow: 2,

                    arrows: false

                }

            },

            {

                breakpoint: 565,

                settings: {

                    slidesToShow: 1,

                    arrows: false

                }

            }

        ]

    })





    setCartHeight();





    jQuery(window).on('resize', function() {

        setCartHeight();

    });



    jQuery('select.product_select').each(function(i) {

        let select = jQuery(this),

            options = select.find('option'),

            container = '<ul>'



        options.each(function() {

            if (jQuery(this).val() != '') {

                checked = (jQuery(this).is(':checked')) ? 'checked="checked"' : '';

                container += `   <li>

                                        <label class="control">

                                            ${jQuery(this).val()}

                                            <input value="${jQuery(this).val()}" type="radio" name="product-radio-${i}" ${checked}/>

                                            <span class="control-indicator"></span>

                                        </label>

                                    </li>`

            }

        })

        container += '</ul>'

        select.after(container)

        jQuery('input[name="product-radio-' + i + '"]').change(function(e) {

            val = jQuery(this).val()

            slect_option = select.find('option[value="' + val + '"]')

            slect_option.prop("selected", true);

            slect_option.parent().change()

        });

    })

});





jQuery('.woocommerce').on('change', 'input.quantity__num ', function() {

    jQuery("[name='update_cart']").trigger("click");

});





jQuery('#coupon_code').on('change', function() {

    jQuery('button[name="apply_coupon"]').trigger("click");

})



jQuery('.paypal-buttons iframe').on('load', () => {

    let iframeHead = jQuery('.paypal-buttons iframe').contents().find('head');

    let iframeCSS = `<style>.paypal-button {

            border: 3px solid #098cec;

            background-color: transparent;

            padding: 13px 13px 11px;

            font-size: 18px;

        }</style>`;

    jQuery(iframeHead).append(iframeCSS);

});



const checkout_coupon_code_button = jQuery('#checkout_coupon_code_button'),

    checkout_coupon_code = jQuery('#checkout_coupon_code')



function initCheckOutDiscont() {

    let checkout_discount = jQuery('#checkout_discount'),

        checkout_discount_button = jQuery('.checkout_discount_button')





    if (checkout_discount.length) {

        let checkout_discount_val



        checkout_discount.on('input', function() {

            checkout_discount_val = jQuery(this).val()



            if (checkout_discount_val.length > 0 && !checkout_discount_button.hasClass('active')) {

                checkout_discount_button.addClass('active')

            }

            if (checkout_discount_val.length === 0 && checkout_discount_button.hasClass('active')) {

                checkout_discount_button.removeClass('active')

            }

            checkout_coupon_code.val(checkout_discount_val)

        })

        checkout_discount.on('keypress', function(e) {

            if (e.which == 13) {

                e.preventDefault();

                checkout_coupon_code_button.trigger('click')

            }

        });



        checkout_discount_button.click(function() {

            checkout_coupon_code_button.trigger('click')

        })

    }

}

initCheckOutDiscont()



jQuery(document.body).on('updated_checkout', function() {

    initCheckOutDiscont()

    js_tab_head_init()

});

// ready functions end





// currency



jQuery('.js-currency_select').on('change', function() {



    const currency = jQuery(this).val()



    var l = woocs_remove_link_param('currency', window.location.href);

    l = l.replace("#", "");



    if (woocs_special_ajax_mode) {

        var data = {

            action: "woocs_set_currency_ajax",

            currency: currency

        };



        jQuery.post(woocs_ajaxurl, data, function(value) {

            //location.reload();

            window.location = l;

        });

    } else {

        if (Object.keys(woocs_array_of_get).length === 0) {

            window.location = l + '?currency=' + currency;

        } else {

            woocs_redirect(currency);

        }

    }

});





// wc add option

jQuery(document).ready(function($) {

    jQuery('body').find('.cart:not(.cart_group)').on('updated_addons', function() {



        const price = jQuery(this).find('#product-addons-total .wc-pao-subtotal-line .amount')

        if (price.length && price.text() != '') {

            jQuery('.woocommerce-variation-add-to-cart .woocommerce-Price-amount bdi').html(price.text())

        }

    })

})





//--------------------------------------------



jQuery('.woocommerce-MyAccount-navigation-link a').on('click', function(e) {



    e.preventDefault()

    jQuery('.woocommerce-MyAccount-navigation-link').removeClass('is-active')

    jQuery(this).parents('.woocommerce-MyAccount-navigation-link').addClass('is-active')

    let el = jQuery(this).attr('href')

    jQuery('.profile_tab').addClass('hidden')

    jQuery(`${el}`).removeClass('hidden')



});



jQuery(window).on("scroll load resize", function() {

    // mobileAside()

})



function mobileAside() {

    if (jQuery(window).outerWidth() <= 991) {

        jQuery('.header_wow_versions').prependTo(jQuery('.header_aside'))

        jQuery('.header_acc').appendTo(jQuery('.header_aside'))

        jQuery('.header__logo').prependTo(jQuery('.header__inner'))

    } else {

        jQuery('.header_wow_versions').prependTo(jQuery('.header__inner'))

        jQuery('.header_acc').appendTo(jQuery('.header__inner'))

        jQuery('.header__logo').prependTo(jQuery('.header_menu_left'))

    }



}





let lastScrollTop = 0;

jQuery(window).scroll(function(event) {

    let st = jQuery(this).scrollTop();

    if (st > 0) {

        // downscroll code

        jQuery('.header_aside').addClass('js_header_aside')

    } else {

        // upscroll code

        jQuery('.header_aside').removeClass('js_header_aside')

    }

    //    lastScrollTop = st;

});



jQuery('.dropdown').each((i, e) => {



    const $el = jQuery(e)

    const $childLink = jQuery(e).children('a')

    const $sp = '<span class="after">+</span>'

    jQuery($sp).insertAfter($childLink)



})

jQuery(document).on('click', 'span.after', function() {





    console.log(jQuery(this).parents('.dropdown').hasClass('open'));



    if (jQuery(this).parents('.dropdown').hasClass('open')) {

        jQuery(this).parents('.dropdown').removeClass('open')

    } else {

        jQuery('span.after').parents('.dropdown').removeClass('open')

        jQuery(this).parents('.dropdown').addClass('open')

    }



});



var dup_start = [];

jQuery('.tab_item').each(function() {

    let prodid = jQuery(this).data('prodid');

    if (dup_start.includes(prodid))

    {

        jQuery(this).addClass('hidden');

    } else

        dup_start.push(jQuery(this).data('prodid'));

});


jQuery('.tab_title').on('click', function() {
    let selectedGames = [];

    let paginations = jQuery('.pagination.tab_item');
    let filter = jQuery(this).data('gamename');
    jQuery('.tab_title').removeClass('active')
    jQuery(this).addClass('active')
    if (paginations) {
        paginations.each(function(i) {
            let perPage = jQuery(this).attr('data-per-page');
            jQuery(this).attr('data-offset', perPage);
        });
    }
    if (filter == 'all'){

        let paginationAll = jQuery('.pagination.tab_item[data-game="all"]');
        let dup = [];

        jQuery('.tab_item').removeClass('hidden');

        jQuery('.tab_item').each(function(i) {

            if (paginationAll.length > 0) {
                let show_prod = paginationAll.attr('data-per-page');
                console.log(show_prod);
                jQuery('.js-tabs_wrap a.tab_item:nth-child(n+' + (parseInt(show_prod) + 1) + ')').addClass('hidden');

                jQuery('.pagination[data-game]:not([data-game="all"])').addClass('hidden');


            } else {

                let prodid = jQuery(this).data('prodid');

                if (dup.includes(prodid))

                {

                    jQuery(this).addClass('hidden');

                } else

                    dup.push(jQuery(this).data('prodid'));

            }

        });
        return

    }else{
        selectedGames = filter.split(',');
        
        // Перевірте кожен елемент і приховайте ті, які не належать до вибраних ігор
        jQuery('.tab_item').each(function(i) {
            let itemGames = jQuery(this).data('game').split(',');
            if (itemGames.some(game => selectedGames.includes(game))) {
                jQuery(this).removeClass('hidden');
            } else {
                jQuery(this).addClass('hidden');
            }
        });
    }
   
});



jQuery('.choose_game_link').on('click', function(event) {

    event.preventDefault();

    jQuery('html, body').animate({

        scrollTop: jQuery($.attr(this, 'href')).offset().top

    }, 1500);

});



// });