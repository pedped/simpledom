<?php /* Smarty version 2.6.13, created on 2015-03-17 01:52:05
         compiled from plugins/search/group.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'plugins/search/group.tpl', 2, false),array('function', 'multiTableTR', 'plugins/search/group.tpl', 6, false),array('function', 'ifisinrequest', 'plugins/search/group.tpl', 10, false),array('function', 'multiTablePad', 'plugins/search/group.tpl', 16, false),array('block', 'multiTableTD', 'plugins/search/group.tpl', 9, false),)), $this); ?>

<?php echo smarty_function_counter(array('name' => 'group_search_id','start' => 0,'print' => false), $this);?>


<?php $_from = $this->_tpl_vars['group_names']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['group_name']):
?>
    <?php if ($this->_tpl_vars['index']%4 == 0): ?>
        <?php echo smarty_function_multiTableTR(array(), $this);?>

    <?php endif; ?>

    <?php $this->_tag_stack[] = array('multiTableTD', array('type' => 'left')); $_block_repeat=true;smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input name="group_name_<?php echo $this->_tpl_vars['group_name']; ?>
" value="<?php echo $this->_tpl_vars['group_name']; ?>
" type=checkbox <?php echo smarty_function_ifisinrequest(array('name' => "group_name_".($this->_tpl_vars['group_name']),'value' => 'checked'), $this);?>
> 
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>	
    <?php $this->_tag_stack[] = array('multiTableTD', array('type' => 'right','width' => "25%")); $_block_repeat=true;smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['group_name']; ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  endforeach; endif; unset($_from);  echo smarty_function_multiTablePad(array('last_index' => $this->_tpl_vars['index'],'go_until' => 4,'width' => "25%"), $this);?>

</tr><tr><td colspan=30 height=1 bgcolor="#FFFFFF"></td></tr>