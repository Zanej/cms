<html>
    <head>
        {block name="head"}
            {include file="./head.tpl"}
        {/block}
    </head>
    <body>
        <div class="contenitore">
            <header>
                {block name="header"}
                    {include file="./header.tpl"}
                {/block}
            </header>
            {block name="content"}
                <div class='nav_left'>
                    
                </div>
                <div class='nav_right'>
                    
                </div>
            {/block}
            <footer>
                {block name="footer"}
                    {include file="./footer.tpl"}
                {/block}
            </footer>
        </div>
    </body>
        
</html>