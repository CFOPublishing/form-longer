<?php

/*
Plugin Name: Form Longer
Plugin URI: http://aramzs.me
Description: This plugin makes long form work. 
Version: 0.5
Author: Aram Zucker-Scharff
Author URI: http://aramzs.me
License: GPL2
*/

/*  Copyright 2014  CFO Publishing  (email : aramzs@cfo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Form_Longer {
    
    var $slug;
    
    // See http://php.net/manual/en/language.oop5.decon.php to get a better understanding of what's going on here.
	function __construct() {
        $this->slug = 'formlong';
		$this->includes();
        
        
        add_action('wp_head', array($this,'styles_scripts'));
        add_action("admin_init", array($this,"add_to_settings")); 
    }
    
    function includes(){

    }
    
    function styles_scripts() {
        global $wp_query;

        $match = get_option(formlonger()->slug."_setting"); 
        #var_dump($match); die();
        if (is_singular()){

            if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
                $post_id = get_the_ID();

            endif;
        }

    }

    function add_to_settings(){
        register_setting( 'writing', formlonger()->slug.'_setting_section', array(formlonger(), 'options_validator') );
        add_settings_section(formlonger()->slug.'_setting_section', 'Form Longer', array(formlonger(),'setting_section_callback'), 'writing');
        add_settings_field(formlonger()->slug.'_setting','Set Collapsing Columns', array(formlonger(),'callback'), 'writing', formlonger()->slug.'_setting_section');
    }

    function setting_section_callback(){

    }

    function callback(){
        $setting = get_option(formlonger()->slug.'_setting');
        #var_dump($je_id);
        ?>  
            <div class="wrap">  
                <form action="options.php" method="post">  
                    <table class="form-table">  
                        <tr valign="top">  
                            <td>  
                                <input type="text" name="cfo_je_setting" value="<?php echo $setting; ?>" size="25" />  
                            </td>  
                        </tr>  
                    </table> 
                    <input type="hidden" name="update_settings" value="Y" />  				
                </form>  
            </div>  
        <?php
            if (isset($_POST["update_settings"])) {  
                // Do the saving  
                $setting = esc_attr($_POST[formlonger()->slug."_setting"]); 
                #var_dump($je_id); die();
                update_option(formlonger()->slug."_setting", $setting);  			
            }  	

    }

    function options_validator($input){
            #var_dump($_POST); die();
            if (isset($_POST["update_settings"])) {  
                // Do the saving  
                $setting = esc_attr($_POST[formlonger()->slug."_setting"]); 
                #var_dump($input); die();
                update_option(formlonger()->slug."_setting", $setting);  			
            } 	
    }
}

/**
 * Bootstrap
 *
 * You can also use this to get a value out of the global, eg
 *
 *    $foo = pressforward()->bar;
 *
 * @since 1.7
 */
function formlonger() {
	global $formlong;
	if ( ! is_a( $formlong, 'Form_Longer' ) ) {
		$formlong = new Form_Longer();
	}
	return $formlong;
}

// Start me up!
formlonger();