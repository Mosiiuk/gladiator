jQuery(document).ready(function($) {
    // burger menu func

    const $headerNav = $('.js-header-nav');
    const $burger = $('.js-burger');
    const $body = $('body');

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
        $body.addClass('fixed');
    }

    function closeBurgerMenu() {
        $headerNav.removeClass('active');
        $burger.removeClass('active');
        $body.removeClass('fixed');
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
        let scrollOfset = $(window).scrollTop();

        return scrollOfset;
    }

    // rotate effect and scroll end  


    // filter func



    const best_deals_element = $('.js-filter-body-element')
    let filter_buttons = $('.js-filter-head').append($('<li class="active"><a href="#" data-filter="all">All</a></li>'))
    let filter_buttons_set = new Array()
    let filter_Body = $('.js-filter-body')

    best_deals_element.each(function() {
        filter_buttons_set.push($(this).data('category'))
    });
    filter_buttons_set = new Set(filter_buttons_set)

    for (let category of filter_buttons_set) {
        filter_buttons.append($(`<li><a href="#" data-filter="${category}">${category}</a></li>`))
    }

    function initFilterSlick() {
        filter_Body.slick(slickFilterParams)
        init_home_slider()
    }

    filter_buttons.find('a').on('click', function(event) {
        event.preventDefault();

        let category = $(this).data('filter');

        $('.js-filter-head li').removeClass('active');
        $(this).parents().addClass('active');

        filter_Body.animate({ opacity: '0' }, 200);

        setTimeout(function() {
            filter_Body.slick('unslick');

            if (category == 'all') {
                filter_Body.html(best_deals_element)
            } else {
                filter_Body.html(best_deals_element.filter(`[data-category="${category}"]`))
            }
            initFilterSlick()
            setTimeout(function() {
                filter_Body.animate({ opacity: '1' }, 200);
            }, 300)

        }, 200)



    })



    // filter func end


    // quantiti func
    function initCart() {
        $('.js-product-cart').each(function() {
            const $elm = $(this);
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
                    $("[name='update_cart']").trigger("click");
                }
            }

            function quantityPlus() {
                $quantityNum.val(+$quantityNum.val() + 1);
                $quantityNum.trigger("change");
                $("[name='update_cart']").trigger("click");
            }

            function productPrice() {
                let count = $quantityNum.val();

                newProductPriceVal = productPriceVal * count;

                $productPrice.text(newProductPriceVal.toFixed(2));
            }

            function deleteProductRow() {
                $elm.remove();

                if ($('.js-product-cart').length == 0) {
                    $('.js-table-cart').append('<div class="attention__cart">The Cart is empty!</div>')
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
    $(document.body).on('updated_cart_totals', function() {
        $('.woocommerce-notices-wrapper').addClass('res_animation')
        setTimeout(function() { $('.woocommerce-notices-wrapper').removeClass('res_animation') }, 100)
        initCart()
        $('#coupon_code').on('change', function() {
            $('button[name="apply_coupon"]').trigger("click");
        })
    })


    // quantiti func end

    // form apply

    $('.js-form-apply').each(function() {
        const $elm = $(this);
        const $input = $elm.find('input');


        function defaultForm() {
            $elm.removeClass('active');
        }

        function applyForm() {
            $elm.addClass('active');
        }

        $input.on('change', function() {
            if ($(this).val().length > 0) {
                applyForm();
            } else {
                defaultForm();
            }
        })

    })





    // form apply end


    // tab select 

    function js_tab_head_init() {
        $('.js-tab-head-box').on('click', '.js-tab-head', function(event) {
            // console.log('asd')
            event.preventDefault();

            const $tabHead = $(this);
            const tabData = $tabHead.data('target');
            const $tabBody = $(tabData);

            $('#' + $tabHead.parent().attr('for')).prop('checked', true);
            $('#' + $tabHead.parent().attr('for')).trigger('click')

            $('.js-tab-head').removeClass('active');
            $tabHead.addClass('active');
            $('.js-tab-body').slideUp(500);
            $tabBody.slideDown(500);
        });
    }
    js_tab_head_init()
        // tab select end


    // show number stat 

    function showNumbersStat() {
        var show = true;
        var countbox = ".js-section-stat";
        $(window).on("scroll load resize", function() {
            if (!show) return false;
            var w_top = $(window).scrollTop();
            var e_top = $(countbox).offset().top;
            var w_height = $(window).height();
            var d_height = $(document).height();
            var e_height = $(countbox).outerHeight();
            if (w_top + 500 >= e_top || w_height + w_top == d_height || e_height + e_top < w_height) {
                $('.js-stat-value').css('opacity', '1');
                $('.js-stat-title').css('opacity', '0.1');
                $('.js-stat-value').spincrement({
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
        const $cart = $('.js-table-cart');
        let productsCount = $('.js-product-cart').length;
        let productHeight = $('.js-product-cart').innerHeight();
        $cart.css('min-height', productsCount * productHeight);
    }


    // cart height func end


    // popup func

    function showDarkOverlay() {
        $('.js-dark-overlay').fadeIn(500);
        $('body').addClass('fixed');
    }

    function hideDarkOverlay() {
        $('.js-dark-overlay').fadeOut(500);
        $('body').removeClass('fixed');
    }

    let dealFlag = false;

    function openDealPopUp() {
        showDarkOverlay();
        $('.js-popup-deal').show();
        dealFlag = true;
    }

    function hideDealPopUp() {
        hideDarkOverlay();
        $('.js-popup-deal').hide();
        $('.js-popup-deal-img').children().remove();
        $('.js-popup-deal-info').children().remove();
        dealFlag = false;
    }

    function init_home_slider() {
        $('.js-filter-body li').each(function() {
            const $elm = $(this);
            const $image = $elm.find('.js-deals-img');
            const $innerContent = $elm.children();
            const $detailsBtn = $elm.find('.js-details');


            $detailsBtn.on('click', function(e) {
                e.preventDefault()
                let filterSection = $('.js-section-deals').offset().top;
                openDealPopUp();
                $image.clone().appendTo($('.js-popup-deal-img'));
                $innerContent.clone().appendTo($('.js-popup-deal-info'));

                $('html, body').animate({
                    scrollTop: filterSection
                }, 0);
            });
        });
    }

    $('.js-modal-deal-close').on('click', function() {
        hideDealPopUp();
    });

    $(document).mouseup(function(e) {
        var div = $(".js-popup-deal");
        if (!div.is(e.target) && div.has(e.target).length === 0) {
            hideDealPopUp();
        }
    });

    // popup func end

    // ready functions

    $(document).ready(function() {

        $('.dropdown').on('click', function() {
            if($(window).width() < 991) {
                $(this).toggleClass('open');
            }
        });

        
        var d = new Date();
        $('.copyright').text(d.getFullYear());

        $('select:not(.product_select)').niceSelect();

        $(window).on('scroll', function() {
            $('.js-circle').css('transform', 'translateX(-50%) rotate(' + rotateBg() / 10 + 'deg)')
        });


        $('.js-review-slider').slick({
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

        if ($('.js-section-stat').length > 0) {
            showNumbersStat();
        }

        initFilterSlick()


        setCartHeight();


        $(window).on('resize', function() {
            setCartHeight();
        });

        $('select.product_select').each(function(i) {
            let select = $(this),
                options = select.find('option'),
                container = '<ul>'

            options.each(function() {
                if ($(this).val() != '') {
                    checked = ($(this).is(':checked')) ? 'checked="checked"' : '';
                    container += `   <li>
                                        <label class="control">
                                            ${$(this).val()}
                                            <input value="${$(this).val()}" type="radio" name="product-radio-${i}" ${checked}/>
                                            <span class="control-indicator"></span>
                                        </label>
                                    </li>`
                }
            })
            container += '</ul>'
            select.after(container)
            $('input[name="product-radio-' + i + '"]').change(function(e) {
                val = $(this).val()
                slect_option = select.find('option[value="' + val + '"]')
                slect_option.prop("selected", true);
                slect_option.parent().change()
            });
        })
    });


    $('.woocommerce').on('change', 'input.quantity__num ', function() {
        $("[name='update_cart']").trigger("click");
    });


    $('#coupon_code').on('change', function() {
        $('button[name="apply_coupon"]').trigger("click");
    })

    $('.paypal-buttons iframe').on('load', () => {
        let iframeHead = $('.paypal-buttons iframe').contents().find('head');
        let iframeCSS = `<style>.paypal-button {
            border: 3px solid #098cec;
            background-color: transparent;
            padding: 13px 13px 11px;
            font-size: 18px;
        }</style>`;
        $(iframeHead).append(iframeCSS);
    });

    const checkout_coupon_code_button = $('#checkout_coupon_code_button'),
        checkout_coupon_code = $('#checkout_coupon_code')

    function initCheckOutDiscont() {
        let checkout_discount = $('#checkout_discount'),
            checkout_discount_button = $('.checkout_discount_button')


        if (checkout_discount.length) {
            let checkout_discount_val

            checkout_discount.on('input', function() {
                checkout_discount_val = $(this).val()

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

    $(document.body).on('updated_checkout', function() {
        initCheckOutDiscont()
        js_tab_head_init()
    });
    // ready functions end


    // currency

    jQuery('.js-currency_select').on('change', function () {

        const currency = jQuery(this).val()

        var l = woocs_remove_link_param('currency', window.location.href);
        l = l.replace("#", "");

        if (woocs_special_ajax_mode) {
            var data = {
                action: "woocs_set_currency_ajax",
                currency: currency
            };

            jQuery.post(woocs_ajaxurl, data, function (value) {
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
})

// wc add option
jQuery(document).ready(function($) {
    jQuery('body').find('.cart:not(.cart_group)').on('updated_addons', function(){

        const price = $(this).find('#product-addons-total .wc-pao-subtotal-line .amount')
        if(price.length && price.text() != '' ){
            $('.woocommerce-variation-add-to-cart .woocommerce-Price-amount bdi').html(price.text())
        }
    })
})