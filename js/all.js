$((function(){$(".hamburger").click((function(){$(this).toggleClass("is-active"),$(".responsive-nav").slideToggle("fast",(function(){})),$(this).attr("aria-expanded",(function(e,t){return"true"==t?"false":"true"})),"true"===$(this).attr("aria-expanded")?$(this).attr("aria-label","Sulje valikko"):$(this).attr("aria-label","Avaa valikko")})),$(".sidebar .btn-menu").click((function(){$(".sidebar .sub-navigation").slideToggle("fast"),$(this).attr("aria-expanded",(function(e,t){return"true"==t?"false":"true"})),"true"===$(this).attr("aria-expanded")?($(this).attr("aria-label","Sulje valikko"),$(this).attr("title","Sulje valikko")):($(this).attr("aria-label","Avaa valikko"),$(this).attr("title","Avaa valikko"))})),$(".sidebar .children").each((function(){thisDropdown=$(this),title=$(this).closest("li").find("> a").text(),$(this).closest("li").find("> a").append('<button class="open" title="Avaa '+title+'">Avaa '+title+"</div>")})),$(".sidebar ul").on("click",".open",(function(e){return $(this).toggleClass("toggled"),thisDropdown=$(this).closest("li").find("> .children").toggle(),!1})),$(".current-locale").on("click",(function(){$(".locale-menu").toggleClass("menu-open")})),$(".results-filters button").on("click",(function(){$(".results-filters button").removeClass("current"),$(this).addClass("current"),$(".results .results-tab-container").hide();var e=$(this).attr("id");$(".results #"+e).show()})),$(document).on("click",".page-navigation a",(function(e){e.preventDefault(),type=$(this).parent().parent().parent().attr("id"),cur_page=$("#"+type+" .page-navigation .page-number span").text(),number_of_pages=$("#"+type+" .page-navigation .number-of-pages").text(),console.log(type),$(this).parent().hasClass("nextpage")?(page=parseInt(cur_page)+1,cur_page++):(page=parseInt(cur_page)-1,cur_page--),1==cur_page&&($("#"+type+" .page-navigation .prevpage a").contents().unwrap(),$("#"+type+" .page-navigation .nextpage").contents().wrap('<a href="#" />')),$.ajax({url:ajaxpagination.ajaxurl,type:"post",data:{action:"ajax_pagination",query_vars:ajaxpagination.query_vars,page:page,contentType:type},beforeSend:function(){$("#"+type+" #displayResults").find("#loader").remove(),$("#"+type+" #displayResults").find(".item").remove(),$("#"+type+" #displayResults").append('<div class="page-content" id="loader"><div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>')},success:function(e){$("#"+type+" #displayResults #loader").remove(),$("#"+type+" #displayResults").find(".item").remove(),$("#"+type+" #displayResults").append(e),$("#"+type+" .page-navigation .page-number span").text(cur_page),cur_page>1&&$("#"+type+" .page-navigation .prevpage").contents().wrap('<a href="#" />'),cur_page==number_of_pages&&$("#"+type+" .page-navigation .nextpage a").contents().unwrap()}})})),$(".accessibility-sentences button").on("click",(function(){$(this).toggleClass("closed"),$(this).parent().toggleClass("visible")})),$(".home .slides").slick({arrows:!0,autoplay:!0,autoplaySpeed:6e3})}));