<?php /* Smarty version 2.6.13, created on 2015-03-17 01:57:22
         compiled from plugins/user/edit/voip_username.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'attrUpdateMethod', 'plugins/user/edit/voip_username.tpl', 1, false),array('function', 'attrDefault', 'plugins/user/edit/voip_username.tpl', 16, false),array('function', 'multistr', 'plugins/user/edit/voip_username.tpl', 22, false),array('function', 'helpicon', 'plugins/user/edit/voip_username.tpl', 23, false),array('function', 'ifisinrequest', 'plugins/user/edit/voip_username.tpl', 37, false),array('block', 'viewTable', 'plugins/user/edit/voip_username.tpl', 2, false),array('block', 'addEditTD', 'plugins/user/edit/voip_username.tpl', 3, false),)), $this); ?>
<?php echo smarty_function_attrUpdateMethod(array('update_method' => 'voipAttrs'), $this);?>

<?php $this->_tag_stack[] = array('viewTable', array('title' => 'VoIP Username and Password','table_width' => '380','nofoot' => 'TRUE')); $_block_repeat=true;smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?> 
    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Has VoIP Username
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox name="has_voip_username" value="t" class=checkbox <?php if (attrDefault ( $this->_tpl_vars['user_attrs'] , 'voip_username' , 'has_voip_username' ) != ""): ?>checked<?php endif; ?> onClick='voip_select.toggle("voip_username")'>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	VoIP Username
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=hidden name=current_voip_username value='<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'voip_username','default_request' => 'current_voip_username'), $this);?>
'>
	<input id="voip_username" type=text  class=text name="voip_username" 
	    value="<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'voip_username','default_request' => 'voip_username'), $this);?>
" 
	    onChange="updateUserAddCheckImage('voip','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'voip_username','default_request' => 'current_voip_username'), $this);?>
',0);" 
	    onKeyUp="updateUserAddCheckImage('voip','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'voip_username','default_request' => 'current_voip_username'), $this);?>
',1);"
	> 
	<?php echo smarty_function_multistr(array('form_name' => 'user_edit','input_name' => 'voip_username'), $this);?>

	<?php echo smarty_function_helpicon(array('subject' => 'voip username','category' => 'user'), $this);?>

	<a href="#" onClick="showUserAddCheckWindow('voip','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'voip_username','default_request' => 'voip_username'), $this);?>
');">
	    <img border=0 name="voip_user_exists" src="/IBSng/admin/user/check_user_for_add.php?image=t&username=&type=voip&current_username=" title="Users Exist">
	</a>
	<script language=javascript>
	    updateUserAddCheckImage('voip','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'voip_username','default_request' => 'current_voip_username'), $this);?>
',1);
	</script>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Generate Password
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox id="voip_generate_password" name="voip_generate_password" value="t" class=checkbox <?php echo smarty_function_ifisinrequest(array('name' => 'voip_generate_password','value' => 'checked'), $this);?>
 onClick='voipGeneratePasswordOnClick(this);'>
	<?php echo smarty_function_helpicon(array('subject' => 'generate password','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','id' => 'voip_password_char_tr')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Password Includes
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Character <input type=checkbox class=checkbox name="voip_password_character" id="voip_password_character" value="t" <?php echo smarty_function_ifisinrequest(array('name' => 'voip_password_character','value' => 'checked'), $this);?>
> 
	Digit <input type=checkbox class=checkbox name="voip_password_digit" id="voip_password_digit" value="t" <?php echo smarty_function_ifisinrequest(array('name' => 'voip_password_digit','value' => 'checked','default' => 'checked'), $this);?>
> 
	<?php echo smarty_function_helpicon(array('subject' => 'password characters','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','id' => 'voip_password_len_tr')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Generated Password Length
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=text id="voip_password_len" name="voip_password_len" value="<?php echo smarty_function_ifisinrequest(array('name' => 'voip_password_len','default' => '6'), $this);?>
" class=small_text>
	<?php echo smarty_function_helpicon(array('subject' => 'password length','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','id' => 'voip_password_tr')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Password
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=text id="voip_password" name="voip_password" value="<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'voip_password','default_request' => 'voip_password'), $this);?>
" class=text>
	<?php echo smarty_function_multistr(array('form_name' => 'user_edit','input_name' => 'voip_password'), $this);?>

	<?php echo smarty_function_helpicon(array('subject' => 'password','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Save In List<font size=1>[Usernames/Passwords]</font>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox name="voip_save_user_add" id="voip_save_user_add" value="t" class=checkbox <?php echo smarty_function_ifisinrequest(array('name' => 'voip_save_user_add','value' => 'checked'), $this);?>
>
	<?php echo smarty_function_helpicon(array('subject' => 'save username and password','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $this->_tag_stack[] = array('viewTable', array('title' => 'Upload VoIP Username and Password From File','table_width' => '380','nofoot' => 'TRUE')); $_block_repeat=true;smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?> 
    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Upload VoIP Usernames from file
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox name="has_voip_username_from_file" value="t" class=checkbox onClick='return voipUploadChanged(this)'>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	File (Format: Username,Password)
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <input type=file name="voip_username_from_file" class=text id="voip_username_from_file" size=15>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<br>

<script language="javascript">

	voip_select=new DomContainer();
	voip_select.disable_unselected=true;
	voip_select.addByID("voip_username",new Array("voip_generate_password","voip_password","voip_password_len","voip_password_character","voip_password_digit","voip_save_user_add"));
<?php if (attrDefault ( $this->_tpl_vars['user_attrs'] , 'voip_username' , 'has_voip_username' ) != ""): ?>
    voip_select.select("voip_username");
<?php else: ?>
    voip_select.select(null);
<?php endif; ?>

	voip_from_file_select=new DomContainer();
	voip_from_file_select.disable_unselected=true;
	voip_from_file_select.addByID("voip_username_from_file",[]);
	voip_from_file_select.select(null);

	voip_generate_password=new DomContainer();
	voip_generate_password.addByID("voip_password_tr",[]);
	voip_generate_password.addByID("voip_password_char_tr",new Array("voip_password_len_tr"));
	voip_generate_password.setOnSelect("display","");
	voip_generate_password.setOnUnSelect("display","none");	
<?php if (isInRequest ( 'voip_generate_password' )): ?>
	voip_generate_password.select("voip_password_char_tr");
<?php else: ?>
	voip_generate_password.select("voip_password_tr");	
<?php endif;  echo '

function voipUploadChanged(obj)
{
    if(document.user_edit.has_voip_username.checked)
    {
	alert("Please turn off Has VoIP Username first");
	return false;
    }
    voip_from_file_select.toggle("voip_username_from_file");
    return true;
}

function voipGeneratePasswordOnClick(obj)
{
    if(obj.checked)
    {
	voip_generate_password.select("voip_password_char_tr");
	document.user_edit.voip_save_user_add.checked=true;
    }
    else
	voip_generate_password.select("voip_password_tr");
}
'; ?>

</script>