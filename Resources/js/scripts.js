function Clave(){
	
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for( var i=0; i < 8; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    $('#code').val(text);
}