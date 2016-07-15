<div class="left_container">    
    {$sezioni = $user->getGruppiSezioni()}    
    {foreach $sezioni as $ordine => $s}
        <div class="left_group dropdown">
            <div class="titolo">
                {$s["nome"]}
            </div>
            <div class="hidden" data-group="{$ordine}">
                {foreach $s["sezioni"] as $k => $v}
                    <div class="left_sezione">
                        <p>
                            {$v->getNome()}
                        </p>
                        <a href="#">

                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
        
    {/foreach}
    
</div>