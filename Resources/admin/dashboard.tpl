{$idPage ="dashboard"}
{$nomeSezione = "dashboard"}
{$title ="dashboard"}
{$pagina ="dashboard"}

{extends file="./default.tpl"}
{block name="right_side"}
    <div class="to_do_list">
        <div class="titolo">
            TO DO LIST
        </div>
        {$todolist = $user->getTodoList()}        
        <div class="buttons_dx">
            <div class="buttons drop">
                <p>
                    <img src="/admin/assets/images/drop-down-arrow.png"/><!--img-->
                </p><!--p-->
            </div><!--buttons.drop-->
            <div class="buttons add">
                <p>
                +
                </p><!--p-->
            </div><!--buttons.add-->
        </div><!--buttons_dx-->
        <div class="hidden add">
            <div class="cont_content">
                <form action="addTodo.php" method="POST" enctype="multipart/form-data" id="add_todo"> 
                    <input type="hidden" name="{ini_get("session.upload_progress.name")}" value="form_add" />
                    <div class="box_input">
                        <div class="cont_input">
                            <input type="text" name="message" placeholder="Inserisci la tua nota.."/>
                        </div><!--cont_input--> 
                    </div><!--box_input-->
                    <div class="box_file">
                        <div class="cont_file">
                            <input type="file" id="file" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                                text/plain, application/pdf" name="file[]" multiple/>
                            <label for="file"></label>
                        </div><!--cont_input-->
                    </div><!--box_input-->
                    <div class="box_img">
                        <div class="cont_img">                        
                            <input type="file" id="img" accept="image/*" name="immagine[]" multiple/>
                            <label for="img"></label>
                        </div><!--cont_input-->
                    </div><!--box_input-->
                    <div class="box_input submit">
                        <div class="cont_submit">
                            <input type="submit" value="Aggiungi"/>
                        </div><!--cont_submit-->
                    </div><!--box_input-->
                </form><!--form-->
            </div><!--cont_content-->
        </div><!--hidden-->
        {if count($todolist) > 0}
            {foreach $todolist as $k => $v}
                {$gallery = explode(",",$v->getGallery())}
                
                <div class="list hidden {if !$gallery[0]} no_gal {/if}">           
                    <div class="todo_singola">
                        <div class="text">
                            <p>
                                {$v->getTesto()}
                            </p>
                        </div><!--text-->
                        {if $gallery[0]}
                        <div class="gallery">                            
                            {foreach $gallery as $gal}
                                <div class="img_gal">
                                    <img src="/admin/upNoteImages/{$v->getId()}/{$gal}"/>
                                </div>
                            {/foreach}                            
                        </div><!--gallery-->
                        {/if}
                        <div class="allegato">

                        </div><!--allegato-->
                        <div class="date">
                            {date("d/m/Y H:i:s",strtotime($v->getDataAggiunta()))}
                        </div><!--date-->
                    </div><!--todo_singola-->                            
                </div><!--list hidden-->
            {/foreach}
        {/if}
    </div>
{/block}