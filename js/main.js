// Source: https://www.w3schools.com/howto/howto_js_navbar_shrink_scroll.asp
// Description: Shrinking navigation bar when scrolled down.
// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        document.getElementById("navigationbar").classList.remove("py-3")
        document.getElementById("navigationbar").classList.add("py-1")
        document.getElementById("brand").style.fontSize = "1rem";
        document.getElementById("brandlogo").width = "20";
        document.getElementById("brandlogo").height = "20";
    } else {
        document.getElementById("navigationbar").classList.remove("py-1")
        document.getElementById("navigationbar").classList.add("py-3")
        document.getElementById("brand").style.fontSize = "1.25rem";
        document.getElementById("brandlogo").width = "30";
        document.getElementById("brandlogo").height = "30";
    }
}

// Source: https://www.w3schools.com/howto/howto_html_include.asp
// Description: To include html files in <body>
function includeHTML() {
  var z, i, elmnt, file, xhttp;
  /*loop through a collection of all HTML elements:*/
  z = document.getElementsByTagName("*");
  for (i = 0; i < z.length; i++) {
    elmnt = z[i];
    /*search for elements with a certain atrribute:*/
    file = elmnt.getAttribute("w3-include-html");
    if (file) {
      /*make an HTTP request using the attribute value as the file name:*/
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.status == 200) {elmnt.innerHTML = this.responseText;}
          if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
          /*remove the attribute, and call this function once more:*/
          elmnt.removeAttribute("w3-include-html");
          includeHTML();
        }
      }
      xhttp.open("GET", file, true);
      xhttp.send();
      /*exit the function:*/
      return;
    }
  }
};

// Source: https://www.w3schools.com/howto/howto_css_smooth_scroll.asp
// Description: Smooth scrolling when link is pressed.
$(document).ready(function(){
    // Add smooth scrolling to all links
    $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
            scrollTop: $(hash).offset().top
            }, 800, function(){

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
            });
        } // End if
    });
});
