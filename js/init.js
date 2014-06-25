$(document).ready(function() {
  var superfish_params = {
    speed: 400,
    animation: {opacity: 'show'},
    delay: 0,
    autoArrows: false
  };
  $('.sf-menu').superfish(superfish_params);
  $('.sf-menu a.no-action').click(function() {
    return false;
  });
});
