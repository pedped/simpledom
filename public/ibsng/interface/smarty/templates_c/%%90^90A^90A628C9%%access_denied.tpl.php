<?php /* Smarty version 2.6.13, created on 2015-03-18 02:33:11
         compiled from access_denied.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'access_denied.tpl', 13, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('title' => 'Access Denied')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table align=center border=1>
<tr>
  <td align=center>
    <h2>
	<font color=red>
	    Access Denied
	</font>
    </h2>

    You must log in to access this page. <br>
    This page needs IBS authenticated <b><?php echo ((is_array($_tmp=$this->_tpl_vars['role'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</b>.<br>
    You can login <a href="<?php echo $this->_tpl_vars['url']; ?>
"> here </a>
  </td>
</tr>
</table>