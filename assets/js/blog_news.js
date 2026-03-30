jQuery(document).ready(function($){
    console.log('Blog news script load');
    var blog_paged=1;

    function blog_build_request()
    {
        let req_data=blog_build_data();

        let data =
        {
            action: 'blog_get_news',
            game_period: req_data.game_period,
            sort_by: req_data.sort_by,
            paged: req_data.paged,
            term_id: blog_term_id,
        };

        jQuery.ajax({
            type:'POST',
            url:ajaxurl.url,
            data:data,
            success:function(data)
            {
                let obj = jQuery.parseJSON(data);
                $('.blog_list_news_content').html(obj.result.list_news_html);
                $('.blog_news_pagination').html(obj.result.pagination_html);
            }
        });

        return false;
    }

    function blog_build_data()
    {
        let game_period = $('.tab_title_wrap .tab_title_blog.active').data('gamename');
        let sort_by = $('#sort_news option:selected').val();

        let blog_build_data_str={
            game_period: game_period,
            sort_by: sort_by,
            paged: blog_paged,
        };

        return blog_build_data_str;
    }

    $('.blog_news_select').change(function(){
        blog_build_request();
        return false;
    });

    $('.tab_title_wrap .tab_title_blog').click(function(){
        $('.tab_title_wrap .tab_title_blog').removeClass('active');
        $(this).addClass('active');
        blog_paged=1;
        blog_build_request();
    });

    $(document).on('click', '.blog_paginate_js', function(e) {
        e.preventDefault();
        let page_num = $(this).data('page_num');
        blog_paged = page_num;
        blog_build_request();
        return false;
    });

    $('.blog_menus_sub_item').change(function(){
        window.location.href=$(this).val();
    });
});