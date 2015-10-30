function showResult(str) {
	
	var ajax_livesearch = document.getElementById("ajax-livesearch");
	
  if (str.length==0) { 
    ajax_livesearch.innerHTML="";
    ajax_livesearch.style.display="none";

    return;
  }

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();

  } else {  
  	// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {

      ajax_livesearch.innerHTML=xmlhttp.responseText;
      ajax_livesearch.style.display="block";
    }
  }

  xmlhttp.open("POST","/skola/wordpress/wp-admin/admin-ajax.php?action=search&q="+str,true); //Hämtar wp-admins ajax mojs
  xmlhttp.send();
}