<?php
/* Smarty version 3.1.29, created on 2016-04-06 23:34:25
  from "C:\Users\zane2\Documents\progetti\cms\Resources\default.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_570580e1f16872_93690159',
  'file_dependency' => 
  array (
    '75d00d8c6f7684f63b4146f3ffbd0da80dc3c599' => 
    array (
      0 => 'C:\\Users\\zane2\\Documents\\progetti\\cms\\Resources\\default.tpl',
      1 => 1459978446,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./head.tpl' => 1,
    'file:./header.tpl' => 1,
    'file:./footer.tpl' => 1,
  ),
),false)) {
function content_570580e1f16872_93690159 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>
<html>
    <head>
        <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "head", array (
  0 => 'block_2506570580e1eea144_57794262',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

    </head>
    <body>
        <div class="contenitore">
            <header>
                <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "header", array (
  0 => 'block_26427570580e1efa6f8_45770756',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

            </header>
            <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "content", array (
  0 => 'block_7768570580e1f05c19_53419192',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

            <footer>
                <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "footer", array (
  0 => 'block_27569570580e1f0cf73_66544456',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

            </footer>
        </div>
    </body>
        
</html><?php }
/* {block 'head'}  file:./default.tpl */
function block_2506570580e1eea144_57794262($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php
}
/* {/block 'head'} */
/* {block 'header'}  file:./default.tpl */
function block_26427570580e1efa6f8_45770756($_smarty_tpl, $_blockParentStack) {
?>

                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php
}
/* {/block 'header'} */
/* {block 'content'}  file:./default.tpl */
function block_7768570580e1f05c19_53419192($_smarty_tpl, $_blockParentStack) {
?>

                <div class='nav_left'>
                    
                </div>
                <div class='nav_right'>
                    
                </div>
            <?php
}
/* {/block 'content'} */
/* {block 'footer'}  file:./default.tpl */
function block_27569570580e1f0cf73_66544456($_smarty_tpl, $_blockParentStack) {
?>

                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php
}
/* {/block 'footer'} */
}
