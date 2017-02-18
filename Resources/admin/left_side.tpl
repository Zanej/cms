<div class="left_container menu_section active">   
    <div class="navbar nav_title" style="border: 0;">
        <a href="index.html" class="site_title">
            <span>CMS</span>
        </a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
        {* <div class="profile_pic">
            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
        </div> *}
        <div class="profile_info">
            <span>Welcome back, <br></span>
            <h2>
                {if $setAccess}
                    {$user->setUltimoAccesso(date("Y-m-d H:i:s"))}
                    {$user->save()}
                {/if}
                {$user->getNome()}
            </h2>
            <span>
                 your last login:<br> {date("d/m/Y H:i",strtotime($user->getUltimoAccesso()))}
            </span>
        </div>
    </div>

    <ul class="nav side-menu">
        <li {if $pagina == 'dashboard'} class='active' {/if}>
            <a href='/admin/'>
                Dashboard
            </a>
        </li>
        {$sezioni = $user->getGruppiSezioni()}    
        {foreach $sezioni as $ordine => $s}                
            {if count($s["sezioni"]) == 1}
                <li class="{if $s.sezioni[0]->getId() == $v->getId()} active{/if}">
                    <a href="/admin/sezioni/{$v->getId()}">
                        {$s["sezioni"][0]->getNome()}
                    </a>
                </li>
            {else}
                <li class="multiple">
                    <a href="javascript:void(0);">
                        <i class="fa fa-home"></i> {$s.nome} <span class="fa fa-chevron-down"></span>
                    </a>

                    {$mostra = false}

                    {foreach $s["sezioni"] as $k => $v}
                        {if $sezione && $sezione->getId() == $v->getId()}
                            {$mostra = true}
                        {/if}
                    {/foreach}

                    <ul class="nav child_menu {if $mostra} show {/if}">                                            
                        {foreach $s["sezioni"] as $k => $v}
                            <li class="{if $sezione && $sezione->getId() == $v->getId()} active {/if}">                                    
                                <a href="/admin/sezioni/{$v->getId()}">
                                    {$v->getNome()}
                                </a>
                            </li>
                        {/foreach}                        
                    </ul>
                </li>
            {/if}
            
            
        {/foreach}
    </ul>
</div>