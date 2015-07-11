<?php /* Smarty version 2.6.13, created on 2015-03-17 01:52:05
         compiled from admin/user/search_user/search_user_attributs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'showAttributes', 'admin/user/search_user/search_user_attributs.tpl', 1, false),array('function', 'addAttribute', 'admin/user/search_user/search_user_attributs.tpl', 3, false),)), $this); ?>
<?php $this->_tag_stack[] = array('showAttributes', array('form_name' => 'search_user','always_in_form' => 'search','cols' => 3,'module' => 'ALL')); $_block_repeat=true;smarty_block_showAttributes($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

	<?php echo smarty_function_addAttribute(array('name' => 'Internet Username','value' => 'show__attrs_normal_username','default_checked' => 'TRUE'), $this);?>


	<?php echo smarty_function_addAttribute(array('name' => 'VoIP Username','value' => 'show__attrs_voip_username','default_checked' => 'TRUE','module' => 'VoIP'), $this);?>

	
	<?php echo smarty_function_addAttribute(array('name' => 'Credit','value' => "show__basic_credit|price",'default_checked' => 'TRUE'), $this);?>
 
	
	<?php echo smarty_function_addAttribute(array('name' => 'Group','value' => 'show__basic_group_name','default_checked' => 'TRUE'), $this);?>
 
	
	<?php echo smarty_function_addAttribute(array('name' => 'Owner','value' => 'show__basic_owner_name','default_checked' => 'TRUE'), $this);?>
 
	
	<?php echo smarty_function_addAttribute(array('name' => 'Creation Date','value' => 'show__basic_creation_date','default_checked' => 'FALSE'), $this);?>
 
	
	<?php echo smarty_function_addAttribute(array('name' => 'Relative ExpDate','value' => "show__attrs_rel_exp_date,show__attrs_rel_exp_date_unit",'default_checked' => 'FALSE'), $this);?>

	
	<?php echo smarty_function_addAttribute(array('name' => 'Absolute ExpDate','value' => 'show__attrs_abs_exp_date','default_checked' => 'FALSE'), $this);?>

	
	<?php echo smarty_function_addAttribute(array('name' => 'Multi Login','value' => 'show__attrs_multi_login','default_checked' => 'FALSE'), $this);?>

	
	<?php echo smarty_function_addAttribute(array('name' => 'Normal Charge','value' => 'show__attrs_normal_charge','default_checked' => 'FALSE'), $this);?>

	
	<?php echo smarty_function_addAttribute(array('name' => 'VoIP Charge','value' => 'show__attrs_voip_charge','default_checked' => 'FALSE'), $this);?>

	
	<?php echo smarty_function_addAttribute(array('name' => 'Lock','value' => "show__attrs_lock|lockFormat",'default_checked' => 'FALSE'), $this);?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_showAttributes($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>