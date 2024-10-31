/*
Plugin Name: PushQuote Plugin
Author: Realtidbits
Author URI: http://realtidbits.com/
*/


jQuery(document).ready(function() {
	var login = PushquoteAjax.login,
	api_key = PushquoteAjax.api_key,
	pathname = window.location.href,
	pagetitle = document.title,
	shorten_url = "";
	
	if(jQuery('.realtidbitsPushquote').length) {
		get_short_url(pathname, login, api_key, function(short_url) {
			shorten_url = short_url;	

			jQuery('.realtidbitsPushquote').each(function(i){
				jQuery(this).removeClass('realtidbitsPushquote');
				
				var pullquote = jQuery('<div />').html(jQuery(this).html());
				pullquote=	jQuery(pullquote).attr( { class: 'pulled-'+jQuery(this).attr('class') });	
	
				// Social Buttons
				var $tw_btn = jQuery('<a />')
									.addClass('pullquote_twitter')
									.attr( { href: 'http://twitter.com/share?original_referer='+shorten_url+'&text='+encodeURIComponent((jQuery(this).html().length > 110 ? jQuery(this).html().substr(0, 110)+"... - " : jQuery(this).html())), title: 'Share in Twitter' } )
									.click(function(event) {
										var width  = 575,
											height = 400,
											left   = (jQuery(window).width()  - width)  / 2,
											top    = (jQuery(window).height() - height) / 2,
											url    = this.href,
											opts   = 'status=1' +
													 ',width='  + width  +
													 ',height=' + height +
													 ',top='    + top    +
													 ',left='   + left;
										
										window.open(url, 'twitter', opts);
									 
										return false;
								  }),
				$fb_btn = jQuery('<a />')
								.addClass('pullquote_facebook')
								.attr( { href: 'http://www.facebook.com/share.php?s=100&p[url]='+shorten_url+'&p[title]='+pagetitle+'&p[summary]='+encodeURIComponent(jQuery(this).html()), title: 'Share in Facebook' } )
								.click(function(event) {
										var width  = 575,
											height = 400,
											left   = (jQuery(window).width()  - width)  / 2,
											top    = (jQuery(window).height() - height) / 2,
											url    = this.href,
											opts   = 'status=1' +
													 ',width='  + width  +
													 ',height=' + height +
													 ',top='    + top    +
													 ',left='   + left;
										
										window.open(url, 'facebook', opts);
									 
										return false;
								  });
				if(PushquoteAjax.show_credits == 1) {
					jQuery(pullquote)
						.append(
							jQuery('<div />')
								.addClass('pullquote_copyright')
								.html('Pullquote Plugin by <a href="http://www.pushquote.net" target="_blank">PushQuote</a>')
						);
				}
				jQuery(pullquote)
					.append(
						jQuery('<div />')
							.addClass('pullquote_social')
							.append($tw_btn)
							.append($fb_btn)
					);
				
				jQuery(this).after(pullquote);
			});
		});
	}
});

function get_short_url(long_url, login, api_key, func)
{
    jQuery.getJSON(
        "http://api.bitly.com/v3/shorten?callback=?", 
        { 
            "format": "json",
            "apiKey": api_key,
            "login": login,
            "longUrl": long_url
        },
        function(response)
        {
			
            func(response.data.url);
        }
    );
}