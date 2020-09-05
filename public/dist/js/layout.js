/*
window.addEventListener("load",function(){

    var  page = document.getElementById("loader") ;
    

    setTimeout(function(){ page.style.visibility="hidden" ;  }, 3000);
 

}) ; 
*/



// loader
var loader = function() {
    setTimeout(function() { 
        if($('#ftco-loader').length > 0) {
            $('#ftco-loader').removeClass('show');
        }
    }, 3);
};
loader();