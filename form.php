


 
 
 <?
//$BG_SITE_FOLDER = $_GET['f_cl'];
$ct_url = $full_url2;
$site_folder = '../../';

require_once($site_folder.'libs/common.php');
require($site_folder.'modules/mod_login/makeSecure.php');
include_once($site_folder.'lang/'.$_SESSION['BG_SITE_LANG'].'/'.$_SESSION['BG_SITE_LANG'].'.php');
include_once($site_folder.'lang/'.$_SESSION['BG_SITE_LANG'].'/'.$_SESSION['BG_SITE_LANG'].'_fields.php');
require_once($site_folder.'libs/funcoes_users_perm.php');
require_once($site_folder.'libs/funcoes_forms.php');



//updating_fields_list($db_ct,$db,MYSQL_USERNAME,$_SESSION['BG_CLIENTE_ID']);
//creating_fields_key($db,MYSQL_USERNAME);


$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

$mod="mod_contas";
$field_prefixo='ct_';
$obj_list_prefixo='list_'.$field_prefixo.$mod;
$obj_form_prefixo='form_'.$field_prefixo.$mod;

$folder='bestgest/';

if($mode != 'view')
{
 $source = "add_contas";
}//if($mode != 'view')
else
{
 $source = "view_contas";
}










$permissoes=verificar_permissoes($db,$_SESSION['BG_USERID'],$mod);
// if($permissoes['access'] == 1) {


 if ($id!=NULL) {
    $sqlQuery = "SELECT * FROM ".$dbPrefixo."contas WHERE id=".$id;
    $Result = $db->query($sqlQuery);
    if ($Result==='false') {
       save_error_log($db,$db_ct,'Ficha Conta',$file='',$id,"Failed to run query 1: (" . $db->_error() . ") ",$sqlQuery);
	   custom_Highlight('error',"Failed to run query 1: (" . $db->lastError() . ") ", $translator);
	   die();
	} else {
      $row_ficha = $Result->fetchArray();
    }


    $sqlQuery = "SELECT * FROM ".$dbPrefixo."contas_info WHERE conta_id=".$id;
    $Result = $db->query($sqlQuery);
    if ($Result==='false') {
       save_error_log($db,$db_ct,'Ficha Conta',$file='',$id,"Failed to run query 2: (" . $db->_error() . ") ",$sqlQuery);
	   custom_Highlight('error',"Failed to run query 2: (" . $db->lastError() . ") ", $translator);
	   die();
	} else {
      $row_ficha_info = $Result->fetchArray();
      unset($row_ficha_info['id']);
     }
 }//if ($id!=NULL)
 	

$row_ficha = array_merge ($row_ficha,$row_ficha_info);


//print_r($row_ficha);
$array=create_form_field($db,$mod,$lang_array,$folder,$field_prefixo,$row_ficha,$id);
//print_r($array);
 $list = $array['fields'];
 $list_draw = $array['draw'];

?>






<div id="<? echo $field_prefixo; ?>active_form">




<form class="<? echo $field_prefixo; ?>form" id="<? echo $field_prefixo; ?>form" enctype="multipart/form-data" >




<div class="row">
          <div class="col-lg-12">
          <div class="col-lg-10 text-left">
            <div class="panel panel-default">
              <div class="panel-body" style="padding:1px;">
                
  <?php
echo '<div id="'.$field_prefixo.'form_result"><input type="text" name="'.$field_prefixo.'id" id="'.$field_prefixo.'id" value="'.$id.'" hidden="true" /> </div>';
echo '<div id="'.$field_prefixo.'form_result2" style="height:100%"></div>';
?>               
                
              </div>
            </div>            
          </div>
          
          
          <div class="col-lg-2 text-right">
            <div class="panel panel-default">
              <div class="panel-body" style="padding:1px;">
                

<?php include_once('form_menu.php'); ?>

              </div>
            </div>            
          </div>
      </div><!-- col-lg-12 -->
 </div><!-- row -->













<div class="col-lg-12" style="z-index:1000;">

       <div class="col-lg-6">
            <div class="panel panel-primary">
              <div class="panel-body">
					<?
            $count = count($list_draw['0_LEFT']);
						for ($i = 0; $i < $count; $i++) {
							echo $list_draw['0_LEFT'][$i][0];
              }
					 ?>
              </div>
            </div>
          </div>




          <div class="col-lg-6">
            <div class="panel panel-primary">
              <div class="panel-body">
					<?
            $count = count($list_draw['0_RIGHT']);
						for ($i = 0; $i < $count; $i++) {
							echo $list_draw['0_RIGHT'][$i][0];
              }
					 ?>
              </div>
            </div>
          </div>

</div>











 <div class="col-lg-12">

        <div id='<? echo $field_prefixo; ?>jqxTabs_form'>
            <ul>
                <li id="FORM_CONT_TAB_LINK" style="margin-left: 30px;"><? echo getTranslateText($db,$lang_array,"FORM_CONT", $lang); ?></li>
                <li id="HISTORICAL_TAB_LINK"><? echo getTranslateText($db,$lang_array,"HISTORICAL", $lang); ?></li>
            </ul>


            <div id="content1">
                <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a id="CONTACTS_TAB_LINK"  href="#CONTACTS_TAB" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"CONTACTS", $lang); ?></a></li>
                <li ><a id="ADDRESS_TAB_LINK"  href="#ADDRESS_TAB" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"ADDRESS", $lang); ?></a></li>
                <li ><a id="ADDRESS_INVOICE_TAB_LINK" href="#ADDRESS_INVOICE_TAB" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"ADDRESS_INVOICE", $lang); ?></a></li>
                <li ><a id="INFORMATION_TAB_LINK"  href="#INFORMATION_TAB" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"INFORMATION", $lang); ?></a></li>
                <li ><a id="SOCIAL_NETWORKS_TAB_LINK"  href="#SOCIAL_NETWORKS_TAB" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"SOCIAL_NETWORKS", $lang); ?></a></li>

              </ul>
              <div id="myTabContent" class="tab-content">

                <div class="tab-pane fade active in" id="CONTACTS_TAB">

                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?   $count = count($list_draw['CONTACTS_TAB_LEFT']);
                       for ($i = 0; $i < $count; $i++) {
                       echo $list_draw['CONTACTS_TAB_LEFT'][$i][0];
                       }   ?>
                     </div>
                    </div>
                  </div>


                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?  $count = count($list_draw['CONTACTS_TAB_RIGHT']);
                      for ($i = 0; $i < $count; $i++) {
                      echo $list_draw['CONTACTS_TAB_RIGHT'][$i][0];
                      }   ?>
                    </div>
                   </div>
                  </div>

                </div><!-- FIM CONTACTS_TAB -->


                <div class="tab-pane fade" id="ADDRESS_TAB">

                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?   $count = count($list_draw['ADDRESS_TAB_LEFT']);
                       for ($i = 0; $i < $count; $i++) {
                       echo $list_draw['ADDRESS_TAB_LEFT'][$i][0];
                       }   ?>
                     </div>
                    </div>
                  </div>


                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?  $count = count($list_draw['ADDRESS_TAB_RIGHT']);
                      for ($i = 0; $i < $count; $i++) {
                      echo $list_draw['ADDRESS_TAB_RIGHT'][$i][0];
                      }   ?>
                    </div>
                   </div>
                  </div>

                </div><!-- FIM ADDRESS_TAB -->


                <div class="tab-pane fade" id="ADDRESS_INVOICE_TAB">

                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?   $count = count($list_draw['ADDRESS_INVOICE_TAB_LEFT']);
                       for ($i = 0; $i < $count; $i++) {
                       echo $list_draw['ADDRESS_INVOICE_TAB_LEFT'][$i][0];
                       }   ?>
                     </div>
                    </div>
                  </div>


                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?  $count = count($list_draw['ADDRESS_INVOICE_TAB_RIGHT']);
                      for ($i = 0; $i < $count; $i++) {
                      echo $list_draw['ADDRESS_INVOICE_TAB_RIGHT'][$i][0];
                      }   ?>
                    </div>
                   </div>
                  </div>

                </div><!-- FIM ADDRESS_INVOICE_TAB -->


                <div class="tab-pane fade" id="INFORMATION_TAB">

                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?   $count = count($list_draw['INFORMATION_TAB_LEFT']);
                       for ($i = 0; $i < $count; $i++) {
                       echo $list_draw['INFORMATION_TAB_LEFT'][$i][0];
                       }   ?>
                     </div>
                    </div>
                  </div>


                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?  $count = count($list_draw['INFORMATION_TAB_RIGHT']);
                      for ($i = 0; $i < $count; $i++) {
                      echo $list_draw['INFORMATION_TAB_RIGHT'][$i][0];
                      }   ?>
                    </div>
                   </div>
                  </div>

                </div><!-- FIM INFORMATION_TAB -->


                <div class="tab-pane fade" id="SOCIAL_NETWORKS_TAB">

                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?   $count = count($list_draw['SOCIAL_NETWORKS_TAB_LEFT']);
                       for ($i = 0; $i < $count; $i++) {
                       echo $list_draw['SOCIAL_NETWORKS_TAB_LEFT'][$i][0];
                       }   ?>
                     </div>
                    </div>
                  </div><!-- content1 -->


                  <div class="col-lg-6">
                   <div class="panel panel-primary">
                    <div class="panel-body">
                      <?  $count = count($list_draw['SOCIAL_NETWORKS_TAB_RIGHT']);
                      for ($i = 0; $i < $count; $i++) {
                      echo $list_draw['SOCIAL_NETWORKS_TAB_RIGHT'][$i][0];
                      }   ?>
                    </div>
                   </div>
                  </div>

                </div><!-- FIM SOCIAL_NETWORKS_TAB -->



            </div><!-- myTabContent -->

          </div><!-- content1 -->








            <div id="content2">
            </div><!-- content2 -->




        </div><!-- jqxTabs_form -->





    </div> <!-- FIM overflow: hidden -->

</form>


<!-- FIM form -->







<div class="col-lg-12" style="min-height:25px">
</div> <!-- FIM col-lg-12 -->








<div class="col-lg-12">

<div id='<? echo $field_prefixo; ?>_jqxTabs_list'>
    <ul>
        <li id="<? echo $field_prefixo; ?>CONTACTS_LIST_TAB_LINK"><? echo getTranslateText($db,$lang_array,"CONTACTS", $lang); ?></li>
        <li id="<? echo $field_prefixo; ?>TASKS_LIST_TAB_LINK"><? echo getTranslateText($db,$lang_array,"TASKS", $lang); ?></li>
        <li id="<? echo $field_prefixo; ?>TRAINING_LIST_TAB_LINK"><? echo getTranslateText($db,$lang_array,"TRAINING", $lang); ?></li>
    </ul>

    <div id="<? echo $field_prefixo; ?>CONTACTS_LIST_TAB">
        <img src='img/ajax-loader.gif' />
    </div>

    <div id="<? echo $field_prefixo; ?>TASKS_LIST_TAB">
        <img src='img/ajax-loader.gif' />
    </div>

    <div id="<? echo $field_prefixo; ?>TRAINING_LIST_TAB"></div>

</div><!-- FIM _jqxTabs_list -->


</div><!-- FIM col-lg-12 -->








<div class="col-lg-12" style="min-height:25px">
</div> <!-- FIM col-lg-12 -->











<div id="<? echo $field_prefixo; ?>div_forms"></div>






<?
$count = count($list);
for ($i = 0; $i < $count; $i++) {
	echo $list[$i][0]['draw_extra'];
}
 ?>








<script type="text/javascript">

 var theme = '<? echo $theme; ?>';


// Create jqxTabs_form.
 var <? echo $field_prefixo; ?>jqxTabs_form = $('#<? echo $field_prefixo; ?>jqxTabs_form').jqxTabs({ width: '100%',  position: 'top',  collapsible: true,  selectionTracker: true, animationType: 'fade'});
 <? echo $field_prefixo; ?>jqxTabs_form.jqxTabs('collapse');
 <? echo $field_prefixo; ?>jqxTabs_form.jqxTabs('select', 0);

// Create _jqxTabs_list.
 var <? echo $field_prefixo; ?>_jqxTabs_list = $('#<? echo $field_prefixo; ?>_jqxTabs_list').jqxTabs({ width: '100%',  position: 'top',  collapsible: true,  selectionTracker: true, animationType: 'fade'});
 <? echo $field_prefixo; ?>_jqxTabs_list.jqxTabs('collapse');
 <? echo $field_prefixo; ?>_jqxTabs_list.jqxTabs('select', 0);


$('.text-input').addClass('jqx-input');
$('.text-input').addClass('jqx-rc-all');







 <? echo $field_prefixo; ?>ver_datas_new_up();







//******************************************************************
//******************************************************************
// TABS list.


<? if((verificar_acesso_client_mod($db_ct,$_SESSION['BG_CLIENTE_ID'],'mod_contas') == 1)
  and (verificar_acesso_mod($db,$_SESSION['BG_USERID'],'mod_contas')==1)) { ?>

  $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB_LINK").click(function () {
   var CONTACTS_LIST_TAB = $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB");
   
   
   if (CONTACTS_LIST_TAB.is(':empty')){  
    $.post( 'bestgest/modules/mod_formadores2/index.php')
    .done(function( data ) {
      CONTACTS_LIST_TAB.html(data);
      initGrid();
    })
    .fail(function() {
     var msg = "Sorry but there was an error: ";
     alert( msg + xhr.status + " " + xhr.statusText );
      $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
     });
   }//empty
  return false;
  });

<? } else { ?>
  //  $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB_LINK").hide();
  //  $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB").hide();
  $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB_LINK").remove();
  $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB").remove();
<? } ?>







<? if((verificar_acesso_client_mod($db_ct,$_SESSION['BG_CLIENTE_ID'],'mod_contas') == 1)
  and (verificar_acesso_mod($db,$_SESSION['BG_USERID'],'mod_contas')==1)) { ?>

  $("#<? echo $field_prefixo; ?>TRAINING_LIST_TAB_LINK").click(function () {
    var id_val = $("input#<? echo $field_prefixo; ?>id").val();
    var TRAINING_LIST_TAB = $("#<? echo $field_prefixo; ?>TRAINING_LIST_TAB");

  if (TRAINING_LIST_TAB.is(':empty')){

    $.post( 'bestgest/modules/mod_contas2/lista.php?sub=1&m_or=<? echo $mod; ?>&m_or_id='+id_val)
    .done(function( data ) {
      TRAINING_LIST_TAB.html(data);
      //initGrid();
    })
    .fail(function() {
     var msg = "Sorry but there was an error: ";
     alert( msg + xhr.status + " " + xhr.statusText );
      $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
     });
  }//empty
  return false;
  });

<? } else { ?>
  //  $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB_LINK").hide();
  //  $("#<? echo $field_prefixo; ?>CONTACTS_LIST_TAB").hide();
  $("#<? echo $field_prefixo; ?>TRAINING_LIST_TAB_LINK").remove();
  $("#<? echo $field_prefixo; ?>TRAINING_LIST_TAB").remove();
<? } ?>




//******************************************************************
//******************************************************************






<?
for ($i = 0; $i < $count; $i++) {
	echo $list[$i][0]['java'];
}


for ($i = 0; $i < $count; $i++) {
	echo $list[$i][0]['java_extra'];
}



for ($i = 0; $i < $count; $i++) {
	echo $list[$i][0]['java_iniciar_form'];
}


?>




$('#<? echo $field_prefixo; ?>form').jqxValidator({

rules: [
<?
for ($i = 0; $i < $count; $i++) {
	echo $list[$i][0]['rules'];
}
 ?>
]

});// form Validator









 $(document).ready(function () {
 var theme = '<? echo $theme; ?>';
 		setTimeout(function(){

<?
for ($i = 0; $i < $count; $i++) {
	echo $list[$i][0]['java_iniciar_form2'];
}
?>

$('.jqx-widget').on('change', function (event)
{
  $('#<? echo $field_prefixo; ?>form').addClass('unsavedForm');
});

		}, 500);
//alert(1);
   console.log( "form loaded" );
});












function <? echo $field_prefixo; ?>ver_datas_new_up() {
 var id = $("input#<? echo $field_prefixo; ?>id").val();
 var dataString = 'id='+ id+ '&table=contas';

Pace.ignore(function(){

        $.ajax({
        type: "GET",
		cache:true,
		async:true,
        url: "bestgest/modules/data_new_up.php",
        data: dataString,
        success:
            function(response) {
			//$('#form').find('.form_result').hide();
			$('#<? echo $field_prefixo; ?>form_result2').html(response).show();
			 }

        });

 });//Pace


var id_val = $("input#<? echo $field_prefixo; ?>id").val();

if(id_val == '')
{
  $('#<? echo $field_prefixo; ?>Delete_form').hide();
  $('#<? echo $field_prefixo; ?>Delete_BD_form').hide();
  $('#<? echo $field_prefixo; ?>Print_form').hide();
}
else
{
  $('#<? echo $field_prefixo; ?>Delete_form').show();
  $('#<? echo $field_prefixo; ?>Delete_BD_form').show();
  $('#<? echo $field_prefixo; ?>Print_form').show();
}


    return false;
};








//***********************************************************
//***********************************************************

function iniciar_form_<? echo $obj_form_prefixo; ?>(){
// initialize the input fields.
<?
for ($i = 0; $i < $count; $i++) {
//	echo $list[$i][0]['java'];
}


for ($i = 0; $i < $count; $i++) {
//	echo $list[$i][0]['java_iniciar_form2'];
}
?>

 return false;
};










</script>



</div> <!-- FIM active_form-->

<? unset($list); ?>





 
 
 
