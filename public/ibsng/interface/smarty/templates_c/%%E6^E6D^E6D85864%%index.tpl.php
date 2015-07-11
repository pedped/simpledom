<?php /* Smarty version 2.6.13, created on 2013-07-19 05:05:49
         compiled from admin/graph/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'viewTable', 'admin/graph/index.tpl', 10, false),array('block', 'menuTR', 'admin/graph/index.tpl', 11, false),array('block', 'addRelatedLink', 'admin/graph/index.tpl', 39, false),array('block', 'setAboutPage', 'admin/graph/index.tpl', 76, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array('title' => 'Graphs','selected' => 'Onlines Graph')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table border=0 width="100%" height="100%" cellspacing=0 cellpadding=0>
    <tr>
	<td colspan=2 height=30>
	</td>
    </tr>	
    <tr>
	<td valign="center" align="center"> 
		<?php $this->_tag_stack[] = array('viewTable', array('title' => 'Graphs','table_width' => '200','nofoot' => 'TRUE','color' => 'brown','arrow_color' => 'white')); $_block_repeat=true;smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		    <?php $this->_tag_stack[] = array('menuTR', array()); $_block_repeat=true;smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<a href="/IBSng/admin/graph/realtime/realtime.php?img_url=onlines.php" class="page_menu">All Onlines RealTime Graph</a>
		    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		    <?php $this->_tag_stack[] = array('menuTR', array()); $_block_repeat=true;smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<a href="/IBSng/admin/graph/realtime/realtime.php?img_url=onlines.php?internet=1" class="page_menu">Internet Onlines RealTime Graph</a>
		    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		    <?php $this->_tag_stack[] = array('menuTR', array()); $_block_repeat=true;smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<a href="/IBSng/admin/graph/realtime/realtime.php?img_url=onlines.php?voip=1" class="page_menu">VoIP Onlines RealTime Graph</a>
		    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		    <?php $this->_tag_stack[] = array('menuTR', array()); $_block_repeat=true;smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<a href="/IBSng/admin/graph/realtime/realtime.php?img_url=bw.php" class="page_menu">Internet BW RealTime Graph</a>
		    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

		    <?php $this->_tag_stack[] = array('menuTR', array()); $_block_repeat=true;smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<a href="/IBSng/admin/graph/onlines.php" class="page_menu">Onlines Graph</a>
		    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

		    <?php $this->_tag_stack[] = array('menuTR', array()); $_block_repeat=true;smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<a href="/IBSng/admin/graph/analysis/connection_analysis.php" class="page_menu">Connections Analysis</a>
		    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_menuTR($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

		    
		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

	</td>
    </tr>
</table>

<?php $this->_tag_stack[] = array('addRelatedLink', array()); $_block_repeat=true;smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <a href="/IBSng/admin/graph/realtime/realtime.php?img_url=onlines.php" class="RightSide_links">
	All RealTime Graph
    </a>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('addRelatedLink', array()); $_block_repeat=true;smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <a href="/IBSng/admin/graph/realtime/realtime.php?img_url=onlines.php?internet=1" class="RightSide_links">
	Internet RealTime Graph
    </a>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('addRelatedLink', array()); $_block_repeat=true;smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <a href="/IBSng/admin/graph/realtime/realtime.php?img_url=onlines.php?voip=1" class="RightSide_links">
	VoIP RealTime Graph
    </a>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('addRelatedLink', array()); $_block_repeat=true;smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <a href="/IBSng/admin/graph/realtime/realtime.php?img_url=bw.php" class="RightSide_links">
	BW RealTime Graph
    </a>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('addRelatedLink', array()); $_block_repeat=true;smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <a href="/IBSng/admin/graph/onlines.php" class="RightSide_links">
	Onlines Graph
    </a>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('addRelatedLink', array()); $_block_repeat=true;smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <a href="/IBSng/admin/graph/analysis/connection_analysis.php" class="RightSide_links">
	Connection Analysis
    </a>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addRelatedLink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>


<?php $this->_tag_stack[] = array('setAboutPage', array('title' => 'Graph')); $_block_repeat=true;smarty_block_setAboutPage($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_setAboutPage($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
