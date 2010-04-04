function changeFlagged(imgElement) {
  var imgJQuery = $(imgElement);
  var isFlagged = imgJQuery.hasClass("flagged");
  var userId = imgElement.className.match(/user-(\d+)/);
  if (userId) userId = userId[1];
  // using .ajax instead of .get since apparently .get caches in IE
  $.ajax({
    async: true,
    cache: false,
    data: { id: userId, set: (isFlagged ? 0 : 1) },
    dataType: "text",
    success: function(msg) {
      if ("0" != msg) {
        if (isFlagged) {
          $(".user-" + userId).removeClass("flagged").attr("src", "img/flagged-0.png");
        }
        else {
          $(".user-" + userId).addClass("flagged").attr("src", "img/flagged-1.png");
        }
      }
    },
    type: "GET",
    url: "flag.php"
  });
}