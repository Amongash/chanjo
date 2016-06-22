/*
 * task.js
 *
 * jquery functions used for task
 */
var base_url = window.location.protocol + "//" + window.location.host + "/";
var timestamp = new Date().getTime();

var refreshTask
/*
 * start refreshing the div task
 *
 */
function startrefreshtask()
{
    refreshTask = setInterval(function()
    {
        //hack for pesky IE session handling ;)
        
        $('#tasks').load(base_url +'tasks/index/'+ timestamp);
    }, 5000);
}






/*
 * refresh every second
 */
var newtask = setInterval(function()
{
    $('#tasks').load(base_url +'tasks/index/'+ timestamp);
}, 2000);

var newcount= setInterval(function()
{
    $('#task-count').load(base_url +'tasks/get_count/'+ timestamp);
}, 2000);

var newtodo= setInterval(function()
{
    $('#pending').load(base_url +'tasks/to_do/'+ timestamp);
}, 2000);


$(document).ready(function() {
    //event trigger
    $("#task-root").click(function(){
        $.ajax({
            type: "GET",
            url: base_url +'tasks/index/'+ timestamp,
            success: function(msg) {
                $('tasks').html(msg);
            }
        });

    });
});