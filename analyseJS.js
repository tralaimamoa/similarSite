var clicEnCours = false;
	var position_x = 0;
	var position_y = 0;
	var origineDiv_x = 0;
	var iExplorer = false;
	var deplacable = "";
	if (document.all){
	  iExplorer = true;
	} 
	
	function ouvrirFermerSpoiler() {		
        var divContenu = document.getElementById('box');
        if(divContenu.style.display == 'none') {
            divContenu.style.display = 'block';
        } else {
            divContenu.style.display = 'none';
        }
    }
	function voirChargement(){
		var loader = document.getElementById('loader');
		loader.style.display = 'block';
	}
	function zoom(image){
		image.style.position = "absolute";
		image.style.width = '150px';
		image.style.height = '150px';
	}
	function deZoomer(image){
		image.style.position = "initial";
		image.style.width = '100%';
		image.style.height = '25px';		
	}