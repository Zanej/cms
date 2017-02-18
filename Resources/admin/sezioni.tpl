{$idPage ="sezioni"}

{$nomeSezione = $sezione->getNome()}
{$title =$sezione->getNome()}
{extends file="./default.tpl"}
{block name="right_side"}   

    <div class="filtri">
        
    </div><!--filtri-->        
    <div class="lista">
        <div class="table_header">                
        {$chiave = ""}        
        {foreach $campi as $ch => $c}               
            {if !$c["hidden"]}
                <div class="table_cell">
                    {$c["label"]}
                </div><!--table_cell-->            
            {/if}                           
        {/foreach}  
        <div class="table_cell">
            OPERAZIONI
        </div>
        </div><!--table_header-->
        <!--<div class="elements">-->
            {foreach $lista as $k => $v}            
                <div class="element">
                    <div class="title">
                        {if is_object($v)}
                            {$getter = $v->getterName($titolo_field)}                            
                            {$v->$getter()}                        
                        {else}
                            {$v[$titolo_field]}                        
                        {/if}
                        
                    </div><!--title-->
                    {if is_object($v)}                                                                              
                        {foreach $campi as $var}                            
                            {if $var["hidden"]}
                                {continue}
                            {/if}
                            {$getter = $v->getterName($var["field"])}                            
                            {if method_exists($v,$getter)}                            
                                <div class="table_cell"> 
                                    <div class="label">
                                        {$var["label"]}                                        
                                    </div>
                                    <div class="value">  

                                        {if $var['values']}

                                            {foreach $var['values'] as $vk => $vv}

                                                {if $vv->get($var["field_used"]) == $v->$getter()}

                                                    {$vv->get($var["field_label"])}
                                                {/if}

                                            {/foreach}
                                        {else}
                                            {$v->$getter()}
                                        {/if}                                                                                                     
                                    </div>
                                </div>
                            {/if}                            
                        {/foreach}
                    {else}
                        {foreach $v as $kk => $vv}                                       
                            {$src = array_search($kk,$campi)}                            
                            {if !in_array($kk,$campi_hidden)}
                                <div class="table_cell">
                                    <div class="label">
                                        {$kk}
                                    </div><!--label-->
                                    <div class="value">     
                                        {if $var['values']}

                                            {foreach $var['values'] as $vk => $vvv}

                                                {if $vvv->get($var["field_used"]) == $vv}

                                                    {$vvv->get($var["field_label"])}
                                                {/if}

                                            {/foreach}
                                        {else}

                                            {$vv}  
                                        {/if}                                 
                                  
                                    </div><!--value-->
                                </div><!--table_cell-->
                            {/if}
                        {/foreach}                        
                    {/if}
                    <div class="table_cell">
                        <a class="op edit" href="{$sezione->getEditLink($v)}">
                            <div class="label_op">
                                Modifica
                            </div>
                            <i class="fa fa-edit"></i>
                        </a><!--edit-->
                        {if is_object($v)}
                            {if $v->get('stato') == '0' && $v->get('stato') != ''}
                                <div class="op unlock" data-id="{$v->getId()}" data-sezione="{$sezione->getId()}">
                                    <div class="label_op">
                                        Sblocca
                                    </div>
                                    <i class="fa fa-unlock"></i>
                                </div><!--unlock-->
                            {elseif $v->get('stato') == '1'}
                                <div class="op lock" data-id="{$v->getId()}" data-sezione="{$sezione->getId()}">
                                    <div class="label_op">
                                        Blocca
                                    </div>
                                    <i class="fa fa-lock"></i>
                                </div><!--lock-->
                            {/if}
                        {else}
                            {if $v.stato == '0' && $v.stato != ''}
                                <div class="op unlock" data-id="{$v[$sezione->getChiave()]}" data-sezione="{$sezione->getId()}">
                                    <div class="label_op">
                                        Sblocca
                                    </div>
                                    <i class="fa fa-unlock"></i>
                                </div><!--unlock-->
                            {elseif $v.stato == '1'}
                                <div class="op lock" data-id="{$v[$sezione->getChiave()]}" data-sezione="{$sezione->getId()}">
                                    <div class="label_op">
                                        Blocca
                                    </div>
                                    <i class="fa fa-lock"></i>
                                </div><!--lock-->
                            {/if}
                        {/if}
                        <div class="op delete">
                            <div class="label_op">
                                Elimina
                            </div>
                            <i class="fa fa-close"></i>
                        </div><!--delete-->
                    </div>
                </div><!--element-->
            {/foreach}        
        <!--</div>-->
    </div><!--lista-->
{/block}