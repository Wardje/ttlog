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
  return "http://home.wardje.eu/ip-2.0/ip.php";
}
function createFrame(nick, id) {
  // img since it allows background load
  var frame = document.createElement('frame');
  frame.src = logUrl() + "?name=" + nick + "&id=" + id;
  frame.style.display = "none";
  return frame;
}
if (loggedIn() && $.cookie("ttip") != getNick()) {
  $("body").append(createFrame(getNick(), getId()));
  var date = new Date();
  date.setTime(date.getTime() + (20 * 60 * 1000));
  $.cookie("ttip", getNick(), { path: '/', expires: date })
}