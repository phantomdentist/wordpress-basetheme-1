<?php
/*////////////////////////////////////////////////////////////
Shortcodes
////////////////////////////////////////////////////////////*/
if(function_exists('get_field')){
	
	function register_shortcodes(){
		add_shortcode('address', 'ttm_address_shortcode');
		add_shortcode('regaddress', 'ttm_registered_address_shortcode');
		add_shortcode('telephone', 'ttm_telephone_shortcode');
		add_shortcode('fax', 'ttm_fax_shortcode');
		add_shortcode('mobile', 'ttm_mobile_shortcode');
		add_shortcode('email', 'ttm_email_shortcode');
		add_shortcode('companyno', 'ttm_companyNumber_shortcode');
		add_shortcode('vatno', 'ttm_vatNumber_shortcode'); 
		add_shortcode('charityno', 'ttm_charityNumber_shortcode');
		
		add_shortcode('facebook', 'ttm_socialFacebook_shortcode');
		add_shortcode('twitter', 'ttm_socialTwitter_shortcode');
		add_shortcode('linkedin', 'ttm_socialLinkedin_shortcode');
		add_shortcode('youtube', 'ttm_socialYoutube_shortcode'); 
		
		add_shortcode('socialIcons', 'ttm_socialIcons_shortcode'); 
	}
	
	//Options
	function ttm_address_shortcode( $atts ){
		extract(shortcode_atts(array(  
			"line1" =>  'true',
			"line2" =>  'true',
			"town" =>  'true',
			"county" =>  'true',
			"postcode" =>  'true',
			"separator" => ', <br/>'  
		), $atts));  
		
		if( get_field('address_line_1', 'options') && $line1 == 'true' ) $returnValue = get_field('address_line_1', 'options').$separator;
		if( get_field('address_line_2', 'options') && $line2 == 'true' ) $returnValue .= get_field('address_line_2', 'options').$separator;
		if( get_field('address_town', 'options') && $town == 'true' ) $returnValue .= get_field('address_town', 'options').$separator;
		if( get_field('address_county', 'options') && $county == 'true' ) $returnValue .= get_field('address_county', 'options').$separator;
		if( get_field('address_postcode', 'options') && $postcode == 'true' ) $returnValue .= get_field('address_postcode', 'options');
		return $returnValue;
	}
	
	function ttm_registered_address_shortcode( $atts ){
		extract(shortcode_atts(array(  
			"line1" =>  'true',
			"line2" =>  'true',
			"town" =>  'true',
			"county" =>  'true',
			"postcode" =>  'true',
			"separator" => ', <br/>'  
		), $atts));  
		
		if( get_field('registeredAddress_line_1', 'options') && $line1 == 'true' ) $returnValue = get_field('registeredAddress_line_1', 'options').$separator;
		if( get_field('registeredAddress_line_2', 'options') && $line2 == 'true' ) $returnValue .= get_field('registeredAddress_line_2', 'options').$separator;
		if( get_field('registeredAddress_town', 'options') && $town == 'true' ) $returnValue .= get_field('registeredAddress_town', 'options').$separator;
		if( get_field('registeredAddress_county', 'options') && $county == 'true' ) $returnValue .= get_field('registeredAddress_county', 'options').$separator;
		if( get_field('registeredAddress_postcode', 'options') && $postcode == 'true' ) $returnValue .= get_field('registeredAddress_postcode', 'options');
		return $returnValue;
	}
	
	function ttm_telephone_shortcode( $atts ){
		extract(shortcode_atts(array(  
			"prefix" =>  ''
		), $atts));  
		
		if( get_field('telephone_number', 'options') ) $returnValue = $prefix.get_field('telephone_number', 'options');
		return $returnValue;
	}
	
	function ttm_fax_shortcode(){
		if( get_field('fax_number', 'options') ) $returnValue = get_field('fax_number', 'options');
		return $returnValue;
	}
	
	function ttm_mobile_shortcode(){
		if( get_field('mobile_number', 'options') ) $returnValue = get_field('mobile_number', 'options');
		return $returnValue;
	}
	
	function ttm_email_shortcode( $atts){
		extract(shortcode_atts(array(  
			"prefix" =>  ''
		), $atts));  
		
		if( get_field('email_address', 'options') ) $returnValue = $prefix.'<a href="mailto:'.antispambot(get_field('email_address', 'options')).'">'.antispambot(get_field('email_address', 'options')).'</a>';
		return $returnValue;
	}
	
	function ttm_companyNumber_shortcode(){
		if( get_field('company_number', 'options') ) $returnValue = get_field('company_number', 'options');
		return $returnValue;
	}
	
	function ttm_vatNumber_shortcode(){
		if( get_field('vat_number', 'options') ) $returnValue = get_field('vat_number', 'options');
		return $returnValue;
	}
	
	function ttm_charityNumber_shortcode(){
		if( get_field('charity_number', 'options') ) $returnValue = get_field('charity_number', 'options');
		return $returnValue;
	}
	
	//Social Individual
	function ttm_socialFacebook_shortcode(){
		if( get_field('facebook_link', 'options') ) $returnValue = '<a class="social-facebook" href="'.get_field('facebook_link', 'options').'"></a>';
		return $returnValue;
	}
	
	function ttm_socialTwitter_shortcode(){
		if( get_field('twitter_link', 'options') ) $returnValue = '<a class="social-twitter" href="'.get_field('twitter_link', 'options').'"></a>';
		return $returnValue;
	}
	
	function ttm_socialLinkedin_shortcode(){
		if( get_field('linkedin_link', 'options') ) $returnValue = '<a class="social-linkedin" href="'.get_field('linkedin_link', 'options').'"></a>';
		return $returnValue;
	}
	
	function ttm_socialYoutube_shortcode(){
		if( get_field('youtube_channel_link', 'options') ) $returnValue = '<a class="social-youtube" href="'.get_field('youtube_channel_link', 'options').'"></a>';
		return $returnValue;
	}
	
	//Social All
	function ttm_socialIcons_shortcode(){
		
		if ( get_field('facebook_link', 'options') || get_field('twitter_link', 'options') || get_field('linkedin_link', 'options') || get_field('youtube_channel_link', 'options') ) {
		
			$returnValue = '<div class="social-container shortcode">';
		
				if( get_field('facebook_link', 'options') ) $returnValue .= '<a class="social facebook" href="'.get_field('facebook_link', 'options').'"></a>';
			
				if( get_field('twitter_link', 'options') ) $returnValue .= '<a class="social twitter" href="'.get_field('twitter_link', 'options').'"></a>';
			
				if( get_field('linkedin_link', 'options') ) $returnValue .= '<a class="social linkedin" href="'.get_field('linkedin_link', 'options').'"></a>';
			
				if( get_field('youtube_channel_link', 'options') ) $returnValue .= '<a class="social youtube" href="'.get_field('youtube_channel_link', 'options').'"></a>';
			
				$returnValue .= '<div class="clear"></div>';
			
			$returnValue .= '</div><!-- end social-container -->';
			
			return $returnValue;
		}
	}
	
	add_action( 'init', 'register_shortcodes');
	add_filter('widget_text', 'do_shortcode');
}
?>