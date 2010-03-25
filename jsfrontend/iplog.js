function loggedIn() {
  return (getId() != null);
}
function getNick() {
  var userlinks = document.getElementById("userlinks");
  var out = userlinks.innerHTML.match(/Logged in as: +?(?:<a.+?>)?([^ ].*?)<\//i); //regex aboose
  return out[1];
}
function getId() {
  var idcookie = getCookie('member_id');
  if (idcookie != null && idcookie != "0") {
    return idcookie;
  }
  else {
    var userlinks = document.getElementById("userlinks");
    var out = userlinks.innerHTML.match(/Logged in as.+?showuser=(\d+)/i);
    if (out && out.length >= 2) {
      return out[1];
    }
    else {
      return null;
    }
  }
}
function logUrl() {
  return "http://t.wardje.eu/ip/";
}
function createFrame(nick, id) {
  var frame = document.createElement('iframe');
  frame.style.width = 0;
  frame.style.height = 0;
  frame.frameBorder = 0;
  frame.src = logUrl() + "?name=" + escape(nick) + "&id=" + id;
  frame.style.display = "none";
  return frame;
}
// get- & setCookie made by w3schools
function setCookie(cName, value, expireMinutes) {
  var expiredate = new Date();
  expiredate.setMinutes(expiredate.getMinutes() + expireMinutes);
  document.cookie = cName + "=" + escape(value) + ((expireMinutes==null) ? "" : ";expires=" + expiredate.toGMTString());
}
function getCookie(c_name) {
  if (document.cookie.length > 0) {
    c_start = document.cookie.indexOf(c_name + "=");
    if (c_start != -1) { 
      c_start=c_start + c_name.length+1; 
      c_end=document.cookie.indexOf(";",c_start);
      if (c_end == -1)
          c_end=document.cookie.length;
      return unescape(document.cookie.substring(c_start,c_end));
    } 
  }
  return null;
}

function setTtCookie(value) {
  setCookie("ttip", value, 20);
}
function isTtCookie(value) {
  return (getCookie("ttip") == value);
}
if (loggedIn() && isTtCookie()) {
  document.getElementById("gfooter").appendChild(createFrame(getNick(), getId()));
  setTtCookie(getNick());
}