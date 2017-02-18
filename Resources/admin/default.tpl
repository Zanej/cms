<html>
    <head>
        {block name="head"}
            {include file="./head.tpl"}
        {/block}
    </head>
    <body id="{$idPage}" class="{$bodyClass}">
        <div class="contenitore">
            <div class="left open navbar left_col">
                {block name="left_side"}
                    {include file="./left_side.tpl"}
                {/block}
            </div><!--left-->
            <div class="right">
                {include file="./header.tpl"}
                {block name="right_side"}                    
                    {include file="./right_side.tpl"}                    
                {/block}
            </div><!--right-->
        </div><!--contenitore-->
        {block name="footer"}
            {include file="./footer.tpl"}
        {/block}
    </body>
</html>