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
            <div class="contenuto">
                {block name="content"}
                    <div class='left'>
                        {block name="left"}
                        {/block}
                    </div>
                    <div class='right'>
                        {block name="right"}
                        {/block}
                    </div>
                {/block}
            </div>
            <footer>
                {block name="footer"}
                    {include file="./footer.tpl"}
                {/block}
            </footer>
        </div>
    </body>
        
</html>