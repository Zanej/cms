{extends file="./default.tpl"}
{block name="header"}
    <h3>Form</h3>
{/block}
{block name="content"}
    <div class="form_container">
        <form action="" method="POST" data-validate data-submitter="#submitter" data-change>
            <div class="input_box">
                <label for="nome">Nome</label>
                <div class="text_box">                    
                    <input type="text" name="nome" id="nome" data-required/>
                </div>
            </div>
            <div class="input_box">
                <label for="cognome">Cognome</label>
                <div class="text_box">                    
                    <input type="text" name="cognome" id="cognome" data-required/>
                </div>
            </div>
            <div class="input_box">
                <label for="citta">Citt&agrave;</label>
                <div class="select_box">                    
                    <select id="citta">
                        <option value="PD">Padova</option>
                        <option value="BL">Belluno</option>
                        <option value="NY">New York</option>
                    </select>
                    <!--<input type="text" name="nome" id="nome"/>-->
                </div>
            </div>
            <div class="clear"></div>
            <div class="input_box">
                <div class="checkbox_box">                    
                    <input type="checkbox" id="privacy" data-required/>
                    <label for="privacy">Privacy</label>
                </div>
            </div>
            <input type="button" value="INVIA!" id="submitter"/>
            <!--<div class="input_box">
                <div class="text_box">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome"/>
                </div>
            </div>-->
        </form>
    </div>
{/block}
