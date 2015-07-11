<?php /* Smarty version 2.6.13, created on 2013-07-19 05:05:55
         compiled from admin/report/online_users/ras_filter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'multiTableTR', 'admin/report/online_users/ras_filter.tpl', 3, false),array('function', 'reportToShowCheckBox', 'admin/report/online_users/ras_filter.tpl', 6, false),array('function', 'multiTablePad', 'admin/report/online_users/ras_filter.tpl', 8, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['ras_descs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['ras_tuple']):
?>
	<?php if ($this->_tpl_vars['index']%4 == 0): ?>
	    <?php echo smarty_function_multiTableTR(array(), $this);?>

	<?php endif; ?>

	<?php echo smarty_function_reportToShowCheckBox(array('name' => "ras_".($this->_tpl_vars['ras_tuple'][1]),'value' => $this->_tpl_vars['ras_tuple'][1],'output' => ($this->_tpl_vars['ras_tuple'][0]),'default_checked' => 'FALSE','always_in_form' => ""), $this);?>

<?php endforeach; endif; unset($_from);  echo smarty_function_multiTablePad(array('last_index' => $this->_tpl_vars['index'],'go_until' => 3,'width' => "25%"), $this);?>
