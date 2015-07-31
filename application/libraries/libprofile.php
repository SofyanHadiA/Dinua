<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// Library ini digunakan untuk mengambil data profil
class LibProfile {
    public function getProfile($id, $field=null, $isdisabled=null){ // method ini digunakan untuk mengambil profil 1 akun
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
            $where      =array( 'id'=>$id, 'disabled'=>$isdisabled);
            $table      ='accounts';
            $profile    =$CI->ModelCRUDD->get($table, $field, $where);
            
        if(!empty($profile)){
            $data = $profile[0];
            $id_encrypt=$id;
            $id_encrypt=$CI->encrypt->encode($id_encrypt);
            $id_encrypt=urlencode($id_encrypt);
            $data['id_encrypt']=$id_encrypt;
            if(!empty($data['birthday'])){
                $data['birthday_epoch'] = $data['birthday'];
                //Mengambil tanggal lahir saja, waktunya di hilangkan
                $birthday= standard_date('DATE_IND_NOTIME', $data['birthday']);
                $birthday = en2in_date($birthday);
                $data['birthday']=$birthday;
            }
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }
    
    function switchType($data, $type){
        $CI =& get_instance();
                switch ($type){ 
                	case 'realname':  
                        $explode = explode(' ',$data);
                        
                        $data = array();
                        
                        $return['data']='<tr>'.
                            '<td>Nama Pertama :</td>'.
                            '<td>Nama Tengah :</td>'.
                            '<td>Nama Akhir :</td>'.
                        '</tr>'.
                        '<tr>';
                        
                        if(empty($explode[0])){$explode[0]='';}
                        if(empty($explode[1])){$explode[1]='';}
                        if(empty($explode[2])){$explode[2]='';}
                        $return['data'].=''.
                            '<td><input id="firstname" type="text" value="'.$explode[0].'" /></td>'.
                            '<td><input id="middlename" type="text" value="'.$explode[1].'" /></td>'.
                            '<td><input id="lastname" type="text" value="'.$explode[2].'" /></td>'.
                        '</tr>';
                        $return['input'] = array('firstname', 'middlename', 'lastname');
                    break;
                    
                    case 'email' :
                        /*$return['data']='<tr>'.
                            '<td>email :</td>'.
                            '<td>Konfirmasi email :</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td><input id="email1" type="text" value="'.$data.'" /></td>'.
                            '<td><input id="email2" type="text" value="" /></td>'.
                        '</tr>';
                        
                        $return['input'] = array('email1', 'email2');*/
                        $return['data'] = 'Saat ini email belum bisa diubah';
                    break;
                    
                    case 'password' :
                        $return['data']='<tr>'.
                            '<td>Password :</td>'.
                            '<td>Konfirmasi  Password :</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td><input id="pass1" type="password" value="" /></td>'.
                            '<td><input id="pass2" type="password" value="" /></td>'.
                        '</tr>';
                        $return['input'] = array('pass1', 'pass2');
                    break;
                    
                    case 'birthday' :
                        
                        $return['data']='<tr>'.
                            '<td><input id="birthday" class="datepicker" type="text" value="00-00-0000" /></td>'.
                        '</tr>'.
                        '<script type="text/javascript"> $( ".datepicker" ).datepicker({'.
			                 'changeMonth: true,'.
			                 'changeYear: true,'.
                             'yearRange : "c-60",'.
                             'dateFormat: "dd-mm-yy",'.
                             'maxDate: "-13y"'.
                        '});</script>';
                        
                        $return['input']=array('birthday');
                    break;
                    
                    case 'gender' :
                        if($data == 'M'){
                            $selected1 = 'selected';
                            $selected2 = '';
                        }else{
                            $selected2 = 'selected';
                            $selected1 = '';}
                        $return['data']='<tr>'.
                            '<td><select id="gender" size="1">'.
                            '<option value="M" '.$selected1.'>Laki-Laki</option>'.
                            '<option value="F" '.$selected2.'>Perempuan</option>'.
                            '</select></td>'.
                        '</tr>';
                        
                        $return['input']=array('gender');
                    break;
                    
                    case 'address' :
                        $return['data']='<tr>'.
                            '<td><textarea id="address" style="max-width :450px; max-height:50px;">'.$data.'</textarea></td>'.
                        '</tr>';
                        
                        $return['input']=array('address');
                    break;
                    
                    case 'city' :
                        $return['data']='<tr>'.
                            '<td><input id="city" type="text" value="'.$data.'"/></td>'.
                        '</tr>';
                        $return['input']=array('city');
                    break;
                    
                    case 'country' :
                        $CI->load->model('ModelCRUDD');
                        $country = $CI->ModelCRUDD->get('lookup'); 
                        $return['data']='<tr><td><select id="country" size="1">';
                        $option='';
                        foreach ($country as $rows){
                            if($rows['code']=='IDN'){
                                $selected='selected';
                            }else{$selected='';}
                            $option = $option.'<option value="'.$rows['value'].'" '.$selected.'>'.$rows['value'].'</option>';
                        }
                        $return['data']=$return['data'].$option.'</select></td></tr>';
                        
                        $return['input']= array('country');
                    break;
                    
                    case 'occupation' :
                        $return['data']='<tr>'.
                            '<td><input id="occupation" type="text" value="'.$data.'"/></td>'.
                        '</tr>';
                        $return['input']=array("occupation");
                    break;
                    
                    case 'work_at' :
                        $return['data']='<tr>'.
                            '<td><input id="work_at" type="text" value="'.$data.'"/></td>'.
                        '</tr>';
                        $return['input']=array("work_at");
                    break;
                    
                    case 'about_me' :
                        $return['data']='<tr>'.
                            '<td><textarea id="about_me" style="max-width :450px; max-height:50px;">'.$data.'</textarea></td>'.
                        '</tr>';
                        $return['input']=array('about_me');
                    break;
                } 
                return $return;                
    }
}
