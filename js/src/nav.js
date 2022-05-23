$(function() {
  $( ".hamburger" ).click(function() {
    $(this).toggleClass("is-active");
    $( ".responsive-nav" ).slideToggle( "fast", function() {});
    $(this).attr('aria-expanded', function (i, attr) {
      return attr == 'true' ? 'false' : 'true'
    });
    if ($(this).attr( 'aria-expanded') === 'true') {
      $(this).attr("aria-label","Sulje valikko");
    } else {
      $(this).attr("aria-label","Avaa valikko");
    }
  });
  $( ".sidebar .btn-menu" ).click(function() {
    $('.sidebar .sub-navigation').slideToggle('fast');
    $(this).attr('aria-expanded', function (i, attr) {
      return attr == 'true' ? 'false' : 'true'
    });
    if ($(this).attr( 'aria-expanded') === 'true') {
      $(this).attr("aria-label","Sulje valikko");
      $(this).attr("title","Sulje valikko");
    } else {
      $(this).attr("aria-label","Avaa valikko");
      $(this).attr("title","Avaa valikko");
    }
  });
  var navItemDropdown = $('.sidebar .children');
  navItemDropdown.each(function(){
    thisDropdown = $(this);
    title = $(this).closest('li').find('> a').text();
    $(this).closest('li').find('> a').append('<button class="open" title="Avaa '+title+'">Avaa '+title+'</div>');
  });
  $('.sidebar ul').on('click','.open',function(event){
      $(this).closest('li').toggleClass('active');
      thisDropdown = $(this).closest('li').find('> .children');
      thisDropdown.toggleClass('visible');
      return false;
  });
  $('.current-locale').on('click', function() {
    $('.locale-menu').toggleClass('menu-open');
  });

  /* Search Results FilterTabs */
  $('.results-filters button').on('click', function() {
    $('.results-filters button').removeClass('current');
    $(this).addClass('current');
    $('.results .results-tab-container').hide();
    var target = $(this).attr('id');
    $('.results #'+target).show();
  });
});