document.addEventListener("DOMContentLoaded", function(){

const sidebar = document.getElementById("sidebar");
const toggleBtn = document.querySelector(".toggle-sidebar");
const overlay = document.getElementById("overlay");

/* Detectar móvil */
function isMobile() {
    return window.innerWidth <= 992;
}

/* Toggle Sidebar */
toggleBtn.onclick = () => {

    if (isMobile()) {
        sidebar.classList.toggle("mobile-active");
        overlay.classList.toggle("active");
    } else {
        sidebar.classList.toggle("collapsed");
    }
};

/* Cerrar tocando overlay */
overlay.onclick = () => {
    sidebar.classList.remove("mobile-active");
    overlay.classList.remove("active");
};

/* SUBMENU */
document.querySelectorAll(".submenu-toggle > a").forEach(item=>{
    item.addEventListener('click', function(e) {
        if (this.getAttribute('href') === '#') {
            e.preventDefault();
        }
    });
});

/* DARK MODE */
const toggleTheme = document.getElementById("toggleTheme");
const html = document.documentElement;

if(localStorage.getItem("theme")==="dark"){
    html.setAttribute("data-theme","dark");
}

toggleTheme.onclick = ()=>{
    let theme = html.getAttribute("data-theme")==="dark"?"light":"dark";
    html.setAttribute("data-theme",theme);
    localStorage.setItem("theme",theme);
};

/* CHARTS */
new Chart(document.getElementById("salesChart"),{
    type:"bar",
    data:{
        labels:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        datasets:[
            {label:"Ventas",data:window.salesData,backgroundColor:"#7367f0"},
            {label:"Visitas",data:window.visitsData,backgroundColor:"#ff9f43"}
        ]
    }
});

new Chart(document.getElementById("donutChart"),{
    type:"doughnut",
    data:{
        labels:window.trendingData.map(x=>x.name),
        datasets:[{
            data:window.trendingData.map(x=>x.value),
            backgroundColor:window.trendingData.map(x=>x.color)
        }]
    }
});

});