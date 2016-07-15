/* global this */

$.fn.imagesLoaded = function () {

    // get all the images (excluding those with no src attribute)
    var $imgs = this.find('img[src!=""]');
    // if there's no images, just return an already resolved promise
    if (!$imgs.length) {return $.Deferred().resolve().promise();}

    // for each image, add a deferred object to the array which resolves when the image is loaded (or if loading fails)
    var dfds = [];  
    $imgs.each(function(){

        var dfd = $.Deferred();
        dfds.push(dfd);
        var img = new Image();
        img.onload = function(){
            dfd.resolve();
        };
        img.onerror = function(){
            dfd.resolve();
        };
        img.src = this.src;

    });

    // return a master promise object which will resolve when all the deferred objects have resolved
    // IE - when all the images are loaded
    return $.when.apply($,dfds);

};  
function ajaxLoader(){
    this.ajaxs = [];
    this.done = [];
    this.default_opt ={
        dataType:"html",
        type:"POST",
        cache:"true",
        imagesLoaded:false,
        success:function(){
            
        },
        error:function(){
            
        },
        complete:function(){
            
        }
    };
}
ajaxLoader.prototype.load = function(url,options){
    var loader = this;
    var deferred_total = $.Deferred();
    if(this.ajaxs.length === 0){
        return;
    }
    this.recursive(0);
   /* $(this.done).each(function(){
       console.log(this.state()); 
    });*/
    $.when.apply($,this.done).then(function(){
        loader.afterLoad();
    });
};
ajaxLoader.prototype.afterLoad = function(){
    
};
ajaxLoader.prototype.recursive = function(index){
    var loader = this;
    if(index < this.ajaxs.length){
        $.when(this.doAjax(index)).then(function(){            
            loader.recursive(index+1);            
        }); 
    }
};
ajaxLoader.prototype.getData = function(index){
    return this.ajaxs[index].data;
};
ajaxLoader.prototype.addAjax = function(url,options){
    var keys = Object.keys(this.default_opt);
    var loader = this;
    $(keys).each(function(index,item){
        if(typeof options[item] === "undefined"){
            options[item] = loader.default_opt[item];
        }
    });
    this.ajaxs.push({
        url:url,
        options:options,
        data:""
    });
    this.done.push($.Deferred());
};
ajaxLoader.prototype.doAjax = function(index){
    var loader = this;
    var ajax = this.ajaxs[index];
    var def_arr = [];
    var deferred = this.done[index];
    def_arr.push(deferred);
    $.ajax({
        url:ajax.url,
        dataType:ajax.options.dataType,
        type:ajax.options.type,
        cache:ajax.options.cache,
        success:function(data){
            loader.ajaxs[index].data = data;
            ajax.options.success.bind(data).call();           
        },
        error:function(data){
            ajax.options.error.bind(data).call();
        },
        complete:function(data){
            ajax.options.complete.bind(data).call();
            if(ajax.options.dataType == "hmtl"){
                if(ajax.options.imagesLoaded === false){
                    deferred.resolve();
                }else{
                    $("body").append(data).imagesLoaded().then(function(){
                        deferred.resolve();
                    });
                }
            }else{
                deferred.resolve();
            }
        }        
    });
    return $.when.apply($,def_arr);
};


