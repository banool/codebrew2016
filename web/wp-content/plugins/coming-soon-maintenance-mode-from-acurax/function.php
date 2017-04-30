<?php
function acx_csma_styles() 
{	
	wp_register_style('acx_csmaadmin_style', plugins_url('css/style_admin.css', __FILE__));
	wp_enqueue_style('acx_csmaadmin_style');
	wp_register_style('acx_csmabox_style', plugins_url('css/acx_csma_box.css', __FILE__));
	wp_enqueue_style('acx_csmabox_style');
	wp_register_style('acx_datepick_style', plugins_url('css/jquery.datetimepicker.css', __FILE__));
	wp_enqueue_style('acx_datepick_style');
}
add_action('admin_enqueue_scripts', 'acx_csma_styles');
function acx_csma_date_picker_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
}
add_action('admin_enqueue_scripts','acx_csma_date_picker_scripts');
function acx_csma_colorpicker_scripts() 
{
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic','',array( 'jquery' ) );
}
$acx_csma_temp_array = get_option('acx_csma_temp_array');
if($acx_csma_temp_array != "")
{
	if(is_array($acx_csma_temp_array))
	{
		if(is_serialized($acx_csma_temp_array))
		{ 
			$acx_csma_temp_array = unserialize($acx_csma_temp_array); 
		}
	}
}
else{
	$acx_csma_temp_array=array(0,1,2,3,4,5);
	if(!is_serialized($acx_csma_temp_array))
	{ 
		$acx_csma_temp_array = serialize($acx_csma_temp_array); 
	}
	update_option('acx_csma_temp_array',$acx_csma_temp_array);
}

// color picker
 if(ISSET($_GET['page']))
{
	$acx_csma_page=$_GET['page'];
}
else
{
	$acx_csma_page="";
}	
if($acx_csma_page == "Acurax-Coming-Soon-Maintenance-Mode-Settings")
{
	add_action('admin_init','acx_csma_colorpicker_scripts');
}
//Date picker
function acx_csma_script()
{
	wp_register_script('acx_csma_datepick_script', plugins_url('js/jquery.datetimepicker.js', __FILE__)); 
	wp_enqueue_script('acx_csma_datepick_script','',array( 'jquery' ));
}
add_action('admin_enqueue_scripts', 'acx_csma_script');
function acx_csma_color_pick()
{
	echo '<script type="text/javascript" src="'.plugins_url('js/color.js', __FILE__). '"></script>';
}	
if($acx_csma_page == "Acurax-Coming-Soon-Maintenance-Mode-Settings")
{
	add_action('admin_head','acx_csma_color_pick');	
}

$acx_csma_template=get_option('acx_csma_template');
if($acx_csma_template == ""|| !is_numeric($acx_csma_template))
{
	$acx_csma_template = 1;
}
if($acx_csma_template < 0 || $acx_csma_template >6)
{
	$acx_csma_template= 1;
}
$acx_csma_template_path="templates/".$acx_csma_template."/index.php";
$acx_csma_activation_status = get_option('acx_csma_activation_status');
if($acx_csma_activation_status=='')
{
	update_option('acx_csma_activation_status',0);
}
if($acx_csma_activation_status==1)
{
	$acx_csma_display_template=true;
}
else
{
	$acx_csma_display_template=false;
}
if($acx_csma_display_template == true)
{
	$acx_csma_max_date = get_option('acx_csma_date_time');
	$acx_csma_timestamp=current_time('timestamp');
	$acx_csma_auto_launch=get_option('acx_csma_auto_launch'); 

	if($acx_csma_timestamp > $acx_csma_max_date)
	{
		if($acx_csma_auto_launch==0)
		{	
			$acx_csma_display_template=true;
		} else
		{
			$acx_csma_display_template=false;
		}
	}
}
if($acx_csma_display_template==true)
{
	add_action('template_redirect','acx_csma_plugin_activation');
}
function acx_csma_plugin_activation()
{
	global $wpdb,$acx_csma_display_template,$acx_csma_template_path;
	
	if($acx_csma_display_template==true)
	{
		if (is_user_logged_in()) 
		{
			$acx_csma_role_array=get_option('acx_csma_restrict_role');
			if(is_serialized($acx_csma_role_array))
			{
				$acx_csma_role_array = unserialize($acx_csma_role_array); 
			}
			$current_user = wp_get_current_user();
			$roles = $current_user->roles;   //$roles -array
			
			foreach($roles as $key=>$value)
			{
				$user_roles=ucwords($value);	
			}
			if(is_array($acx_csma_role_array))
			{
				if(in_array($user_roles,$acx_csma_role_array)|| $user_roles=="Administrator" || is_super_admin())
				{
					//do not display maintenance page.....
					$acx_csma_display_template=false;
				}
			}
		}
	}
	if($acx_csma_display_template==true)
	{
		$acx_csma_ip_array=get_option('acx_csma_ip_list');
		if($acx_csma_ip_array=="")
		{
		$acx_csma_ip_array = array();	
		}
		if(is_serialized($acx_csma_ip_array))
		{
			$acx_csma_ip_array = unserialize($acx_csma_ip_array); 
		}
		$current_ip=$_SERVER['REMOTE_ADDR'];
		
		if(is_array($acx_csma_ip_array) && in_array($current_ip,$acx_csma_ip_array))
		{
			// do not display maintenance page.....
			$acx_csma_display_template=false;
		}
	}
	$acx_csma_display_template = apply_filters('acx_csma_display_template_filter',$acx_csma_display_template);
	function filter_acx_csma_template($acx_csma_display_template)
	{
		if($acx_csma_display_template != '')
		{
			return $acx_csma_display_template;
		}
	}
	add_filter('acx_csma_display_template_filter','filter_acx_csma_template',5);


	if($acx_csma_display_template == true)
	{
		$protocol = "HTTP/1.0";
		if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] )
		$protocol = "HTTP/1.1";
		header( "$protocol 503 Service Unavailable", true, 503 );
		$end_time = get_option('acx_csma_date_time');
		if($end_time != "")
		{
		$end_time = date_i18n("D, j M Y H:i:s e", $end_time);
		header( "Retry-After: $end_time" );
		}
		include_once($acx_csma_template_path);
		exit;
	}
}
function acx_csma_template_preview()
{
	if(ISSET($_GET['acx_csma_preview']) && current_user_can( 'manage_options' )){
		$acx_csma_temp_array = get_option('acx_csma_temp_array');
		if(is_serialized($acx_csma_temp_array))
		{ 
			$acx_csma_temp_array = unserialize($acx_csma_temp_array); 
		}
		$acx_csma_preview=$_GET['acx_csma_preview'];
		if(in_array($acx_csma_preview,$acx_csma_temp_array))
		{
			$protocol = "HTTP/1.0";
			if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] )
			$protocol = "HTTP/1.1";
			header( "$protocol 503 Service Unavailable", true, 503 );
			$end_time = get_option('acx_csma_date_time');
			if($end_time != "")
			{
			$end_time = date_i18n("D, j M Y H:i:s e", $end_time);
			header( "Retry-After: $end_time" );
			}
			include_once("templates/".$acx_csma_preview."/index.php");
			exit;
		}
	}
}
add_action('template_redirect','acx_csma_template_preview');
// changing launch text
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
		if(array_key_exists('3',$acx_csma_appearence_array) && array_key_exists('acx_csma_inside_title3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_inside_title3 = $acx_csma_appearence_array['3']['acx_csma_inside_title3'];
			if(strcmp($acx_csma_inside_title3,"Estimate Time Before Lunching") === 0 )
				{
					$acx_csma_appearence_array['3']['acx_csma_inside_title3'] = "Estimate Time Before Launching";
					update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
				}
		}
	}
// upload images and logos
function acx_csma_upload_images_template_1() 
{
	if(function_exists('wp_enqueue_media'))
	{
		wp_enqueue_media();	
	}
?>
<script type="text/javascript">
function acx_csma_upload_images_template_loader(button_id,uploader_title,uploader_button,hidden_field_id,preview_id)
{                                                       
	if(button_id)
	{
	button_id = "#"+button_id;
	}
	if(uploader_title == "")
	{
	uploader_title = "Choose Image";
	}
	if(uploader_button == "")
	{
	uploader_button = "Select";
	}
	if(hidden_field_id)
	{
	hidden_field_id = "#"+hidden_field_id;
	}
	if(preview_id)
	{
	preview_id = "#"+preview_id;
	}
	var custom_uploader_template_1_1;
	jQuery(button_id).click(function(e) 
	{
		e.preventDefault();
		//If the uploader object has already been created, reopen the dialog
		if (custom_uploader_template_1_1) 
		{
		custom_uploader_template_1_1.open();
		return;
		}
		//Extend the wp.media object
		custom_uploader_template_1_1 = wp.media.frames.file_frame = wp.media({
		title: uploader_title,
		button:
		{
		text: uploader_button
		},
		multiple: false	});
		//When a file is selected, grab the URL and set it as the text field's value
		custom_uploader_template_1_1.on('select', function() 
		{
		attachment = custom_uploader_template_1_1.state().get('selection').first().toJSON();
		// console.log(attachment);
		if(hidden_field_id)
		{
		jQuery(hidden_field_id).val(attachment.id);
		}
		if(preview_id != "")
		{
		jQuery(preview_id).attr('src',attachment.url);
		}
		});
		//Open the uploader dialog
		custom_uploader_template_1_1.open();
	});
}
</script>
<?php
} 
add_action('admin_head', 'acx_csma_upload_images_template_1'); 	

//Quick Request Form
function acx_csma_quick_request_submit_callback()
{
	$acx_name =  $_POST['acx_name'];
	$acx_email =  $_POST['acx_email'];
	$acx_phone =  $_POST['acx_phone'];
	$acx_csma_es =  $_POST['acx_csma_es'];
	$acx_weburl =  $_POST['acx_weburl'];
	$acx_subject =  stripslashes($_POST['acx_subject']);
	$acx_question =  stripslashes($_POST['acx_question']);
	if (!wp_verify_nonce($acx_csma_es,'acx_csma_es'))
	{
	$acx_csma_es == "";
	}
	if(!current_user_can('manage_options'))
	{
	$acx_csma_es == "";
	}
	if($acx_csma_es == "" || $acx_name == "" || $acx_phone == "" || $acx_email == "" || $acx_weburl == "" || $acx_subject == "" || $acx_question == "")
	{
		echo 2;
	} 
else
{
	$current_user = wp_get_current_user();
	$current_user_acx = $current_user->user_email;
	if($current_user_acx == "")
	{
		$current_user_acx = $acx_email;
	}
	$headers[] = 'From: ' . $acx_name . ' <' . $current_user_acx . '>';
	$headers[] = 'Content-Type: text/html; charset=UTF-8'; 
	$message = "Name: ".$acx_name . "\r\n <br>";
	$message = $message . "Email: ".$acx_email . "\r\n <br>";
	if($acx_phone != "")
	{
		$message = $message . "Phone: ".$acx_phone . "\r\n <br>";
	}
	// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$acx_question = wordwrap($acx_question, 70, "\r\n <br>");
	$message = $message . "Request From: CSMA - Expert Help Request Form \r\n <br>";
	$message = $message . "Website: ".$acx_weburl . "\r\n <br>";
	$message = $message . "Question: ".$acx_question . "\r\n <br>";
	$emailed = wp_mail( 'info@acurax.com', $acx_subject, $message, $headers );
	if($emailed)
	{
		echo 1;
	} else
	{
		echo 0;
	}
}
	die(); // this is required to return a proper result
}add_action('wp_ajax_acx_csma_quick_request_submit','acx_csma_quick_request_submit_callback');

 
function acx_csma_add_items($admin_bar)
{
	$args = array(
    'id'    => 'acx_csma_activation_msg',
    'parent' => 'top-secondary',
    'title' => 'Maintenance Mode is Activated',
    'href'  => 'admin.php?page=Acurax-Coming-Soon-Maintenance-Mode-Settings'
    );
	if (!current_user_can('manage_options') ) {
        return;
    }
    $admin_bar->add_menu($args);
}
$acx_csma_activation_status=get_option('acx_csma_activation_status');
if($acx_csma_activation_status == 1 && is_admin())
{
	add_action('admin_bar_menu', 'acx_csma_add_items'); 
}

function acx_csma_subscribe_email()
{
	if (!isset($_POST['acx_csma_subscribe_es'])) die("<br><br>Unknown Error Occurred, Try Again... <a href=''>Click Here</a>");
	if (!wp_verify_nonce($_POST['acx_csma_subscribe_es'],'acx_csma_subscribe_es')) die("<br><br>Unknown Error Occurred, Try Again... <a href=''>Click Here</a>");

	if(ISSET($_POST['name']))
	{
		$name=$_POST['name'];
	}
	else{
		$name="";
	}
	if(ISSET($_POST['email']))
	{
		$email=$_POST['email'];
	}
	else{
		$email="";
	}
	if(ISSET($_POST['ip']))
	{
		$ip=$_POST['ip'];
	}
	else{
		$ip="";
	}

	if(ISSET($_POST['timestamp']))
	{
		$timestamp=$_POST['timestamp'];
	}
	else{
		$timestamp = "";
	}

	$acx_csma_subscribe_details=get_option('acx_csma_subscribe_user_details');
	if($acx_csma_subscribe_details != "")
	{
		if(is_serialized($acx_csma_subscribe_details))
		{ 
			$acx_csma_subscribe_details = unserialize($acx_csma_subscribe_details); 
		}
	}	
	else{
	$acx_csma_subscribe_details=array();
	}	 
	$found=0;
	foreach($acx_csma_subscribe_details as $key => $value)
	{
		if($value['email'] == $email)
		{
		$found=1;
		}
	}
	if($found == 1)
	{
		echo "Exists";
	}
	else{
	$acx_csma_subscribe_details[]= array (
										'name'=> $name,
										'email' => sanitize_email($email),
										'ip' => $ip,
										'timestamp' => $timestamp
											);
	if(!is_serialized($acx_csma_subscribe_details))
	{
		$acx_csma_subscribe_details = serialize($acx_csma_subscribe_details); 
	}
	update_option('acx_csma_subscribe_user_details',$acx_csma_subscribe_details);
	echo "success";
	} 
	die(); // this is required to return a proper result
}
add_action( 'wp_ajax_nopriv_acx_csma_subscribe_email', 'acx_csma_subscribe_email' );

function acx_csma_subscribe_ajax()
{	
	$acx_csma_subscribe_details=get_option('acx_csma_subscribe_user_details');
	if(is_serialized($acx_csma_subscribe_details ))
	{
		$acx_csma_subscribe_details = unserialize($acx_csma_subscribe_details); 
	}	
	if(!empty($acx_csma_subscribe_details)) {
		$filename = 'subscribers-list-' . date('Y-m-d') . '.csv';
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename='.$filename);
		$fp = fopen('php://output', 'w');
		fputcsv($fp, array('Name','Email','Date'));
		foreach ($acx_csma_subscribe_details as $item=> $value) {
			if(ISSET($value['ip']))
			{
				unset($acx_csma_subscribe_details[$item]['ip']);
			}
			if(ISSET($value['timestamp']))
			{	
				$format="Y-m-d H:i:s";
				$acx_csma_subscribe_details[$item]['timestamp']=date_i18n($format, $acx_csma_subscribe_details[$item]['timestamp']);
			}
		}
		foreach ($acx_csma_subscribe_details as $item=> $value) {
			fputcsv($fp, $value);
		}
		fclose($fp);
	}
	die();
}
add_action( 'wp_ajax_acx_csma_subscribe_ajax', 'acx_csma_subscribe_ajax' );
function acx_csma_addon_ua_demo()
{
echo "<div id='acx_csma_addon_demo_ua'><br><hr>
<img src='".plugins_url('/images/addon_ua_demo.png',__FILE__)."' style='border:0px;width:100%;height:auto;' class='acx_csma_info_lb' lb_title='Private Access URL Feature - Premium Addon Plugin' lb_content='<p style=\"font-size:13px;\">You may needs to showcase the website to your friends, contacts or clients to get approval, or get suggestions.<br><br>When website is in under construction mode, they may needs to login or provide you their ip address to grand them access.<br><br>But using Private Access URL Addon, You will get the option to generate a private URL which you can provide to anyone, and they can access your website, They wont see the under construction page until the url expire.<br><br> While generating a URL, You can set expiry, It can be Never, So URL is valid until you delete it. Can set expiry as Hours, So URL will be active for specified hours from their first visit.<br><br>Can also set expiry as page views. Lets say, you generated a URL for 10 Page views, and when someone visit the URL and access 10 pages or visited 10 times.URL will automatically gets expired.<br><br><a href=\"https://clients.acurax.com/order.php?pid=csmauapa&utm_source=link_1&utm_medium=csma_1&utm_campaign=csma\" style=\"float:right;\" target=\"_blank\">Order Now</a></p>'>
</div>";
}
add_action('acx_csma_hook_mainoptions_below_general_settings','acx_csma_addon_ua_demo');
function acx_csm_info_lb()
{
?>
<script type="text/javascript">
jQuery( ".acx_csma_info_lb" ).click(function() {
var lb_title = jQuery(this).attr('lb_title');
var lb_content = jQuery(this).attr('lb_content');
var html= '<div id="acx_csma_c_icon_p_info_lb_h" style="display:none;"><div class="acx_csma_c_icon_p_info_c"><span class="acx_csma_c_icon_p_info_close" onclick="acx_csma_remove_info()"></span><h4>'+lb_title+'</h4><div class="acx_csma_c_icon_p_info_content">'+lb_content+'</div></div></div> <!-- acx_csma_c_icon_p_info_lb_h -->';
jQuery( "body" ).append(html)
jQuery( "#acx_csma_c_icon_p_info_lb_h" ).fadeIn();
});

function acx_csma_remove_info()
{
jQuery( "#acx_csma_c_icon_p_info_lb_h" ).fadeOut()
jQuery( "#acx_csma_c_icon_p_info_lb_h" ).remove();
};
</script>
<?php
}
add_action('acx_csma_hook_mainoptions_below_general_settings','acx_csm_info_lb');
function acx_csma_updated_fields_content()
{
	$acx_csma_appearence_array=get_option('acx_csma_appearence_array');
	if(is_serialized($acx_csma_appearence_array))
	{ 
		$acx_csma_appearence_array = unserialize($acx_csma_appearence_array); 
	}
	if(is_array($acx_csma_appearence_array))
	{
		
		if(!array_key_exists('acx_csma_show_subscription',$acx_csma_appearence_array['1']))
		{
			$acx_csma_appearence_array['1']['acx_csma_show_subscription'] = 1;
		}
		if(!array_key_exists('acx_csma_custom_html_top_sub1',$acx_csma_appearence_array['1']))
		{
			$acx_csma_appearence_array['1']['acx_csma_custom_html_top_sub1'] = "";
		}
		if(!array_key_exists('acx_csma_custom_html_bottom_sub1',$acx_csma_appearence_array['1']))
		{
			$acx_csma_appearence_array['1']['acx_csma_custom_html_bottom_sub1'] = "";
		}
		if(!array_key_exists('acx_csma_custom_css_temp1',$acx_csma_appearence_array['1']))
		{
			$acx_csma_appearence_array['1']['acx_csma_custom_css_temp1'] = "";
		}
		if(!array_key_exists('acx_csma_custom_html_top_timer',$acx_csma_appearence_array['2']))
		{
			$acx_csma_appearence_array['2']['acx_csma_custom_html_top_timer'] = "";
		}
		if(!array_key_exists('acx_csma_show_subscription2',$acx_csma_appearence_array['2']))
		{
			$acx_csma_appearence_array['2']['acx_csma_show_subscription2'] = 1;
		}
		if(!array_key_exists('acx_csma_custom_css_temp2',$acx_csma_appearence_array['2']))
		{
			$acx_csma_appearence_array['2']['acx_csma_custom_css_temp2'] = "";
		}
		if(!array_key_exists('acx_csma_primary_color3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_primary_color3'] = "#ffffff";
		}
		if(!array_key_exists('acx_csma_secondary_color3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_secondary_color3'] = "#fe7e01";
		}
		if(!array_key_exists('acx_csma_left_bar_color3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_left_bar_color3'] = "#000000";
		}
		if(!array_key_exists('acx_csma_timer_color3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_timer_color3'] = "#ffffff";
		}
		if(!array_key_exists('acx_csma_show_subscription3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_show_subscription3'] = 1;
		}
		if(!array_key_exists('acx_csma_show_timer3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_show_timer3'] = 1;
		}
		if(!array_key_exists('acx_csma_custom_html_top_timer_temp3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_custom_html_top_timer_temp3'] = "";
		}
		if(!array_key_exists('acx_csma_custom_html_bottom_temp3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_custom_html_bottom_temp3'] = "";
		}
		if(!array_key_exists('acx_csma_custom_css_temp3',$acx_csma_appearence_array['3']))
		{
			$acx_csma_appearence_array['3']['acx_csma_custom_css_temp3'] = "";
		}
		if(!array_key_exists('acx_csma_custom_css_temp4',$acx_csma_appearence_array['4']))
		{
			$acx_csma_appearence_array['4']['acx_csma_custom_css_temp4'] = "";
		}
		if(!array_key_exists('acx_csma_show_subscription5',$acx_csma_appearence_array['5']))
		{
			$acx_csma_appearence_array['5']['acx_csma_show_subscription5'] = 1;
		}
		if(!array_key_exists('acx_csma_custom_html_top_sub',$acx_csma_appearence_array['5']))
		{
			$acx_csma_appearence_array['5']['acx_csma_custom_html_top_sub'] = "";
		}
		if(!array_key_exists('acx_csma_custom_html_bottom_sub',$acx_csma_appearence_array['5']))
		{
			$acx_csma_appearence_array['5']['acx_csma_custom_html_bottom_sub'] = "";
		}
		if(!array_key_exists('acx_csma_launch_title_color5',$acx_csma_appearence_array['5']))
		{
			$acx_csma_appearence_array['5']['acx_csma_launch_title_color5'] = "#4b4b4b";
		}
		if(!array_key_exists('acx_csma_custom_css_temp5',$acx_csma_appearence_array['5']))
		{
			$acx_csma_appearence_array['5']['acx_csma_custom_css_temp5'] = "";
		}
		if(!is_serialized($acx_csma_appearence_array))
		{
			$acx_csma_appearence_array = serialize($acx_csma_appearence_array); 
		}
		update_option('acx_csma_appearence_array',$acx_csma_appearence_array);
	}
}
add_action('acx_csma_hook_mainoptions_inside_else_submit','acx_csma_updated_fields_content')


?>