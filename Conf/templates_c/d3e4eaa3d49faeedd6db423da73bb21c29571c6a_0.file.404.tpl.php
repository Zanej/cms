<?php
/* Smarty version 3.1.29, created on 2016-04-06 23:30:48
  from "C:\Users\zane2\Documents\progetti\cms\Resources\404.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5705800895fb46_21775675',
  'file_dependency' => 
  array (
    'd3e4eaa3d49faeedd6db423da73bb21c29571c6a' => 
    array (
      0 => 'C:\\Users\\zane2\\Documents\\progetti\\cms\\Resources\\404.tpl',
      1 => 1459978246,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./default.tpl' => 1,
  ),
),false)) {
function content_5705800895fb46_21775675 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "content", array (
  0 => 'block_236895705800895a988_24379538',
  1 => false,
  3 => 0,
  2 => 0,
));
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'content'}  file:C:/Users/zane2/Documents/progetti/cms//Resources/404.tpl */
function block_236895705800895a988_24379538($_smarty_tpl, $_blockParentStack) {
?>

    404 page not found!
<?php
}
/* {/block 'content'} */
}
