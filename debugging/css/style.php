<?php
    header("Content-type: text/css; charset: UTF-8");
	require_once "../tweeGetallen.php";
?>

@media only screen and (min-width:368px){
	h1 {font-size:4em;margin:0px;}
	label {padding:7px;}
	#submit {cursor:pointer;}
	#groepen button, #operators button {
		margin:6px;
		font-size:2em;
		width:500px;
		height:125px;
	}
	#startpagina button {
		border-radius:5px;
		border-style:hidden;
		margin:5px;
		background-color:white;
		padding:8px;
	}
	
}

@media only screen and (min-width:768px){
	h1 {font-size:4em;}
	label {padding:9px;}
	#groepen button, #operators button {
		margin:20px;
		font-size:4em;
		width:250px;
		height:250px;
	}
	button{transition: all .2s ease-in-out;}
	button:hover {
		transform:scale(1.1);
	}
}


@media only screen and (min-width:1024px){
	h1 {font-size:5em;}
	label {padding:10px;}
}
body {
	margin: 0;
	font-family: Dyslexie;
	background-color: #F44333;
	color: white;
}

button {
	cursor: pointer;
}

:focus {
	outline: none;
}

input {
	padding: 10px;
    background-color: white;
    border-style: hidden;
}

@font-face {
	font-family: "Dyslexie";
	src: url("../fonts/Dyslexie Regular LP199232.ttf");
}

.flex-direction-row {
	display: flex;
	flex-direction: row;
}
.flex-direction-column {
	display: flex;
	flex-direction: column;
}
.text-center{
	text-align: center;
}
.div-center {
	align-items: center;
    justify-content: center;
	margin: auto;
}
.div-center-justify{
	justify-content: center
}
#startpagina, #groepen, #operators, #opdrachtenSelectie, #opdrachten{	
	display: none;
	justify-content: center;
	flex-flow: column nowrap;
	margin: 0;
	width: 100%;
	height: 100%;
}
#startpagina form {
	align-items: center;
    justify-content: center;
    margin: auto;
}
#buttons {
	display: flex;
    flex-direction: column;
}
#startpagina button {
	width: 140px;
	align-self: flex-end;
	margin-right: 25px;

}
#startpagina button:last-child {
	margin-bottom: 25px;
}
#groepen button, #operators button {
    font-family: Dyslexie;
    color: white;
    background-color: black;
    border-radius: 50px;
}
#opdrachtenSelectie button {
	width: 50px;
	height: 50px;
}
