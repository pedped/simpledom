<?php /* Smarty version 2.6.13, created on 2013-07-19 05:05:55
         compiled from admin/report/online_users_js.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'tabTable', 'admin/report/online_users_js.tpl', 27, false),array('block', 'tabContent', 'admin/report/online_users_js.tpl', 28, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array('title' => 'Online Users','selected' => 'Online Users','page_valign' => 'top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 

<script language="javascript" src="/IBSng/js/check_box_container.js"></script>
<script type="text/javascript" src="/IBSng/js/onlines.js"></script>
<script type="text/javascript" src="/IBSng/js/libface.js"></script>

<table align=center border=0 style="display: none" id="error_table"> 
<tr> 
<td align=left>
    <img border="0" src="/IBSng/images/msg/before_error_message.gif">
</td>
    <td align=left class="error_messages">
	<span id="error_message">&nbsp;</span>
    </td>
</tr>
</table>

<div align=center><a href="online_users.php" class="page_menu" style="font-weight: bold; font-size: 11; font-family: tahoma;">Switch to Normal Mode</a></div>
<br>

<!-- kill user frame -->
<iframe name=msg id=msg border=0 FRAMEBORDER=0 SCROLLING=NO height=50 valign=top src="/IBSng/util/empty.php"></iframe>

<?php $this->_tag_stack[] = array('tabTable', array('tabs' => "Ras Filter,Internet,VoIP,Username Filter",'content_height' => 50,'action_icon' => "",'form_name' => "")); $_block_repeat=true;smarty_block_tabTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('tabContent', array('tab_name' => 'Ras Filter','add_table_tag' => 'TRUE','add_table_id' => 'ras_filter_select')); $_block_repeat=true;smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/report/online_users/ras_filter.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('tabContent', array('tab_name' => 'Username Filter','add_table_tag' => 'TRUE','add_table_id' => 'username_filter_select')); $_block_repeat=true;smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/report/online_users/username_filter.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('tabContent', array('tab_name' => 'Internet','add_table_tag' => 'TRUE','add_table_id' => 'internet_select')); $_block_repeat=true;smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/report/online_users/internet_attrs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('tabContent', array('tab_name' => 'VoIP','add_table_tag' => 'TRUE','add_table_id' => 'voip_select')); $_block_repeat=true;smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/report/online_users/voip_attrs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_tabContent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <tr><td colspan=20 align=center>	

    <table width=100% border="0" cellspacing="0" bordercolor="#000000" cellpadding="0">    

	<tr class="List_Foot_Line_red">
		<td colspan=30></td>
	</tr>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/report/online_users/tab_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 

    </table>

    </td></tr>


<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_tabTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<span id="all_internet">

<form id="internet_onlines" name="internet_onlines"></form>

</span>

<br />

<span id="all_voip">

<form id="voip_onlines" name="voip_onlines"></form>

</span>

<br />

<input align=center type=image src="/IBSng/images/icon/kick.gif" name=kick value="kick" onClick="actionIconClicked('kick')">
<input align=center type=image src="/IBSng/images/icon/clear.gif" name=clear value="clear" onClick="actionIconClicked('clear')">
<input align=center type=image src="/IBSng/images/icon/message.gif" name=clear value="message" onClick="actionIconClicked('message')">

<?php echo '
<script>
setCheckBoxesOnclick("internet_select",displayOnlines);
setCheckBoxesOnclick("voip_select",displayOnlines);

window.internet_onlines=[];
window.voip_onlines=[];

window.refresh_timer_status="play";
requestOnlines();


function doRequest()
{
    requestOnlines();
}

function getOnlinesHandler(http_request)
{
    if (http_request.readyState == 4) 
    {    
	if (http_request.status == 200) 
	{
	    document.getElementById("request_time").innerHTML=(new Date().getTime() - window.request_send)/1000
	    
    	    clearError();

	    if(http_request.responseXML.getElementsByTagName("result")[0].childNodes[0].nodeValue!="SUCCESS")
		showError(http_request.responseXML.getElementsByTagName("reason")[0].childNodes[0].nodeValue);
	    else
	    {
		var parser_start=new Date().getTime();

	        var xml_internet_onlines=http_request.responseXML.getElementsByTagName("internet_onlines");
		var xml_voip_onlines=http_request.responseXML.getElementsByTagName("voip_onlines");
	        window.internet_onlines=convertOnlinesToArray(xml_internet_onlines[0].childNodes);
		window.voip_onlines=convertOnlinesToArray(xml_voip_onlines[0].childNodes);

		document.getElementById("parser_time").innerHTML=(new Date().getTime() - parser_start)/1000
		
		var render_start=new Date().getTime();
		
		displayOnlines();
		
		document.getElementById("render_time").innerHTML=(new Date().getTime() - render_start)/1000
	    }
	    
	}
	else
	    showError("Internal Error");
	
	updateTimer();

    }

}


function requestOnlines()
{
    var http_request;
    changeTimerState("_Loading_");
    
    if (window.XMLHttpRequest)
	http_request = new XMLHttpRequest();
    else if (window.ActiveXObject) 
	http_request = new ActiveXObject("Microsoft.XMLHTTP");

    if(http_request)
    {
	window.request_send=new Date().getTime();
	http_request.onreadystatechange = function() { getOnlinesHandler(http_request) };
	var url=\'/IBSng/admin/report/online_users_js.php?internet_order_by=\'+getCurSort("internet")+
							\'&internet_desc=\'+getCurDesc("internet")+
							\'&voip_order_by=\'+getCurSort("voip")+
							"&voip_desc="+getCurDesc("voip")+
							"&"+getFiltersURL();
	http_request.open(\'GET\', url, true);
	http_request.send(null);	
    }
    else
	showError("Browser doesn\'t support xmlhttp");
}



</script>

'; ?>


<br />
<p align=right style="font-family: tahoma; font-size:6pt"> Request: <span id=request_time></span> Parser: <span id=parser_time></span> Render: <span id=render_time></span> Seconds</font>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/report/online_users_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>