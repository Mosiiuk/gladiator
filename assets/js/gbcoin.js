jQuery(document).ready(function($){

    function gbcoin_result($status=0)
    {
        $('#gbcoin_info').removeClass('gbcoin_hidden');
        if ($status>0)
            $('#gbcoin_info').addClass('gbcoin_error');
        else
        {
            $('#gbcoin_info').html('GBCoin successfully applied');
            $('#gbcoin_info').addClass('gbcoin_ok');
        }

        //gbcoin_error gbcoin_ok
        switch ($status) {
            case 1:
                $('#gbcoin_info').html('GBCoin not set.');
            break;
            case 2:
                $('#gbcoin_info').html('User not found.');
            break;
            case 3:
                $('#gbcoin_info').html('You don\'t have that many GBCoin');
            break;
        }

    }

    $('#set_gbcoin').click(function(){
        let gbcoin = parseFloat($('#gbcoin').val());

        if (gbcoin<=0) {
            $('#gbcoin').val(0);
            $('#gbcoin').focus();
            return;
        }

        let data =
            {
                action: 'gbcoin_set',
                gbcoin:gbcoin,
            };

        $('#gbcoin_info').addClass('gbcoin_hidden');

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl.url,
            data: data,
            success: function (data) {
                let obj = jQuery.parseJSON(data);
                if ( parseInt(obj.error)==0 )
                {
                    gbcoin_result();
                    window.location.reload();
                }
                else
                {
                    gbcoin_result(obj.error);
                }
            }
        });

    });

    $('#cancel_gbcoin').click(function(){
        let data =
            {
                action: 'gbcoin_cancel',
            };

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl.url,
            data: data,
            success: function (data) {
                let obj = jQuery.parseJSON(data);
                window.location.reload();
            }
        });
    });
});