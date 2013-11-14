/*$(document).ready(function(){

	$('#header > ul >li >a').click(function(){

		$('#header >ul >li >ul').hide();

		if($(this).hasClass('active')){
			$(this).removeClass('active');
		}
		else{
			$('#header >ul >li >a').removeClass('active');
			$(this).addClass('active');
			$(this).next('ul').show(200);
		}
	});
});	
*/

function clave(){
	
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for( var i=0; i < 8; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    document.form1.textbox.defaultValue = text
}