<?php
    header("Content-type: text/css; charset: UTF-8");
	require_once "../ajax.php";
?>

@media only screen and (min-width:368px){
	h1 {
		font-size:4em;margin:0px;
	}
	label {
		padding:7px;
	}
	.backwards {
		margin: -15px !important;
		font-size: 1.5em !important;
	}
	#restart {
		width: 361px !important;
		font-size: 2em !important;
		height: 75px !important;;
	}
	#results {
		width: 230px !important;
		font-size: 2em !important;
		height: 75px !important;
	}
	#submit {
		cursor:pointer;
	}
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
	#opdrachtenSelectie button {
		margin:20px;
		font-size:2em;
		width:75px;
		height:75px;
		border-radius:20px;
	}

}

@media only screen and (min-width:910px){
	h1 {
		font-size:4em;
	}
	label {
		padding:9px;
	}
	button {
		transition: all .2s ease-in-out;
	}
	button:hover {
		transform:scale(1.1);
	}
	#groepen button, #operators button {
		margin:20px;
		font-size:4em;
		width:250px;
		height:250px;
	}
	.backwards {
		margin: 20px !important;
		font-size: 2em !important;
	}
	#opdrachtenSelectie button {
		margin:20px;
		font-size:3em;
		width:125px;
		height:125px;
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

table {
	background-color: black;
    color: white;
    border: 1px;
    border-radius: 50px;
    padding: 25px;
    margin: auto;
}

.flex-direction-row {
	display: flex;
	flex-flow: row wrap;
}
.flex-direction-column {
	display: flex;
	flex-flow: row wrap;
}
.flex-justify-space-between {
	display: flex;
	justify-content: space-between;
}
.flex-justify-space-around {
	display: flex;
	justify-content: space-around;
}
.flex-justify-center{
	display: flex;
	justify-content: center
}
.flex-align-center {
	align-items: center;	
}

.text-center{
	text-align: center;
}
.div-center {
	margin: auto;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-small {
	width: 35% !important;
	text-align:center;
}

.modal-medium {
	width: 500px !important;
    text-align: center;
    border: 1px;
    border-radius: 22px;
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
	color: black;
}

#yesOrno {
	width: 200px !important;
	height: 175px !important;
	border-radius: 35px !important;
}

#resultatenKnop {
	width: 450px !important;
    font-size: 4em;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover, .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

#startpagina, #groepen, #operators, #opdrachtenSelectie, #opdrachten, #uitslag{
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
	margin-bottom: 10px;
}

.backwards{
	font-family: Dyslexie;
    color: white;
    background-color: black;
    border-radius: 50px;
    width: 190px !important;
    height: 75px !important;
	border-radius: 15px !important;
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
	font-family: Dyslexie;
	color: white;
	background-color:black;
}

