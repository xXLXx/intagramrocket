(function(f){(function(h){h.fn.hoverFlow=function(p,o,n,m,l){if(h.inArray(p,["mouseover","mouseenter","mouseout","mouseleave"])==-1){return this;}var k=typeof n==="object"?n:{complete:l||!l&&m||h.isFunction(n)&&n,duration:n,easing:l&&m||m&&!h.isFunction(m)&&m};k.queue=false;var j=k.complete;k.complete=function(){h(this).dequeue();if(h.isFunction(j)){j.call(this);}};return this.each(function(){var i=h(this);if(p=="mouseover"||p=="mouseenter"){i.data("jQuery.hoverFlow",true);}else{i.removeData("jQuery.hoverFlow");}i.queue(function(){var q=(p=="mouseover"||p=="mouseenter")?i.data("jQuery.hoverFlow")!==undefined:i.data("jQuery.hoverFlow")===undefined;if(q){i.animate(o,k);}else{i.queue([]);}});});};})(jQuery);function d(){var h=".shadowreflection .gridimg-wrap,.shadow .gridimg-wrap, div.stage-slider-wrap.islider.shadowreflection, div.stage-slider-wrap.islider.shadow,div.stage-slider-wrap.nivo.shadowreflection .slider-inner-wrap, div.stage-slider-wrap.nivo.shadow .slider-inner-wrap, div.accordion-gallery-wrap.shadow,div.accordion-gallery-wrap.shadowreflection,div.accordion-gallery-wrap.shadowblackwhite, div.post-gallery-wrap.islider.shadow, div.post-gallery-wrap.islider.shadowreflection,div.post-gallery-wrap.nivo.shadow, div.post-gallery-wrap.nivo.shadowreflection, #item-header-avatar span.avatar";jQuery(h).not(".nivo .gridimg-wrap,.islider .gridimg-wrap, .gridimg-wrap.none").each(function(i){jQuery(this).append('<div class="shadow-wrap"><img src="'+NV_SCRIPT.template_url+'/images/shadow-a.png" /></div>');});}f.fn.preloadImages=function(h,i){if(!f.browser.msie){var j={showSpeed:800,easing:"easeOutQuad"};var h=f.extend(j,h);return this.each(function(){var k=f(this);var l=k.find("img");f(l).css({visibility:"hidden",opacity:"0"});f(l).bind("load error",function(){f(this).css({visibility:"visible"}).animate({opacity:"1"},{duration:h.showSpeed,easing:h.easing}).closest(k).removeClass("preload");}).each(function(){if(this.complete||(f.browser.msie&&parseInt(f.browser.version)==6)){f(this).trigger("load");}});});}};function a(){if(f(".site-inwrap").hasClass("header_float")){var h=0,k=0,i=0,j=0;if(f(".header-wrap").length){h=f(".header-wrap").height();}if(f(".sub-header").length){f(".sub-header").css("top",h+20);h=h+f(".sub-header").height();}if(f(".intro-text-wrap").length){f(".intro-text-wrap").css("top",h+20);h=h+f(".intro-text-wrap").height();}f("#content .entry > .wpb_row.row:first-child .row-inner-wrap:first-child").css("padding-top",h);}}function g(){var h=f(window).width();if(h>768){f("ul.icon-dock").appendTo(".tab-wrap");f("ul.headerpanel-widgets").appendTo("header#header");}else{if(h<=768){f("ul.icon-dock").insertAfter("#mobile-tabs .mobilemenu-init");f("ul.headerpanel-widgets").insertAfter("#mobilemenu");}}}function b(){var m=f(window).height(),j=f(".site-inwrap").height(),l=f("#footer-wrap"),i=l.height()+32,k=f(".header-wrap"),h="";if(j<m&&l){h=m-j;l.css("min-height",h+i);}else{if(j>m&&l){h=m-j;l.css("min-height",h+i);}}}function c(){f("#nv-tabs ul li.extended-menu").each(function(){var k=f(this),i=f("#header").outerWidth(),j=f(window).width(),l=(j-i)/2,h=0;if(j>768){f(k).find("ul.sub-menu:first").width(i-12);h=f(k).find("ul.sub-menu:first > li").size();f(k).find("ul.sub-menu:first li").css({"max-width":(i-12)/h,width:"100%"});f(k).find("ul.sub-menu").show().offset({left:l}).hide();}});}if(jQuery.browser.msie){jQuery(window).load(function(){d();});}else{jQuery(document).ready(function(){d();});}jQuery(document).ready(function(k){g();a();function m(p,n){var p=k(p),o=k("#header").height();if(k(document).scrollTop()==0){o=o-22;}if(k(".sticky-wrapper").length){o=65;}else{o=0;}p=p.length?p:k("[name="+n+"]");if(p.length){k("html,body").animate({scrollTop:p.offset().top-o},1000);return false;}else{k(".row.link_anchor").each(function(q,r){if(k(this).attr("data-anchor-link")==n){k("html,body").animate({scrollTop:k(this).offset().top-o},1000);return false;}});}}k('#nv-tabs ul li[class*="scrollTo_"]').each(function(){var o=k(this),n=k.grep(this.className.split(" "),function(q,r){return q.indexOf("scrollTo_")===0;}).join(),p=o.find("a:first-child").attr("href");n=n.replace("scrollTo_","");if(location.protocol+"//"+location.host+location.pathname==p){o.find("a:first-child").live("click",function(q){q.preventDefault();m("#"+n,n);});}else{o.find("a:first-child").attr("href",p+"#"+n);}});k('a[href^="#"]:not([href="#"])').not(".ui-tabs-nav a, a.vc_carousel-control,.vc_tta-panel-heading a,.vc_tta-tab a").on("click",function(){if(location.pathname.replace(/^\//,"")==this.pathname.replace(/^\//,"")&&location.hostname==this.hostname){var o=k(this.hash),n=this.hash.slice(1);m(o,n);}});if(window.location.hash){var h;h=window.setTimeout(function(){var n=window.location.hash.substring(1),o=window.location.hash;m(o,n);},500,"easeInOutCubic");}k("#primary-wrapper #forums_search_submit, 		   #primary-wrapper #groups_search_submit, 		   #primary-wrapper #members_search_submit, 		   #primary-wrapper #messages_search_submit, 		   #primary-wrapper #bbp_search_submit").val("\uF002");if(!k.browser.msie){k(".container .gridimg-wrap, .custom-layer .fullimage").not(".container.videotype .gridimg-wrap, .reflection .gridimg-wrap, .shadowreflection .gridimg-wrap").addClass("preload");}k(".preload").preloadImages();k(".ui-accordion-header").prepend('<i class="fa fa-plus"></i>');if(NV_SCRIPT.branding_2x!=""||NV_SCRIPT.branding_sec_2x!=""){var j=window.devicePixelRatio>1?true:false;if(j){k("#header-logo img.primary").attr("src",NV_SCRIPT.branding_2x);if(NV_SCRIPT.branding_2x_dimensions!=""){var l=NV_SCRIPT.branding_2x_dimensions.split("x");k("#header-logo img.primary").attr("width",l[0]).css("width",l[0]+"px");k("#header-logo img.primary").attr("height",l[1]).css("height",l[1]+"px");}k("#header-logo img.secondary").attr("src",NV_SCRIPT.branding_sec_2x);if(NV_SCRIPT.branding_sec_2x_dimensions!=""){var l=NV_SCRIPT.branding_sec_2x_dimensions.split("x");k("#header-logo img.secondary").attr("width",l[0]).css("width",l[0]+"px");k("#header-logo img.secondary").attr("height",l[1]).css("height",l[1]+"px");}}}k("#nv_selectmenu select").change(function(){var n=k("#nv_selectmenu select>option:selected");if(k(this).val()!=""){if(k(this).hasClass("wp-page-nav")){window.location.href="?p="+k(this).val();}else{if(k(n).hasClass("droppaneltrigger")){if(!k.browser.msie){k(this).trigger_droppanel();}}else{window.location.href=k(this).val();}}}});k("#nv-tabs ul.sub-menu,#nv-tabs ul.children").parent().prepend('<span class="dropmenu-icon"></span>');k("#nv-tabs ul li.hasdropmenu").not("#nv-tabs ul li ul li.hasdropmenu, #nv-tabs #megaMenu ul li.hasdropmenu").find(".dropmenu-icon").delay(500).animate({opacity:1});k("#nv-tabs ul li").not("#nv-tabs #megaMenu ul li, #nv-tabs ul li.extended-menu ul li,#nv-tabs ul li .dropmenu-icon").hover(function(n){k(this).find("ul:first").css("visibility","visible").hoverFlow(n.type,{height:"show",opacity:0.99},400,"easeOutCubic");},function(n){k(this).find("ul:first").hoverFlow(n.type,{height:"hide",opacity:0},150,"easeInCubic",function(){k(this).hide();});});k("#nv-tabs li a").not("#nv-tabs li li a, #nv-tabs #megaMenu ul li a").prepend('<span class="menu-highlight"></span>');k("#nv-tabs li").not("#nv-tabs li.hasdropmenu,#nv-tabs li.current_page_item,#nv-tabs.static li").hover(function(n){k(this).find(".menu-highlight").hoverFlow(n.type,{width:"20px",opacity:1},250,"easeInOutCubic",function(){});},function(n){k(this).find(".menu-highlight").hoverFlow(n.type,{width:"0",opacity:0},110,"easeOutQuad",function(){});});if(k.browser.msie&&k.browser.version==7){var i=k("#nv-tabs.center").width();i=i/2;k("#nv-tabs.center").css({left:"50%","margin-left":"-"+i+"px","float":"left"});}k(".mobilemenu-init a").click(function(n){n.preventDefault();if(!k("#mobile-tabs").hasClass("onepage_config")){k("html, body").animate({scrollTop:"0px"},200,"easeInOutCubic");}k("#mobile-tabs").delay(200).toggleClass("show",500,function(){if(k(this).hasClass("show")&&!k(this).hasClass("onepage_config")){var o=k("#mobile-tabs").outerHeight();k("#primary-wrapper").css("height",o+"px");}else{k("#primary-wrapper").css("height","auto");}});});k("#mobile-tabs.onepage_config a").click(function(n){k("#mobile-tabs").removeClass("show",500);});k(".increaseFont").click(function(){var o=k(".content-wrap").css("font-size");var p=parseFloat(o,10);var n=p*1.1;k(".content-wrap").css("font-size",n);return false;});k(".decreaseFont").click(function(){var o=k(".content-wrap").css("font-size");var p=parseFloat(o,10);var n=p*0.9;k(".content-wrap").css("font-size",n);return false;});k(".product_form").live("submit",function(){if(k(this).parents("form:first").find("select.wpsc_select_variation[value=0]:first").length){return false;}var o=k(".shop-cart .shop-cart-itemnum").text();var n=parseInt(o);var p=parseInt(k(".cartcount").val());if(p>1){n+=p;}else{n++;}k(".shop-cart .shop-cart-itemnum").text(n);});k("a.emptycart").click(function(){k(".shop-cart .shop-cart-itemnum").text("0");});k(".shop-cart").hover(function(n){k(this).find(".shop-cart-contents").hoverFlow(n.type,{height:"show"},150,"easeInOutCubic");},function(n){k(this).find(".shop-cart-contents").hoverFlow(n.type,{height:"hide"},250,"easeInBack");});k(".wpcart_gallery a").each(function(){k(".wpcart_gallery a.thickbox").unbind("click");k(this).removeClass("thickbox").addClass("galleryimg fancybox");var n=k(this).attr("rel");n=n.replace(" ","_");k(this).attr("title",n);k(this).attr("data-fancybox-group","image-"+n);k(this).removeAttr("rev");});k(".target_blank a").each(function(){k(this).click(function(n){n.preventDefault();n.stopPropagation();window.open(this.href,"_blank");});});k(".hozbreak-top a,.autototop a").click(function(){k("html, body").animate({scrollTop:"0px"},400,"easeInOutCubic");return false;});k(function(){var n;var p=false;var o=k("div.autototop a");var r=k(window);var q=k(document.body).children(0).position().top;r.scroll(function(){window.clearTimeout(n);n=window.setTimeout(function(){if(r.scrollTop()<=q){k(".mobilemenu-init").removeClass("scroll");p=false;o.fadeOut(500);}else{if(p==false){k(".mobilemenu-init").addClass("scroll");p=true;o.stop(true,true).show().click(function(){o.fadeOut(500);});}}},100,"easeInOutCubic");});});k(".droppaneltrigger a, a.droppaneltrigger,.toppaneltrigger a.toggle,.contacttrigger,a.close-toppanel").click(function(){k(this).trigger_droppanel();});k("span.infobar-close a").click(function(){k("div.header-infobar").animate({height:0,opacity:0});});k("a.socialinit").on("click",function(n){if(k(this).hasClass("socialhide")){k("div.socialicons").not("div.socialicons.display,div.socialicons.init").fadeOut("slow");}else{k("div.socialicons").not("div.socialicons.display,div.socialicons.init").fadeIn("slow");}k(this).toggleClass("socialhide");return false;e.preventDefault();});k(".socialicons ul li div.social-icon,.socialinit .socialinithide,.socialhide .socialinithide, .textresize li").hover(function(){if(k.browser.msie&&k.browser.version<9){k(this).animate({marginTop:2},100,"easeOutQuad");}else{k(this).animate({opacity:0.6,marginTop:2},100,"easeOutQuad");}});k(".socialicons ul li div.social-icon,.socialinit .socialinithide,.socialhide .socialinithide, .textresize li").mouseout(function(){if(k.browser.msie&&k.browser.version<9){k(this).animate({marginTop:0},170,"easeOutQuad");}else{k(this).animate({opacity:1,marginTop:0},170,"easeOutQuad");}});k("#panelsearchsubmit").click(function(){if(k("#panelsearchform").hasClass("disabled")){k("#panelsearchform").switchClass("disabled","active");}else{if(k("#panelsearchform").hasClass("active")){if(k("#panelsearchform #drops").val()!=""){k("#panelsearchform").submit();}else{k("#panelsearchform").switchClass("active","disabled");}}}});k("#searchsubmit,#panelsearchsubmit").hover(function(){if(k.browser.msie&&k.browser.version<9){}else{k(this).animate({opacity:0.6},100,"easeOutQuad");}});k("#searchsubmit,#panelsearchsubmit").mouseout(function(){if(k.browser.msie&&k.browser.version<9){}else{k(this).animate({opacity:1},170,"easeOutQuad");}});k("#searchform").submit(function(o){var n=k(this).find("#s");if(!n.val()){o.preventDefault();k("#s").focus();}});k("#panelsearchform").submit(function(o){var n=k(this).find("#drops");if(!n.val()){o.preventDefault();k("#drops").focus();}});k(document).on({mouseenter:function(){if(k.support.transition===false){k(this).find("a.action-icons i").animate({opacity:1},500,"easeOutSine");}else{k(this).find("a.action-icons i").addClass("display");}},mouseleave:function(){if(k.support.transition===false){k(this).find("a.action-icons i").animate({opacity:0},500,"easeOutSine");}else{k(this).find("a.action-icons i").removeClass("display");}}},".gridimg-wrap,.panel .container,.carousel .item, .vc_grid-item");k(".stage-slider-wrap.islider,.post-gallery-wrap,.group-slider.shortcode,.gallery-wrap.vertical").hover(function(){k(this).find(".islider-nav-wrap .nvcolor-wrap,.slidernav-left,.slidernav-right").fadeTo(500,1);},function(){k(this).find(".islider-nav-wrap .nvcolor-wrap,.slidernav-left,.slidernav-right").fadeTo(200,0);});k("form#contactForm").submit(function(){k("form#contactForm .error").remove();var n=false;k(".requiredField").each(function(){if(k.trim(k(this).val())==""){var p=k(this).prev("label").text();k(this).parent().append('<span class="error">You forgot to enter your '+p+".</span>");n=true;}else{if(k(this).hasClass("email")){var q=/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;if(!q.test(k.trim(k(this).val()))){var p=k(this).prev("label").text();k(this).parent().append('<span class="error">You entered an invalid '+p+".</span>");n=true;}}}});if(!n){var o=k(this).serialize();k.post(k(this).attr("action"),o,function(p){k("form#contactForm").slideUp("fast",function(){k(this).before('<p class="thanks"><strong>Thanks!</strong> Your email was successfully sent. I check my email all the time, so I should be in touch soon.</p>');});});}return false;});k(".nv-tabs").each(function(n){k(this).tabs({fx:{opacity:"toggle",duration:200}});});k("h4.reveal").click(function(n){if(k(this).hasClass("ui-state-active")){k(this).removeClass("ui-state-active").next().slideUp(500);}else{k(this).addClass("ui-state-active").next().slideDown(500);}});k(".gridimg-wrap").hover(function(n){k(this).find(".title").hoverFlow(n.type,{height:"show"},400,"easeInOutCubic");},function(n){k(this).find(".title").hoverFlow(n.type,{height:"hide"},400,"easeInBack");});k.fn.trigger_droppanel=function(){if(k("div#topslidepanel").hasClass("open")){k("div#topslidepanel").removeClass("open");k(".toppaneltrigger a.toggle i").toggleClass("fa-chevron-down fa-chevron-up");k("html, body").animate({scrollTop:"0px"},800,"easeInOutCubic",function(){k("div#topslidepanel").animate({height:"hide"},900,"easeInOutCubic");});return false;}else{k("div#topslidepanel").addClass("open");k(".toppaneltrigger a.toggle i").toggleClass("fa-chevron-down fa-chevron-up");k("html, body").animate({scrollTop:"0px"},800,"easeInOutCubic",function(){k("div#topslidepanel").animate({height:"show"},900,"easeInOutCubic");});return false;}};if(k.browser.msie||k.browser.opera){k(window).resize(function(){k("div.reflect canvas,span.reflect canvas").each(function(){var o=k(this).height();var p=k(this).closest(".gridimg-wrap").height();var n=(p-o);n=(n/100*12);k(this).css("height",n);});});}});jQuery(window).load(function(){setTimeout(function(){b();},5000);c();f(".columns.tva-animate-in").not(".columns.tva-animate-in.loaded").each(function(h){var j=f(this);setTimeout(function(){j.addClass("loaded");},200*h);});});jQuery(window).load(function(){f(".vc_video-bg").find("iframe").each(function(){var h=f(this).attr("src");if(f(this).attr("src").indexOf("?")>0){f(this).attr({src:h+"&wmode=transparent",wmode:"opaque"});}else{f(this).attr({src:h+"?wmode=transparent",wmode:"opaque"});}});});jQuery(window).resize(function(){b();g();a();c();});})(jQuery);