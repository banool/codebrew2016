<?php
/* 
Plugin Name: Under Construction / Maintenance Mode From Acurax
Plugin URI: http://www.acurax.com/Products/
Description: Simple and the best Coming Soon or Maintenance Mode Plugin Which Supports Practically Unlimited Responsive Designs.
Author: Acurax 
Version: 2.4
Author URI: http://www.acurax.com 
License: GPLv2 or later
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/ 
?>
<?php
/*************** Admin function ***************/
define("ACX_CSMA_CURRENT_VERSION","2.4");
define("ACX_CSMA_TOTAL_THEMES",5);
define("ACX_CSMA_BASE_LOCATION",plugin_dir_url( __FILE__ ));

include_once('function.php');
include_once('includes/hooks.php');
include_once('includes/hook_functions.php');

$filename = plugin_dir_path( __FILE__ ) . 'backward_compactability_file.php';
	if( file_exists( $filename  ) === true )
	{	
		include('backward_compactability_file.php');	
	}
	function acx_csma_admin() 
	{
		include('includes/acx_csma_admin.php');
	}
	function acx_csma_subscribers() 
	{
		include('includes/acx_csma_subscribers.php');
	}

	function acx_csma_misc() 
	{
		include('includes/acx_csma_misc.php');
	}
	function acx_csma_help() 
	{
		include('includes/acx_csma_help.php');
	}

	function acx_csma_expert_support() 
	{
		include('includes/acx_csma_expert_support.php');
	}


	$acx_csma_hide_expert_support_menu = get_option('acx_csma_hide_expert_support_menu');
	if ($acx_csma_hide_expert_support_menu == "") {	$acx_csma_hide_expert_support_menu = "no"; }
	function acx_csma_admin_actions()
	{
		global $acx_csma_hide_expert_support_menu;
		add_menu_page(  'Maintenance Mode / Coming Soon Configuration', 'Maintenance Mode', 'manage_options', 'Acurax-Coming-Soon-Maintenance-Mode-Settings','acx_csma_admin',plugin_dir_url( __FILE__ ).'/images/admin.png' ); // manage_options for admin
		add_submenu_page('Acurax-Coming-Soon-Maintenance-Mode-Settings', 'Coming Soon/Maintenance From Acurax Subscribers List', 'View All Subscribers', 'manage_options', 'Acurax-Coming-Soon-Maintenance-Mode-Subscribers' ,'acx_csma_subscribers');
		add_submenu_page('Acurax-Coming-Soon-Maintenance-Mode-Settings', 'Coming Soon/Maintenance From Acurax Misc Settings', 'Misc', 'manage_options', 'Acurax-Coming-Soon-Maintenance-Mode-Misc' ,'acx_csma_misc');
		
		if($acx_csma_hide_expert_support_menu == "no") {
		add_submenu_page('Acurax-Coming-Soon-Maintenance-Mode-Settings', 'Acurax Expert Support', 'Expert Support', 'manage_options', 'Acurax-Coming-Soon-Maintenance-Mode-Expert-Support' ,'acx_csma_expert_support');
		}
		add_submenu_page('Acurax-Coming-Soon-Maintenance-Mode-Settings', 'Coming Soon/Maintenance From Acurax Help and Support', 'Help', 'manage_options', 'Acurax-Coming-Soon-Maintenance-Mode-Help' ,'acx_csma_help');
	}
	if ( is_admin() )
	{
		add_action('admin_menu', 'acx_csma_admin_actions');
	}
	
	$acx_csma_version=get_option('acx_csma_version');
	if($acx_csma_version == '' && get_option('acx_csma_start_date_time') != "")
	{
		add_action('admin_head','acx_csma_migration');
	}
	function acx_csma_migration()
	{
		$acx_csma_start_timestamp_from = get_option('acx_csma_start_date_time');
		$acx_csma_cur_date_time_from=get_option('acx_csma_date_time');
		$acx_csma_wp_time= current_time('timestamp');
		$acx_csma_server_time=time();
		$diff=$acx_csma_wp_time-$acx_csma_server_time;
		$acx_csma_start_timestamp = $acx_csma_start_timestamp_from + ($diff);
		$acx_csma_date_time = $acx_csma_cur_date_time_from + ($diff);
		update_option('acx_csma_start_date_time',$acx_csma_start_timestamp);
		update_option('acx_csma_date_time',$acx_csma_date_time);
		update_option('acx_csma_version','1.1');
	}

$acx_csma_version=get_option('acx_csma_version');
if(($acx_csma_version > 0 && $acx_csma_version < ACX_CSMA_CURRENT_VERSION))
{
	if (function_exists('acx_csma_base_encode_fix')) {
		add_action('admin_head','acx_csma_update_content');
	}
}

function acx_csma_update_content()
{
	$acx_csma_appearence_array=get_option('acx_csma_appearence_array');
	if($acx_csma_appearence_array != "")
	{
			if(is_serialized($acx_csma_appearence_array))
			{ 
				$acx_csma_appearence_array = unserialize($acx_csma_appearence_array); 
			}
	}
	if(is_array($acx_csma_appearence_array))
	{
		if(array_key_exists('1',$acx_csma_appearence_array) && array_key_exists('acx_csma_inside_title1',$acx_csma_appearence_array['1']))
		{
			$acx_csma_inside_title1 = $acx_csma_appearence_array['1']['acx_csma_inside_title1'];
			if(strcmp($acx_csma_inside_title1,"Estimate Time Before Lunching") === 0 )
				{
					$acx_csma_appearence_array['1']['acx_csma_inside_title1'] = "Estimate Time Before Launching";
					update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
				}
		}
		if(array_key_exists('1',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_top_temp1',$acx_csma_appearence_array['1']))
		{
			$acx_csma_custom_html_top_temp1 = $acx_csma_appearence_array['1']['acx_csma_custom_html_top_temp1'];
			
			
					$acx_html_fix_content1 = acx_csma_base_encode_fix($acx_csma_custom_html_top_temp1);
					$acx_csma_appearence_array['1']['acx_csma_custom_html_top_temp1'] = $acx_html_fix_content1;
					update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
		}
		if(array_key_exists('1',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_bottom_temp1',$acx_csma_appearence_array['1']))
		{
			$acx_csma_custom_html_bottom_temp1 = $acx_csma_appearence_array['1']['acx_csma_custom_html_bottom_temp1'];
		
			$acx_html_fix_content2 =acx_csma_base_encode_fix($acx_csma_custom_html_bottom_temp1);
			$acx_csma_appearence_array['1']['acx_csma_custom_html_bottom_temp1'] = $acx_html_fix_content2;
			update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
			
		}
		if(array_key_exists('2',$acx_csma_appearence_array) && array_key_exists('acx_csma_desc_subtitle2',$acx_csma_appearence_array['2']))
		{
			$acx_csma_desc_subtitle2 = $acx_csma_appearence_array['2']['acx_csma_desc_subtitle2'];
		
			$acx_html_fix_content3 = acx_csma_base_encode_fix($acx_csma_desc_subtitle2);
			$acx_csma_appearence_array['2']['acx_csma_desc_subtitle2'] = $acx_html_fix_content3;
			update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
		
		}
		if(array_key_exists('2',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_top_temp2',$acx_csma_appearence_array['2']))
		{
			$acx_csma_custom_html_top_temp2 = $acx_csma_appearence_array['2']['acx_csma_custom_html_top_temp2'];
			$acx_html_fix_content4 = acx_csma_base_encode_fix($acx_csma_custom_html_top_temp2);
			$acx_csma_appearence_array['2']['acx_csma_custom_html_top_temp2'] = $acx_html_fix_content4;
			update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
		}
		if(array_key_exists('3',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_top_temp3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_custom_html_top_temp3 = $acx_csma_appearence_array['3']['acx_csma_custom_html_top_temp3'];
			$acx_html_fix_content5 = acx_csma_base_encode_fix($acx_csma_custom_html_top_temp3);
			$acx_csma_appearence_array['3']['acx_csma_custom_html_top_temp3'] = $acx_html_fix_content5;
			update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
		
		}
		if(array_key_exists('3',$acx_csma_appearence_array) && array_key_exists('acx_csma_desc_subtitle3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_desc_subtitle3 = $acx_csma_appearence_array['3']['acx_csma_desc_subtitle3'];
			$acx_html_fix_content6 = acx_csma_base_encode_fix($acx_csma_desc_subtitle3);
			$acx_csma_appearence_array['3']['acx_csma_desc_subtitle3'] = $acx_html_fix_content6;
			update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
			
		}
		if(array_key_exists('4',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_top_temp4',$acx_csma_appearence_array['4']))
		{
			$acx_csma_custom_html_top_temp4 = $acx_csma_appearence_array['4']['acx_csma_custom_html_top_temp4'];
				$acx_html_fix_content7 =  acx_csma_base_encode_fix($acx_csma_custom_html_top_temp4);
				$acx_csma_appearence_array['4']['acx_csma_custom_html_top_temp4'] = $acx_html_fix_content7;
				update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
		}
		if(array_key_exists('4',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_bottom_temp4',$acx_csma_appearence_array['4']))
		{
			$acx_csma_custom_html_bottom_temp4 = $acx_csma_appearence_array['4']['acx_csma_custom_html_bottom_temp4'];		
				$acx_html_fix_content8 = acx_csma_base_encode_fix($acx_csma_custom_html_bottom_temp4);
				$acx_csma_appearence_array['4']['acx_csma_custom_html_bottom_temp4'] = $acx_html_fix_content8;
				update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
			
		}
		if(array_key_exists('5',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_top_temp5',$acx_csma_appearence_array['5']))
		{
			$acx_csma_custom_html_top_temp5 = $acx_csma_appearence_array['5']['acx_csma_custom_html_top_temp5'];	
				$acx_html_fix_content9 = acx_csma_base_encode_fix($acx_csma_custom_html_top_temp5);
				$acx_csma_appearence_array['5']['acx_csma_custom_html_top_temp5'] = $acx_html_fix_content9;
				update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
			
		}
		if(array_key_exists('5',$acx_csma_appearence_array) && array_key_exists('acx_csma_custom_html_bottom_temp5',$acx_csma_appearence_array['5']))
		{
			$acx_csma_custom_html_bottom_temp5 = $acx_csma_appearence_array['5']['acx_csma_custom_html_bottom_temp5'];

				$acx_html_fix_content10 = acx_csma_base_encode_fix($acx_csma_custom_html_bottom_temp5);
			$acx_csma_appearence_array['5']['acx_csma_custom_html_bottom_temp5'] = $acx_html_fix_content10;
			update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
		}
		if(array_key_exists('5',$acx_csma_appearence_array) && !array_key_exists('acx_csma_subscribe_main_title5',$acx_csma_appearence_array['5']))
		{
			$acx_csma_appearence_array['5']['acx_csma_subscribe_main_title5'] = "Want to know when we launch?";
			update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
		}
	} 
	$acx_csma_custom_html_val = get_option('acx_csma_custom_html_val');	
	$acx_html_fix_content11 = acx_csma_base_encode_fix($acx_csma_custom_html_val);
	update_option('acx_csma_custom_html_val',$acx_html_fix_content11);
	update_option('acx_csma_version',ACX_CSMA_CURRENT_VERSION);
}
?>