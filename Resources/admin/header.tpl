<header>
    <div class="hamburger">  
        <i class="fa fa-bars"></i>
    </div><!--hamburger-->
    <div class="float_right">
        Welcome back, {$user->getNome()}<br> your last login: {date("d/m/Y H:i",strtotime($user->getUltimoAccesso()))}
        {if $setAccess}
            {$user->setUltimoAccesso(date("Y-m-d H:i:s"))}
            {$user->save()}
        {/if}
    </div><!--float_right-->
    <div class="sezione">
        {$nomeSezione}
    </div><!--sezione-->
    <div class="right_name">
        {$user->getNome()}
    </div><!--right_name-->
    
</header>