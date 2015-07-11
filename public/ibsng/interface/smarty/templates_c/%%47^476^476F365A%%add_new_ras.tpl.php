<?php /* Smarty version 2.6.13, created on 2013-07-19 13:34:21
         compiled from admin/ras/add_new_ras.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'addEditTable', 'admin/ras/add_new_ras.tpl', 14, false),array('block', 'addEditTD', 'admin/ras/add_new_ras.tpl', 16, false),array('block', 'addRelatedLink', 'admin/ras/add_new_ras.tpl', 61, false),array('block', 'setAboutPage', 'admin/ras/add_new_ras.tpl', 67, false),array('function', 'ifisinrequest', 'admin/ras/add_new_ras.tpl', 20, false),array('function', 'helpicon', 'admin/ras/add_new_ras.tpl', 21, false),array('function', 'html_options', 'admin/ras/add_new_ras.tpl', 37, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array('title' => 'Add New Ras','selected' => 'RAS')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "err_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method=POST>
    <?php $this->_tag_stack[] = array('addEditTable', array('title' => 'Add New RAS')); $_block_repeat=true;smarty_block_addEditTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','err' => 'ras_ip_err')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    RAS IP
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    	<input class="text" type=text name=ras_ip value="<?php echo smarty_function_ifisinrequest(array('name' => 'ras_ip'), $this);?>
">
	    	<?php echo smarty_function_helpicon(array('subject' => 'ras ip','category' => 'ras'), $this);?>

	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','err' => 'ras_desc_err')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    RAS Description
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    	<input class="text" type=text name=ras_description value="<?php echo smarty_function_ifisinrequest(array('name' => 'ras_description'), $this);?>
">
	    	<?php echo smarty_function_helpicon(array('subject' => 'ras description','category' => 'ras'), $this);?>

	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','err' => 'ras_type_err')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    RAS Type
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<select name=ras_type>
		    <?php echo smarty_function_html_options(array('output' => $this->_tpl_vars['ras_types'],'values' => $this->_tpl_vars['ras_types'],'selected' => $this->_tpl_vars['ras_type']), $this);?>

		</select>
		<?php echo smarty_function_helpicon(array('subject' => 'ras type','category' => 'ras'), $this);?>

	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','err' => 'radius_secret_err')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    Radius Secret
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    	<input class="text" type=text name="radius_secret" value="<?php echo smarty_function_ifisinrequest(array('name' => 'radius_secret'), $this);?>
">
		<?php echo smarty_function_helpicon(array('subject' => 'radius secret','category' => 'ras'), $this);?>


	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','err' => 'comment_err','comment' => 'TRUE')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    Comment
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right','comment' => 'TRUE')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    <textarea name=comment class=text><?php echo smarty_function_ifisinrequest(array('name' => 'comment'), $this);?>
</textarea>
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

</form>
<?php $this->_tag_stack[] = array('addRelatedLink', array()); $_block_repeat=true;smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <a href="/IBSng/admin/ras/ras_list.php" class="RightSide_links">
	RAS List
     </a>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('setAboutPage', array('title' => 'Add New RAS')); $_block_repeat=true;smarty_block_setAboutPage($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_setAboutPage($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>