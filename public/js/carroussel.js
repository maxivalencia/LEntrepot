var Caroussel;
function GenererCarrousel(){
	
	var Car_Image_Sources=new Array(
		"img/tfile_menu_pic1.jpg",
		"img/tfile_menu_pic2.jpg",
		"img/tfile_menu_pic3.jpg",
		"img/tfile_menu_pic4.jpg",
		"img/tfile_menu_pic5.jpg",
		"img/tfile_menu_pic6.jpg"
	);
	Caroussel=new Carroussel_Fondu(document.getElementById('Carousel_Menu'),Car_Image_Sources);
	Caroussel.RedimentionnerCalque(0); //Ajuste le calque à la taille maximal  de l'image la plus grande
	Caroussel.Definir_Vitesse(1000); //Vitesse de changement des photos
	Caroussel.Definir_Vitesse_Fondu(0.01); //Vitesse du fondu
}