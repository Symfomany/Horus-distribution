﻿// Ion.CheckRadio
// version 1.0.2 Build: 19
// https://github.com/IonDen/ion.CheckRadio
(function(e){var k=0,d={init:function(){return this.each(function(){var a=e(this),b,f,d,g,l,m,c,h;if(!a.data("isActive")){a.data("isActive",!0);k++;this.pluginCount=k;l=a.prop("type");d=a.prop("disabled");g=a.prop("checked");m=a.prop("name");b=a.parent("label");if(0<b.length)h=b.html(),c=h.replace(/<input["-=a-zA-Z\u0400-\u04FF\s\d]+>{1}/,""),h=c.trim();else if(b=a.prop("id"),b=e("label[for='"+b+"']"),0<b.length)h=b.html().trim();else throw Error("Label not found!");a[0].style.display="none";b[0].style.display=
"none";c=d?g?'<span class="icr disabled checked" id="icr-'+this.pluginCount+'">':'<span class="icr disabled" id="icr-'+this.pluginCount+'">':g?'<span class="icr enabled checked" id="icr-'+this.pluginCount+'">':'<span class="icr enabled" id="icr-'+this.pluginCount+'">';c=c+('<span class="icr__'+l+'"></span>')+('<span class="icr__text">'+h+"</span>");c+="</span>";b.after(c);f=e("#icr-"+this.pluginCount);(function(){f.on("click",function(){d||(g?a.prop("checked",!1):a.prop("checked",!0),e("input[name='"+
m+"']").trigger("stateChanged"))});f.on("mousedown",function(a){a.preventDefault();return!1});a.on("stateChanged",function(){(g=a.prop("checked"))?f.addClass("checked"):f.removeClass("checked")})})()}})}};e.fn.ionCheckRadio=function(a){return d[a]?d[a].apply(this,Array.prototype.slice.call(arguments,1)):"object"!==typeof a&&a?(e.error("Method "+a+" does not exist for jQuery.ionCheckRadio"),!1):d.init.apply(this,arguments)}})(jQuery);