function Validator(forms,errors,options){
    this.forms = forms;
    this.campo_obbligatorio = errors.campo_obbligatorio;
    this.errore_di_rete = errors.errore_di_rete;
    this.do_what = options.particular_fields || [];
    this.options = options;
    if(typeof(this.options.requiredFields === "undefined")){
        this.options.requiredFields = "[data-required]";
    }
}
Validator.prototype.validate = function(form){
    if(this.isTheSame(form)){
        return this.doValidation(form);
    }
    return false;
};
Validator.prototype.isSameField = function (field,fieldtwo){
    return field.get(0) == fieldtwo.get(0);
};
Validator.prototype.doValidation = function(form){
    error = false;
    if(form.length > 0){
        form.find(".error").remove();
        var heights = Array();
        var elements = Array();
        var valid = this;
        form.find("[data-required]").each(function(){
            elements.push($(this));
        });
        $(elements).each(function(index,item){
            item.each(function(ind,el){
                if(!valid.fieldTypeCheck(el)){
                    valid.doOnFieldsRequired($(el),form);
                    heights.push($(el).offset().top);
                }else{
                    valid.doOnFieldsSuccess($(el),form);
                }
            });
            
        });
        if(heights.length === 0){
            this.success(form);
            return true;
        }else{
            this.error(form);
            var min = 99000;
            $(heights).each(function(index,item){
                if(item < min){
                    min = item;
                }
            });
            $("body","html").animate({
                "scrollTop":min-50
            });
            return false;
        }
    }
};
Validator.prototype.isTheSame = function(form){
    if(typeof form.data("validate") !== "undefined"){
        return true;
    }
    $(this.forms).each(function(index,item){
        if(form.get(0) == item){
            return true;
        }
    });
    return false;
};
Validator.prototype.checkField= function(field){
    var form = $(field).parents("form");
    if(this.isTheSame(form)){
        if(typeof $(field).data("required") !== "undefined"){
            if(!this.fieldTypeCheck($(field))){
                this.doOnFieldsRequired(field,form);
            }else{
                this.doOnFieldsSuccess(field,form);
            }
        }
    }
};
Validator.prototype.fieldTypeCheck = function(field){
    $(field).parent().find(".error").remove();
    var valid = this;
    var me = false;
    if($(field).is(":input")){
        if($(field).prop("type") === "checkbox"){
            if(!$(field).is(":checked")){
                return false;                
            }
        }else{
            if($(field).val().trim() == ""){
                return false;                
            }
        }
    }else{
        if($(field).val().trim() == 0){
            return false;            
        }
    }
    return true;
};
Validator.prototype.success = function(form){
    if(typeof this.options.success !== "undefined"){
        this.options.success.bind(form).call();
    }
};
Validator.prototype.error = function(form){
    if(typeof this.options.error !== "undefined"){
        this.options.error.bind(form).call();
    }
};
Validator.prototype.doOnFieldsRequired = function(field,form){
    var valid = this;
    var fatto = false;
    $(this.do_what).each(function(index,item){
        $(item.field).each(function(ind,real_item){
            if(valid.isSameField($(real_item),field)){
                item.error.bind(real_item).call();
                fatto = true;
            }            
        });
    });
    if(!fatto){
        $(field).parent().append("<div class='error'>"+this.campo_obbligatorio+"</div>");
    }
};
Validator.prototype.doOnFieldsSuccess = function(field,form){
    var valid = this;
    var fatto = false;
    $(this.do_what).each(function(index,item){
        $(item.field).each(function(ind,real_item){
            if(valid.isSameField($(real_item),field)){
                item.success.bind(real_item).call();
            }
        });
    });
};