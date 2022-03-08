<?php //doshas.php

ini_set("display_errors", 1);
error_reporting(15);

USE experimentos;
CREATE TABLE doshas (
	id_dosha int not null auto_increment primary key,
	nombre varchar(50) not null unique key,
	descripcion text null
);

CREATE TABLE doshas_tests(
	id_test int not null auto_increment primary key,
	nombre varchar(50) not null unique key,
	descripcion text null
);

CREATE TABLE doshas_test_preguntas(
	id_test_pregunta int not null auto_increment primary key,
	id_test int not null,
	texto varchar (255) not null,
	notas text null
);

CREATE TABLE doshas_participantes(
	id_participante int null,
	nombre varchar(90) null,
	email varchar(90) null,
	referer int null default '0',
	texto varchar (255) not null,
	notas text null
);


CREATE TABLE doshas_respuestas(
	id int not null auto_increment primary key,
	id_participante int null,
	id_test int not null,
	id_pregunta int not null,
	valor int not null default '0',
	texto varchar (255) not null,
	notas text null
);

INSERT INTO `experimentos`.`doshas` (`id_dosha`, `nombre`, `descripcion`) VALUES 

(NULL, 'Kapha', 'Kapha es el dosha del elefante, es lento, fuerte, tranquilo, pero poderoso.
Digestión lenta, puede comer mucho, pero puede aguantar mucho tiempo sin comer sin que le afecte.'), 

(NULL, 'Vata', 'Vata es elegante, le gusta la belleza, la armonía, la perfección en el encaje con el entorno, es activo, nervioso, flaco, con curvas. Necesita que todo esté bien.');



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
	$respuestas = $_REQUEST["sexo"];
	$respuestas = $_REQUEST["respuestas"];
	$sql="";
	foreach($respuestas as $dosha => $datos){
		//print_r($datos);
		foreach($datos as $n => $v){
			$sql.="INSERT INTO doshas ";
		}

		$suma = array_sum($datos);
		$mediana = getMedian($datos);
		$media = avr($datos);
		$html .= "Dosha <strong> $dosha: ".$suma."</strong>: $suma<br>";
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