<?php
/**
 * Plugin Name:       Chat Lite
 * Plugin URI:        https://wordpress.org/plugins/whatsapp_lite/
 * Description:       Lets add your Web page button WhatsApp with a single click.
 * Version:           1.0
 * Author:            adiel ben moshe
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       whatsapp-lite
 * Domain Path:       /languages
 */

 // the prefix is 'wlabm' ( stands for 'Whatsapp Lite Adiel Ben Moshe' ) 


/*   ======   Setting Page   ======   */ 

add_action( 'admin_menu', 'wlabm_add_submenu_page' );
function wlabm_add_submenu_page() {
	add_submenu_page('options-general.php', 'Whatsapp Lite', 'Whatsapp Lite', 'manage_options', 'whatsapp_lite', 'wlabm_options_page' );
}
 
function wlabm_options_page() {
	?>
		<div class="wrap">
			<h2>Whatsapp Lite</h2>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'whatsapp_lite' ); 
				do_settings_sections( 'whatsapp_lite' ); 
				submit_button(); 
				?>
 			</form>
		</div>
	<?php
}


/*   ======   Section & Fields   ======   */ 

add_action( 'admin_init', 'wlabm_setting_page' );

function wlabm_setting_page(){ 

    // Create section of Page
    
	$settings_section = 'whatsapp_lite_main';
	$option_group_and_page = 'whatsapp_lite';
	add_settings_section( $settings_section, '', 'wlabm_main_section_text_output', $option_group_and_page );

    // Create Settings:

    // 1. Phone Option
    
	$option_name = 'wlabm_phone_option';
	register_setting( $option_group_and_page, $option_name, array('default' => 15179999999 ) );
	add_settings_field( $option_name, 'Phone', 'wlabm_phone_input_renderer', $option_group_and_page, $settings_section );

    /*   Callback Functions for Setting   */

    // Section
    function wlabm_main_section_text_output() {
        echo "<p>Select a phone number including a prefix. e. g. +15179999999</p>";
    }

    // 1. Phone
    function wlabm_phone_input_renderer() {
        echo '<input type="text" id="wlabm_phone_option" value="'.get_option('wlabm_phone_option').'" name="wlabm_phone_option">';
        echo '<p class="description"> </p>';
    }

}

/*   ======   Icon Output   ======   */ 

add_action( 'wp_footer', 'wlabm_icon_output');

function wlabm_icon_output() {

    echo '<a target="_blank" href="https://wa.me/'.get_option("wlabm_phone_option").'">';

    ?>

    <div class="whatsapp-lite"><i>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.96em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1536 1600"><path d="M985 878q13 0 97.5 44t89.5 53q2 5 2 15q0 33-17 76q-16 39-71 65.5T984 1158q-57 0-190-62q-98-45-170-118T476 793q-72-107-71-194v-8q3-91 74-158q24-22 52-22q6 0 18 1.5t19 1.5q19 0 26.5 6.5T610 448q8 20 33 88t25 75q0 21-34.5 57.5T599 715q0 7 5 15q34 73 102 137q56 53 151 101q12 7 22 7q15 0 54-48.5t52-48.5zm-203 530q127 0 243.5-50t200.5-134t134-200.5t50-243.5t-50-243.5T1226 336t-200.5-134T782 152t-243.5 50T338 336T204 536.5T154 780q0 203 120 368l-79 233l242-77q158 104 345 104zm0-1382q153 0 292.5 60T1315 247t161 240.5t60 292.5t-60 292.5t-161 240.5t-240.5 161t-292.5 60q-195 0-365-94L0 1574l136-405Q28 991 28 780q0-153 60-292.5T249 247T489.5 86T782 26z" fill="#fff"/></svg></i></div></a>

    <style>
    .whatsapp-lite {
        position: fixed;
        bottom: 20px;
        right: 48px;
        z-index: 111;
        animation: fade-in 1s linear 1s both;
    }

    .whatsapp-lite i {
        font-size: 39px !important;
        background: #25d366 !important;
        display: inline-block !important;
        border-radius: 100px ;
        padding: 28% 33%;
        box-shadow: 1px 2px 10px 0 #00000024;
        transition: 0.5s;
    }


    .whatsapp-lite svg {
        display: block !important;
        height: initial !important;
        max-width: initial !important;
    }
    </style>

    <?php

}
 

/*   ======   Plugin Uninstall    ======   */ 

register_uninstall_hook( __FILE__, 'wlabm_uninstall' );

function wlabm_uninstall() {
    delete_option( 'wlabm_phone_option' );
}