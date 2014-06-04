<?php
$site_folder = '../../';

$field_prefixo='ct_';


require_once($site_folder.'libs/OBJ_mysql.php');
require_once($site_folder.'libs/db_connection.php');
require_once($site_folder.'libs/common_session.php');
include_once($site_folder.'modules/mod_login/makeSecure.php');
require_once($site_folder.'libs/funcoes.php');
require_once($site_folder.'lang/'.$_SESSION['BG_SITE_LANG'].'/'.$_SESSION['BG_SITE_LANG'].'_msg.php');

if (!empty($_POST))
{
	 $id = $_POST[$field_prefixo.'id'];


	require $site_folder .'libs/classes/BulkFromProcess.php';
    $Common=new Common($DB);

	$PExcep=array('action','submit','button',$field_prefixo.'id', $field_prefixo.'logotipo','id'); // add exception fields

    $sql_extra="";



 	if ($_POST[$field_prefixo.'financiamento']!=1) $_POST[$field_prefixo.'financiamento']=0;



       if(!empty($_POST[$field_prefixo.'factor_valoriza'])) {

		   $comma_separated = implode(",", $_POST[$field_prefixo.'factor_valoriza']);
                   $_POST[$field_prefixo.'factor_valoriza']= $comma_separated;
        }




   if($id > 0 )
   {


	  $_update=$Common->ProcessBulkForm($_POST,"update",$PExcep, $field_prefixo, $db);

       $sqlQuery2 = "select id from ".$dbPrefixo."contas_info
	   WHERE conta_id = ".$id;
       $result2 = $db->query($sqlQuery2);
       if($result2->num_rows==0)
	   {
       $sqlQuery2 = "INSERT INTO ".$dbPrefixo."contas_info
	   (conta_id ,user_criacao ,data_criacao ,eliminado)
	   VALUES (".$id.",".$_SESSION['BG_USERID'].",'".date("Y-m-d H:i:s")."',0)";
       $result2 = $db->query($sqlQuery2);
       }



       $sqlQuery = "UPDATE ".$dbPrefixo."contas
	   INNER JOIN ".$dbPrefixo."contas_info as contas_info on contas.id=contas_info.conta_id SET
	   ".$_update.",
	   contas.data_alteracao='".date("Y-m-d H:i:s")."',
	   contas.user_alteracao=".$_SESSION['BG_USERID'].",
	   contas_info.data_alteracao='".date("Y-m-d H:i:s")."',
	   contas_info.user_alteracao=".$_SESSION['BG_USERID']."
	   WHERE contas.id = ".$id;

	   //echo $sqlQuery;
       $result = $db->query($sqlQuery);

       $input_id= " <input type=\"text\" name=\"".$field_prefixo."id\" id=\"".$field_prefixo."id\" value=\"".$id."\" hidden=\"true\" />";

	   if (!$result) {

		save_error_log($db, $db_ct,$mod,__FILE__,'','Invalid query 1 (UPDATE) '.str_replace("'",'"',$db->_error()),str_replace("'",'"',$sqlQuery));

		echo json_encode(array('status'=>'error', 'file'=>$uploadfile,
                               'msg'=> custom_Highlight_text('error','Invalid query 1 (UPDATE)', $lang_array).$input_id));
       die();
	   }
	   else
	   {
         if($_POST[$field_prefixo.'atribuido_user_id'] > 0 )
         {
	      $sqlQuery = "UPDATE ".$dbPrefixo."contactos SET
	      atribuido_user_id='".$_POST[$field_prefixo.'atribuido_user_id']."'
	      WHERE (atribuido_user_id IS NOT NULL) and (conta_id='".$_POST[$field_prefixo.'id']."')";
          $result = $db->query($sqlQuery);
		 }



     if ($_FILES) {

    	if($_FILES[$field_prefixo.'logotipo']['name']!=''){
		   $pasta='logotipos';
           $uploaddir = 'docs/'.$pasta.'/';//<----This is all I changed
           $search  = array(" ", "ã", "á","õ","ê","í");
           $replace   = array("_", "a", "a","o","e","i");

           $filename = $id.'_'.str_replace( $search, $replace, basename($_FILES[$field_prefixo.'logotipo']['name']) );
           $uploadfile = $uploaddir . $filename;
	     }
	      else $uploadfile = NULL;
        } // if ($_FILES)

		$json_encode_text =  json_encode(array('status'=>'success', 'file'=>$uploadfile,
                               'msg'=> custom_Highlight_text('success','RECORD_UPDATED', $lang_array).$input_id));

       
	   }





   } //if($_POST['id'] > 0 )
  else
   {



    $sqlQuery5 = "select id, pais from ".$dbPrefixo."contas
    WHERE UPPER(nome) LIKE UPPER('".$_POST[$field_prefixo.'nome']."')";

    if ($_POST[$field_prefixo.'pais']!=NULL) $sqlQuery5 .=" and pais='".$_POST[$field_prefixo.'pais']."'";
	//echo $sqlQuery5;
    $result = $db->query($sqlQuery5);
    if(($result->num_rows==0))
    {




	 $sqlQuery="INSERT INTO ".$dbPrefixo."contas ( nome, tipo_conta_id )  values ('" . $_POST[$field_prefixo.'nome'] . "','" . $_POST[$field_prefixo.'tipo_conta_id'] . "')" ;
     $result = $db->query($sqlQuery);
	 $id = $db->insert_id();




	   $_update=$Common->ProcessBulkForm($_POST,"update",$PExcep, $field_prefixo, $db);

       $sqlQuery2 = "select id from ".$dbPrefixo."contas_info
	   WHERE conta_id = ".$id;
       $result2 = $db->query($sqlQuery2);
       if($result2->num_rows==0)
	   {
       $sqlQuery2 = "INSERT INTO ".$dbPrefixo."contas_info
	   (conta_id ,user_criacao ,data_criacao ,eliminado)
	   VALUES (".$id.",".$_SESSION['BG_USERID'].",'".date("Y-m-d H:i:s")."',0)";
       $result2 = $db->query($sqlQuery2);
       }



       $sqlQuery = "UPDATE ".$dbPrefixo."contas
	   INNER JOIN ".$dbPrefixo."contas_info on contas.id=contas_info.conta_id SET
	   ".$_update.",
	   contas.data_criacao='".date("Y-m-d H:i:s")."',
	   contas.user_criacao=".$_SESSION['BG_USERID'].",
	   contas_info.data_criacao='".date("Y-m-d H:i:s")."',
	   contas_info.user_criacao=".$_SESSION['BG_USERID']."
	   WHERE contas.id = ".$id;

	   //echo $sqlQuery;
       $result = $db->query($sqlQuery);


	   if (!$result) {

		save_error_log($db, $db_ct,$mod,__FILE__,'','Invalid query 2 (UPDATE) '.str_replace("'",'"',$db->_error()),str_replace("'",'"',$sqlQuery));

       $input_id= " <input type=\"text\" name=\"".$field_prefixo."id\" id=\"".$field_prefixo."id\" value=\"0\" hidden=\"true\" />";

		echo json_encode(array('status'=>'error', 'file'=>$uploadfile,
                               'msg'=> custom_Highlight_text('error','Invalid query 2 (UPDATE)', $lang_array).$input_id));

		 die();
	   }
	   else
	   {

	   $sqlQuery = "UPDATE ".$dbPrefixo."contas SET
	   data_criacao='".date("Y-m-d H:i:s")."',
	   user_criacao=".$_SESSION['BG_USERID']."
	   WHERE id = $id";
       $result = $db->query($sqlQuery);

		  if ($_FILES) {
		 	if($_FILES[$field_prefixo.'logotipo']['name']!=''){
		 		   $pasta='logotipos';
		            $uploaddir = 'docs/'.$pasta.'/';//<----This is all I changed
 		           $search  = array(" ", "Ã¢", "Ã£","Ãµ","Ã©","Ã­");
 		           $replace   = array("_", "a", "a","o","e","i");

		            $filename = $id.'_'.str_replace( $search, $replace, basename($_FILES[$field_prefixo.'logotipo']['name']) );
		 	       //$uploadfile = $uploaddir . $_FILES['logotipo']['name'];
		            $uploadfile = $uploaddir . $filename;
		 	}
		 	else $uploadfile = NULL;
		  }

       $input_id= " <input type=\"text\" name=\"".$field_prefixo."id\" id=\"".$field_prefixo."id\" value=\"".$id."\" hidden=\"true\" />";
  	   $json_encode_text =  json_encode(array('status'=>'success', 'file'=>$uploadfile,
                               'msg'=> custom_Highlight_text('success','RECORD_INSERTED', $lang_array).$input_id));
        
	   }



   }// if($num_rows==0)
   else
   {
       $input_id= " <input type=\"text\" name=\"".$field_prefixo."id\" id=\"".$field_prefixo."id\" value=\"0\" hidden=\"true\" />";
		echo json_encode(array('status'=>'error','file'=>NULL,
                               'msg'=> custom_Highlight_text('error','****  Já exsiste Conta com este Nome.  ****', $lang_array).$input_id));
		die();
   }


}//if($_POST['id'] > 0 )











 if ($_FILES) {

	if($_FILES[$field_prefixo.'logotipo']['name']!=''){

    $input_id= " <input type=\"text\" name=\"".$field_prefixo."id\" id=\"".$field_prefixo."id\" value=\"".$id."\" hidden=\"true\" />";


$allowedExtensions = array("bmp","jpg","jpeg","gif","png");

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {
       // throw new Exception(sprintf('The server was unable to handle that much POST data (%s bytes) due to its current configuration', $_SERVER['CONTENT_LENGTH']));

		save_error_log($mod,__FILE__,'',sprintf('The server was unable to handle that much POST data (%s bytes) due to its current configuration', $_SERVER['CONTENT_LENGTH']),'');

		json_encode(array('status'=>'error','file'=>NULL,
                               'msg'=> custom_Highlight_text('error',sprintf('The server was unable to handle that much POST data (%s bytes) due to its current configuration', $_SERVER['CONTENT_LENGTH']), $lang_array).$input_id) );
    			   $ok=0;

		die();

	}

			   $ok=1;



		$pasta='logotipos';


           $uploaddir = '../../../docs/'.$pasta.'/';//<----This is all I changed

             if (!is_dir('../../../docs/'.$pasta)) {
               mkdir('../../../docs/'.$pasta);
             }


$search  = array(" ", "Ã¢", "Ã£","Ãµ","Ã©","Ã­");
$replace   = array("_", "a", "a","o","e","i");
           $name = array_reverse(explode('.',  $filename));
		   $ext = strtolower($name[0]);

           $filename = $id.'_'.str_replace( $search, $replace, basename($_FILES[$field_prefixo.'logotipo']['name']) );
           $filename_th = 'th_'.$filename;
           $uploadfile = $uploaddir . $filename;



        if (!in_array(end(explode(".", strtolower( $filename))),$allowedExtensions))
		{
               //echo "<p style=\" color: red;\">Invalid file type!</p><br>";

		save_error_log($mod,__FILE__,'','Invalid file type! '.$_FILES[$field_prefixo.'logotipo']['name'],$uploadfile);

		echo json_encode(array('status'=>'error', 'file'=>$uploadfile,
                               'msg'=> custom_Highlight_text('error','Invalid file type! '.$uploadfile, $lang_array).$input_id));

			   $ok=0;
		die();
         }




		 if( $ok==1){
           if (move_uploaded_file($_FILES[$field_prefixo.'logotipo']['tmp_name'], $uploadfile)) {
           //    echo "File is valid, and was successfully uploaded.\n";
                $sqlQuery = "UPDATE ".$dbPrefixo."contas SET
           	   logotipo='".$filename."'
           	   WHERE id = $id";
                $result = $db->query($sqlQuery);

	   if (!$result) {
		save_error_log($db, $db_ct,$mod,__FILE__,'','Invalid query (file upload) '.str_replace("'",'"',$db->_error()),str_replace("'",'"',$sqlQuery));
		echo json_encode(array('status'=>'error', 'file'=>$uploadfile,
                               'msg'=> custom_Highlight_text('error','Invalid query (file upload)', $lang_array).$input_id));

		die();
	   }
	   else
	   {
		 if(file_exists($uploadfile) ) {

           $name = array_reverse(explode('.',  $filename));
		   $ext = strtolower($name[0]);


		   $max_width = 150;
		   $max_height = 100;
		   list($width, $height) = getimagesize($uploadfile);
		   $ratioh = $max_height/$height;
		   $ratiow = $max_width/$width;
		   $ratio = min($ratioh, $ratiow);
		   // New dimensions
		   $width2 = intval($ratio*$width);
		   $height2 = intval($ratio*$height);


			if($ext=='png')
			{
            $im = imagecreatefrompng($uploadfile);
            $im_dest = imagecreatetruecolor ($width2, $height2);
            imagealphablending($im_dest, false);
            imagecopyresampled($im_dest, $im, 0, 0, 0, 0, $width2, $height2, $width, $height);
            imagesavealpha($im_dest, true);
            imagepng($im_dest, $uploaddir . $filename_th);
			}//png


 			if($ext=='bmp')
			{
         	require_once($site_folder.'libs/classes/php-image-magician/php_image_magician.php');

	        $magicianObj = new imageLib($uploadfile);
 	        $magicianObj -> setTransparency(false);
	        $magicianObj -> setFillColor('#cccccc');
	        $magicianObj -> resizeImage($width2, $height2);
	        $magicianObj -> saveImage( $uploaddir . $filename_th);
			}//bmp


 			if($ext=='gif')
			{
            $im = imagecreatefromgif($uploadfile);
            //$im_dest = imagecreatetruecolor ($width2, $height2);
			//$im_dest = imagecolorallocate($im_dest,255,255,255);
            //imagealphablending($im_dest, false);
            //imagecopyresampled($im_dest, $im, 0, 0, 0, 0, $width2, $height2, $width, $height);
            //imagesavealpha($im_dest, true);
            imagegif($im, $uploaddir . $filename_th);
			}//gif

 			if($ext=='jpg')
			{
			$img = imagecreatefromjpeg($uploadfile);
            $im_dest = imagecreatetruecolor ($width2, $height2);
			imagecopyresized( $im_dest, $img, 0, 0, 0, 0, $width2, $height2, $width, $height );
            imagejpeg($im_dest, $uploaddir . $filename_th);
			}//jpg

          //imagedestroy($im_dest);
		 }//if(file_exists

		//die();
	   }




            } else {
               //echo "<p style=\" color: red;\">Error in file upload!</p><br>";
		save_error_log($db, $db_ct,$mod,__FILE__,'','Error in file upload! '.$uploadfile,'');
		echo json_encode(array('status'=>'error', 'file'=>$uploadfile,
                               'msg'=> custom_Highlight_text('error','Error in file upload!', $lang_array).$input_id));

		   die();
           }

            //echo 'Here is some more debugging info:';
           //print_r($_FILES);
		 } //if( $ok==1)

	     $json_encode_text =  json_encode(array('status'=>'success', 'file'=>'docs/'.$pasta.'/'.$filename,
	     		'msg'=> custom_Highlight_text('success','RECORD_INSERTED', $lang_array).$input_id));


	     } //if($_FILES['userfile']['name']!='')


	     
 
 } //  if ($_FILES)








echo $json_encode_text;


die();
}
