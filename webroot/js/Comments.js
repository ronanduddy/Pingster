function commentLoad(loc)
{
  var block = $('#commentsBlock');
  block.fadeOut();
  $.ajax({dataType: "html", evalScripts: true, url: loc, success: function (data, textStatus) {
    block.hide();
    block.empty().append(data);
    block.fadeIn();
  }})
  .fail(function (jqxhr) {
    block.fadeIn({
      done: function () {
        commentDisplayError("Could not load this comment, sorry!");
      }
    });
  });
}

function commentDisplayError(message) {
  var flash = $("#commentsPage .commentsFlash");
  flash.hide();
  flash.empty().append(message);
  flash.slideDown("slow");
}

$(function () {
  $('#commentsBlock .comment-navigator a').bind('click', function (e) {
    var destination = $(e.target).attr('href');
    e.preventDefault();
    commentLoad(destination);
  });

  $('#commentsBlock .comment-deleter').bind('click', function (e) {
    var destination = $(e.target).attr('href');
    var commentsPaginatorUrl = $('#commentsPaginatorUrl').val();
    e.preventDefault();
    $.ajax({type: "POST", dataType: "html", evalScripts: true, url: destination, data: {_method: "POST"}, success: function (data, textStatus) {
      commentLoad(commentsPaginatorUrl);
    }})
    .fail(function (jqxhr) {
      var data = $.parseJSON(jqxhr.responseText);
      commentDisplayError(data.message);
    });
  });
});
