// We define a function that takes one parameter named $.
(function ($) {
  // Use jQuery with the shortcut:
  console.log($.browser);
  alert('hello');

  Drupal.behaviors.attaching_assetsCustomBlocks = function (context) {
    console.log($.browser);
    alert('hello');
  }


// Here we immediately call the function with jQuery as the parameter.
}(jQuery));
