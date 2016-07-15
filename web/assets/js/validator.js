function Validator(forms,options){
    this.forms = forms;    
    this.do_what = options.particular_fields || [];
    this.options = options;
    var valid = this;
    
    if(typeof options.validate_all === "undefined"){

        options.validate_all = true;
    }

    if(options.validate_all == true){
        var form_validate = $("[data-validate]");              

        $(form_validate).each(function(index,item){    

            if(!valid.isTheSame($(item))){                                               

                valid.forms.push(item);
            }

        });           
    }

    $(valid.forms).each(function(index,item){ 

        if(typeof $(item).data("submitter") !== "undefined"){            
            $(document).on("click",$(item).data("submitter"),function(event){                                                                   
                return valid.validate($(item));
            });
        }else{                                    

            if($(item).length > 0){                

                $(document).on("submit",$(item),function(event){                     
                    
                    return valid.validate($(item));
                });    
            }

            
        }

        if(typeof $(item).data("change") !== "undefined"){    

            /*$(item).find("input,select,textarea").each(function(ind,it){*/

                var item_id;

                if(typeof $(item) !== "undefined"){ 

                    item_id = "#"+$(item).prop("id");                    
                }
                
                if(typeof item_id === "undefined"){

                    item_id = "form";   
                }

                $(document).on("change",item_id+" input, "+item_id+" select, "+item_id+" textarea",function(e){                    

                    valid.checkField($(this));
                });
            /*});*/
        }        
    });        
    
}
Validator.prototype.validate = function(form){          

    if(this.isTheSame(form)){        

        return this.doValidation(form);
    }
    
    return false;
};
Validator.prototype.isSameField = function (field,fieldtwo){
    
    return $(field).get(0) == $(fieldtwo).get(0);
};
Validator.prototype.doValidation = function(form){
    error = false;    
    if(form.length > 0){
        /*form.find(".error").remove();*/
        var heights = Array();
        var elements = Array();
        var valid = this;
        form.find("input,select,textarea").each(function(){
            elements.push($(this));
        });

        $(elements).each(function(index,item){            

            item.each(function(ind,el){                

                var check = valid.fieldTypeCheck(el);

                if(check.valid == false){

                    if (check.type == "invalid"){                        

                        valid.doOnFieldsInvalid($(el),form);
                    }else{

                        valid.doOnFieldsRequired($(el),form);
                    }

                    heights.push($(el).offset().top);

                }else{
                    valid.doOnFieldsSuccess($(el),form);
                }

            });
           
        });
                

        if(heights.length === 0){            

            return this.success(form);
            //return true;
        }else{
            this.error(form);
            var min = 99000;
            $(heights).each(function(index,item){
                if(item < min){
                    min = item;
                }
            });

            if(typeof this.options.scroll === "undefined"){
                this.options.scroll = true;
            }

            if(this.options.scroll == true){
                $("body","html").animate({
                    "scrollTop":min-50-98
                });
            }
            return false;
        }
    }
};
Validator.prototype.isTheSame = function(form){
    var ret = false;

    $(this.forms).each(function(index,item){            

        if(form.is(item)){ 
            ret = true;
        }
    });  
    return ret;
};
Validator.prototype.checkField = function(field){

    var form = $(field).parents("form");    

    if(this.isTheSame(form)){

        //if(typeof $(field).data("required") !== "undefined" || typeof $(field).data("pattern") !== "undefined" || ($(field).is(":input") && $(field).prop("type") == "email")){
        var check = this.fieldTypeCheck($(field));

        if(check.valid == false){

            if (check.type == "invalid"){                

                this.doOnFieldsInvalid(field,form);
            }else{                

                this.doOnFieldsRequired(field,form);
            }

        }else{
            this.doOnFieldsSuccess(field,form);
        }
        //}
    }
};

Validator.prototype.getDataFromField = function(field){

    var ret = {};

    var valid = this;    


    

    if(typeof $(field).data("required") !== "undefined"){        

        ret.required = true;
    }

    if(typeof $(field).data("pattern") !== "undefined"){        

        ret.pattern = $(field).data("pattern");
    }

    ret.use_default = true;

    $(valid.do_what).each(function(index,item){        

        $(item.field).each(function(ind,it){


            if(valid.isSameField(it,field)){
                

                if(typeof item.check !== "undefined"){                    

                    ret.check = item.check;
                }

                if(typeof item.use_default !== "undefined"){

                    ret.use_default = item.use_default;
                }

            }

        });                      

    });

    return ret;

}
Validator.prototype.fieldTypeCheck = function(field){
    /*$(field).parent().find(".error").remove();*/
    var valid = this;
    var me = false;    
    var data_send = this.getDataFromField(field);        

    var field_check = new Field(field,valid,data_send);    

    return field_check.check();

};
Validator.prototype.success = function(form){
    if(typeof this.options.success !== "undefined"){        

        return this.options.success.bind(form).call();
    }else{

        return true;
    }
};
Validator.prototype.error = function(form){
    if(typeof this.options.error !== "undefined"){

        this.options.error.bind(form).call();
    }else{

        return false;
    }
};
Validator.prototype.doOnFieldsRequired = function(field,form){

    var valid = this;
    var fatto = false;    

    $(this.do_what).each(function(index,item){

        var field_arr = $(item.field);

        $(field_arr).each(function(i,f){

            if(valid.isSameField(f,field)){

                if(typeof item.error !== "undefined"){                    

                    item.error.bind(f).call();    
                }else{                    
                    
                }
                
                fatto = true;
            }
        });
    });

    if(!fatto){
        /*console.debug("error")*/
        /*$(field).parent().append("<div class='error'>"+this.campo_obbligatorio+"</div>");*/
    }
};

Validator.prototype.doOnFieldsInvalid = function(field,form){

    var valid = this;
    var fatto = false;    

    $(this.do_what).each(function(index,item){

        var field_arr = $(item.field);

        $(field_arr).each(function(i,f){

            if(valid.isSameField(f,field)){

                if(typeof item.invalid !== "undefined"){

                    item.invalid.bind(f).call();

                }else if(typeof item.error !== "undefined"){                                        

                    item.error.bind(f).call();    
                }
                
                fatto = true;
            }
        });
    });
}
Validator.prototype.doOnFieldsSuccess = function(field,form){

    var valid = this;
    var fatto = false;    

    $(this.do_what).each(function(index,item){

        var field_arr = $(item.field);        
        $(field_arr).each(function(i,f){

            if(valid.isSameField(f,field)){

                if(typeof item.success !== "undefined"){

                    item.success.bind(f).call();    
                }else{
                    

                }
                
                fatto = true;
            }
        });
    });
};

/**FIELD**/

function Field(element,validator,options){
    this.field = element;
    this.validator = validator;
    this.options = options || [];
}

Field.prototype.check = function(){

    var field = this;    

    var field_check = field.field;        

    var form_check = $(field_check).parents("form");    


    if(field.validator.isTheSame(form_check)){                        

        if( field.options.use_default == true){

            if(typeof field.options.required !== "undefined"){                

                if($(field_check).is(":input")){                    

                    if($(field_check).prop("type") === "checkbox"){                        
                    
                        if(!$(field_check).is(":checked")){                            

                            return  {"valid":false,"type":"empty"};                
                        }

                    }else if($(field_check).prop("type") === "radio"){

                        var name = $(field_check).prop("name");
                        var form = $(field_check).parents("form");
                        var checked = false;

                        form.find("input[name='"+name+"']").each(function(){                                                        

                            if($(this).is(":checked")){
                                checked = true;
                            }
                        });                        
                        
                        return {"valid":checked,"type":"empty"};

                    }else{

                        if($(field_check).val().trim() == ""){                            

                            return {"valid":false,"type":"empty"};                
                        }

                    }
                }else{                    

                    if($(field_check).val().trim() == 0){                        

                        return {"valid":false,"type":"empty"};            
                    }
                }
            }

            if(typeof field.options.pattern !== "undefined" && $(field_check).val()){                                

                var pattern = new RegExp(field.options.pattern);                        

                if(!pattern.test($(field_check).val())){                            

                    return {"valid":false,"type":"invalid"};
                }
            }

            if($(field_check).is(":input") && typeof $(field_check).prop("type") !== "undefined" && $(field_check).prop("type") == "email"){                

                var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                
                if(!pattern.test($(field_check).val())){                

                    return {"valid":false,"type":"invalid"};
                }

            }
        }
       

        if(typeof field.options.check !== "undefined"){                                    

            return {"valid":field.options.check.bind(field_check).call(),"type":"invalid"};            
        }

    }

    return true;
}