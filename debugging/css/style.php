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

input {
	padding: 10px;
    background-color: white;
    border-style: hidden;
}
label {
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
	display: inline-flex;
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
	margin: 20px;
    font-family: Dyslexie;
    color: white;
    background-color: black;
    font-size: 4em;
    width: 250px;
    height: 250px;
    border-radius: 50px;
}
#opdrachtenSelectie button {
	width: 50px;
	height: 50px;
}
