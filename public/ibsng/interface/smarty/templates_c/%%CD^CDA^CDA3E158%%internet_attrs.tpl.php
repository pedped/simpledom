<?php /* Smarty version 2.6.13, created on 2013-07-19 05:05:55
         compiled from admin/report/online_users/internet_attrs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'multiTableTR', 'admin/report/online_users/internet_attrs.tpl', 1, false),array('function', 'reportToShowCheckBox', 'admin/report/online_users/internet_attrs.tpl', 2, false),)), $this); ?>
    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'normal_username','value' => 'Internet Username','output' => 'Internet Username','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'group_name','value' => 'Group','output' => 'Group','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'login_time','value' => 'Login Time','output' => 'Login Time','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'duration_secs','value' => 'Duration','output' => 'Duration','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'current_credit','value' => 'Credit','output' => 'Credit','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'owner_name','value' => 'Owner','output' => 'Owner'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'ras_description','value' => 'Ras','output' => 'Ras Description','default_checked' => 'TRUE','always_in_form' => ""), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'ras_ip','value' => 'Ras IP','output' => 'Ras IP','always_in_form' => ""), $this);?>

    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'in_bytes','value' => 'In Bytes','output' => 'In Bytes'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'out_bytes','value' => 'Out Bytes','output' => 'Out Bytes'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'in_rate','value' => 'In Rate','output' => 'In Rate'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'out_rate','value' => 'Out Rate','output' => 'Out Rate'), $this);?>

    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'attrs_remote_ip','value' => 'Remote IP','output' => 'Remote IP'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'unique_id_val','value' => "Port/ID",'output' => "Port/ID"), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'attrs_mac','value' => 'Mac','output' => 'Mac Address'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'attrs_station_ip','value' => 'Station IP','output' => 'Station IP'), $this);?>

    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'attrs_caller_id','value' => 'Caller ID','output' => 'Caller ID'), $this);?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => 'user_id','value' => 'User ID','output' => 'User ID'), $this);?>

