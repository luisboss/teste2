<?
//$site_folder = $_GET['f_cl'];
$site_folder = '../../';
$ct_url = '';
require_once($site_folder.'libs/common.php');
include_once($site_folder.'modules/mod_login/makeSecure.php');
include_once($site_folder.'lang/'.$_SESSION['BG_SITE_LANG'].'/'.$_SESSION['BG_SITE_LANG'].'.php');
include_once($site_folder.'lang/'.$_SESSION['BG_SITE_LANG'].'/'.$_SESSION['BG_SITE_LANG'].'_msg.php');
include_once($site_folder.'lang/'.$_SESSION['BG_SITE_LANG'].'/'.$_SESSION['BG_SITE_LANG'].'_fields.php');


$menu = $_GET['m'];
$sub = $_request['sub'];
$filter = $_GET['filter'];


$mod="mod_contas";
$field_prefixo='ct_';
$obj_list_prefixo='list_'.$field_prefixo.$mod;
$obj_form_prefixo='form_'.$field_prefixo.$mod;
//require_once($site_folder.'includes/calc_path.php');




include_once($site_folder.'includes/panel_power_by.php');




//echo '--- '.$sub;

//echo 'BG_USERID - '.$_SESSION['BG_USERID'].'<br>';
//echo '1- '.$_SESSION['FILTER_1'].'<br>';
//echo '2- '.$_SESSION['FILTER_2'].'<br>';
//echo '3- '.$_SESSION['FILTER_3'].'<br>';

$permissoes=verificar_permissoes($db,$_SESSION['BG_USERID'],$mod);


if($permissoes['access'] == 1) {



$filter_mobile='';
if($_SESSION['BG_MOBILE']==1) $filter_mobile='and (mf.list_mobile_hidden=0) ';

$dbc = "SELECT  mf.datafield, mf.name,mf.list_real_name, mf.list_type, mf.list_hidden,
mf.list_mobile_hidden, mf.list_width, mf.cellclass,
mf.list_exportable, mf.list_filterable, mf.list_sortable,
mf.list_menu, mf.list_filtertype, mf.list_columntype,
mf.list_editable, mf.list_cellsformat, mf.list_aggregates
FROM ".$dbPrefixo."bg_ct_modules_field_list as mf".
" where mf.module='".$mod."' ".
" and ((mf.list_type IS NOT NULL) or (mf.list_type<>'')) ".$filter_mobile." Order by mf.tab_order";
$result = $db->query($dbc);

if (!$result) {echo "Failed to run query: (" . $db->_error() . ") ";
} else {

  if ($result->num_rows > 0) {

    foreach( $result->fetchAll() as $row ){

		  $fields[]=$row->datafield;

     if ($row->list_exportable==1) { $exportable='exportable:true, '; }
     else { $exportable='exportable:false, '; }

     if ($row->list_filterable==1) {
	      $filterable='filterable:true, ';
         if (($row->list_filtertype!='') and ($row->list_filtertype!=NULL)) { $filtertype="filtertype:'".$row->filtertype."', "; }
          else { $filtertype=''; }
	 }
     else { $filterable='filterable:false, '; }

     if ($row->list_sortable==1) { $sortable='sortable:true, '; }
     else { $sortable='sortable:false, '; }

     if ($row->list_menu==1) { $menu='menu:true, '; }
     else { $menu='menu:false, '; }

     if ($row->list_editable==1) { $editable='editable:true, '; }
     else { $editable='editable:false, '; }


     if (($row->list_aggregates!='') and ($row->list_aggregates!=NULL)) { $aggregates="aggregates:['".$row->list_aggregates."'], "; }
      else { $aggregates=''; }

     if (($row->list_columntype!='') and ($row->list_columntype!=NULL)) { $columntype="columntype:'".$row->list_columntype."', "; }
      else { $columntype=''; }




     if ($row->list_hidden==1) { $hidden='true'; $checked='false'; }
     else { $hidden='false'; $checked='true'; }

      if ($ismobile==1) {
        if ($row->list_mobile_hidden==1) { $hidden='true'; $checked='false'; }
        else { $hidden='false'; $checked='true'; }
      }

     if ($row->cellclass==1) { $cellclass='cellclassname: '.$row->datafield.'_cellclass,'; }
     else { $cellclass=''; }


      //if (($row->textValue!='') and ($row->textValue!=NULL)) { $label=$row->textValue; }
      //else { $label=$row->datafield; }

      $label=getTranslateText($db,$lang_array['field'],$row->name, $lang);

$list_fields_datasource[]="{ name: '".$row->datafield."', type: '".$row->list_type."'}, \n";
$list_fields_grid[]="{ text: '".$label."', datafield: '".$row->datafield."', hidden: ".$hidden.", ".$exportable.$filterable.$filtertype.$sortable.$menu.$editable.$columntype.$aggregates.$cellclass." width: '".$row->list_width."' }, \n";
$list_fields_colunas[]="{ label: '".$label."', value: '".$row->datafield."', checked: ".$checked." }, \n";


        }//foreach
     } //$result->num_rows
} //if (!$result)

$result->free;
?>




<div id="jqxWidget">

 <div id="grid_<? echo $obj_list_prefixo; ?>">


<div class="row">
          <div class="col-lg-12">
          <div class="col-lg-10 text-left">
            <div class="panel panel-default" style="margin-bottom: 3px;">
              <div class="panel-body" style="padding:10px;">
                
          <div class="col-lg-4 text-left">
             <h3 class="panel-title"><i class="fa fa-table"></i> <? echo $m_titulo; ?>ssssssssss</h3>
          </div><!-- col-lg-4 -->
          
          <div class="col-lg-6 text-center">
             <div id="log_<? echo $obj_list_prefixo; ?>" ></div>
          </div><!-- col-lg-6 -->   
          
                    
              </div>
            </div>            
          </div>
          
          
          
          <div class="col-lg-2 text-right">
            <div class="panel panel-default" style="margin-bottom: 3px;">
              <div class="panel-body" style="padding:1px;">          


<?php include_once('lista_menu.php'); ?>
              
              
              </div>
            </div>            
          </div>
      </div><!-- col-lg-12 -->
 </div><!-- row -->



           
              
       
          
          
            
            
            
<div class="panel-body" >


<?
//echo 'user '.$_SESSION['BG_USERID'].'<br>';
//print_r($permissoes);
?>

<script type="text/javascript">
  var  grid_<? echo $obj_list_prefixo; ?> = null;
  var  log_<? echo $obj_list_prefixo; ?> = null;
  var  div_form_<? echo $obj_list_prefixo; ?> = null;
  var  jqxgrid_<? echo $obj_list_prefixo; ?> = null;


   $(document).ready(function () {
     // prepare the data
        var theme = '<? echo $theme; ?>';

		grid_<? echo $obj_list_prefixo; ?> = $('#grid_<? echo $obj_list_prefixo; ?>');
    log_<? echo $obj_list_prefixo; ?> = $("#log_<? echo $obj_list_prefixo; ?>");
    div_form_<? echo $obj_list_prefixo; ?> = $('#div_form_<? echo $obj_list_prefixo; ?>');
		jqxgrid_<? echo $obj_list_prefixo; ?> = $("#jqxgrid_<? echo $obj_list_prefixo; ?>");




		    var source_<? echo $obj_list_prefixo; ?> =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},


					<?
                        $count = count($list_fields_datasource);
                        for ($i = 0; $i < $count; $i++) {
                        	echo $list_fields_datasource[$i];
                        }
					 ?>

                ],
				id: 'id',
				url: 'bestgest/modules/<? echo $mod; ?>/data.php?t=data&filter=<? echo $filter; ?>',
				cache: false,
				async: false,
				root: 'Rows',
        pager: function (pagenum, pagesize, oldpagenum) {
             //alert(pagesize);
                    // callback called when a page or page size is changed.
                },
				filter: function()
				{
					// update the grid and send a request to the server.
					jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{
					// update the grid and send a request to the server.
					jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('updatebounddata', 'sort');
				},
                deleterow: function (rowid, commit) {

					//alert(rowid);
                    commit(true);
                },
                updaterow: function (rowid, newdata, commit) {
                    commit(true);
                },
				beforeprocessing: function(data)
				{
					if (data != null)
					{
						//alert(data[1].TotalRows);
						source_<? echo $obj_list_prefixo; ?>.totalrecords = data[1].TotalRows;
					}

				}
        };





/*
var cellclass = function (row, columnfield, value) {
                if (value < 20) {
                    return 'red';
                }
                else if (value >= 20 && value < 50) {
                    return 'yellow';
                }
                else return 'green';
            }
*/




<?
$dbc = "SELECT  mf.datafield, mf.sub_table_name, mf.sub_value_field, mf.sub_text_field
FROM ".$dbPrefixo."bg_ct_modules_field_list as mf".
" where mf.module='".$mod."' ".
" and ((mf.list_type IS NOT NULL) or (mf.list_type <> '')) ".
" and (mf.cellclass = 1) ".
" Order by mf.tab_order";
$result = $db->query($dbc);

if (!$result) {echo "Failed to run query: (" . $db->_error() . ") ";
} else {

  if ($result->num_rows > 0) {


    foreach( $result->fetchAll() as $row ){

	 echo "\n var ".$row->datafield."_cellclass = function (row, columnfield, value) { ";

		 $dbc = "SELECT  aux.".$row->sub_text_field.", cr.descricao as cor FROM ".$dbPrefixo.$row->sub_table_name." as aux
		 left join ".$dbSufixo."lt_cores as cr on aux.cor_bg=cr.id
		 where ((aux.cor_bg IS NOT NULL) or (aux.cor_bg > 0))";
		 $result2 = $db->query($dbc);
//echo $dbc;

		 	 if (!$result2) {echo "Failed to run query: (" . $db->_error() . ") ";
		 	 } else {
		 	  if ($result2->num_rows > 0) {
		         foreach( $result2->fetchAll() as $row2 ){
		 	       echo ' if (value == "'.$row2->descricao.'") {';
		 	       echo "return '".$row2->cor."';";
		 	       echo '} else ';
		         }//foreach
		      } //$result2->num_rows
		    } //if (!$result2)

	  echo " return 'default'; ";
	  echo " } ";

        }//foreach


     } //$result->num_rows
} //if (!$result)

?>











		    var dataadapter_<? echo $obj_list_prefixo; ?> = new $.jqx.dataAdapter(source_<? echo $obj_list_prefixo; ?>, {
				loadComplete: function (records) {
                },
					loadError: function(xhr, status, error)
					{
						alert('erro: '+ error);
					}
				}
			);


            var jqxgrid_<? echo $obj_list_prefixo; ?> = $("#jqxgrid_<? echo $obj_list_prefixo; ?>").jqxGrid(
            {
                source: dataadapter_<? echo $obj_list_prefixo; ?>,
                theme: theme,
			    altrows: true,
				filterable: true,
				showaggregates: true,
				showstatusbar: true,
                statusbarheight: 25,
				sortable: true,
				autoheight: true,
				//autoloadstate: true,
        //autosavestate: true,
				width: '98%',
				pageable: true,
				virtualmode: true,
                pagermode: 'default',
				selectionmode: 'checkbox',
				editmode: 'dblclick',
				editable: true,
			    autoshowfiltericon: true,
				pagesizeoptions: ['5','10', '20', '30', '50', '100', '200', '500', '1000'],
				localization: getLocalization(),
				rendergridrows: function(obj)
				{
					 return obj.data;
				},
				columnsresize: true,
                columnsreorder: true,
				groupable: true,
			    columns: [

	 				   { text: '.....', datafield: 'Editar', columntype: 'button',sortable: false, filterable: false, groupable: false,hideable: false, menu : false, exportable : false, enabletooltips : false, width: '50', cellsrenderer: function () {
                     return "Editar";
                  },buttonclick: function (row) {
                     // open the popup window when the user clicks a button.

                     editrow = row;
                     var offset = jqxgrid_<? echo $obj_list_prefixo; ?>.offset();
                     var dataRecord = jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('getrowdata', editrow);

					 //grid_<? echo $obj_list_prefixo; ?>.hide('fast');
                    div_form_<? echo $obj_list_prefixo; ?>.html('');
                     if(dataRecord.id > 0) {
				             	$.post( 'bestgest/modules/<? echo $mod; ?>/form.php?id='+dataRecord.id)
					             .done(function( data ) {
					                 div_form_<? echo $obj_list_prefixo; ?>.html(data);
						         			grid_<? echo $obj_list_prefixo; ?>.hide('fast').delay(200);

				            	})
 				         	 .fail(function() {
					            var msg = "Sorry but there was an error: ";
					            //alert( msg + xhr.status + " " + xhr.statusText );
 					           $( "#log_<? echo $obj_list_prefixo; ?>" ).html( msg + xhr.status + " " + xhr.statusText );
				           	});
        }//dataRecord.id > 0

                 }
				}    ,{ text: 'ID', datafield: 'id', hidden: true,  width: '5%' },

					<?
                        $count = count($list_fields_grid);
                        for ($i = 0; $i < $count; $i++) {
                        	echo $list_fields_grid[$i];
                        }
					 ?>



                  ]//, groups: ['Tipo']
            });









//LISTA DE COLUNAS
    var colunas_<? echo $obj_list_prefixo; ?>_Source = [
	   { label: 'ID', value: 'id', checked: false },
					<?
                        $count = count($list_fields_colunas);
                        for ($i = 0; $i < $count; $i++) {
                        	echo $list_fields_colunas[$i];
                        }
					 ?>

	   ];
 var colunas_<? echo $obj_list_prefixo; ?>_listbox =$("#colunas_<? echo $obj_list_prefixo; ?>_listbox").jqxListBox({ source: colunas_<? echo $obj_list_prefixo; ?>_Source, width: 250, height: 150,  checkboxes: true });

            colunas_<? echo $obj_list_prefixo; ?>_listbox.on('checkChange', function (event) {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('beginupdate');
                if (event.args.checked) {
                    jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('showcolumn', event.args.value);
                }
                else {
                    jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('hidecolumn', event.args.value);
                }
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('endupdate');

				return false;
            });







//GROUP

            var expandall_<? echo $obj_list_prefixo; ?> = $("#expandall_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
            var collapseall_<? echo $obj_list_prefixo; ?> = $("#collapseall_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
            // expand all groups.
            expandall_<? echo $obj_list_prefixo; ?>.on('click', function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('expandallgroups');
				return false;
            });
            // collapse all groups.
            collapseall_<? echo $obj_list_prefixo; ?>.on('click', function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('collapseallgroups');
				return false;
            });






//Export

           var printExport_<? echo $obj_list_prefixo; ?> =  $("#printExport_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
           var excelExport_<? echo $obj_list_prefixo; ?> =  $("#excelExport_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
           var xmlExport_<? echo $obj_list_prefixo; ?> =  $("#xmlExport_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
           var csvExport_<? echo $obj_list_prefixo; ?> =  $("#csvExport_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
           var tsvExport_<? echo $obj_list_prefixo; ?> =  $("#tsvExport_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
           var htmlExport_<? echo $obj_list_prefixo; ?> =  $("#htmlExport_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });

            var url_Export_<? echo $obj_list_prefixo; ?> = "bestgest/modules/<? echo $mod; ?>/save-file.php";

            excelExport_<? echo $obj_list_prefixo; ?>.click(function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('exportdata', 'xls', '<? echo $obj_list_prefixo; ?>', true, null, false, url_Export_<? echo $obj_list_prefixo; ?>);              return false;
            });
            xmlExport_<? echo $obj_list_prefixo; ?>.click(function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('exportdata', 'xml', '<? echo $obj_list_prefixo; ?>', true, null, false, url_Export_<? echo $obj_list_prefixo; ?>);              return false;
            });
            csvExport_<? echo $obj_list_prefixo; ?>.click(function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('exportdata', 'csv', '<? echo $obj_list_prefixo; ?>', true, null, false, url_Export_<? echo $obj_list_prefixo; ?>);              return false;
            });
            tsvExport_<? echo $obj_list_prefixo; ?>.click(function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('exportdata', 'tsv', '<? echo $obj_list_prefixo; ?>', true, null, false, url_Export_<? echo $obj_list_prefixo; ?>);              return false;
            });
            htmlExport_<? echo $obj_list_prefixo; ?>.click(function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('exportdata', 'html', '<? echo $obj_list_prefixo; ?>', true, null, false, url_Export_<? echo $obj_list_prefixo; ?>);              return false;
            });



            printExport_<? echo $obj_list_prefixo; ?>.click(function () {
                var gridContent = jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('exportdata', 'html');
                var newWindow = window.open('', '', 'width=400, height=300'),
                document = newWindow.document.open(),
                pageContent =
                    '<!DOCTYPE html>\n' +
                    '<html>\n' +
                    '<head>\n' +
                    '<meta charset="utf-8" />\n' +
                    '<title>jQWidgets Grid</title>\n' +
                    '</head>\n' +
                    '<body>\n' + gridContent + '\n</body>\n</html>';
                document.write(pageContent);
                document.close();
                newWindow.print();
				return false;
            });




//Outros

            var clearfilteringbutton_<? echo $obj_list_prefixo; ?> = $('#clearfilteringbutton_<? echo $obj_list_prefixo; ?>').jqxButton({ theme: theme, height: 25});
            clearfilteringbutton_<? echo $obj_list_prefixo; ?>.click(function () {
                jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('clearfilters');
				return false;
            });

            var clearsortingbutton_<? echo $obj_list_prefixo; ?> = $('#clearsortingbutton_<? echo $obj_list_prefixo; ?>').jqxButton({ theme: theme, height: 25});
            clearsortingbutton_<? echo $obj_list_prefixo; ?>.click(function () {
               jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('removesort');
			   return false;
            });


            var refresh_<? echo $obj_list_prefixo; ?> = $("#refresh_<? echo $obj_list_prefixo; ?>").jqxButton({ theme: theme });
	        refresh_<? echo $obj_list_prefixo; ?>.click(function () {
             jqxgrid_<? echo $obj_list_prefixo; ?>.jqxGrid('updatebounddata');
			 return false;
	        });





});
    </script>







  <div id="jqxgrid_<? echo $obj_list_prefixo; ?>"></div>




  <div style="margin-top: 10px;" id="eventlog_<? echo $obj_list_prefixo; ?>"></div>




        <div class="row">
          <div class="col-lg-12">


            <div class="Tab_<? echo $obj_list_prefixo; ?>">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
               <li class="active"><a href="#options_<? echo $obj_list_prefixo; ?>" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"OPTIONS", $lang); ?></a></li>
                <li><a href="#colunas_<? echo $obj_list_prefixo; ?>" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"COLUMNS", $lang); ?></a></li>
                <li ><a href="#group_<? echo $obj_list_prefixo; ?>" data-toggle="tab"><? echo getTranslateText($db,$lang_array,"GROUPS", $lang); ?></a></li>
<?
if($permissoes['export'] == 1)
{
echo '<li><a href="#export_'.$obj_list_prefixo.'" data-toggle="tab">'.getTranslateText($db,$lang_array,"EXPORT", $lang).'</a></li>';
}
?>

              </ul>


              <div id="myTabContent_<? echo $obj_list_prefixo; ?>" class="tab-content">



                 <div class="tab-pane fade active in" id="options_<? echo $obj_list_prefixo; ?>">
                   <div style="margin-top: 10px;">

                 <button type="button" id='clearfilteringbutton_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-filter"></i>  <? echo getTranslateText($db,$lang_array,"REMOVE_FILTERS", $lang); ?></button>
                   
                 <button type="button" id='clearsortingbutton_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-sort-amount-desc"></i>  <? echo getTranslateText($db,$lang_array,"REMOVE_SORTING", $lang); ?></button>
                 
                 <button type="button" id='refresh_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-refresh"></i>  <? echo getTranslateText($db,$lang_array,"REFRESH", $lang); ?></button>
                 
                   
                   </div> <!-- /.margin-top -->

              </div><!-- /.options_<? echo $obj_list_prefixo; ?> -->



          <div class="tab-pane fade" id="colunas_<? echo $obj_list_prefixo; ?>">
            <div style="margin-top: 30px;">
             <div style="float: left;" id="colunas_<? echo $obj_list_prefixo; ?>_listbox"></div>
           </div>
          </div><!-- /.options_<? echo $obj_list_prefixo; ?> -->






         <div class="tab-pane fade" id="group_<? echo $obj_list_prefixo; ?>">
          <div style="margin-top: 10px;">
                 <button type="button" id='expandall_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-minus-square"></i>  <? echo getTranslateText($db,$lang_array,"EXPAND_ALL", $lang); ?></button>
                
                 <button type="button" id='collapseall_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-plus-square"></i>  <? echo getTranslateText($db,$lang_array,"COLLAPSE_ALL", $lang); ?></button>
                <br />
         </div> <!-- /margin-top -->
       </div> <!-- /.export_<? echo $obj_list_prefixo; ?> -->




<?
if($permissoes['export'] == 1)
{
?>
        <div class="tab-pane fade" id="export_<? echo $obj_list_prefixo; ?>">
          <div style="margin-top: 20px;">
            <div style="float: left;">
                 <button type="button" id='excelExport_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-file-excel-o"></i>  <? echo getTranslateText($db,$lang_array,"Excel", $lang); ?></button>

                 <button type="button" id='xmlExport_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-file-excel-o"></i>  <? echo getTranslateText($db,$lang_array,"XML", $lang); ?></button>

            </div>
            <div style="margin-left: 10px; float: left;">
                 <button type="button" id='csvExport_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-list"></i>  <? echo getTranslateText($db,$lang_array,"CSV", $lang); ?></button>

                 <button type="button" id='tsvExport_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-list"></i>  <? echo getTranslateText($db,$lang_array,"TSV", $lang); ?></button>
            
            </div>
            <div style="margin-left: 10px; float: left;">
 
                  <button type="button" id='htmlExport_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-file-code-o"></i>  <? echo getTranslateText($db,$lang_array,"HTML", $lang); ?></button>

                 <button type="button" id='printExport_<? echo $obj_list_prefixo; ?>' class="btn btn-default"><i class="fa fa-print"></i>  <? echo getTranslateText($db,$lang_array,"PRINT", $lang); ?></button>
 

            </div>


         </div> <!-- /margin-top -->
       </div> <!-- /.export -->

<? } ?>



              </div> <!-- /.myTabContent -->

        </div> <!-- /.bs-example -->



    </div> <!-- /.col-lg-12 -->
  </div> <!-- /.row -->





     </div> <!-- /.panel-body -->
    </div> <!-- /.panel-primary -->

    </div> <!-- /.col-lg-12 -->
  </div> <!-- /.row -->







      </div> <!-- /.grid_<? echo $obj_list_prefixo; ?> -->


    <div id="div_form_<? echo $obj_list_prefixo; ?>"></div>














</div><!-- /.jqxWidget -->

</div>


<?php  } else { ?>
          <div class="alert alert-dismissable alert-danger">
               <strong><? echo getTranslateText($db,$lang_array,"NO_PERMISSIONS", $lang); ?></strong>
           </div>
<? } ?>






     <? if(file_exists('mod_footer_mini.php')) include_once('mod_footer_mini.php'); ?>  
     
     
     
       
