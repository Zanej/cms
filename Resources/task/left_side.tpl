<div class="left_container">    
    <div class="left_group dropdown">
        <div class="titolo">
            Daily
        </div>
        <div class="hidden" data-group="{$ordine}">
            <div class="left_sezione {if $type == 'daily'} selected {/if}">
                <p>

                </p>
                <a href="/task/daily/">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="left_group dropdown">
        <div class="titolo">
            Weekly
        </div>
        <div class="hidden" data-group="{$ordine}">
            <div class="left_sezione {if $type == 'weekly'} selected {/if}">
                <p>

                </p>
                <a href="/task/weekly/">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="left_group dropdown">
        <div class="titolo">
            Monthly
        </div>
        <div class="hidden" data-group="{$ordine}">
            <div class="left_sezione {if $type == 'monthly'} selected {/if}">
                <p>

                </p>
                <a href="/task/monthly/">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>