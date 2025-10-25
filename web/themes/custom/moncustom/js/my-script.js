(function (Drupal, drupalSettings) {
  Drupal.behaviors.myBehavior = {
    attach: function (context, settings) {
      if (drupalSettings.breakpoint) {
        console.log('Breakpoints available:', drupalSettings.breakpoint);
      }
      else {
        console.warn('Breakpoints not loaded!');
      }
    }
  };
})(Drupal, drupalSettings);
