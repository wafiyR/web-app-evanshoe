
// Get the modal
var modal_01 = document.getElementById('id01');
var modal_02 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
/*window.onclick = function (event) {
 if (event.target == modal_01) {
 modal_01.style.display = "none";
 }
 else (event.target == modal_02)
 modal_02.style.display = "none";
 
 }*/

window.onclick = function (event) {
    
    // event.preventDefault();
    if (event.target == modal_01) {
        modal_01.style.display = "none";
    }
    if (event.target == modal_02) {
        modal_02.style.display = "none";
    }
}

/*window.addEventListener('click', function (event) {
 if (event.target === modal_01) {
 modal_01.style.display = "none";
 }
 }); */







