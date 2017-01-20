<?php
    header("Content-type: text/css; charset: UTF-8");
	require_once "../tweeGetallen.php";
?>
body {
	margin: 0;
	font-family: Dyslexie;
	background-color: #F44333;
	color: white;
}

h1 {
	font-size: 5em;
}

#startpaginaform input {
	padding: 10px;
    background-color: white;
    border-style: hidden;
}
#startpaginaform label {
	padding: 10px;
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
	flex-direction: row;
}
.text-center{
	text-align: center;
}
.div-center {
	align-items: center;
    justify-content: center;
	margin: auto;
}
#startpagina, #groepen, #operators{	
	display: inline-flex;
	flex-flow: column nowrap;
	margin: 0;
	width: 100%;
	height: 100%;

}
#groepen, #operators, #opdrachten {
	display: none;
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
	margin: 20px;
    font-family: Dyslexie;
    color: white;
    background-color: black;
    font-size: 4em;
    width: 250px;
    height: 250px;
    border-radius: 50px;
}
}