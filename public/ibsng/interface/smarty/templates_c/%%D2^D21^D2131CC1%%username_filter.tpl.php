<?php /* Smarty version 2.6.13, created on 2013-07-19 05:05:55
         compiled from admin/report/online_users/username_filter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'multiTableTR', 'admin/report/online_users/username_filter.tpl', 3, false),array('function', 'reportToShowCheckBox', 'admin/report/online_users/username_filter.tpl', 6, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['start_with_chars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['char']):
?>
    <?php if ($this->_tpl_vars['index']%6 == 0): ?>
        <?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php endif; ?>

    <?php echo smarty_function_reportToShowCheckBox(array('name' => "username_".($this->_tpl_vars['char']),'value' => $this->_tpl_vars['char'],'output' => $this->_tpl_vars['char'],'default_checked' => "",'always_in_form' => ""), $this);?>

<?php endforeach; endif; unset($_from); ?>
