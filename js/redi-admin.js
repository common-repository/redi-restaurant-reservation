jQuery( document ).ready(function() {
    jQuery( ".redi_video_btn" ).on( "click", function() {
         var datid = jQuery(this).attr("data-id");
        jQuery(".redi_video_modal iframe").attr("src","https://www.youtube.com/embed/"+datid);
        jQuery('.redi_video_modal').show();
    } );

    jQuery( ".redi_video_modal span.close" ).on( "click", function() {
        jQuery(".redi_video_modal iframe").attr("src","");
        jQuery('.redi_video_modal').hide();
    } );

    // Subscription Checkbox
    jQuery(document).on('change', '#IsSubscription', function(){

        var isSub = jQuery(this).prop('checked');
        if(isSub){
            jQuery('#SubscriptionName').prop('required',true);
            jQuery('#SubscriptionEmail').prop('required',true);
        }else{
            jQuery('#SubscriptionName').prop('required', false);
            jQuery('#SubscriptionEmail').prop('required', false);
        }
    });

    // Scroll To input
    jQuery('.error a[href*=#]').click(function (e) {
        e.preventDefault();
        var hash = jQuery(this).attr('href');
        hash = hash.slice(hash.indexOf('#') + 1);
        if (hash) {
            jQuery('html, body').animate({
                scrollTop: jQuery('#' + hash).offset().top - 140
            }, 1000);
            jQuery('#' + hash).addClass('section_active');
        }
    });

});
