// We define a function that takes one parameter named $.
(function ($) {
  // Use jQuery with the shortcut:
  Drupal.behaviors.attaching_assets_customBlocks = {
    attach: function (context, settings) {
      if (context == $(document)[0]) {
        $blocks = $('.block-block-content h2');

        $blocks.each(function() {
          $(this).addClass('change-colors');
        });
      }
    }
  };


// Here we immediately call the function with jQuery as the parameter.
}(jQuery));
