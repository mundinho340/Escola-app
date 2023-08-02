<?php
    session_start();
    if (isset($_SESSION['username'])) {
      include "../app/db.conn.php";
      include '../app/helpers/user.php';
      include '../app/helpers/conversations.php';
      include '../app/helpers/timeAgo.php';
      include '../app/helpers/chat.php';
      include '../app/helpers/last_chat.php';
      include '../app/helpers/opened.php';
      $user = getUser($_SESSION['username'], $conn);
        	$user = getUser($_SESSION['username'], $conn);

  	# Getting User conversations
  	$conversations = getConversation($user['user_id'], $conn);
      
   if (isset($_SESSION['username'])) {
  	# database connection file
  	if (empty($chatWith)) {
        
  			}// exit;

   
  	# Getting User data data
     
     
     if (!isset($_GET['user'])) {
  		// exit;
   }else{
        $chatWith = getUser($_GET['user'], $conn);

   }
   if (isset($_GET['user'])){

      $chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $conn);
      opened($chatWith['user_id'], $conn, $chats);
   }
  	
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title></title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
        <link rel="stylesheet" href="../bootstrap-5.3.0-dist/css/bootstrap.css">
   <link rel="stylesheet" href="./css/style.css">
   <style>
      .image{
         height: 5rem;
         width: 5rem;
         border-radius: 50%;
         object-fit: contain;
         margin-bottom: 1rem;
      }
      #chatList .image{
         height: 7rem;
         width: 7rem;
         border-radius: 50%;
         object-fit: contain;
         margin-bottom: 1rem;
      }
   </style>

</head>
<body>

<header class="header">
   
   <section class="flex">

      <a href="home.php" class="logo">Tua Escola</a>

      <div class="search-form">
         <input type="text" type="text"
    			       placeholder="Search..."
    			       id="searchText"
    			       class="form-control" name="search_box" required placeholder="search courses..." maxlength="100">
         <button type="submit" id="serachBtn" class="fas fa-search"></button>
   </div>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <img src="images/pic-1.jpg" class="image" alt="">
         <h3 class="name">shaikh anas</h3>
         <p class="role">studen</p>
         <a href="profile.html" class="btn">Ver Perfil</a>
         <div class="flex-btn">
            <a href="login.html" class="option-btn">login</a>
            <a href="register.html" class="option-btn">register</a>
         </div>
      </div>

   </section>

</header>   

<div class="side-bar">

   <div id="close-btn">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
      <img src="../uploads/<?=$user['p_p']?>" class="image" alt="">
      <h3 class="name"><?=$user["name"]?></h3>
      <p class="role">Estudante</p>
      <a href="profile.php" class="btn">view profile</a>
   </div>

   <nav class="navbar">
    <ul id="chatList"
    		    class="list-group mvh-50 overflow-auto" >
    			<?php if (!empty($conversations)) { ?>
    			    <?php 

    			    foreach ($conversations as $conversation){ ?>
	    			<li class="list-group-item">
	    				<a href="chat.php?user=<?=$conversation['username']?>"
	    				   class="d-flex
	    				          justify-content-between
	    				          align-items-center p-2">
	    					<div class="d-flex
	    					            align-items-center">
	    					   <img  src="../uploads/<?=$conversation['p_p']?>"
	    					        class="image">
	    					    <h3 class="fs-xs m-2">
	    					    	<?=$conversation['name']?><br>
                      <small style="color:gray;">
                        <?php 
                          echo lastChat($_SESSION['user_id'], $conversation['user_id'], $conn);
                        ?>
                      </small>
	    					    </h3>            	
	    					</div>
	    					<?php if (last_seen($conversation['last_seen']) == "Active") { ?>
		    					<div title="online">
		    						<div class="online"></div>
		    					</div>
	    					<?php } ?>
	    				</a>
	    			</li>
    			    <?php } ?>
    			<?php }else{ ?>
    				<div class="alert alert-info 
    				            text-center">
					   <i class="fa fa-comments d-block fs-big"></i>
                       Não tem nenhuma conversa, inicie um chat agora!
					</div>
    			<?php } ?>
    		</ul>
   </nav>
</div>



<div class="h-600">
           <div class="d-flex align-items-center" style="height:50vh; margin-top:0px!important;" >
                  <div class=" d-flex"style=" margin-top:-290px!important;  background:white; width:100%;"> 
                  	<a href="home.php"
    	   class="fs-4 link-dark">&#8592;</a>

                     <div  class=" d-flex" style="margin-left:20px;">
                     <?php $userRecive; if (isset($_GET['user'])){ $userRecive =$chatWith['name'];?>
                        <img src="../uploads/<?=$chatWith['p_p']?>" class="image" ><?php } else{$userRecive="";}?> 
                                       <h3 class="display-4 fs-sm m-2" style="margin-left:20px;">
                           <?=$userRecive?> <br>
                           <div class="d-flex
                                       align-items-center"
                                 title="online" >
                           <?php
                              if(isset($_GET["user"])){
                                  if (last_seen($chatWith['last_seen']) == "Active") {
                           ?>
                                 <div class="online"></div>
                                 <small class="d-block p-1">Online</small>
                           <?php }else{ ?>
                                 <small class="h5">
                                    Last seen:
                                    <?=last_seen($chatWith['last_seen'])?>
                                 </small>
                           <?php }} ?>
                           </div>
                                       </h3>
                     </div>
                  </div>
            </div>
      </div>
    	   <div class="shadow p-4 rounded
    	               d-flex flex-column
    	               mt-2 chat-box"
    	        id="chatBox" style="margin-top:-220px !important; height:55vh !important ;overflow:auto !important;"> 
    	        <?php 
                     if (!empty($chats)) {
                     foreach($chats as $chat){
                     	if($chat['from_id'] == $_SESSION['user_id'])
                     	{ ?>
						<p style="background:blue; color:white; " class="rtext align-self-end
						        border rounded p-2 mb-1 h3 w-20 ">
						    <?=$chat['message']?> 
						    <small class="d-block h6 ">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p>
                    <?php }else{ ?>
					<p style="background:white; width:300px;" class="ltext border 
					         rounded p-2 mb-1 h3">
					    <?=$chat['message']?> 
					    <small class="d-block h6">
					    	<?=$chat['created_at']?>
					    </small>      	
					</p>
                    <?php } 
                     }	
    	        }else{ ?>
               <div class="alert alert-info 
    				            text-center">
				   <i class="fa fa-comments d-block fs-big"></i>
	               Sem nenhuma conversa
			   </div>
    	   	<?php } ?>
    	   </div>
    	   <div class="input-group  ">
    	   	   <textarea cols="3"
    	   	             id="message"
    	   	             class="form-control"></textarea>
         </div>
                        
         <button class="btn btn-primary "
                 id="sendBtn">
              <i class="fa fa-paper-plane" ></i>
         </button>
      </div>
                     


	
</script>
</div>
<?php
  }else{
  	header("Location: index.php");
   	exit;
  }
 ?>

   </div>
    
  

</section>
<!-- custom js file link  -->
<script src="../jquery.js"></script>
<script>
	$(document).ready(function(){
      
      // Search
       $("#searchText").on("input", function(){
       	 var searchText = $(this).val();
         if(searchText == "") return;
         $.post('../app/ajax/search.php', 
         	     {
         	     	key: searchText
         	     },
         	   function(data, status){
                  $("#chatList").html(data);
         	   });
       });

       // Search using the button
       $("#serachBtn").on("click", function(){
       	 var searchText = $("#searchText").val();
         if(searchText == "") return;
         $.post('../app/ajax/search.php', 
         	     {
         	     	key: searchText
         	     },
         	   function(data, status){
                  $("#chatList").html(data);
         	   });
       });


      /** 
      auto update last seen 
      for logged in user
      **/
      let lastSeenUpdate = function(){
      	$.get("../app/ajax/update_last_seen.php");
      }
      lastSeenUpdate();
      /** 
      auto update last seen 
      every 10 sec
      **/
      setInterval(lastSeenUpdate, 10000);

    });
    var scrollDown = function(){
        let chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
	}

	scrollDown();

	$(document).ready(function(){
      
      $("#sendBtn").on('click', function(){
      	message = $("#message").val();
      	if (message == "") return;

      	$.post("../app/ajax/insert.php",
      		   {
      		   	message: message,
      		   	to_id: <?=$chatWith['user_id']?>
      		   },
      		   function(data, status){
                  $("#message").val("");
                  $("#chatBox").append(data);
                  scrollDown();
      		   });
      });

      /** 
      auto update last seen 
      for logged in user
      **/
      let lastSeenUpdate = function(){
      	$.get("../app/ajax/update_last_seen.php");
      }
      lastSeenUpdate();
      /** 
      auto update last seen 
      every 10 sec
      **/
      setInterval(lastSeenUpdate, 10000);



      // auto refresh / reload
      let fechData = function(){
      	$.post("../app/ajax/getMessage.php", 
      		   {
      		   	id_2: <?=$chatWith['user_id']?>
      		   },
      		   function(data, status){
                  $("#chatBox").append(data);
                  if (data != "") scrollDown();
      		    });
      }

      fechData();
      /** 
      auto update last seen 
      every 0.5 sec
      **/
      setInterval(fechData, 500);
    
    });
</script>

</body>
</html>