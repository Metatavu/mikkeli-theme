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

  /* Ajax Pagination */
  $(document).on( 'click', '.page-navigation a', function( event ) {
		event.preventDefault();
    type = $(this).parent().parent().parent().attr('id');
    cur_page = $('#'+type+' .page-navigation .page-number span').text();
    number_of_pages = $('#'+type+' .page-navigation .number-of-pages').text();
    console.log(type);

    if($(this).parent().hasClass('nextpage')) {
      page = parseInt(cur_page) + 1;
      cur_page++;
    } else {
      page = parseInt(cur_page) - 1;
      cur_page--;
    }

    if(cur_page == 1) {
      $('#'+type+' .page-navigation .prevpage a').contents().unwrap();
      $('#'+type+' .page-navigation .nextpage').contents().wrap('<a href="#" />');
    }

    $.ajax({
      url: ajaxpagination.ajaxurl,
      type: 'post',
      data: {
        action: 'ajax_pagination',
        query_vars: ajaxpagination.query_vars,
        page: page,
        contentType: type
      },
      beforeSend: function() {
        $('#'+type+' #displayResults').find( '#loader' ).remove();
        $('#'+type+' #displayResults').find( '.item' ).remove();
        $('#'+type+' #displayResults').append( '<div class="page-content" id="loader"><div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>' );
      },
      success: function( html ) {
        $('#'+type+' #displayResults #loader').remove();
        $('#'+type+' #displayResults').find('.item').remove();
        $('#'+type+' #displayResults').append( html );
        $('#'+type+' .page-navigation .page-number span').text(cur_page);
        //console.log(cur_page);
        if(cur_page > 1) {
          $('#'+type+' .page-navigation .prevpage').contents().wrap('<a href="#" />');
        }
        if(cur_page == number_of_pages) {
          $('#'+type+' .page-navigation .nextpage a').contents().unwrap();
        }
      }
    });
  })

  /* AccordionTabs */
  $('.accessibility-sentences button').on('click', function() {
    $(this).toggleClass('closed');
    $(this).parent().toggleClass('visible');
  });

  /* Front Page Slider */
  $('.home .slides').slick({
    arrows: false,
    autoplay: true,
    autoplaySpeed: 6000
  });
});