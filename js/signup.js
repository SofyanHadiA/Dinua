//************ Validation Input *************************//
//************ By : Fr377 - Created 12/12/2011***********//
//*******************************************************//
$(document).ready(function () {    
   
	// if user clicked on button, the overlay layer or the dialogbox, close the dialog
	 $('a.button-close, .popup-overlay').click(function () {		
	 		$('#signup-overlay, #signup-box, #rememberpass-overlay , #rememberpass-box ').hide();	
             f_tcalCancel();	
	 		return false;
	 	});
	
	// if user resize the window, call the same function again
	// to make sure the overlay fills the screen and dialogbox aligned to center	
	$(window).resize(function () {
		
		//only do it if the dialog box is not hidden
		if (!$('#signup-box').is(':hidden')) popup();		
	});	
	
    var form = $("#customForm");
	var name = $("#signupName");
	var nameInfo = $("#nameInfo");
	var email = $("#signupEmail");
	var emailInfo = $("#emailInfo");
	var pass1 = $("#pass1");
	var pass1Info = $("#pass1Info");
	var pass2 = $("#pass2");
	var pass2Info = $("#pass2Info");
	var birthDay = $("#birthDay");
	
    var signupButton =$("#signupButton");
    
    var validation=new Array();
    for (var i=0;i<=5;i++)
    {
        validation[i]=false;
    }
    
	//On blur
	name.blur(validateName);
	email.blur(validateEmail);
	pass1.blur(validatePass1);
	pass2.blur(validatePass2);
    birthDay.blur(validateBirthDay);
	//On key press
	name.keyup(validateName);
	pass1.keyup(validatePass1);
	pass2.keyup(validatePass2);
    birthDay.keyup(validateBirthDay);
    
    
    //Hide button submit on default    
    signupButton.hide();
	

    
	//validation functions
	function validateEmail(){
		//testing regular expression
		var a = $("#signupEmail").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			email.removeClass("error");
            email.attr("title", "Email anda");
			emailInfo.text("Email");
			emailInfo.removeClass("cl_orange");   
            
            validation[1]=true;
            show_submit()     
			return true;
		}
		//if it's NOT valid
		else{
			email.addClass("error");
            email.attr("title", "Email anda belum valid");
			emailInfo.text("Email Belum Valid");     
			emailInfo.addClass("cl_orange");
            
            validation[1]=false;
            show_submit()
			return false;
		}
	}
	function validateName(){
		//if it's NOT valid
		if(name.val().length < 4){
			name.addClass("error");
            name.attr("title","Nama anda belum valid");
			nameInfo.text("Belum Valid");
			nameInfo.addClass("cl_orange");
            
            validation[2]=false;
            show_submit()
			return false;
		}
		//if it's valid
		else{
			name.removeClass("error");
            name.attr("title","Nama Lengkap");
            nameInfo.text("Nama Lengkap");
			nameInfo.removeClass("cl_orange");
            show_submit();
			
            validation[2]=true;
            show_submit()
            return true;
		}
	}
	function validatePass1(){
		//it's NOT valid
		if(pass1.val().length <8){
			pass1.addClass("error");
            pass1.attr("title","Minimal 8 Karakter");
			pass1Info.text("Minimal 8 Karakter");
			pass1Info.addClass("cl_orange");
			
            validation[3]=false;
            show_submit()
            return false;
		}
		//it's valid
		else{			
			pass1.removeClass("error");
            pass1.attr("title","Kata Sandi");
			pass1Info.text("Kata Sandi");
			pass1Info.removeClass("cl_orange");
			validatePass2();
			
            validation[3]=true;
            show_submit()
            return true;
		}
	}
	function validatePass2(){
		//are NOT valid
		if( pass1.val() != pass2.val() ){
			pass2.addClass("error");
            pass2.attr("title","Kata Sandi Beda");
			pass2Info.text("Kata Sandi Beda");
			pass2Info.addClass("cl_orange");
			
            validation[4]=false;
            show_submit()
            return false;
		}
		//are valid
		else{
			pass2.removeClass("error");
            pass2.attr("title","Ulang Kata Sandi");
			pass2Info.text("Ulang Kata Sandi");
			pass2Info.removeClass("cl_orange");
			
            validation[4]=true;
            show_submit()
            return true;
		}
	}
    
     function validateBirthDay(){
        if( birthDay.val().length<10){
            birthDay.addClass("error");
            birthDay.attr("title","Tanggal Lahir Anda Belum Valid");
            validation[5]=false; 
            show_submit()
        }
        else{
            birthDay.removeClass("error");
            birthDay.attr("title","Tanggal Lahir Anda");
            validation[5]=true;
            show_submit() 
        }
     }
    
    //enable submit
    function show_submit(){
        if(validation[1] && validation[2] && validation[3] && validation[4] && validation[5] ){
		  signupButton.show();	return true;}
		else{
		  signupButton.hide();	return false;}
    }

});

//Popup dialog
function popup($param) {
    switch ($param){ 
	case 'rememberpass' : 
        $overlay =  '#rememberpass-overlay';
        $box =  '#rememberpass-box';
	break;
	case 'signup': 
        $overlay =  '#signup-overlay';
        $box =  '#signup-box';
	break;
    }
    
    // get the screen height and width  
	var maskHeight = $(document).height();  
	var maskWidth = $(window).width();
	
	// calculate the values for center alignment
	var dialogTop =  ((maskHeight/2)+150) - ($('.popup-box').height());  
	var dialogLeft = (maskWidth/2) - ($('.popup-box').width()/2); 
	
	// assign values to the overlay and dialog box
	$('.popup-overlay').css({height:maskHeight, width:maskWidth});
    $($overlay).show();
	$('.popup-box').css({top:dialogTop, left:dialogLeft});
    $($box).show();
			
};
