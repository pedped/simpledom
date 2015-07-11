<?php /* Smarty version 2.6.13, created on 2015-03-17 01:52:20
         compiled from util/show_multistr.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'helpicon', 'util/show_multistr.tpl', 17, false),array('function', 'multiTableTR', 'util/show_multistr.tpl', 33, false),array('function', 'math', 'util/show_multistr.tpl', 36, false),array('function', 'multiTablePad', 'util/show_multistr.tpl', 44, false),array('modifier', 'truncate', 'util/show_multistr.tpl', 20, false),array('block', 'multiTable', 'util/show_multistr.tpl', 30, false),array('block', 'multiTableTD', 'util/show_multistr.tpl', 35, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('title' => 'Show Multiple Strings')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "err_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table border="0"  class="List_Main" cellspacing="1" bordercolor="#FFFFFF" cellpadding="0" width=100%>
	<tr> <td>
		<!-- List Title Table -->
		<table border="0" cellspacing="0" cellpadding="0" class="List_Title">
			<tr>
				<td class="List_Title_Begin" rowspan="2"><img border="0" src="/IBSng/images/form/begin_form_title_red.gif"></td>
				<td class="List_Title" rowspan="2">Show Multiple Strings <?php echo smarty_function_helpicon(array('subject' => 'multi str','category' => 'util'), $this);?>
</td>
				<td class="List_Title_End" rowspan="2"><img border="0" src="/IBSng/images/list/end_of_list_title_red.gif" width="5" height="20"></td>
				<td class="List_Title_Top_Line" align="RIGHT">
				Raw Multi String:<font color="#800000"> <?php echo ((is_array($_tmp=$this->_tpl_vars['raw_str'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?>
</font></td>
			</tr>
			<tr>
				<td class="List_Title_End_Line"></td>
			</tr>
		</table>
		<!-- End List Title Table -->
		</td>
		    <tr>
			<td>
	<?php $this->_tag_stack[] = array('multiTable', array()); $_block_repeat=true;smarty_block_multiTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	    <?php $_from = $this->_tpl_vars['all_strs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['str']):
?>
	        <?php if ($this->_tpl_vars['index']%4 == 0): ?>
		    <?php echo smarty_function_multiTableTR(array(), $this);?>

    		<?php endif; ?>
		<?php $this->_tag_stack[] = array('multiTableTD', array('type' => 'left')); $_block_repeat=true;smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		    <?php echo smarty_function_math(array('equation' => "index+1",'index' => $this->_tpl_vars['index']), $this);?>
.
		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		<?php $this->_tag_stack[] = array('multiTableTD', array('type' => 'right','width' => "25%")); $_block_repeat=true;smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		    <?php echo $this->_tpl_vars['str']; ?>

		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_multiTableTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	    <?php endforeach; endif; unset($_from); ?>

	    <?php echo smarty_function_math(array('equation' => "index+1",'index' => $this->_tpl_vars['index'],'assign' => 'index'), $this);?>

	    <?php echo smarty_function_multiTablePad(array('last_index' => $this->_tpl_vars['index'],'go_until' => 4), $this);?>

	    
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_multiTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<!-- view table Foot -->
	<tr class="List_Foot_Line_red">
		<td colspan=100></td>
	</tr>
	<!-- End view table Foot-->
</table>


<?php echo '
<script language="javascript">
    window.focus();
</script>
'; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>