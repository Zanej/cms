var valida;

$(document).ready(function(){
    valida = new Validator([
        "#form_test"
    ],{
        campo_obbligatorio:"Campo obbligatorio!",
        errore_di_rete:"Errore di rete!"
    },{
        success:function(){
            var load = new ajaxLoader();
            load.addAjax("test1.php",{});
            load.addAjax("test2.php",{
                success:function(){ 
                    $("body").append(load.getData(0));
                    $("body").find(".outer").html(this);
                }
            });
            load.load();
        },
        error:function(){
            console.log("error form!!");
        },
        particular_fields:[{
            field:"input[type='text']",            
            error:function(){
                console.log("error text!");
            },
            success:function(){
                console.log("success text!");
            }
        },{
            field:"select",
            error:function(){
                console.log("error select!");
            },
            success:function(){
                console.log("success select!");
            }
        },{
            field:"input[type='checkbox']",
            error:function(){
                console.log("error checkbox!");
            },
            success:function(){
                console.log("success checkbox");
            }
        }]
    });
})
