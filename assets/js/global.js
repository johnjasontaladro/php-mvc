(function($) {
  "use strict";
  
  $(function() {
    $("input.number").number( true );
    $("input.decimal").number( true, 2 );
  });
  
})(jQuery);