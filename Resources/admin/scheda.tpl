{$idPage ="scheda"}

{$nomeSezione = $sezione->getNome()}
{$title =$sezione->getNome()}
{print_r($campi)}
{extends file="./default.tpl"}
{block name="right_side"}       
    <div class="scheda">
        <form action="/admin/edit_sezione.php" method="POST" enctype="multipart/form-data">
        {foreach $campi as $k => $v}                        
            {if is_object($object)}                
                {$getter = $object->getterName($v["field"])}                       
                {if $v["hidden"]}                                
                    <input type="hidden" name="{$v["field"]}" value="{$object->$getter()}"/>
                {else}
                    <div class="row">
                        <div class="label">
                            {$v["field"]}
                        </div>
                        <div class="box_input">                            
                            {if !$v["values"]}
                                <div class="cont_input">
                                    <input type="text" name="{$v["field"]}" value="{$object->$getter()}"/>
                                </div>
                            {else}
                                {if $v["type"] == "single"}
                                    <div class="cont_select">
                                        <select name="{$v["field"]}">
                                            {foreach $v["values"] as $val}                                                
                                                <option value="{$val->get($v["field_used"])}" {if $object->get($v["field_used"]) == $val->get($v["field_used"])} selected {/if} >
                                                    {$val->get($v["field_label"])}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                {else}
                                    <div class="cont_checkbox">
                                        {foreach $v["values"] as $val}
                                            <div class="checkbox">                                                
                                                <input type="checkbox" name="{$v["field"]}[]" value="{$val->get($v["field_used"])}" id="check_{$val->get($v["field_used"])}"/>
                                                <label for="check_{$val->get($v["field_used"])}">
                                                    {$val->get($v["field_label"])}
                                                </label>
                                            </div>
                                        {/foreach}
                                    </div>
                                {/if}
                            {/if}
                        </div>
                    </div>
                {/if}
            {else}
                {if $v["hidden"]}                                
                    <input type="hidden" name="{$v["field"]}" value="{$object[$v["field"]]}"/>
                {else}
                    <div class="row">
                        <div class="label">
                            {$v["field"]}
                        </div>
                        <div class="box_input">
                            <div class="cont_input">
                                <input type="text" name="{$v["field"]}" value="{$object[$v["field"]]}"/>                    
                            </div>
                        </div>
                    </div>
                {/if}
            {/if}            
        {/foreach}
        <div class="submit">
            <div class="box_input submit">
                <div class="cont_input">
                    <input type="submit" value="Salva"/>
                </div>
            </div>
        </div>
        </form>
    </div>
{/block}