<?php /* Smarty version 3.1.27, created on 2016-09-19 22:48:44
         compiled from "D:\OpenServer\domains\dom1.modx\www\setup\templates\footer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1988457e0411cd25be8_30133348%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '037c6e7f4922171b1a367d8c6a226e259729cbb2' => 
    array (
      0 => 'D:\\OpenServer\\domains\\dom1.modx\\www\\setup\\templates\\footer.tpl',
      1 => 1469078022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1988457e0411cd25be8_30133348',
  'variables' => 
  array (
    '_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e0411cd58875_77203212',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e0411cd58875_77203212')) {
function content_57e0411cd58875_77203212 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once 'D:/OpenServer/domains/dom1.modx/www/core/model/smarty/plugins\\modifier.replace.php';

$_smarty_tpl->properties['nocache_hash'] = '1988457e0411cd25be8_30133348';
?>
        </div>
        <!-- end content -->
        <div class="clear">&nbsp;</div>
    </div>
</div>

<!-- start footer -->
<div id="footer">
    <div id="footer-inner">
    <div class="container_12">
        <p><?php ob_start();
echo date('Y');
$_tmp1=ob_get_clean();
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['_lang']->value['modx_footer1'],'[[+current_year]]',$_tmp1);?>
</p>
        <p><?php echo $_smarty_tpl->tpl_vars['_lang']->value['modx_footer2'];?>
</p>
    </div>
    </div>
</div>

<div class="post_body">

</div>
<!-- end footer -->
</body>
</html><?php }
}
?>