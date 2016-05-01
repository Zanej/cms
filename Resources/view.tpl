{extends file="./default.tpl"}
{block name="header"}
    <h3>Agenzie</h3>
{/block}
{block name="left"}
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
        {foreach $agenzie as $key => $val}
        <li {if $val->getIdAgenzia() == $agenzia->getIdAgenzia()} class="selected" {/if}>
            <a href="/view_agenzie/{$val->getIdAgenzia()}">{$val->getNome()}</a>
        </li>
        {/foreach}
    </ul>
{/block}
{block name="right"}
    <div class="nome">
        {$agenzia->getNome()}
    </div>
{/block}
