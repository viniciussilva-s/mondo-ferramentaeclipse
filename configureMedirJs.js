
$( document ).ready(function() {


var tooltipPassWordCriterios = "<div id='message2'>";
tooltipPassWordCriterios +=  "<h6>Critérios para senha:</h6>";
tooltipPassWordCriterios +=    "<p id='capital' class='invalid'>Uma <b>letra maiuscula</b></p>";
tooltipPassWordCriterios +=    "<p id='number' class='invalid'>Um <b>número</b></p>";
tooltipPassWordCriterios +=" <p id='length' class='invalid'>minimo <b>8 caracteres </b></p>";
tooltipPassWordCriterios += "</div>";

    $("#despassword").popover({
        placement: "top",
   //     template: '<div class="tooltip tooltip-custom"><div class="title">Test</div><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        title:tooltipPassWordCriterios,
        html:true});


});

var myInput = document.getElementById("despassword");
//var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

var despassword2 = document.getElementById("despassword2");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
  document.getElementById("message2").style.display = "block";

  $('[data-toggle="tooltip"]').tooltip();   
}

despassword2.onblur = function(){
    if(myInput.value != despassword2.value){
        var div = document.getElementById('feedbackdiv');
        div.setAttribute('style',"display:block;")

    }else{
        var div = document.getElementById('feedbackdiv');
        div.setAttribute('style',"display:none;")

        var buttonCreate = document.getElementById('btn-create');
        buttonCreate.setAttribute('disabled',false)
    }
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
 // document.getElementById("message").style.display = "none";
}




strengthValue = 0 ;
var passUpCase = false, passNumbers = false, passLength = false; 
// When the user starts to type something inside the password field
myInput.onkeyup = function() {


  // Validate lowercase letters
  // var lowerCaseLetters = /[a-z]/g;
  // if(myInput.value.match(lowerCaseLetters)) {  
  //   letter.classList.remove("invalid");
  //   letter.classList.add("valid");
  // } else {
  //   letter.classList.remove("valid");
  //   letter.classList.add("invalid");
  // }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {

    capital.classList.remove("invalid");
    capital.classList.add("valid");

    if(!passUpCase)strengthValue+=3;

    passUpCase = true; 

  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
    if(passUpCase)strengthValue-=3;
    passUpCase = false; 
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
   
    if(!passNumbers)strengthValue+=3;

    passNumbers = true; 

  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
    if(passNumbers)strengthValue-=3;
    passNumbers = false;  

  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
    
    if(!passLength)strengthValue+=3;

    passLength = true;  

  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
    if(passLength)strengthValue-=3;
    passLength = false; 
  }

  document.getElementById('strength').value= strengthValue; 


}