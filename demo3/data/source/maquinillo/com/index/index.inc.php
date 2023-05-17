<?php
if($_GET['sc'] == 'sm')
	$frontTableWidth = 'style="width: 330px"';
?>
<table border="0" align="left" cellpadding="0" cellspacing="8" class="fronttable" <? echo $frontTableWidth; ?> >
<tr>
<td colspan="2">
<script type="text/javascript">
var uri = 'http://impes.tradedoubler.com/imp?type(img)g(18177632)a(2106134)' + new String (Math.random()).substring (2, 11);
document.write('<a href="http://clk.tradedoubler.com/click?p=17460&a=2106134&g=18177632" target="_BLANK"><img src="'+uri+'" border=0></a>');
</script>
</td>
</tr>
  <tr> 
    <td width="320" align="left" valign="top"> 

 


      
    <br />
<?php
// Genera el número aleatorio para mostrar promo del índice
srand((double) microtime() * 10000000);
$value = round(rand(1,8));
//include (ROOT_INC.'/index/promo_index_'.$value.'.htm');
// Si a la paz (11 de Marzo)
// <a href="http://boulesis.com/boule/nota/114_0_1_0_C/"><img src="/media/promos/pazsi_promo_index.gif" width="320" height="132" border="1" alt="Boulesis.com contra el terrorismo" /></a>
// Olimpiada

// Promo fija
//include (ROOT_INC.'/index/promo_index_9.htm');
?>

 
      <table border="0" cellspacing="0" cellpadding="0" > 

 			<tr>
   		 <td width="320" align="left" valign="top">
			<?php include (ROOT_INC.'/index/promo_index_'.$value.'.htm'); ?>
  			<!--<a href="http://nuevobachillerato.org"><img src="/media/promos/promo-nuevo-bachillerato.jpg" width="320" height="320" alt="Manifiesta para un nuevo Bachillerato" title="Manifiesta para un nuevo Bachillerato" border="0" /></a>-->
  		  </td>
  		</tr>
   	 </table>


	  <br />
	    <table>
  			<tr>
   			 <td width="320" height="72" align="center" valign="top" bgcolor="#E5F3F8" class="frontbox1" > 
      			<a href="/ayuda/que_es_boulesis.php"><img src="/media/promos/promo_boulesis_1.gif" width="230" height="72" border="0" alt="¿Qué es boulesis? ¿Qué significa esta palabra? ¿Qué pretendemos con esta web?" style="margin: 10px 0;"></a> 
   			</td>
  			</tr>
 	 </table><br />
	     
	 <table align="center">
  			<tr>
   			 <td width="100%" height="81" align="center" valign="top" bgcolor="#FFFFFF" class="frontbox"> 
      			<a href="/didactica/comunidad/"><img src="/media/promos/promo_comunidad.gif" width="300" height="81" border="0" alt="Comunidad Online de boulesis.com para los interesados en aprender" style="margin: 1px 0;"></a> 
   			</td>
  			</tr>
 	 </table><br />
 	 
 	     <!-- Promocion del premio CNICE -->
   <table border="0" cellspacing="0" cellpadding="0" > 
 			<tr>
    <td width="320" align="left" valign="top">
  	<a href="/boule/boulesiscom-premiada-por-educacion/"><img src="/media/promos/promo_premio_ministerio.gif" width="320" height="58" alt="Boulesis.com ha sido premiada por el CNICE del Ministerio de Educación y Ciencia de España. Click para ampliar" border="0" /></a>
    </td>
  	</tr>
    </table><br />
	 
<?php
// Columna secundaria para pantallas pequeñas
if($_GET['sc'] == 'sm'){
	//echo '</tr><tr>';
	include('index-second.inc.php');
	//echo '</tr></tr>';
	}
?>		 

	  <table width="100%" border="0" cellspacing="3" cellpadding="0" class="frontbox2">
        <tr> 
          <td class="frontsection">web de temporada</td>
        </tr>
        <tr> 
          <td><a href="http://www.filosofia.net/materiales/portada.htm"><img src="/media/promos/front_spotweb.png" width="320" height="50" border="1" alt="Web seleccionada por una temporada"></a></td>
       
	    </tr>
		  <tr> 
          <td><a href="http://www.filosofia.net/materiales/portada.htm">Cuaderno de materiales</a> &middot; Página de la Facultad de Filosofía de la Universidad Complutense, con diversos materiales y recursos. Cuentan con un <a href="http://www.filosofia.net/materiales/manifiesto.html">manifiesto en defensa de la educación pública y la enseñanza de la filosofía</a>. 
		</td></tr>		  
		  <tr>
		  	<td class="frontlink"><a href="/didactica/enlaces">Más enlaces</a></td>
		  </tr>
		  <!-- <tr>
    <td width="320" height="72" align="center" valign="middle" bgcolor="#E5F3F8" class="frontbox1" > 
      <a href="/boule/dialbit/"><img src="/media/dialbit/dialbit_logo_2.gif" width="200" height="70" border="0" alt="DialBit : Propuesta de diálogo en la red" style="margin: 10px 0;"></a> 
    </td>
  </tr> -->
      </table>
	  <br />


<br />
	<table align="center">
  			<tr>
   			 <td width="100%" height="50" align="center" valign="top" bgcolor="#E5F3F8" class="frontbox1"> 
      			<a href="/ayuda/rss/"><img src="/media/promos/promo_rss.gif" width="262" height="50" border="0" alt="RSS de boulesis.com Sindica nuestros contenidos. ¿Qué es RSS' ¿Qué significa?" style="margin: 3px 0;"></a> 
   			</td>
  			</tr>
 	</table>
    </td>

<?php
// Columna secundaria
if(!$_GET['sc']){
	$secondColWidth = '250';
	echo '<td rowspan="4" valign="top" class="frontlastbox" style="width: '.$secondColWidth.'px" >	'."\n";
	include('index-second.inc.php');
	echo '</td>'."\n";
	}
?>	

  </tr>
</table>

