<?php //doshas.php

ini_set("display_errors", 1);
error_reporting(15);

//iniciamos el html
$html= <<<fin
<html>
<head>
	<link href="doshas.css" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script>
	$(function() {
		$( "#fnac" ).datepicker({
			changeMonth: true,
			changeYear: true,
			firstDay: 1,
			dayNamesShort: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
			dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ]
		});
	});
	</script>

</head>
<body>
fin;


//la lista de doshas
$doshas= array("vata", "pitta", "kapha");





//recorremos las respuestas
if(isset($_REQUEST["respuestas"])){

	// $variables = array("fnac","sexo","nombre","email","tel", "acepto");
	// foreach($variables as $variable){
	// 	$campos=Array();
	// 	if(isset($_REQUEST[$variable])){
	// 		$dato = $$variable = $_REQUEST[$variable];
	// 		$campos[$variable]=$dato;
	// 	}
	// }

	// $sql="INSERT INTO doshas_visita SET ";

/*
	$sexo = $_REQUEST["sexo"];
	$fnac = $_REQUEST["fnac"];
	$nombre = $_REQUEST["nombre"];
	$email = $_REQUEST["email"];
	$tel = $_REQUEST["tel"];
	$acepto = $_REQUEST["acepto"];
*/

	$respuestas = $_REQUEST["respuestas"];

	foreach($respuestas as $dosha => $datos){
		foreach($datos as $v){
			$sql.="INSERT INTO ";
		}

		$suma = array_sum($datos);
		$html .= "Dosha <strong>".$suma."</strong>: $suma<br>";
	}

	$html .= "<a href=\"?\">formulario de doshas</a>";
	$html .= "</body></html>";
	print $html;
	exit();
}





//iniciamos el form
$html.="<form action=\"?form=true\" method=\"post\">";
$html .= <<<fin

<br>Por favor, este servicio es gratuito.<br>Estamos recopilando datos para hacer un estudio estadístico, sobre la relación entre los doshas y la numerología tántrica.<br>Para obtener datos (anónimos), necesitamos saber tu fecha de nacimiento y sexo.
<br>Fecha Nacimiento: <input type="date" id="fnac" name="fnac" value="tu fecha de nacimiento"/>
<br>Sexo: 
<br><input type="radio" id="mujer" name="sexo" value="mujer"/>  <label for="mujer">mujer</label> 
<br><input type="radio" id="hombre" name="sexo" value="hombre"/>  <label for="hombre">hombre</label> 
<br>

fin;

foreach($doshas as $d => $dosha){
	
	//leo los ficheros de texto en un array
	$preguntas[$dosha]=file($dosha.".txt");
	//$html .= "<hr>Preguntas para el dosha <strong>$dosha</strong><br>";
	$c=0;
	$html .= <<<fin
			<div id="div_$dosha" class="dosha">
			<hr><p class="titulo">Preguntas para el dosha <strong>$dosha</strong></p><br>
fin;
	foreach($preguntas[$dosha] as $pregunta){
		$c++;

		$d0=$dosha."_".$c."_0";
		$d1=$dosha."_".$c."_1";
		$d2=$dosha."_".$c."_2";
		$d3=$dosha."_".$c."_3";

		$var = "pregunta_".$dosha."_".$c;

		$html .= <<<fin
			<div id="$var" class="pregunta">
				$c - <span>$pregunta</span>
				
				<input type="hidden" name="preguntas[$dosha][$c]" value="$pregunta"/>
				<br>
				<input type="radio" id="$d0" name="respuestas[$dosha][$c]" value="0"/> <label for="$d0">0</label> /
				<input type="radio" id="$d1" name="respuestas[$dosha][$c]" value="1"/>  <label for="$d1">1</label> / 
				<input type="radio" id="$d2" name="respuestas[$dosha][$c]" value="3"/>  <label for="$d2">2</label> / 
				<input type="radio" id="$d3" name="respuestas[$dosha][$c]" value="3"/>  <label for="$d3">3</label> 
			</div>
fin;
	}
	$html .= "</div>";
}

$html .= <<<fin
<div id="cola">
Los siguientes datos son opcionales y sólo nos interesan si quieres que contactemos contigo:
<br>Nombre: <input type="text" name="nombre" value="aqui tu nombre"/>
<br><input type="checkbox" name="acepto" value="1"/> Quiero Recibir información sobre Kundalini Yoga, eventos, cursos y formaciones relacionadas.
<br>Email: <input type="email" name="email" value="email"/>
<br>Teléfono: <input type="tel" name="tel" value="tel"/>
<br><input type="submit" value="Enviar">

<br><input type="submit" value="Enviar">
</div>
</form>
</body>
</html>
fin;

print $html;
?>