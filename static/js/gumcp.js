function open_ajax_dialog(dialogTitle, ajaxUrl)
{
$.get(ajaxUrl, function(data) {
open_dialog(dialogTitle, data);
})
}
function open_dialog(dialogTitle, dialogContent)
{
var html = '<div id="dialog" class="modal fade" role="dialog">';
html += '<div class="modal-dialog">';
html += '<div class="modal-content">';
html += '<div class="modal-header">';
html += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
html += '<h4 class="modal-title">'+dialogTitle+'</h4>';
html += '</div>';
html += '<div class="modal-body">';
html += dialogContent;
html += '</div>';
html += '<div class="modal-footer">';
html += '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
html += '</div>';
html += '</div>';
html += '</div>';
html += '</div>';
$('#dialog-placeholder').html(html);
$('#dialog').modal('show');
}
function getUrlVars() 
{
var vars = {};
var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
function(m,key,value) {
vars[key] = value;
});
return vars;
}