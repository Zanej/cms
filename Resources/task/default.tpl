<html>
    <head>
        {block name="head"}
            {include file="./head.tpl"}
        {/block}
    </head>
    <body id="{$idPage}" class="{$bodyClass}">
        {block name="header"}
            {include file="./header.tpl"}
        {/block}
        <div class="contenitore">
            <div class="left closed">
                {block name="left_side"}
                    {include file="./left_side.tpl"}
                {/block}
            </div><!--left-->
            <div class="right open">
                {block name="right_side"}
                    {include file="./right_side.tpl"}                    
                {/block}
            </div><!--right-->
        </div><!--contenitore-->
        {block name="footer"}
        
        {/block}
    </body>
</html>