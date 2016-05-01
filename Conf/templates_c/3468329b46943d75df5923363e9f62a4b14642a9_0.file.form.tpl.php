<?php
/* Smarty version 3.1.29, created on 2016-04-15 23:26:48
  from "C:\Users\zane2\Documents\progetti\cms\Resources\form.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57115c98482556_94305579',
  'file_dependency' => 
  array (
    '3468329b46943d75df5923363e9f62a4b14642a9' => 
    array (
      0 => 'C:\\Users\\zane2\\Documents\\progetti\\cms\\Resources\\form.tpl',
      1 => 1460755556,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./default.tpl' => 1,
  ),
),false)) {
function content_57115c98482556_94305579 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "header", array (
  0 => 'block_1475157115c98472433_73258585',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, "content", array (
  0 => 'block_1098857115c9847a1f6_06210772',
  1 => false,
  3 => 0,
  2 => 0,
));
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:./default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'header'}  file:../../Resources/form.tpl */
function block_1475157115c98472433_73258585($_smarty_tpl, $_blockParentStack) {
?>

    <h3>Form</h3>
<?php
}
/* {/block 'header'} */
/* {block 'content'}  file:../../Resources/form.tpl */
function block_1098857115c9847a1f6_06210772($_smarty_tpl, $_blockParentStack) {
?>

    <div class="form_container">
        <form action="" method="POST" data-validate>
            <div class="input_box">
                <label for="nome">Nome</label>
                <div class="text_box">                    
                    <input type="text" name="nome" id="nome" data-required/>
                </div>
            </div>
            <div class="input_box">
                <label for="cognome">Cognome</label>
                <div class="text_box">                    
                    <input type="text" name="cognome" id="cognome" data-required/>
                </div>
            </div>
            <div class="input_box">
                <label for="citta">Citt&agrave;</label>
                <div class="select_box">                    
                    <select id="citta">
                        <option value="PD">Padova</option>
                        <option value="BL">Belluno</option>
                        <option value="NY">New York</option>
                    </select>
                    <!--<input type="text" name="nome" id="nome"/>-->
                </div>
            </div>
            <div class="clear"></div>
            <div class="input_box">
                <div class="checkbox_box">                    
                    <input type="checkbox" id="privacy" data-required/>
                    <label for="privacy">Privacy</label>
                </div>
            </div>
            <input type="button" value="INVIA!"/>
            <!--<div class="input_box">
                <div class="text_box">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome"/>
                </div>
            </div>-->
        </form>
    </div>
<?php
}
/* {/block 'content'} */
}
