<?php /* Smarty version 3.1.27, created on 2016-09-19 22:50:30
         compiled from "D:\OpenServer\domains\dom1.modx\www\manager\templates\default\welcome.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3022657e041867e6299_64525341%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf494ca13c6e1a5884d7ee326734e345c5aba85e' => 
    array (
      0 => 'D:\\OpenServer\\domains\\dom1.modx\\www\\manager\\templates\\default\\welcome.tpl',
      1 => 1474314513,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3022657e041867e6299_64525341',
  'variables' => 
  array (
    'dashboard' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e041867edf94_69609872',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e041867edf94_69609872')) {
function content_57e041867edf94_69609872 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3022657e041867e6299_64525341';
?>
<div id="modx-panel-welcome-div"></div>

<div id="modx-dashboard" class="dashboard">
<?php echo $_smarty_tpl->tpl_vars['dashboard']->value;?>

</div><?php }
}
?>