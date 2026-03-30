jQuery(document).ready(function($){
    console.log('Games JS OK');

    $('#game_change').niceSelect();

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/; SameSite=None; Secure";
    }


    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i=0;i < ca.length;i++) {
            let c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }


    function set_game(select_game='',url='')
    {
        let data =
        {
            action: 'set_game_js',
            select_game:select_game,
        };

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl.url,
            data: data,
            success: function (data) {
                let obj = jQuery.parseJSON(data);
                if (url=='')
                    document.location.href = ajaxurl.site_url;
                else
                    document.location.href = url;
            }
        });
    }

    $('#game_change').change(function(){
        let game = $(this).val();
        set_game(game);
    });

    $('.game_tab_link').click(function(e){
        e.preventDefault();
        let href=$(this).attr('href');
        let game = $(this).data('game_rel');
        set_game(game,href);
    });
});