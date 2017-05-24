/**
 * Created by Daniel on 24/05/2017.
 */
$(function ()
{
  $('#urlForm').submit(function (event)
  {
    event.preventDefault();
    var longUrlField = $('#longUrl');
    var errorText = $('#errorText');
    var longUrl = longUrlField.val();
    var url = '/shorten?url=' + longUrl;

    $.ajax({
      method: "GET",
      url: url
    }).done(function( msg ) {
      $('#js-ajax-update').append('' +
          '<tr>' +
            '<td><a href="'+longUrl+'">'+longUrl+'</a></td>' +
            '<td><a href="'+msg+'">'+msg+'</a></td>' +
          '</tr>');
      longUrlField.val('');
      errorText.html('');
    }).fail(function (msg) {
      console.log( "Something went wrong: " + JSON.stringify(msg));
      errorText.html(msg.responseText);
    });
  });
});