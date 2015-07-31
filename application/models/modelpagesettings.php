<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelPageSettings extends CI_Model {
    
      function __construct()
        {
        // Call the Model constructor
        parent::__construct();
        }
    
    //untuk mengambil halaman login 
	function loginPage(){
        $data = array(
                'signup_msg'=>'Silahkan mendaftar agar Anda bisa terhubung',
                'page' => 'vw_login.php',
                'body_class' => '');   
        return $data;            
	} 
        
    function infoPage(){
        $data = array(
                'page' => 'vw_information.php',
                'body_class' => ''); 
        return $data;
    }
    
    function mywallPage(){
        $data = array(
                'page'          => 'vw_mywall.php',
                'body_class'    => 'beranda',
                'leftmenu'      => 'menu/incl_leftmenu.php'
                );
        return $data;      
    }
    
    function profilePage(){
        $data = array(
                'page'          => 'vw_content.php',
                'body_class'    => 'beranda',
                'content'       => 'include/incl_profile.php',
                'leftmenu'      => 'menu/incl_leftmenu.php'
                );
        return $data;      
    }
    /*-----------------------------ALBUM------------------------------*/
    function albumPage(){
        $data = array(
                'page'          => 'vw_content.php',
                'body_class'    => 'beranda',
                'content'       => 'include/incl_albums.php',
                'leftmenu'      => 'menu/incl_leftmenu.php',
                'main_url'      => 'photo/show'
                );
        return $data;      
    }
    
    /*-----------------------------ALBUM------------------------------*/
    
    /*-----------------------------CONTENT---------------------------*/
    function photoPage(){
        $data = array(
                'page'          => 'vw_content.php',
                'body_class'    => 'beranda',
                'content'       => 'include/incl_showcase.php',
                'showcase'      => 'incl_showcase_photo.php'
                );
        return $data;      
    }
    
    function ebookPage(){
        $data = array(
                'page'          => 'vw_content.php',
                'body_class'    => 'beranda',
                'content'       => 'include/incl_showcase.php',
                'showcase'      => 'incl_showcase_ebook.php'
                );
        return $data;      
    }
    
     
    function notePage(){
        $data = array(
                'page'          => 'vw_content.php',
                'body_class'    => 'beranda',
                'content'       => 'include/incl_showcase.php',
                'showcase'      => 'incl_showcase_note.php'
                );
        return $data;      
    }
    /*-----------------------------CONTENT---------------------------*/
    
    
    function worldPage(){
        $data = array(
                'page'          => 'vw_content.php',
                'content'       => 'incl_world.php',
                'body_class'    => 'beranda');
        return $data;      
    }
    
    function messagePage(){
        $data = array(
                'page'          => 'vw_content.php',
                'content'       => 'include/incl_message.php',
                'body_class'    => 'beranda');
        return $data;      
    }
    
}
