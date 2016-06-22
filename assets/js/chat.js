/*
 * chat.js
 *
 * jquery functions used for chatting
 */
var base_url = window.location.protocol + "//" + window.location.host + "/";

$(function(){
    $('#chatmessage').slimScroll({
        height: '250px'
    });
});

var refreshChat
/*
 * start refreshing the div chat
 *
 */
function startrefresh()
{
    refreshChat = setInterval(function()
    {
        //hack for pesky IE session handling ;)
        var timestamp = new Date().getTime();
        $('#chatmessage').load(base_url +'chat/index/'+ timestamp);
    }, 2000);
}
/*
 * stop refreshing the div chatbox
 * 
 */
function stoprefresh()
{
    clearInterval(refreshChat);
}

/*
 * refresh chat page/retrieve message every second
 */
var newChat = setInterval(function()
{
    //hack for pesky IE session handling ;)
    var timestamp = new Date().getTime();
    $('#newmessage').load(base_url +'chat/get_new_messages/'+ timestamp);
}, 2000);

var newBuddies = setInterval(function()
{
    //hack for pesky IE session handling ;)
    var timestamp = new Date().getTime();
    $('#onlinebuddies').load(base_url +'contacts/index/'+ timestamp);
}, 10000);

jQuery(function( $ ){
var menuRoot = $( "#menu-root" );
var chatroom = $( "#chatroom" );
var buddies = $( "#buddies" );

// Hook up menu root click event.
menuRoot
.attr( "href", "javascript:void( 0 )" )
.click(
function(){
    chatroom.hide();
    // Toggle the menu display.
    buddies.toggle();
    $('#chatmessage').html('');
    //stop refreshing the chat window
    stoprefresh();

    var timestamp=new Date().getTime();
    $('#onlinebuddies').load(base_url +'contacts/index/'+ timestamp);
    // Blur the link to remove focus.
    menuRoot.blur();

    // Cancel event (and its bubbling).
    return( false );
});

// Hook up a click handler on the document so that
// we can hide the menu if it is not the target of
// the mouse click.
$( document ).click(
    function( event ){
        // Check to see if this came from the menu.
        if (buddies.is( ":visible" ) && !$( event.target ).closest( "#buddies" ).size()){
            // The click came outside the menu, so
            // close the menu.
            buddies.hide();
        }
    });
});
$(document).ready(function() {
    //event trigger for sending a message
    $("form#chatform").submit(function(){
        $.post(base_url +"chat/sendmessage",{
        message: $("#message").val()
        });
        $("#message").val("");
        return false;
    });
	$("#menu-root").click(function(){
		$.post(base_url +"chat/close_buddy");
	});
});