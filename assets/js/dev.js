jQuery(document).ready(function ($) {
  console.log("DEV JS OK 2024");

  //----------- 2025 -----

  $('.pay_cart_btn').click(function(e) {
    let input_pay_gbcoin = parseFloat($('#pay_gbcoin').val()) || 0;
    let cart_total_gbcoin = parseFloat($('#cart_total_gbcoin').val()) || 0;
    let user_gbcoin = parseFloat(GladiatorInfo.user_gbcoin) || 0;

    input_pay_gbcoin = input_pay_gbcoin.toFixed(2);

    if (input_pay_gbcoin > 0) {
      console.log(input_pay_gbcoin);

      if (user_gbcoin < cart_total_gbcoin) {
        alert('Your GBcoin balance is less than the amount.');
        e.preventDefault();
        return;
      }

      if (input_pay_gbcoin > cart_total_gbcoin) {
        $('#pay_gbcoin').val(cart_total_gbcoin);
      }

      if (input_pay_gbcoin < cart_total_gbcoin) {
        $('#pay_gbcoin').val(cart_total_gbcoin);
      }

      var data = {
        action: 'input_pay_gbcoin',
        input_pay_gbcoin: input_pay_gbcoin,
      };

      $.ajax({
        url: ajaxurl.url,
        type: 'POST',
        data: data,
        async: false,
        success: function(response) {
          console.log('' + response);
        },
        error: function(xhr, status, error) {
          console.log('' + error);
        }
      });

      $('#form_minicart').submit();
    }
  });



  const money_prod_min = $('#money_prod_min').val();
  const money_prod_max = $('#money_prod_max').val();
/*
  const money_price_per = parseFloat($('#money_price_per').val());
  const money_per_quantity = parseFloat($('#money_per_quantity').val());
*/
  const money_price_per = parseFloat($('input[name="server"]:checked').data('cost'));
  const money_per_quantity = parseFloat($('input[name="server"]:checked').data('qty'));

  //--------- OM LOAD MONEY PRODUCT ------------
  var money_price=0;
  var money_price_not_convert=0;

  if (
      money_prod_min != null &&
      typeof money_prod_min !== 'undefined' &&
      money_prod_max != null &&
      typeof money_prod_max !== 'undefined'
  )
  {
    var money_item_sel = $('input[name="money_item"]:checked').val();
    var money_item_sel_unit = $('input[name="money_item"]:checked').data('unit');
    var money_server_sel = $('input[name="server"]:checked').val();

    $('.gold_total_item_amount').html(money_item_sel);
    $('.gold_unit').html(money_item_sel_unit);
    $('#select_server').html(money_server_sel);

    if (parseFloat(money_price_per)>0 && parseFloat(money_per_quantity)>0)
    {
      let per_qtny_price = money_price_per/money_per_quantity;
      let summ = per_qtny_price*money_item_sel;

      $('#gold_total_summ').html(summ.toFixed(2));
      $('#gold_total_summ_cart').html(summ.toFixed(2));

      calc_summ_money_prod(money_item_sel,money_item_sel_unit);

      $('#gold_custom_amount_value').val(money_item_sel);

      $('.gold_total_item_amount').html(money_item_sel);
      $('.gold_unit').html(money_item_sel_unit);
    }

  }
  //--------- /OM LOAD MONEY PRODUCT ------------

  //---------------------money product----------------------------------

  $('#mon_prod_start_chat').click(function(e){
    e.preventDefault();
    if (Tawk_API.toggle) {
      Tawk_API.toggle();
    }
  });


  function calc_summ_money_prod(qtn=0,unit='')
  {
    let money_price_per = parseFloat($('input[name="server"]:checked').data('cost'));
    let money_price_per_notconvert = parseFloat($('input[name="server"]:checked').data('not_convert'));
    let money_per_quantity = parseFloat($('input[name="server"]:checked').data('qty'));

    let per_qtny_price = money_price_per/money_per_quantity;
    let per_qtny_price_noconvert = money_price_per_notconvert/money_per_quantity;


    let summ = per_qtny_price*qtn;
    let summ_not_convert = per_qtny_price_noconvert*qtn;

    $('#gold_total_summ').html(summ.toFixed(2));
    $('#gold_total_summ_cart').html(summ.toFixed(2));

    $('#gold_custom_amount_value').val(qtn);
    $('.gold_total_item_amount').html(qtn);

    money_price = summ.toFixed(2);
    money_price_not_convert = summ_not_convert.toFixed(2);

    if (unit) {
      $('.gold_unit').html(unit);
    }
  }

  $('.money_server_act').on('change',function(){
    let val = $(this).val();
    $('#select_server').html(val);

    let qtn = parseInt($('input[name="money_item"]:checked').val());
    let unit = parseInt($('input[name="money_item"]:checked').data('unit'));

    calc_summ_money_prod(qtn,unit);

  });

  $('.money_item_act').on('change',function(){
    let qtn = parseFloat($(this).val());
    let name = $(this).data('name');
    let unit = $(this).data('unit');

    if (money_price_per>0 && qtn>0 && money_per_quantity>0)
    {
      calc_summ_money_prod(qtn,unit);
    }

  });

  $('#gold_custom_amount_value').on('change',function(){
    let input_qtn = parseInt($(this).val());

    if (input_qtn>0)
    {
      calc_summ_money_prod(input_qtn,'');
    }
  });

  $('#gold_custom_amount_value').on('keyup',function(){
    let input_qtn = parseInt($(this).val());

    if (input_qtn>0)
    {
      calc_summ_money_prod(input_qtn,'');
    }
  });

  $(".gold_custom_amount_plus, .gold_custom_amount_minus").click(function () {
    let radios = $(".money_item_act");
    let checked = radios.filter(":checked");
    let index = radios.index(checked);
    let nextIndex = $(this).hasClass("gold_custom_amount_plus") ? (index + 1) % radios.length : (index - 1 + radios.length) % radios.length;
    radios.eq(nextIndex).prop("checked", true).trigger("change");
  });

  $('#money_prod_buy').click(function(){
      let prod_id = $(this).data('prod_id');
      let money_qtn = parseInt($('#gold_custom_amount_value').val());
      let server = $('input[name="server"]:checked').val();
      let unit = $('input[name="money_item"]:checked').data('unit');

      if (money_qtn < parseFloat(money_prod_min) )
      {
        alert('Minimum '+ money_prod_min+unit);
        return false;
      }

      if (money_qtn > parseFloat(money_prod_max) )
      {
        alert('Maximum '+ money_prod_max+unit);
        return false;
      }

      let data={
        action:'act_money_prod_buy',
        prod_id:prod_id,
        money_qtn:money_qtn,
        server:server,
        unit:unit,
        money_price:money_price,
        money_price_not_convert:money_price_not_convert,
      };

      jQuery.ajax({
        type: "POST",
        url: ajaxurl.url,
        data: data,
        success: function (data) {
          refreshMiniCart(true);
        },
      });

  });
  //---------------------/money product----------------------------------

  function openMiniCart() {
    const $cartWrapper = $('.checkout__wrapper');
    const $cartButton = $('.btn__cart');

    if (!$cartWrapper.length) {
      return;
    }

    $cartWrapper
      .stop(true, true)
      .css({
        display: 'block',
        zIndex: 30,
      })
      .slideDown()
      .addClass('open');

    $cartButton.addClass('active');
  }

  function refreshMiniCart(openAfterRefresh) {
    $.get(window.location.href, function(response) {
      const $response = $('<div>').append($.parseHTML(response));
      const minicartHtml = $response.find('#form_minicart').html();
      const cartCountHtml = $response.find('.btn__cart .b-count').html();

      if (typeof minicartHtml !== 'undefined') {
        $('#form_minicart').html(minicartHtml);
      }

      if (typeof cartCountHtml !== 'undefined') {
        $('.btn__cart .b-count').html(cartCountHtml);
      }

      if (openAfterRefresh) {
        openMiniCart();
      }
    }).fail(function() {
      if (openAfterRefresh) {
        openMiniCart();
      }
    });
  }



  $('#prod_cat_show_chat').click(function (e) {
    e.preventDefault();
    if (Tawk_API.toggle) {
      Tawk_API.toggle();
    }
  });

  $("#home_search_ext").on("keyup", function() {
      let value = $(this).val();
      console.log(value);

      let data=
      {
        action:'home_search_ext',
        game_name:value,
      };

      jQuery.ajax({
        type: "POST",
        url: ajaxurl.url,
        data: data,
        success: function (data) {
          let obj = jQuery.parseJSON(data);

          $('#home_search_ext_result').show();
          $('#home_search_ext_result').html(obj.html);
        },
      });

  });

  $("#header_search_game").on("keyup", function() {
    let value = $(this).val().toLowerCase();
    $("#pills-tab-game li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().includes(value));
    });
  });

  $("#pills-tab-game li").click(function () {
    $("#header_search_game_cat").val('');
  });

  $("#header_search_game_cat").on("keyup", function() {
    let value = $(this).val().toLowerCase();
    $(".tab-pane.active ul.list_subcat li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().includes(value));
    });
  });


  let itemsToShow = 10;
  let totalItems = $(".home_all_list_game").length;

  $(".home_all_list_game").hide();
  $(".home_all_list_game:lt(" + itemsToShow + ")").show();

  $('#home_all_list_game_btn').click(function(e) {
    e.preventDefault();
    itemsToShow += 10;
    $(".home_all_list_game:lt(" + itemsToShow + ")").fadeIn();

    if (itemsToShow >= totalItems) {
      $(this).hide();
    }
  });

  //----------- /2025 ----


  //------------ 2024 ---------
/*const $gold_total_item_amount = $('.gold_total_item_amount')
  $('label.control input[type="radio"]').on('click', function() {
    let selectedValue = $(this).val();
    $('.gold_custom_amount_value input').val(selectedValue);
    $gold_total_item_amount.text(selectedValue)
  });
    $('.gold_custom_amount_count').on('click', function() {
      let $input = $(this).siblings('.gold_custom_amount_value').find('input');
      let currentValue = parseInt($input.val(), 10);
      let step = parseInt($input.attr('step') || 1, 10);
      let isPlus = $(this).hasClass('gold_custom_amount_plus');

      if (isPlus) {
        $input.val(currentValue + step);
        $gold_total_item_amount.text(currentValue + step)
      } else if (currentValue - step >= step) {
        $input.val(currentValue - step);
        $gold_total_item_amount.text(currentValue - step)
      }

    });
*/


  $('.js-tab-body').each(function() {
    if ($(this).height() < 1100) {
      $(this).find('.read_more_text').css('display', 'none');
    }
  });
  $('.read_more_text').on('click', function() {
    $(this).closest('.js-tab-body').addClass('active');
    $(this).hide()
  });
  $('.btn_show_more').on('click', function(event) {
    event.preventDefault();

    // Перевіряємо, чи кнопка має клас 'not_showed'
    if ($(this).hasClass('not_showed')) {
      $(this).removeClass('not_showed').addClass('showed').text('Show less');
      $('.footer__games ul').addClass('show');
    } else {
      $(this).removeClass('showed').addClass('not_showed').text('Show more');
      $('.footer__games ul').removeClass('show');
    }
  });


  if($('.thx_logo_wrap').length > 0){
    $('.thx_logo_wrap svg').addClass('active')
  }

  $(document).on('click','#apply_coupon',function(e){
      e.preventDefault();
      let coupon_code = $('#coupon_code').val();
      let data={
        action:'set_coupon_code',
        coupon_code:coupon_code,
      };
      jQuery.ajax({
        type: "POST",
        url: ajaxurl.url,
        data: data,
        success: function (data) {
          let obj = jQuery.parseJSON(data);
          $('#form_minicart').html(obj.html);
        },
      });
  });

  $(document).on('click','#cancel_coupon',function(e){
    e.preventDefault();
    let coupon_code = $('#coupon_code').val();
    let data={
      action:'cancel_coupon_code',
      coupon_code:coupon_code,
    };
    jQuery.ajax({
      type: "POST",
      url: ajaxurl.url,
      data: data,
      success: function (data) {
        let obj = jQuery.parseJSON(data);
        $('#form_minicart').html(obj.html);
      },
    });
  });

  $(document).on('click','.mini_cart_remove_prod',function(e){
    e.preventDefault();
    let item_key = $(this).data('item_key');
    let data={
      action:'remove_prod',
      key:item_key,
    };
    jQuery.ajax({
      type: "POST",
      url: ajaxurl.url,
      data: data,
      success: function (data) {
        let obj = jQuery.parseJSON(data);
        $('#form_minicart').html(obj.html);
      },
    });
  });

  $(document).on('click','.woocommerce-form-coupon-toggle',function(e){
    $(".checkout_coupon").addClass('open');
  });

  if ($('.mobile_currency').length)
  {
    let symb = $('.js-currency_select option:selected').data('symbol');
    $('.mobile_currency').html(symb);
  }

  jQuery('.js-currency_select').on('change', function() {
    const currency = jQuery(this).val();
    let symb = $('option:selected', this).data('symbol');
    $('.mobile_currency').html(symb);
    var l = woocs_remove_link_param('currency', window.location.href);
    l = l.replace("#", "");
    if (woocs_special_ajax_mode) {
      var data = {
        action: "woocs_set_currency_ajax",
        currency: currency
      };
      jQuery.post(woocs_ajaxurl, data, function(value) {
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

  jQuery('[data-gamename="all"]').click();

  /*$('.single_add_to_cart_button').off('click');
  $('.single_add_to_cart_button').click(function (e) {
    e.preventDefault();
  });*/

  if (localStorage.getItem('show_minicart') === 'true') {
    openMiniCart();
    localStorage.removeItem('show_minicart');
  }

  $('#user_pass_confirm_reg').attr('placeholder','Confirm Password');

  $('form.variations_form').submit(function(e){
    e.preventDefault();
    let start = $('.single_add_to_cart_button').text();
    let url = $(this).attr('action');
    $.ajax({
      url: url,
      method: 'POST',
      data: $(this).serialize(),
      beforeSend: function() {
        $('.single_add_to_cart_button').text('Process...');
        $('.single_add_to_cart_button').attr('disabled',true);
      },
      success: function(response){
       // $('.single_add_to_cart_button').text(start);
        localStorage.setItem('show_minicart', 'true');
        location.reload();
      },
      error: function(xhr, status, error){
        console.error(error);
      }
    });
  });

  $('.start_chat').click(function () {
    if (Tawk_API) {
      Tawk_API.maximize();
    }
  });


  //----------------------------------------------------

function buy_now(){
  console.log(1);
  if($(window).outerWidth() < 993){
    $('.modile_title_item').appendTo($('.modile_title'))
  }
  else{
    $('.modile_title_item').prependTo($('.modile_title_wrap'))
  }
}
buy_now();
$( window ).on( "resize", buy_now);

  const tabs_items_wrap_opt = {
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1600,
        settings: {
          slidesToShow: 3,
        },
      },

      {
        breakpoint: 1320,
        settings: {
          slidesToShow: 2,
        },
      },

      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  };


  if ($(".home").length > 0) {
    $(".tabs_items_wrap").slick(tabs_items_wrap_opt);
  }

  $(".tab_get_products").on("click", function () {
    if ($(".tabs_items_wrap.slick-initialized").length == 0) {
      $(".tabs_items_wrap").slick(tabs_items_wrap_opt);
    }

    let term_slug = $(this).data("gamename");

    if (term_slug == "all") {
      $(".offer__item").removeClass("hidden");

      $(".tabs_items_wrap").slick("slickUnfilter");

      $(".tabs_items_wrap").slick("refresh");
    } else {
      $(".offer__item").removeClass("hidden");

      $(".tabs_items_wrap").slick("slickUnfilter");

      const selector = '.offer__item[data-game="' + term_slug + '"]';

      if ($(selector).length > 4) {
        $(".tabs_items_wrap").slick("slickFilter", selector);

        $(".tabs_items_wrap").slick("refresh");
      } else {
        $(".tabs_items_wrap").slick("unslick");

        $(".offer__item").addClass("hidden");

        $('.offer__item[data-game="' + term_slug + '"]').removeClass("hidden");
      }
    }
  });

  $("#loginform").submit(function (event) {

    event.preventDefault();

    let enable_on_sign_ups=false;
    let google_recaptcha_v2='';
    let valid=true;

    let user_login = $("#user_login_reg").val();

    let user_email = $("#user_email_reg").val();

    let user_pass = $("#user_pass_reg").val();

    let user_pass_confirm = $("#user_pass_confirm_reg").val();

    $(".register_error").hide();

    $(".register_error").html("");

    if (user_login == "") {
      $("#user_login_reg").focus();

      $(".register_error").show();

      $(".register_error").html("Login empty");

      return false;
    }

    if (user_email == "") {
      $("#user_email_reg").focus();

      $(".register_error").show();

      $(".register_error").html("E-Mail empty");

      return false;
    }

    if (user_pass == "") {
      $("#user_pass_reg").focus();

      $(".register_error").show();

      $(".register_error").html("Password empty");

      return false;
    }

    if (user_pass_confirm == "") {
      $("#user_pass_confirm_reg").focus();

      $(".register_error").show();

      $(".register_error").html("Password confirm empty");

      return false;
    }

    if (user_pass_confirm != user_pass) {
      $("#user_pass_confirm_reg").focus();

      $(".register_error").show();

      $(".register_error").html("Passwords do not match");

      return false;
    }

    /*if (!$("#agree_reg").is(":checked")) {
      $("#agree_reg").focus();

      $(".register_error").show();

      $(".register_error").html(
        "Check a accept Privacy Policy and Terms of Service"
      );

      return false;
    }*/

    if (typeof GladiatorInfo !== "undefined" && typeof GladiatorInfo.recaptcha !== "undefined")
    {
      enable_on_sign_ups = GladiatorInfo.recaptcha.enable_on_sign_ups;
      google_recaptcha_v2 = GladiatorInfo.recaptcha.google_recaptcha_v2;

      if (enable_on_sign_ups===true && google_recaptcha_v2!="")
      {
        valid=false;

        let recaptchaResponse = grecaptcha.getResponse();

        if(recaptchaResponse.length == 0)
        {
          valid=false;
          alert('Please confirm that you are not a robot.');
          return false;
        }

        let data = {
          action: "custom_register_recaptcha",
          recaptcha_response: $('#g-recaptcha-response').val(),
        };

        jQuery.ajax({
          type: "POST",
          url: ajaxurl.url,
          data: data,
          async:false,
          success: function (data) {
            let obj = jQuery.parseJSON(data);

            if (parseInt(obj.valid)==0)
            {
              valid=false;
            }
            else
            {
              valid=true;
            }
          },
        });


      }
    }


    if (valid)
    {
      let data = {
        action: "custom_register",
        user_login: user_login,
        user_email: user_email,
        user_pass: user_pass,
        recaptcha_response: $('#g-recaptcha-response').val(),
      };

      jQuery.ajax({
        type: "POST",
        url: ajaxurl.url,
        data: data,
        success: function (data) {
          let obj = jQuery.parseJSON(data);

          if (obj.username_exists) {
            $(".register_error").show();

            $(".register_error").html("This login is already in use");
          }

          if (obj.email_exists) {
            $(".register_error").show();

            $(".register_error").html("This E-Mail is already in use");
          }

          if (obj.error != "") {
            $(".register_error").show();

            $(".register_error").html(obj.error);
          }

          if (obj.reg == true) {
            $(".register_success").show();

            $(".register_success").html("Registration successful. <span id='js_log_in' style='color:#098cec; font-weight: bold; cursor:pointer; padding:10px; font-size:15pt;' >Log in</span>");

            $("#user_login").val(user_login);

            /* setTimeout(function () {
               $('[data-target="#signInModal"]').click();
             }, 6000);*/
          }
        },
      });
    }

    return false;
  });

  $(document).on('click','#js_log_in',function(){
    $('[data-target="#signInModal"]').click();
  });

  $(".scroll_to_game").click(function () {
    $([document.documentElement, document.body]).animate(
      {
        scrollTop: $("#section-deals").offset().top,
      },

      800
    );

    return false;
  });
let tr = true;
  $(".header_games_menu").on("click", (e) => {
if(tr == true){

  setTimeout(() => {
    $('.mega_menu_list_js').slick('setPosition')
    tr = false;
  }, 200);
}


    $(".header_games_menu").toggleClass("active");

    $(".mega_menu_wrap").toggleClass("d-none");
  });

  $(".search-input:not(.home_search_ext)").on("click", () => {
    if (typeof yourFunctionName === 'closeBurgerMenu') {
      closeBurgerMenu();
    }
  });

  $(document).on("input", '.search-input', function (event) {
    if ($(event.target).closest(".search-input, .result-search").length > 0) {
      $(".result-search").css("transform", "none");
    } else {
      $(".result-search").css("transform", "translateY(-200%)");
    }
  });
  $(document).on("click", function (event) {

    if (event.target != document.querySelector('.search-input') ||
    !event.target.closest('.result-search')) {
      $(".result-search").css("transform", "translateY(-200%)");
    } 
  });

  $(".hero_slider_wrap").slick({
    dots: true,

    infinite: false,

    speed: 300,

    slidesToShow: 1,

    slidesToScroll: 1,
  });

  let range_result = document.getElementById("range_result");

  if (range_result) {
  let first_value = document.getElementById("min-value");

  let second_value = document.getElementById("max-value");

 let valuesToArray = $('#min-value').data('steps')
 
 const stepsArray = valuesToArray.split(',').map(Number);

const steps_value = {};


const stepVal =  Math.floor(100 / stepsArray.length )

let nu = stepVal
for (let i = 1; i < stepsArray.length; i++) {
  steps_value[`${nu}%`] = stepsArray[i];
  nu = nu + stepVal
}

steps_value['min'] = +first_value.getAttribute("data-min");
steps_value['max'] = +second_value.getAttribute("data-max");


    let range_min = +first_value.getAttribute("data-min");

    let range_max = +second_value.getAttribute("data-max");
    noUiSlider.create(range_result, {
      start: [range_min, range_max],
      connect: true,
      format: {
        to: function (value) {
          return Math.round(value);
        },
        from: function (value) {
          return value;
        },
      },
      range: steps_value,
    snap: true,
    });

    range_result.noUiSlider.on("update", function (values, handle) {

      let minMaxvaluesToArray = $('#max-value').data('steps')

      const minMaxStepsArray = minMaxvaluesToArray.split(',').map(Number);

      const minMax = minMaxStepsArray[0]

      if(handle === 1) {
        if(values[handle] < minMax) {
          range_result.noUiSlider.set([null, minMax]);
        }
        second_value.value = values[1];
        $(document).find("select#desired-level").val(values[1]).change();
      }
      if (handle == 0) {
        first_value.value = values[0];

        $(document).find("select#current-level").val(values[0]).change();
      }
      else {

        if(values[handle] < minMax) {
          range_result.noUiSlider.set([null, minMax]);
          return
        }
        second_value.value = values[1];

        $(document).find("select#desired-level").val(values[1]).change();
      }
    });

    first_value.addEventListener("change", function () {
      range_result.noUiSlider.set([this.value, null]);

      $(document).find("select#current-level").val(this.value).change();
    });

    second_value.addEventListener("change", function () {
      range_result.noUiSlider.set([null, this.value]);

      $(document).find("select#desired-level").val(this.value).change();
    });
  }

  $(".product_slider").slick({
    infinite: true,

    slidesToShow: 3,

    slidesToScroll: 1,

    appendArrows: $(".product_slider_arrows"),
  });

  //----- SEARCH TOP INPUT ----
  let s_game = "";
  $(".search-input:not(.home_search_ext)").keyup(function () {
    if ($.trim($(this).val()) != s_game) {
      s_game = $.trim($(this).val());

      if (s_game.length > 2) {
        $.ajax({
          url: ajaxurl.url,
          type: "POST",
          data: {
            action: "search_games",
            search: s_game,
          },

          beforeSend: function () {
            $(".result-search .result-search-list").fadeOut();
            $(".result-search .result-search-list").empty();
            $(".result-search .preloader").show();
          },

          success: function (result) {
            $(".result-search .preloader").hide();
            $(".result-search .result-search-list").fadeIn().html(result);
          },
        });
      }
    }
  });
  //----- /SEARCH TOP INPUT ----

  $(".cart_options_item label .promocode").on("click", function () {
    $(".cart_options_item .woocommerce-input-wrapper").toggle();
  });

  
      $(document).on('click', '.pagination.tab_item[data-game="all"]', function(e) {

        showOnlyWhatINeed($(this));

    });


    var lm_total_pages=1;
    var lm_page=1;
    $(document).on('click', '.pagination.tab_item:not([data-game="all"])', function(e) {

        let el = $(this);
        let id = el.attr('data-id');
        let game = el.attr('data-game');
        let per_page = el.attr('data-per-page');
        let offset = el.attr('data-offset');
        lm_total_pages = parseInt(el.data('total_pages'));

        lm_page++;

        $.ajax({
            url: ajaxurl.url,

            type: "POST",
            data: {
                action: "load_more_prod",
                id: id,
                game: game,
                per_page: per_page,
                offset: offset,
                paged: lm_page,
            },

            beforeSend: function() {
               // el.fadeOut();
                el.hide();
                $(".if_js-tabs_wrap .preloader").show();
            },

            success: function(result) {

                $(".if_js-tabs_wrap .preloader").hide();
                let obj = jQuery.parseJSON(result);
                $(".if_js-tabs_wrap .js-tabs_wrap").append(obj.html.value);

                lm_total_pages = parseInt(obj.max_num_pages);

                if (lm_page>=lm_total_pages)
                {
                  el.hide();
                }
                else
                {
                  el.show();
                  el.css('display','block');
                }
               // el.show();
                if(obj.data === false){
                    //el.attr('data-offset', (parseInt(offset)+parseInt(per_page)));
                   /* el.show();
                    el.css('display','block');*/
                 }
                
            }
        });


    });

    function showOnlyWhatINeed(el) {
        let gamename = $('.button-container .tab_title.active').attr('data-gamename');

        let total_pages = el.attr('data-total_pages');
        let showOneMore = el.attr('data-per-page');
        let offset = el.attr('data-offset');
        let show = (parseInt(showOneMore) + parseInt(offset));
        el.attr('data-offset', show);

        if ($('.js-tabs_wrap a.tab_item.hidden').length > 0)
        {
          if (gamename) {
            if (gamename == 'all') {
              $('.js-tabs_wrap a.tab_item:nth-child(-n+' + (parseInt(show)) + '').removeClass('hidden');
            }
          }
        }
        else
        {
          let game = el.attr('data-game');
          let per_page = el.attr('data-per-page');
          let id = el.attr('data-id');
            lm_page++;

            $.ajax({
              url: ajaxurl.url,

              type: "POST",
              data: {
                action: "load_more_prod",
                id: id,
                game: game,
                per_page: per_page,
                offset: offset,
                paged: lm_page,
              },
                beforeSend: function() {
                // el.fadeOut();
                el.hide();
                $(".if_js-tabs_wrap .preloader").show();
              },
                success: function(result) {

                $(".if_js-tabs_wrap .preloader").hide();
                let obj = jQuery.parseJSON(result);
                $(".if_js-tabs_wrap .js-tabs_wrap").append(obj.html.value);

                lm_total_pages = parseInt(obj.max_num_pages);

                if (lm_page>=lm_total_pages)
                {
                  el.hide();
                }
                else
                {
                  el.show();
                  el.css('display','block');
                }
                
                // el.show();
                if(obj.data === false){
                  //el.attr('data-offset', (parseInt(offset)+parseInt(per_page)));
                  /* el.show();
                   el.css('display','block');*/
                }

              }
            });
        }
    }
	
	$(document).on('keypress', 'form#searchform input', function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			$(this).closest('form.variations_form').find('.gq-btn').trigger('click');
		}
	});

});

document.addEventListener("DOMContentLoaded", function () {
  const scrollContainer = document.querySelector(".scrolling-buttons-inner");

  if (scrollContainer) {
    const scrollLeftButton = document.querySelector(".scroll-left-button");

    const scrollRightButton = document.querySelector(".scroll-right-button");

    const scrollButtons = document.querySelectorAll(".scroll-button");

    const scrollingContainer = document.querySelector(".button-container");

    function checkScroll() {
      const containerWidth = scrollContainer.clientWidth;

      const innerWidth =
        document.querySelector(".button-container").clientWidth;

      const maxScroll = innerWidth - containerWidth;

      const currentScroll = scrollContainer.scrollLeft;

      // Check if scrolling is at the beginning or end

      if (currentScroll === 0) {
        // Hide left scroll button

        scrollButtons[0].style.display = "none";
      } else if (currentScroll >= maxScroll) {
        // Hide right scroll button

        scrollButtons[1].style.display = "none";
      } else {
        scrollButtons[0].style.display = "flex";

        scrollButtons[1].style.display = "flex";
      }
    }

    scrollContainer.addEventListener("scroll", function () {
      toggleScrollButtons();
    });

    scrollLeftButton.addEventListener("click", function () {
      scrollContainer.scrollBy({
        left: -100,

        behavior: "smooth",
      });
    });

    scrollRightButton.addEventListener("click", function () {
      scrollContainer.scrollBy({
        left: 100,

        behavior: "smooth",
      });
    });

    // Add event listener for window resize

    window.addEventListener("resize", function () {
      toggleScrollButtons();

      checkScroll();
    });

    // Initial check on page load

    toggleScrollButtons();

    function toggleScrollButtons() {
      const containerWidth = document.querySelector(
        ".scrolling-buttons-inner"
      ).clientWidth;

      const innerWidth =
        document.querySelector(".button-container").clientWidth;

      if (innerWidth > containerWidth) {
        // Show scroll buttons

        document.querySelector(
          ".scrolling-buttons-inner"
        ).style.justifyContent = "flex-start";

        scrollButtons.forEach(function (button) {
          button.style.display = "flex";
        });
      } else {
        // Hide scroll buttons

        document.querySelector(
          ".scrolling-buttons-inner"
        ).style.justifyContent = "center";

        scrollButtons.forEach(function (button) {
          button.style.display = "none";
        });
      }

      checkScroll();
    }
  }

});

//2026//////////////////////////////////////////////////////////////////

// FIXED BUY BTN ORDER (vanilla JS) ===========================================================

function isPastElement(element) {
  if (!element) return false;

  const rect = element.getBoundingClientRect();

  return rect.top < 0;
}

function checkCartButton() {
  if (window.innerWidth > 991) return;

  const target = document.querySelector(
    '.cart_options_item .woocommerce-variation-add-to-cart .buttons'
  );

  if (!target) return;

  if (isPastElement(target)) {
    document.body.classList.add('is-fixed-cart');
  } else {
    document.body.classList.remove('is-fixed-cart');
  }
}

// events
window.addEventListener('scroll', checkCartButton);
window.addEventListener('resize', checkCartButton);

// initial check
document.addEventListener('DOMContentLoaded', checkCartButton);

//INFO TOOLTIP ================================================================================

document.addEventListener('click', function(e) {
  const icon = e.target.closest('.info-icon-text');

  if (icon) {
    document.querySelectorAll('.info-tooltip').forEach(t => t.remove());

    if (!icon.querySelector('.info-tooltip')) {
      const tooltip = document.createElement('div');
      tooltip.className = 'info-tooltip';
      tooltip.textContent = icon.dataset.info;
      icon.appendChild(tooltip);
    }

    e.stopPropagation();
    return;
  }

  document.querySelectorAll('.info-tooltip').forEach(t => t.remove());
});

//ORDER SUCCESS VIDEO ==============================================================================
const openBtn = document.getElementById('openVideo');
const modal = document.getElementById('videoModal');
const closeBtn = document.getElementById('closeVideo');
const iframe = document.getElementById('videoFrame');

const videoUrl = "https://www.youtube.com/embed/nwM_dbpK8w4?autoplay=1";

openBtn.addEventListener('click', () => {
  modal.style.display = 'block';
  iframe.src = videoUrl;
});

closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
  iframe.src = '';
});

window.addEventListener('click', (e) => {
  if (e.target === modal) {
    modal.style.display = 'none';
    iframe.src = '';
  }
});
