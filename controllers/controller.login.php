<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Docente.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Usuario.php';
$mensaje="";
$tipo_msg="";
$usuario = new Usuario();


if($_POST['procesar'] == "Iniciar"){
	
	$login = $_POST['login'];
	$password= $_POST['password'];
	
	//$docente->setCedula($cedula);
	if($usuario->findBy("LOGIN = '$login' AND PASS = '$password'")){
		session_start();
		$_SESSION['CEDULA']=$usuario->getCedula();
		$_SESSION['NIVEL']=$usuario->getNivel();
		$_SESSION['LOGIN']=$usuario->getLogin();
		require_once '../vistas/index.php';
	}else{
		$tipo_msg="error";
		$mensaje="Errro de Autenticacion del usuario";
		require_once '../vistas/login.php';
	}
	   

}

if($_POST['procesar'] == "Setear"){
	
	if($_POST['password1'] == $_POST['password2']){
		$filas = $usuario->setDefaultPassword($_POST['password1']);
		$tipo_msg="info";
		$mensaje="Se resetearon $filas registros";		
	}else{
		$tipo_msg="error";
		$mensaje="Errro los password no coinciden";
		
	}
	require_once '../vistas/setear_password_profesores.php';
}
?>