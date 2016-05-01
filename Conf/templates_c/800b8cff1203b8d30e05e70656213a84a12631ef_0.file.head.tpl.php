<?php
/* Smarty version 3.1.29, created on 2016-04-16 19:00:44
  from "C:\Users\zane2\Documents\progetti\cms\Resources\head.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57126fbc238180_82010003',
  'file_dependency' => 
  array (
    '800b8cff1203b8d30e05e70656213a84a12631ef' => 
    array (
      0 => 'C:\\Users\\zane2\\Documents\\progetti\\cms\\Resources\\head.tpl',
      1 => 1460825915,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57126fbc238180_82010003 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>
<title>
    <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "title", array (
  0 => 'block_46357126fbc2204a8_08001329',
  1 => false,
  3 => 0,
  2 => 0,
));
?>
 
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "css", array (
  0 => 'block_188457126fbc229f28_80400397',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

    <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "js", array (
  0 => 'block_2314157126fbc232676_89005133',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

    
    
        <?php }
/* {block 'title'}  file:./head.tpl */
function block_46357126fbc2204a8_08001329($_smarty_tpl, $_blockParentStack) {
?>

        Page title
    <?php
}
/* {/block 'title'} */
/* {block 'css'}  file:./head.tpl */
function block_188457126fbc229f28_80400397($_smarty_tpl, $_blockParentStack) {
?>

        <link rel="stylesheet" href="/web/assets/css/clear.css"/>
        <!--<link rel="stylesheet" href="/web/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/web/assets/css/bootstrap-theme.min.css" />-->
        <link rel="stylesheet" href="/web/assets/fonts/glyphicons-halflings-regular.eot" />
        <link rel="stylesheet" href="/web/assets/fonts/glyphicons-halflings-regular.svg" />
        <link rel="stylesheet" href="/web/assets/fonts/glyphicons-halflings-regular.ttf" />
        <link rel="stylesheet" href="/web/assets/fonts/glyphicons-halflings-regular.woff" />
        <link rel="stylesheet" href="/web/assets/fonts/glyphicons-halflings-regular.woff2" />
        
        <link rel="stylesheet" href="/web/assets/css/style.css"/>
    <?php
}
/* {/block 'css'} */
/* {block 'js'}  file:./head.tpl */
function block_2314157126fbc232676_89005133($_smarty_tpl, $_blockParentStack) {
?>

        <?php echo '<script'; ?>
 src="/web/assets/js/jquery-2.2.3.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="/web/assets/js/bootstrap.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="/web/assets/js/validator.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="/web/assets/js/ajaxloader.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="/web/assets/js/script.js"><?php echo '</script'; ?>
>
        <!--<?php echo '<script'; ?>
 src="/web/assets/js/npm.js"><?php echo '</script'; ?>
>-->
    <?php
}
/* {/block 'js'} */
}
