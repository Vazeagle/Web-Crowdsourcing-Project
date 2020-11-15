
function start() {
    var x = document.getElementById("login");
    var y = document.getElementById("signup");
    var s = document.getElementById("su_button");

    x.style.display = "none";
    
    y.style.display = "block";

}

function signup_select() {
    var x = document.getElementById("login");
    var y = document.getElementById("signup");
    var s = document.getElementById("su_button");
    var l = document.getElementById("li_button");
      if (x.style.display === "block" && y.style.display === "none") {
      x.style.display = "none";
      y.style.display = "block";
      l.style.background = "#191919";
      s.style.background = '#2ecc71';

    }
  }

function login_select() {
    var x = document.getElementById("login");
    var y = document.getElementById("signup");
    var s = document.getElementById("su_button");
    var l = document.getElementById("li_button");
    if (y.style.display === "block" && x.style.display === "none") {
        y.style.display = "none";
        x.style.display = "block";
        l.style.background = '#2ecc71';
        s.style.background = '#191919';
    }
  }

/*function openTab(evt, Tabname) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(Tabname).style.display = "block";
            evt.currentTarget.className += " active";
}