<?php
/* Smarty version 3.1.29, created on 2016-04-06 23:27:23
  from "C:\Users\zane2\Documents\progetti\cms\Resources\view.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57057f3befec88_19864788',
  'file_dependency' => 
  array (
    '32fee8a8531dbef31acf527bd816c88287ee2c5c' => 
    array (
      0 => 'C:\\Users\\zane2\\Documents\\progetti\\cms\\Resources\\view.tpl',
      1 => 1459978042,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./default.tpl' => 1,
  ),
),false)) {
function content_57057f3befec88_19864788 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "content", array (
  0 => 'block_1800357057f3bef2058_48439544',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'content'}  file:C:/Users/zane2/Documents/progetti/cms//Resources/view.tpl */
function block_1800357057f3bef2058_48439544($_smarty_tpl, $_blockParentStack) {
?>

    Sono un'agenzia!<?php echo $_smarty_tpl->tpl_vars['agenzia']->value->getNome();?>

<?php
}
/* {/block 'content'} */
}
