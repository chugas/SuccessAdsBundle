$(function() {
    "use strict";

    //Activate tooltips
    $("[data-toggle='tooltip']").tooltip();

  function add_pretty_errors(subject) {
    $('div.success-field-error', subject).each(function(index, element) {
        var input = $(':input', element);

        if (!input.length) {
            return;
        }

        var message = $('div.sonata-ba-field-error-messages', element).html();
        jQuery('div.sonata-ba-field-error-messages', element).remove();

        if (!message || message.length == 0) {
            return;
        }

        var target = input;

        target.popover({
            content: message,
            trigger: 'hover',
            html: true,
            placement: 'right',
            template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>'
        });
    });
  }

  function event_hide_errors(containerId){
    $.each( $('#'+containerId).find('input,textarea,select'), function( key, value ) {
      $(value).keydown(function(e){
        if($(this).hasClass('field-error')){
          $(this).removeClass('field-error');
          $(this).popover('destroy');
        }
      });
    });
  }

  /* 
   * Make sure that the sidebar is streched full height
   * ---------------------------------------------
   * We are gonna assign a min-height value every time the
   * wrapper gets resized and upon page load. We will use
   * Ben Alman's method for detecting the resize event.
   **/
  //alert($(window).height());
  function _fix() {
    //Get window height and the wrapper height
    var height = $(window).height() - $("body > .header").height();
    $(".wrapper").css("min-height", height + "px");
    var content = $(".wrapper").height();
    //If the wrapper height is greater than the window
    if (content > height)
      //then set sidebar height to the wrapper
      $(".left-side, html, body").css("min-height", content + "px");
    else {
      //Otherwise, set the sidebar to the height of the window
      $(".left-side, html, body").css("min-height", height + "px");
    }
  }
  
  add_pretty_errors(document);
  
  //Fire upon load
  _fix();
  //Fire when wrapper is resized
  $(".wrapper").resize(function() {
    _fix();
  });

});
