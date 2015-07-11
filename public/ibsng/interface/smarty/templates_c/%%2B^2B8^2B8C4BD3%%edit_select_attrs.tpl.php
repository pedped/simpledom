<?php /* Smarty version 2.6.13, created on 2015-03-17 01:53:04
         compiled from admin/user/edit_select_attrs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'multiTableTR', 'admin/user/edit_select_attrs.tpl', 1, false),array('function', 'reportToShowCheckBox', 'admin/user/edit_select_attrs.tpl', 2, false),array('block', 'multiTableTD', 'admin/user/edit_select_attrs.tpl', 89, false),)), $this); ?>
<?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__normal_username','output' => 'Internet Username','default_checked' => ($this->_tpl_vars['normal_username_checked']),'always_in_form' => 'submit_form','value' => 'normal_username','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__voip_username','output' => 'VoIP Username','default_checked' => ($this->_tpl_vars['voip_username_checked']),'always_in_form' => 'submit_form','value' => 'voip_username','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__lock','output' => 'Lock Status','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'lock','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


<?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__rel_exp_date','output' => 'Relative ExpDate','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'rel_exp_date','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__abs_exp_date','output' => 'Absolute ExpDate','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'abs_exp_date','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__multi_login','output' => 'Multi Login','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'multi_login','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


<?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__normal_charge','output' => 'Normal Charge','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'normal_charge','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__voip_charge','output' => 'VoIP Charge','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'voip_charge','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__comment','output' => 'Comment','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'comment','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


<?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__ippool','output' => 'IPpool','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'ippool','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__assign_ip','output' => 'Assign IP','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'assign_ip','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__session_timeout','output' => 'Session Timeout','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'session_timeout','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


<?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__limit_mac','output' => 'Limit Mac','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'limit_mac','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__limit_caller_id','output' => 'Limit CallerID','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'limit_caller_id','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__limit_station_ip','output' => 'Limit Station IP','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'limit_station_ip','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


<?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__persistent_lan','output' => 'Persistent Lan','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'persistent_lan','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__caller_id','output' => 'VoIP CallerID','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'caller_id','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__email_address','output' => 'Email Address','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'email_address','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


<?php if (isset ( $this->_tpl_vars['user_search'] )): ?>
	<?php echo smarty_function_multiTableTR(array(), $this);?>

	    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__group','output' => 'Group','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'group_name','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


	    <?php echo smarty_function_reportToShowCheckBox(array('name' => 'edit__owner','output' => 'Owner','default_checked' => 'FALSE','always_in_form' => 'submit_form','value' => 'owner_name','form_name' => 'edit_user','container_name' => 'edit_attrs_selected'), $this);?>


	    <?php $this->_tag_stack[] = array('multiTableTD', array('type' => 'left')); $_block_repeat=true;smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

	    <?php $this->_tag_stack[] = array('multiTableTD', array('type' => 'right')); $_block_repeat=true;smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  endif; ?>	