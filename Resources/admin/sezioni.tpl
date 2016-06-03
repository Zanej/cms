{$idPage ="sezioni"}

{$nomeSezione = $sezione->getNome()}
{$title =$sezione->getNome()}
{extends file="./default.tpl"}
{block name="right_side"}
    {$campi = $sezione->getCampi("lista")}
    {if $page}
        {$lista = $sezione->getRows("lista","",$page)}
    {else}
        {$lista = $sezione->getRows("lista")}
    {/if}
    <div class="filtri">
        
    </div><!--filtri-->        
    <div class="lista">
        <div class="table_header">
        {$titolo_field = ""}
        {$campi_hidden=array()}
        {foreach $campi as $ch => $c}
            {if !$c["hidden"]}
                <div class="table_cell">
                    {$c["name"]}
                </div><!--table_cell-->
            {else}
                {$campi_hidden[] = $c["name"]}
            {/if}
            {if $c["titolo"]}
                {$titolo_field = $c["name"]}
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
                        {$v[$titolo_field]}
                    </div><!--title-->
                    {*if is_object($v)}
                        {$vars = get_object_vars($v)}
                        {foreach $vars as $var}
                            {if method_exists($v->getterName($var))}                            
                                <div class="table_cell">
                                    {$v->getterName($var)}
                                </div>
                            {/if}
                        {/foreach}
                    {else*}
                        {foreach $v as $kk => $vv}                                       
                            {$src = array_search($kk,$campi)}                            
                            {if !in_array($kk,$campi_hidden)}
                                <div class="table_cell">
                                    <div class="label">
                                        {$kk}
                                    </div><!--label-->
                                    <div class="value">                                    
                                        {$vv}                                    
                                    </div><!--value-->
                                </div><!--table_cell-->
                            {/if}
                        {/foreach}
                        <div class="table_cell">
                            <div class="op edit">
                                <div class="label_op">
                                    Modifica
                                </div>
                                <i class="fa fa-edit"></i>
                            </div><!--edit-->
                            <div class="op unlock">
                                <div class="label_op">
                                    Sblocca
                                </div>
                                <i class="fa fa-unlock"></i>
                            </div><!--unlock-->
                            <div class="op lock">
                                <div class="label_op">
                                    Blocca
                                </div>
                                <i class="fa fa-lock"></i>
                            </div><!--lock-->
                            <div class="op delete">
                                <div class="label_op">
                                    Elimina
                                </div>
                                <i class="fa fa-close"></i>
                            </div><!--delete-->
                        </div>
                    {*/if*}
                </div><!--element-->
            {/foreach}        
        <!--</div>-->
    </div><!--lista-->
{/block}