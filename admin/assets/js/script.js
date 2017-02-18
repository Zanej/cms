$(document).ready(function(){

    if($(window).width() <= 768){

        // console.log("aaa");
        $("body .hamburger").removeClass("open");
        $("body .left_col").removeClass("open");
        $("body .left_col").addClass("closed");
    }
    $(document).on("click","body .hamburger",function(e){

        e.preventDefault();

        if($("body .contenitore .left").hasClass("open")){

            $("body .contenitore .left").removeClass("open",200);
            $("body .contenitore .left").addClass("closed",200);   
            $(".hamburger").removeClass("open",200);           
            $("body .contenitore .right").addClass("open",200);                
        }else{

            $("body .contenitore .left").addClass("open",200);
            $(".hamburger").addClass("open",200);           
            $("body .contenitore .left").removeClass("closed",200);    
            $("body .contenitore .right").removeClass("open",200);        
        }    
    });

    $(document).on("click",".to_do_list .buttons_dx .buttons.add",function(e){

        e.preventDefault();
        $(this).parents(".to_do_list").find(".hidden.add").toggleClass("show");
    });

    $(document).on("click",".to_do_list .buttons_dx .buttons.drop",function(e){

        e.preventDefault();

        // console.log("ttt");

        console.log($(this).parents(".to_do_list").find(".hidden.list"));
        $(this).parents(".to_do_list").find(".hidden.list").toggleClass("show");
    });

    $(document).on("submit","#add_todo",function(e){

        e.preventDefault();
        var formdata = new FormData();
        var progressdata = new FormData();
        var form = $(this);
        var img = $(this).find("input[name='immagine[]']");
        var file = $(this).find("input[name='file[]']");    

        $.each($(img)[0].files,function(i,file){
           formdata.append('immagini[]',file); 
        });

        $.each($(file)[0].files,function(i,file){
           formdata.append('file[]',file); 
        });

        $.each($(form).find("input[type='hidden']"),function(i,input){
           formdata.append($(input).prop("name"),$(input).val()); 
           progressdata.append($(input).prop("name"),$(input).val());
        });

        formdata.append("messaggio",$(form).find("input[name='message']").val());   
        /*$.ajax({
            url:"/admin/progress.php",
            data:progressdata,
            contentType:false,
            processData:false,
            type:"POST",
            dataType:"json",
            success:function(data){
                //console.log(data);
            },error:function(data){
                
            }
        });*/
        $.ajax({
            url:"/admin/add_to_do.php",
            type:"POST",
            dataType:"json",
            cache:false,
            contentType:false,
            processData:false,
            data:formdata,
            success:function(data){
                
            },
            error:function(data){
                console.log(data);
            },complete:function(data){
                console.log(data);
            }
        });

        return false; 
    });

    $(document).on("click", ".nav.side-menu li.multiple a[href='javascript:void(0);']", function(e){

        e.preventDefault();
        $(this).parents("li").find("ul").toggleClass("show",200);    
        // $(this).parents("li").find(".hidden").toggleClass("show",200);
    });

    $(document).on("click",".element",function(e){
        
        $(this).toggleClass("open",200);        
    });

    $(document).on("click", ".op.lock[data-id][data-sezione]",function(e) {
        
        e.preventDefault();
        var elem = $(this);

        $.ajax({

            url:"/admin/edit_sezione.php",
            dataType:"json",
            type:"POST",
            data:{
                "type":"lock",
                "id":$(elem).data("id"),
                "sezione":$(elem).data("sezione")
            },
            success:function(data){

                if(data.success){

                    $(elem).prop("data-lock",false);
                    $(elem).prop("data-unlock",true);
                    $(elem).removeClass("lock");
                    $(elem).addClass("unlock");
                    $(elem).find("i").removeClass("fa-lock");
                    $(elem).find("i").addClass("fa-unlock");
                }   
            }
        });
    });

    $(document).on("click", ".op.unlock[data-id][data-sezione]",function(e) {
        
        e.preventDefault();
        var elem = $(this);

        $.ajax({

            url:"/admin/edit_sezione.php",
            dataType:"json",
            type:"POST",
            data:{
                "type":"unlock",
                "id":$(elem).data("id"),
                "sezione":$(elem).data("sezione")
            },
            success:function(data){

                if(data.success){
                    
                    $(elem).removeClass("unlock");
                    $(elem).addClass("lock");
                    $(elem).find("i").removeClass("fa-unlock");
                    $(elem).find("i").addClass("fa-lock");
                }
            }
        });
    });

    $(".list.hidden .gallery").slick({

        accessibility:false,
        autoplay:true,
        autoplaySpeed:3000,
        arrows:false,
        dots:true,
        pauseOnFocus:true,
        pauseOnHover:true,
        adaptiveHeight:false
    });

    $(document).on("click","#scheda .contieni .panel_toolbox a.collapse-link",function(e){
        e.preventDefault();

        var panel_body = $(this).parents(".contieni").find(".panel-body");
        if(panel_body.css('display') == 'none'){
            panel_body.slideDown();
        }else{
            panel_body.slideUp();
        }
    });
});


