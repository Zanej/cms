<?php
/* Smarty version 3.1.29, created on 2016-04-09 20:42:46
  from "C:\Users\zane2\Documents\progetti\cms\Resources\default.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57094d26169655_69536612',
  'file_dependency' => 
  array (
    '75d00d8c6f7684f63b4146f3ffbd0da80dc3c599' => 
    array (
      0 => 'C:\\Users\\zane2\\Documents\\progetti\\cms\\Resources\\default.tpl',
      1 => 1460227363,
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
function content_57094d26169655_69536612 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>
<html>
    <head>
        <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "head", array (
  0 => 'block_3058757094d26127a40_24221821',
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
  0 => 'block_245657094d26138e93_46526677',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

            </header>
            <div class="contenuto">
                <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "content", array (
  0 => 'block_561757094d26146216_42395583',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

            </div>
            <footer>
                <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "footer", array (
  0 => 'block_1005257094d2615ed00_04285506',
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
function block_3058757094d26127a40_24221821($_smarty_tpl, $_blockParentStack) {
?>

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php
}
/* {/block 'head'} */
/* {block 'header'}  file:./default.tpl */
function block_245657094d26138e93_46526677($_smarty_tpl, $_blockParentStack) {
?>

                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php
}
/* {/block 'header'} */
/* {block 'left'}  file:./default.tpl */
function block_3016657094d2614b1d7_56877971($_smarty_tpl, $_blockParentStack) {
?>

                        <?php
}
/* {/block 'left'} */
/* {block 'right'}  file:./default.tpl */
function block_418357094d26153088_41043860($_smarty_tpl, $_blockParentStack) {
?>

                        <?php
}
/* {/block 'right'} */
/* {block 'content'}  file:./default.tpl */
function block_561757094d26146216_42395583($_smarty_tpl, $_blockParentStack) {
?>

                    <div class='left'>
                        <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "left", array (
  0 => 'block_3016657094d2614b1d7_56877971',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

                    </div>
                    <div class='right'>
                        <?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "right", array (
  0 => 'block_418357094d26153088_41043860',
  1 => false,
  3 => 0,
  2 => 0,
), $_blockParentStack);
?>

                    </div>
                <?php
}
/* {/block 'content'} */
/* {block 'footer'}  file:./default.tpl */
function block_1005257094d2615ed00_04285506($_smarty_tpl, $_blockParentStack) {
?>

                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php
}
/* {/block 'footer'} */
}
