<?php require_once('config.php'); ?>
<?php
session_start();
if(isset($_GET["name"]) && ($_GET["name"] == "Victoria" || $_GET["name"] == "James" ) ){
    $_SESSION["name"] = $_GET["name"];
}else{
    session_destroy();
    $baseUrl = BASE_URL;
    header("Location: $baseUrl./index.php");
}

if (empty($_SESSION["name"])){
    session_destroy();
    $baseUrl = BASE_URL;
    header("Location: $baseUrl./index.php");
}
?>

<!DOCTYPE html>
<head>	
	<title>Pusher Test</title>	
<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
	

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript" ></script>	
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript" ></script>	
<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js" type="text/javascript" ></script>				
	
<style = "text/css">	
.messages_display {height: 300px; overflow: auto;}		
.messages_display .message_item {padding: 0; margin: 0; }		
.bg-danger {padding: 10px;}	

.form-input img {
  width:100%;
  display:none;
  margin-bottom:30px;
}
</style>		
</head>
<body>

<br />	

<!--Form Start-->
<div class = "container">		
    <div class = "col-md-6 col-md-offset-3 chat_box" id="chatbox">						
        <div>Hi, <strong><?php echo $_SESSION["name"]; ?></strong> welcome in our private chat app<button class="btn-primary" style="float:right" onclick="logout();">logout</button></div>
		<div class = "form-control messages_display">
        <?php
            $dir = "messages";
            $fileName = $dir."/messages_".date("d-m-Y").".txt";
            if (!file_exists($dir)){
                mkdir($dir, 0744);
            }
            if (file_exists($fileName)){
                $myfile = fopen($fileName, "r");
            
                if (filesize($fileName) > 0){
                    $msg = fread($myfile,filesize($fileName));
                    fclose($myfile);
                    $msgArr = explode("\n",$msg);
                    for($i=0; $i < count($msgArr); $i++){
                        echo $msgArr[$i];
                        echo "\r\n";
                    }
                }
            }  
        ?>
        <!-- <img src="images/rajat.jpg" alt="image not found" data-toggle="modal" data-target="#myModal" onclick="show_full_image();" style="width: 100%; max-width: 100px; height: 100%; max-height: 100px;"> -->

        </div>			
		<br />						
		<div class = "form-group">						
			<input type = "hidden" class = "input_name form-control" value="<?php echo $_SESSION["name"]; ?>" placeholder = "Enter Name" />			
			<input type = "hidden" class = "base_url" value="<?php echo BASE_URL; ?>" />			
		</div>	
        <div class="row">
            <div class="col-md-8">
                <div class = "form-group">						
                    <textarea class = "input_message form-control" placeholder = "Enter Message" rows="3"></textarea>			
                </div>						
            </div>
            <div class="col-md-2">
                <div class = "form-group input_send_holder">				
                    <input type = "submit" value = "Send" class = "btn btn-primary btn-sm input_send" />			
                </div>					
            </div>
        </div>					
            

<!--form end-->
        <form id="image-upload-form"  method="post">
                <div class="row">
                    <div class="col-md-8">
                        <input type="file" name="userImage" class="form-control" id="file-ip-1" accept="image/*" onchange="showPreview(event);" />			
                        <input type="hidden" name="imageName" class="form-control " id="imageName" value = "<?php echo time(); ?>"/>			
                    </div>
                    <div class="col-md-4">
                        <input type="submit" value="send image" class="btn-primary btn-sm " />	
                    </div>
                </div>
        </form>			
        <div class="preview">
            <img id="file-ip-1-preview" style="width : 100px; height : 50px;">
        </div>	
    </div>
	<script type="text/javascript">		
        var base_url = $(".base_url").val();
        console.log("base_url :",base_url);	
	
// Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

// Add API Key & cluster here to make the connection 
var pusher = new Pusher('22e880957852add41853', {
    cluster: 'ap2',
    encrypted: true
});

// Enter a unique channel you wish your users to be subscribed in.
var channel = pusher.subscribe('test_channel');

// bind the server event to get the response data and append it to the message div
channel.bind('my_event',
    function(data) {
        console.log(data);
        $('.messages_display').append('<p class = "message_item">' + data + '</p>');
        $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary btn-block input_send" />');
        $(".messages_display").scrollTop($(".messages_display")[0].scrollHeight);
    });

// check if the user is subscribed to the above channel
channel.bind('pusher:subscription_succeeded', function(members) {
    console.log('successfully subscribed!');
});

// Send AJAX request to the PHP file on server 
function ajaxCall(ajax_url, ajax_data) {
    $.ajax({
        type: "POST",
        url: ajax_url,
        //dataType: "json",
        data: ajax_data,
        success: function(response) {
            console.log(response);
        },
        error: function(msg) {}
    });
}

// Trigger for the Enter key when clicked.
$.fn.enterKey = function(fnc) {
    return this.each(function() {
        $(this).keypress(function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        });
    });
}

// Send the Message enter by User
$('body').on('click', '.chat_box .input_send', function(e) {
    e.preventDefault();
    
    var message = $('.chat_box .input_message').val();
    const d = new Date();
    var hour = d.getHours();
    var min = d.getMinutes();
    var name = $('.chat_box .input_name').val();
    if (name == "James"){
        var color = "#ADD8E6";
    }else{
        var color = "#ffb6c1";
    }
   
	if (message !== '') {
        // Define ajax data
        var chat_message = {
            time: hour+":"+ min,
            name: $('.chat_box .input_name').val(),
            message: '<strong style="color:' + color + ';">' + $('.chat_box .input_name').val() + '</strong> ' + '<span style="display: inline-block; background: #e7e2f4; border-radius: 5px; padding: 0px 5px 0px 5px;">' + message +'</span>'
        }
        // alert(message);
        console.log(chat_message);
        // Send the message to the server passing File Url and chat person name & message
        ajaxCall(base_url+'message.php', chat_message);

        // Clear the message input field
        $('.chat_box .input_message').val('');
        // Show a loading image while sending
        $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary btn-block" disabled /> &nbsp; sending....');
    }
});

// Send the message when enter key is clicked
$('.chat_box .input_message').enterKey(function(e) {
    e.preventDefault();
    $('.chat_box .input_send').click();
}); 
</script>

<script>
    function logout(){
        location.href = base_url+"logout.php"; 
    }

    function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-1-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }
</script>
</div>

<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">
          <img src="" alt="image not found" id="fullImage" style="width: 100%; max-width: 600px; height: 100%; max-height: 500px;"/>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
      
    </div>
  </div>
  <script>
      /** upload image */
       $(document).ready(function (e) {
    	$("#image-upload-form").on('submit',(function(e) {
    		e.preventDefault();
            const d = new Date();
            var hour = d.getHours();
            var min = d.getMinutes();
            var imageName = $("#imageName").val();
    		$.ajax({
            	url: "action.php",
    			type: "POST",
    			data:  new FormData(this),
    			contentType: false,
        	    cache: false,
    			processData: false,
    			success: function(data)
    		    {
                    console.log(data);
                    if (data == 'file uploaded') {

                        var name = $('.chat_box .input_name').val();
                        if (name == "James"){
                            var color = "#ADD8E6";
                        }else{
                            var color = "#ffb6c1";
                        }
                        // Define ajax data
                        var chat_img = {
                            time: hour+":"+ min,
                            message: '<strong style="color:' + color + ';">' + $('.chat_box .input_name').val() + '</strong> ' + '<img data-toggle="modal" data-target="#myModal" id="getFullImage" onclick="show_full_image();" style="width: 100%; max-width: 100px; height: 100%; max-height: 100px;" src="images/'+imageName+'.jpg" />'
                        }
                        // alert(message);
                        console.log(chat_img);
                        // Send the message to the server passing File Url and chat person name & message
                        ajaxCall(base_url+'message.php', chat_img);
                        document.location.reload(true);
                        // $("#file-ip-1").val('');
                        
                    }
    		    },
    		  	error: function(data)
    	    	{
    		  	  console.log("error");
                  console.log(data);
    	    	}
    	   });
    	}));
    });


    function show_full_image(){
        var imageName = $("#getFullImage").attr("src");
        // var imagePath = "images/"+imageName+".jpg"; 
        $('#fullImage').attr('src', imageName);
    }
</script>

</body>