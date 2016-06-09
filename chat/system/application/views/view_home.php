<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo MAINSITE_URL;?>css/main.css" />
    <link rel="stylesheet" href="<?php echo MAINSITE_URL;?>css/divbelow.css" />
    <link rel="stylesheet" href="<?php echo MAINSITE_URL;?>css/chatlayout.css" />
    <script type="text/javascript" src="<?php echo MAINSITE_URL;?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo MAINSITE_URL;?>js/chat.js"></script>
</head>
<body>

<div id="buddies" class="buddies" valign="bottom">
    <div class="headerchat">&nbsp;Online Buddies</div>
<div id="onlinebuddies" class="chat">
</div>
</div>

<div id="chatroom" class="messages" valign="bottom">
<div id="chatmessage" class="chat">
</div>
<br />
<div align="center">
<form id="chatform" name="chatform">
<input type="text" maxlength="75" class="formchattext" name="message" id="message" />
</form>
</div>
</div>


 <div id="site-bottom-bar" class="fixed-position">
 <div id="site-bottom-bar-frame">
 <div id="site-bottom-bar-content">

 <a id="menu-root" href="#">Open Chat</a><div id="newmessage" class="newmessage"></div>

 </div>
 </div>
 </div>

 <div id="site-body-container">
 <div id="site-body-content">

     <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <div align="center">
        <form id="loginform" name="loginform">
            <div class="logincontainer">
                <div align="center">
                    <b>Shutterbox Facebook Chat</b>
                </div>
                <div align="center">
                    You are currently logged in. <a href="<?php echo MAINSITE_URL;?>index.php/logout">Logout</a>
                </div>
            </div>
        </form>
    </div>
 </div>
 </div>
</body>
</html>