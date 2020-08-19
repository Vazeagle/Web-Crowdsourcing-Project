var map = L.map('map').setView([0,0],1);

L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=nQNGtBIpgHqmOzDa5Eo7', {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);

function SYearFunction() {
    document.getElementById("SYeardbtn").classList.toggle("show");
    }
function EYearFunction() {
    document.getElementById("EYeardbtn").classList.toggle("show");
    }
function SMonthFunction() {
document.getElementById("Smonthdbtn").classList.toggle("show");
    }
function EMonthFunction() {
document.getElementById("Emonthdbtn").classList.toggle("show");
    }
function SDayFunction() {
document.getElementById("Sdaydbtn").classList.toggle("show");
    }
function EDayFunction() {
document.getElementById("Edaydbtn").classList.toggle("show");
    }
function STimeFunction() {
document.getElementById("STimedbtn").classList.toggle("show");
    }
function ETimeFunction() {
document.getElementById("ETimedbtn").classList.toggle("show");
    }
function ActivFunction() {
document.getElementById("Activdbtn").classList.toggle("show");
    }
  
  
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
        }
    }
    }
