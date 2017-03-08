$(document).ready(function(){
 RATER.create('.stars');
});

var RATER = {
  create: function(selector) {
    $(selector).each(function() {
      var $list = $('<div></div>');
      $(this)
        .find('input:radio')
        .each(function(i) {
          var rating = $(this).parent().text();
          var $a = $('<a href="#"></a>')
            .attr('title', rating)
            .addClass(i % 2 == 1 ? 'rating-right' : '')
            .text(rating);
          RATER.addHandler($a);
          $list.append($a);
          if($(this).is(':checked')) {
            $a.prevAll().andSelf().addClass('rating');
          }
        });
        $(this).append($list).find('label').hide();
    });
  },
  addHandler: function(a) {
    $(a).click(function(e) {
      var $ster = $(this);
      var $all = $(this).parent();
      $all
        .parent()
        .find('input:radio[value=' + $ster.text() + ']')
        .attr('checked', true);
      $all.children().removeClass('rating');
      $ster.prevAll().andSelf().addClass('rating');
      e.preventDefault();
          
    }).hover(function() {
      $(this).prevAll().andSelf().addClass('rating-over');
    }, function() {
      $(this).siblings().andSelf().removeClass('rating-over')
    });    
  }
  
}