$(document).on("click","body .hamburger",function(){
    if($("body .contenitore .left").hasClass("open")){
        $("body .contenitore .left").removeClass("open",200);
        $("body .contenitore .left").addClass("closed",200);        
        $("body .contenitore .right").addClass("open",200);                
    }else{
        $("body .contenitore .left").addClass("open",200);
        $("body .contenitore .left").removeClass("closed",200);    
        $("body .contenitore .right").removeClass("open",200);        
    }    
});
$(document).on("click",".to_do_list .buttons_dx .buttons.add",function(){
    $(this).parents(".to_do_list").find(".hidden.add").toggleClass("show");
});
$(document).on("click",".to_do_list .buttons_dx .buttons.drop",function(){
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
$(document).on("click",".left_group .titolo",function(){
    $(this).parents(".left_group").toggleClass("open",200);
    $(this).parents(".left_group").find(".hidden").toggleClass("show",200);
});
$(document).ready(function(){
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
});


