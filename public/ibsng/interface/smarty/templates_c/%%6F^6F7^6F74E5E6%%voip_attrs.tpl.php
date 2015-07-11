<?php /* Smarty version 2.6.13, created on 2013-07-19 05:05:55
         compiled from admin/report/online_users/voip_attrs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'multiTableTR', 'admin/report/online_users/voip_attrs.tpl', 1, false),array('function', 'reportToShowCheckBox', 'admin/report/online_users/voip_attrs.tpl', 2, false),)), $this); ?>
    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'voip_username','value' => 'VoIP Username','output' => 'VoIP Username','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'group_name','value' => 'Group','output' => 'Group','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'login_time','value' => 'Start Time','output' => 'Start Time','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'duration_secs','value' => 'Duration','output' => 'Duration','default_checked' => 'TRUE','always_in_form' => ""), $this);?>


    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'current_credit','value' => 'Credit','output' => 'Credit','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'called_number','value' => 'Called Number','output' => 'Called Number','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'prefix_name','value' => 'Prefix','output' => 'Prefix','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'ras_description','value' => 'Ras','output' => 'Ras Description','default_checked' => 'TRUE','always_in_form' => ""), $this);?>


    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'ras_ip','value' => 'Ras IP','output' => 'Ras IP'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'owner_name','value' => 'Owner','output' => 'Owner'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'attrs_caller_ip','value' => 'Caller IP','output' => 'Caller IP'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'attrs_called_ip','value' => 'Called IP','output' => 'Called IP'), $this);?>


    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'attrs_caller_id','value' => 'Caller ID','output' => 'Caller ID'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'user_id','value' => 'User ID','output' => 'User ID'), $this);?>
