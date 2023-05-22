<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    
h1 { 
  font-family: helvetica;
  text-align:center;
}

.pin-code{ 
  padding: 0; 
  margin: 0 auto; 
  display: flex;
  justify-content:center;
  
} 
 
.pin-code input { 
  border: none; 
  text-align: center; 
  width: 48px;
  height:48px;
  font-size: 36px; 
  background-color: #F3F3F3;
  margin-right:5px;
} 



.pin-code input:focus { 
  border: 1px solid #573D8B;
  outline:none;
} 


input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
<body>
    
    <h1>Enter Pin</h1>
    <div class="pin-code">

        <input type="hidden" id="baseUrl" value="<?php echo BASE_URL; ?>">
        <input type="number" maxlength="1" id="pin1" autofocus>
        <input type="number" maxlength="1" id="pin2">
        <input type="number" maxlength="1" id="pin3">
        <input type="number" maxlength="1" id="pin4" oninput="submitpin();">
    </div>

</body>
<script>
    //var pinContainer = document.getElementsByClassName("pin-code")[0];
var pinContainer = document.querySelector(".pin-code");
console.log('There is ' + pinContainer.length + ' Pin Container on the page.');

pinContainer.addEventListener('keyup', function (event) {
    var target = event.srcElement;
    
    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;

    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null) break;
            if (next.tagName.toLowerCase() == "input") {
                next.focus();
                break;
            }
        }
    }

    if (myLength === 0) {
        var next = target;
        while (next = next.previousElementSibling) {
            if (next == null) break;
            if (next.tagName.toLowerCase() == "input") {
                next.focus();
                break;
            }
        }
    }
}, false);

pinContainer.addEventListener('keydown', function (event) {
    var target = event.srcElement;
    target.value = "";
}, false);
</script>

<script>
    var baseUrl = document.getElementById("baseUrl").value;
    console.log(baseUrl);
    function submitpin(){
        var num1 = document.getElementById("pin1").value;
        var num2 = document.getElementById("pin2").value;
        var num3 = document.getElementById("pin3").value;
        var num4 = document.getElementById("pin4").value;
        // console.log(num1,num2,num3,num4);
        if (num1 == 1 && num2 == 0 && num3 == 0 && num4 == 6){
            console.log("login success");
            location.href = baseUrl+"chat.php?name=Victoria"; 
        }
        else if (num1 == 1 && num2 == 0 && num3 == 0 && num4 == 7){
            console.log("login success");
            location.href = baseUrl+"chat.php?name=James"; 
        }else if (num1 == 1 && num2 == 2 && num3 == 3 && num4 == 4){
            console.log("login success but redirect another page");
            location.href = baseUrl+"dummy.php"; 
        }else{
            console.log("login Incorrect!");
            location.href = baseUrl+"index.php"; 
        }
    }
</script>
</html>