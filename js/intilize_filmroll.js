jQuery(document).ready(function() {
    //console.log(document.getElementsByName('footer')[0]);
    if(show_in == "wp_footer")
    {
        if (jQuery('footer').attr('id'))
        {
            jQuery("#film_roll").insertBefore('#' + jQuery('footer').attr('id'));
        }
        else if (jQuery('footer').attr('class'))
        {
            jQuery("#film_roll").insertBefore('.' + jQuery('footer').attr('class'));
        }
        else
        {
            jQuery("#film_roll").insertBefore('footer');
        }   
    }
    else if(show_in == "wp_head")
    {
        jQuery("#film_roll").insertAfter("header");
    }
    else
    {
        if (jQuery('footer').attr('id') != null) {
            jQuery("#film_roll_2").insertBefore('#' + jQuery('footer').attr('id'));
        }
        else if (jQuery('footer').attr('class') != null) {
            jQuery("#film_roll_2").insertBefore('.' + jQuery('footer').attr('class'));
        }
        else {
            jQuery("#film_roll_2").insertBefore('footer');
        }      
        jQuery("#film_roll").insertAfter("header");
    }
    jQuery("#sfwa_footer").remove();
    jQuery('#film_roll').each(function(i)
    {
        jQuery('[id="' + this.id + '"]').slice(1).remove();
    });
    var film_roll = new FilmRoll({
        configure_load: true,
        container: '#film_roll',
        height:lsCareouselHeight,
        pager: lsCareouselPager,
        hover: lsCareouselHover,
        prev: lsCareouselPrev,
        next: lsCareouselNext,
        interval: lsCareouselInterval,
    });
    if(show_in  == 'both')
    {
        var film_roll_2 = new FilmRoll(
        {
        configure_load: true,
        container: '#film_roll_2',
        height:lsCareouselHeight,
        pager: lsCareouselPager,
        hover: lsCareouselHover,
        prev: lsCareouselPrev,
        next: lsCareouselNext,
        interval: lsCareouselInterval,
        });
        jQuery('#film_roll_2').each(function(i)
        {
            jQuery('[id="' + this.id + '"]').slice(1).remove();
        });
    }
});