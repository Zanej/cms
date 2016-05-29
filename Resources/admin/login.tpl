{$idPage ="login"}
{extends file="./default.tpl"}
{block name="header"}
{/block}
{block name="left_side"}
{/block}
{block name="right_side"}
    <div class="full_width">
        <div class="centra">
            <form action="" method="POST" id="log_me">
                <h2>Admin Login</h2>
                <div class="box_input">
                    <div class="cont_input">
                        <input type="text" name="username" placeholder="Username" data-required required/>
                    </div><!--cont_input-->
                </div><!--box_input-->
                <div class="box_input">
                    <div class="cont_input">
                        <input type="password" name="password" placeholder="Password" data-required required/>
                    </div><!--cont_input-->
                </div><!--box_input-->
                <div class="box_input">
                    <div class="cont_select">
                        <select name="lang">
                            <option value="">Seleziona lingua</option>
                            <option value="IT">Italiano</option>
                            <option value="EN">Inglese</option>
                        </select>                        
                    </div><!--cont_select-->
                </div><!--box_input-->
                <div class="box_input submit">
                    <div class="cont_submit">
                        <input type="submit" id="sub_me" value="LOGIN"/>
                    </div><!--cont_submit-->
                </div><!--box_input-->
            </form><!--form-->
        </div>
    </div>
{/block}