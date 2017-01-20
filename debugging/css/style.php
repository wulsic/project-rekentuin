<?php
    header("Content-type: text/css; charset: UTF-8");
	require_once "../tweeGetallen.php";
?>
body {
	margin: 0;
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
	margin: auto;
}
#startpagina, #groepen{	
	display: inline-flex;
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
#groepen button {
	width: 250px;
	height: 250px;
}