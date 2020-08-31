var map = L.map('map').setView([0,0],1);

L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=nQNGtBIpgHqmOzDa5Eo7', {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);

        map.setView ([38.2462420, 21.7350847], 16);


        //test for heatmap
        let testData = {
            max: 8,
            data: [
          {lat: 38.246242, lng: 21.735085, count:3},
          {lat: 38.323343, lng: 21.865082, count:2},
          {lat: 38.34381, lng: 21.57074, count:8},
          {lat: 38.108628, lng: 21.502075, count:7},
          {lat: 38.123034, lng: 21.917725, count:4}]
          };
            
          let cfg = {
            // radius should be small ONLY if scaleRadius is true (or small radius is intended)
            // if scaleRadius is false it will be the constant radius used in pixels
            "radius": 40,
            "maxOpacity": 0.8,
            // scales the radius based on map zoom
            "scaleRadius": false,
            // if set to false the heatmap uses the global maximum for colorization
            // if activated: uses the data maximum within the current map boundaries
            //   (there will always be a red spot with useLocalExtremas true)
            "useLocalExtrema": false,
            // which field name in your data represents the latitude - default "lat"
            latField: 'lat',
            // which field name in your data represents the longitude - default "lng"
            lngField: 'lng',
            // which field name in your data represents the data value - default "value"
            valueField: 'count'
          };
          
          let heatmapLayer =  new HeatmapOverlay(cfg);
          
          map.addLayer(heatmapLayer);
          heatmapLayer.setData(testData);
          //end test for heatmap


function start() {
    var x = document.getElementById("hometab");
    var y = document.getElementById("searchtab");
    
    y.style.display = "none";
    
    x.className += " active";

}


function openTab(evt, Tabname) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(Tabname).style.display = "block";
            evt.currentTarget.className += " active";
}




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

    var i = 0;
function move() {
    var sb = document.getElementById("searchbar");
    sb.style.display = "block";
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("searchbar");
    var width = 10;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
        elem.innerHTML = width  + "%";
      }
    }
  }
}

function logout_confirm() {
    confirm("Are you sure you wish to log out?");
        
}
