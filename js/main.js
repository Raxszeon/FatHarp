/* FUNKTION FÖR ATT VISA OCH DÖLJA MENYN */
function menu() {
	var menu = document.getElementById("menu-huvudmeny");
	if(menu.classList.contains("show")) {
			menu.classList.remove("show");
			document.getElementById("searchform").classList.remove("show");
	} else {
			menu.classList.add("show");
			document.getElementById("searchform").classList.add("show");

	}
}



