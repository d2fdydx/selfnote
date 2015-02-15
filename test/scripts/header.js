var headbgc="#EAEAEA";
var headfgColor="#C4F05B";

function createheader(){
	var headcanvas = document.getElementById("headcanvas");
	var headcontext=headcanvas.getContext("2d");
	
	//fillBackgroundColor(headcanvas,headcontext);
	
	for (var i =0; i <5; i++){
		drawCircle(headcanvas,headcontext);
		
	
	}

drawText(headcanvas,headcontext);
}

function fillBackgroundColor(canvas, context) {
	//var header=document.getElementById("myheader");
	//header.style.backgroundColor=headbgc;

	context.fillStyle = headbgc;
	context.fillRect(0, 0, canvas.width, canvas.height);

}

function drawCircle(canvas, context) {
	var radius = Math.floor(Math.random() * 20);
	var x = Math.floor(Math.random() * canvas.width);
	var y = Math.floor(Math.random() * canvas.height);

	context.beginPath();
	context.arc(x, y, radius, 0, degreesToRadians(360), true);

	// Use this fillStyle instead if you want to try
	// "twitter blue"
	context.fillStyle = "rgb(0, 173, 239)";
	//context.fillStyle = "lightblue";
	context.fill();
}

function degreesToRadians(degrees) {
    return (degrees * Math.PI)/180;
}


function drawIcon(canvas, context){
	
	
	
}

function drawText(canvas, context) {
	var user ="";
	

	context.fillStyle = headfgColor;
	context.font = "bold 1.5em sans-serif";
	context.textAlign = "left";
	context.fillText("Welcome, " + user , 20, 40);


	
}

$(document).ready(function(){
	
	createheader();
})