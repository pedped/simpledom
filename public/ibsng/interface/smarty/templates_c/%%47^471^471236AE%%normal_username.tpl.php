<?php /* Smarty version 2.6.13, created on 2015-03-17 01:57:22
         compiled from plugins/user/edit/normal_username.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'attrUpdateMethod', 'plugins/user/edit/normal_username.tpl', 1, false),array('function', 'attrDefault', 'plugins/user/edit/normal_username.tpl', 16, false),array('function', 'multistr', 'plugins/user/edit/normal_username.tpl', 22, false),array('function', 'helpicon', 'plugins/user/edit/normal_username.tpl', 23, false),array('function', 'ifisinrequest', 'plugins/user/edit/normal_username.tpl', 37, false),array('block', 'viewTable', 'plugins/user/edit/normal_username.tpl', 2, false),array('block', 'addEditTD', 'plugins/user/edit/normal_username.tpl', 3, false),)), $this); ?>
<?php echo smarty_function_attrUpdateMethod(array('update_method' => 'normalAttrs'), $this);?>

<?php $this->_tag_stack[] = array('viewTable', array('title' => 'Internet Username and Password','table_width' => '380','nofoot' => 'TRUE')); $_block_repeat=true;smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?> 
    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Has Internet Username
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox name="has_normal_username" value="t" class=checkbox <?php if (attrDefault ( $this->_tpl_vars['user_attrs'] , 'normal_username' , 'has_normal_username' ) != ""): ?>checked<?php endif; ?> onClick='normal_select.toggle("normal_username")'>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Internet Username
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=hidden name=current_normal_username value='<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'normal_username','default_request' => 'current_normal_username'), $this);?>
'>
	<input id="normal_username" type=text  class=text name="normal_username" 
	    value="<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'normal_username','default_request' => 'normal_username'), $this);?>
" 
	    onChange="updateUserAddCheckImage('normal','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'normal_username','default_request' => 'current_normal_username'), $this);?>
',0);" 
	    onKeyUp="updateUserAddCheckImage('normal','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'normal_username','default_request' => 'current_normal_username'), $this);?>
',1);"
	> 
	<?php echo smarty_function_multistr(array('form_name' => 'user_edit','input_name' => 'normal_username'), $this);?>

	<?php echo smarty_function_helpicon(array('subject' => 'normal username','category' => 'user'), $this);?>

	<a href="#" onClick="showUserAddCheckWindow('normal','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'normal_username','default_request' => 'normal_username'), $this);?>
');">
	    <img border=0 name="normal_user_exists" src="/IBSng/admin/user/check_user_for_add.php?image=t&username=&type=normal&current_username=" title="Users Exist">
	</a>
	<script language=javascript>
	    updateUserAddCheckImage('normal','<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'normal_username','default_request' => 'current_normal_username'), $this);?>
',1);
	</script>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Generate Password
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox id="generate_password" name="generate_password" value="t" class=checkbox <?php echo smarty_function_ifisinrequest(array('name' => 'generate_password','value' => 'checked'), $this);?>
 onClick='normalGeneratePasswordOnClick(this);'>
	<?php echo smarty_function_helpicon(array('subject' => 'generate password','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','id' => 'password_char_tr')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Password Includes
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Character <input type=checkbox class=checkbox name="password_character" id="password_character" value="t" <?php echo smarty_function_ifisinrequest(array('name' => 'password_character','value' => 'checked','default' => 'checked'), $this);?>
> 
	Digit <input type=checkbox class=checkbox name="password_digit" id="password_digit" value="t" <?php echo smarty_function_ifisinrequest(array('name' => 'password_digit','value' => 'checked','default' => 'checked'), $this);?>
> 
	<?php echo smarty_function_helpicon(array('subject' => 'password characters','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','id' => 'password_len_tr')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Generated Password Length
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=text id="password_len" name="password_len" value="<?php echo smarty_function_ifisinrequest(array('name' => 'password_len','default' => '6'), $this);?>
" class=small_text>
	<?php echo smarty_function_helpicon(array('subject' => 'password length','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left','id' => 'password_tr')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Password
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=text id="password" name="password" value="<?php echo smarty_function_attrDefault(array('target' => 'user','default_var' => 'normal_password','default_request' => 'password'), $this);?>
" class=text>
	<?php echo smarty_function_multistr(array('form_name' => 'user_edit','input_name' => 'password'), $this);?>

	<?php echo smarty_function_helpicon(array('subject' => 'password','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Save In List<font size=1>[Usernames/Passwords]</font>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox name="normal_save_user_add" id="normal_save_user_add" value="t" class=checkbox <?php echo smarty_function_ifisinrequest(array('name' => 'normal_save_user_add','value' => 'checked'), $this);?>
>
	<?php echo smarty_function_helpicon(array('subject' => 'save username and password','category' => 'user'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $this->_tag_stack[] = array('viewTable', array('title' => 'Upload Internet Username and Password From File','table_width' => '380','nofoot' => 'TRUE')); $_block_repeat=true;smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?> 
    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	Upload Internet Usernames from file
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<input type=checkbox name="has_normal_username_from_file" value="t" class=checkbox onClick='return normalUploadChanged(this)'>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'left')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	File (Format: Username,Password)
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('addEditTD', array('type' => 'right')); $_block_repeat=true;smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <input type=file name="normal_username_from_file" class=text id="normal_username_from_file" size=15>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_addEditTD($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_viewTable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<br>




<script language="javascript">
	normal_select=new DomContainer();
	normal_select.disable_unselected=true;
	normal_select.addByID("normal_username",new Array("generate_password","password","password_len","password_character","password_digit","normal_save_user_add"));
<?php if (attrDefault ( $this->_tpl_vars['user_attrs'] , 'normal_username' , 'has_normal_username' ) != ""): ?>
    normal_select.select("normal_username");
<?php else: ?>
    normal_select.select(null);
<?php endif; ?>

	normal_from_file_select=new DomContainer();
	normal_from_file_select.disable_unselected=true;
	normal_from_file_select.addByID("normal_username_from_file",[]);
	normal_from_file_select.select(null);

	generate_password=new DomContainer();
	generate_password.addByID("password_tr",[]);
	generate_password.addByID("password_char_tr",new Array("password_len_tr"));
	generate_password.setOnSelect("display","");
	generate_password.setOnUnSelect("display","none");	
<?php if (isInRequest ( 'generate_password' )): ?>
	generate_password.select("password_char_tr");
<?php else: ?>
	generate_password.select("password_tr");	
<?php endif; ?>

<?php echo '

function normalUploadChanged(obj)
{
    if(document.user_edit.has_normal_username.checked)
    {
	alert("Please turn off Has Internet Username first");
	return false;
    }
    normal_from_file_select.toggle("normal_username_from_file");
    return true;
}

function normalGeneratePasswordOnClick(obj)
{
    if(obj.checked)
    {
	generate_password.select("password_char_tr");
	document.user_edit.normal_save_user_add.checked=true;
    }
    else
	generate_password.select("password_tr");
}
'; ?>

</script>