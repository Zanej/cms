<?php
/* Smarty version 3.1.29, created on 2016-05-14 09:51:52
  from "C:\Users\zane2\Documents\progetti\cms\Resources\view.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5736d91858ee56_57382010',
  'file_dependency' => 
  array (
    '32fee8a8531dbef31acf527bd816c88287ee2c5c' => 
    array (
      0 => 'C:\\Users\\zane2\\Documents\\progetti\\cms\\Resources\\view.tpl',
      1 => 1463172295,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./default.tpl' => 1,
  ),
),false)) {
function content_5736d91858ee56_57382010 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "header", array (
  0 => 'block_1555736d9182f3041_19160089',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "left", array (
  0 => 'block_113205736d918303210_59873789',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "right", array (
  0 => 'block_51375736d918579713_54607759',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'header'}  file:C:/Users/zane2/Documents/progetti/cms//Resources/view.tpl */
function block_1555736d9182f3041_19160089($_smarty_tpl, $_blockParentStack) {
?>

    <h3>Agenzie</h3>
<?php
}
/* {/block 'header'} */
/* {block 'left'}  file:C:/Users/zane2/Documents/progetti/cms//Resources/view.tpl */
function block_113205736d918303210_59873789($_smarty_tpl, $_blockParentStack) {
?>

    <!--<h3>Agenzie</h3>-->
    <!--<div class="input_container">
        <div class="select_container">
            <select name="agenzie">
                <option>
                    
                </option>
            </select>
        </div>
    </div>-->
    <ul class="filter">
        <?php
$_from = $_smarty_tpl->tpl_vars['agenzie']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_val_0_saved_item = isset($_smarty_tpl->tpl_vars['val']) ? $_smarty_tpl->tpl_vars['val'] : false;
$__foreach_val_0_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['val']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$__foreach_val_0_saved_local_item = $_smarty_tpl->tpl_vars['val'];
?>
        <li <?php if ($_smarty_tpl->tpl_vars['val']->value->getIdAgenzia() == $_smarty_tpl->tpl_vars['agenzia']->value->getIdAgenzia()) {?> class="selected" <?php }?>>
            <a href="/view_agenzie/<?php echo $_smarty_tpl->tpl_vars['val']->value->getIdAgenzia();?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value->getNome();?>
</a>
        </li>
        <?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_0_saved_local_item;
}
if ($__foreach_val_0_saved_item) {
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_0_saved_item;
}
if ($__foreach_val_0_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_val_0_saved_key;
}
?>
    </ul>
<?php
}
/* {/block 'left'} */
/* {block 'right'}  file:C:/Users/zane2/Documents/progetti/cms//Resources/view.tpl */
function block_51375736d918579713_54607759($_smarty_tpl, $_blockParentStack) {
?>

    <div class="nome">
        <?php echo $_smarty_tpl->tpl_vars['agenzia']->value->getNome();?>

    </div>
    <!--<div class="form_container">
        <div class="input_box">
            <label>Nome</label>
            <input type="text" name="nome"/>
        </div>
    </div>-->
<?php
}
/* {/block 'right'} */
}
