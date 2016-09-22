<?php /* Smarty version 3.1.27, created on 2016-09-19 22:55:03
         compiled from "D:\OpenServer\domains\dom1.modx\www\manager\templates\default\workspaces\index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2319357e04297905bc2_26361463%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7cfb9d844e89f542857af79cb7649e63e13f614d' => 
    array (
      0 => 'D:\\OpenServer\\domains\\dom1.modx\\www\\manager\\templates\\default\\workspaces\\index.tpl',
      1 => 1474314513,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2319357e04297905bc2_26361463',
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e042979155c0_53376719',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e042979155c0_53376719')) {
function content_57e042979155c0_53376719 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2319357e04297905bc2_26361463';
echo (($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp);?>

<div id="modx-panel-workspace-div"></div>
<?php }
}
?>