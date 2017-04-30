<?php
function acx_csma_hook_function($function_name)
{
	if($function_name!="")
	{
		if(function_exists($function_name))
		{
			$function_name();	
		}
	}
}
function acx_csma_hook_sidebar_widget()
{
	do_action('acx_csma_hook_sidebar_widget');
}
function acx_csma_hook_mainoptions_above_title()
{
	do_action('acx_csma_hook_mainoptions_above_title');
}
function acx_csma_hook_mainoptions_set_default_template_1()
{
	do_action('acx_csma_hook_mainoptions_set_default_template_1');
}
function acx_csma_hook_mainoptions_set_default_template_2()
{
	do_action('acx_csma_hook_mainoptions_set_default_template_2');
}
function acx_csma_hook_mainoptions_set_default_template_3()
{
	do_action('acx_csma_hook_mainoptions_set_default_template_3');
}
function acx_csma_hook_mainoptions_set_default_template_4()
{
	do_action('acx_csma_hook_mainoptions_set_default_template_4');
}
function acx_csma_hook_mainoptions_set_default_template_5()
{
	do_action('acx_csma_hook_mainoptions_set_default_template_5');
}
function acx_csma_hook_mainoptions_update_default_values()
{
	do_action('acx_csma_hook_mainoptions_update_default_values');
}
function acx_csma_hook_mainoptions_inside_if_submit()
{
	do_action('acx_csma_hook_mainoptions_inside_if_submit');
}
function acx_csma_hook_mainoptions_inside_else_submit()
{
	do_action('acx_csma_hook_mainoptions_inside_else_submit');
}
function acx_csma_hook_mainoptions_outside_if_submit()
{
	do_action('acx_csma_hook_mainoptions_outside_if_submit');
}
function acx_csma_hook_mainoptions_add_settings()
{
	do_action('acx_csma_hook_mainoptions_add_settings');
}
function acx_csma_hook_mainoptions_below_general_settings()
{
	do_action('acx_csma_hook_mainoptions_below_general_settings');
}
function acx_csma_hook_mainoptions_below_appearence_settings()
{
	do_action('acx_csma_hook_mainoptions_below_appearence_settings');
}
function acx_csma_hook_mainoptions_below_add_template()
{
	do_action('acx_csma_hook_mainoptions_below_add_template');
}
function acx_csma_hook_mainoptions_below_javascript()
{
	do_action('acx_csma_hook_mainoptions_below_javascript');
}
?>