$((function(){$(".hamburger").click((function(){$(this).toggleClass("is-active"),$(".responsive-nav").slideToggle("fast",(function(){})),$(this).attr("aria-expanded",(function(t,i){return"true"==i?"false":"true"})),"true"===$(this).attr("aria-expanded")?$(this).attr("aria-label","Sulje valikko"):$(this).attr("aria-label","Avaa valikko")})),$(".sidebar .btn-menu").click((function(){$(".sidebar .sub-navigation").slideToggle("fast"),$(this).attr("aria-expanded",(function(t,i){return"true"==i?"false":"true"})),"true"===$(this).attr("aria-expanded")?($(this).attr("aria-label","Sulje valikko"),$(this).attr("title","Sulje valikko")):($(this).attr("aria-label","Avaa valikko"),$(this).attr("title","Avaa valikko"))})),$(".sidebar .children").each((function(){thisDropdown=$(this),title=$(this).closest("li").find("> a").text(),$(this).closest("li").find("> a").append('<button class="open" title="Avaa '+title+'">Avaa '+title+"</div>")})),$(".sidebar ul").on("click",".open",(function(t){return $(this).closest("li").toggleClass("active"),thisDropdown=$(this).closest("li").find("> .children"),thisDropdown.toggleClass("visible"),!1})),$(".current-locale").on("click",(function(){$(".locale-menu").toggleClass("menu-open")})),$(".results-filters button").on("click",(function(){$(".results-filters button").removeClass("current"),$(this).addClass("current"),$(".results .results-tab-container").hide();var t=$(this).attr("id");$(".results #"+t).show()}))}));