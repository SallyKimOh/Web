"use strict"
const RADIOUS = 100;
const INCRATE = 120;
const DECRATE = 80;

let browserData = [];
let currentAngle = 0;

let min = 1000;
let max = -1;
let totDataV = 0;
var cx = 0;
var cy = 0;
var title = "";

function getJSON() {
	title = data.label;
	browserData = data.segments;
	getMinMaxTot();
	drawPieChart();
	drawBarChart();
}

function drawPieChart() {

	let vtot = 0;
	var fcanvas = document.getElementById("First2");
	cx = fcanvas.width / 2;
	cy = fcanvas.height / 2;
	var radius = RADIOUS;

	let totr = 0;
	let tota = 0;
	var context = fcanvas.getContext("2d");

	context.font = "bold 10pt Arial";
	context.textAlign = "center";
	for (let data of browserData) {

		console.trace("currentAngle: " + currentAngle);
		let ra = data.value / totDataV; //145.95260000000002;
		var endAngle = currentAngle + (ra * (Math.PI * 2)); //CALCULATE PERCENTAGE OF CIRCLE IN RADIANS
		console.trace("endAngle: " + endAngle);

		totr += ra;
		console.trace("ra: " + ra, "totr: " + totr);

		var angle = (endAngle) / (Math.PI / 180);
		//console.trace(data);
		context.moveTo(cx, cy); //move to middle of the circle
		context.beginPath();
		context.fillStyle = data.color;

		radius = data.value >= max ? (INCRATE / 100) * RADIOUS : data.value == min ? (DECRATE / 100) * RADIOUS : RADIOUS; // * data.value / 145.95260000000002;

		// once it draw max part, away from a little bit of rest of part
		if (data.value == max) {
			let tcx = cx - 5;
			let tcy = cy + 7;
			context.arc(tcx, tcy, radius, currentAngle, endAngle, false);
			context.lineTo(tcx, tcy);
			context.fill();
			context.closePath();

		} else {

			context.arc(cx, cy, radius, currentAngle, endAngle, false);
		}
		context.lineTo(cx, cy);
		context.fill();
		context.closePath();
		//UPDATE THE CURRENT ANGLE TO BE READY FOR THE NEXT SEGMENT

		//Now draw the lines that will point to the values
		context.save();
		context.translate(cx, cy); //make the middle of the circle the (0,0) point
		context.strokeStyle = "#0CF";
		context.lineWidth = 1;
		context.beginPath();
		//angle to be used for the lines
		var midAngle = (currentAngle + endAngle) / 2; //middle of two angles
		context.moveTo(0, 0); //this value is to start at the middle of the circle
		//to start further out...
		var dx = Math.cos(midAngle) * (0.8 * radius);
		var dy = Math.sin(midAngle) * (0.8 * radius);
		context.moveTo(dx, dy);
		//ending points for the lines
		var dx = Math.cos(midAngle) * (radius + 50); //30px beyond radius
		var dy = Math.sin(midAngle) * (radius + 50);

		// for adjusting min line coordinates
		if (data.value == min) {
			dx -= 5;
			dy += 10;
			context.lineTo(dx, dy);
		} else {
			context.lineTo(dx, dy);
		}

		context.stroke();

		// To point label more acurately 
		if (dy > 0) {
			dy += 10;
		}

		context.fillText(data.label, dx, dy);
		context.restore();
		//context.closePath();
		console.log("ENDAngle: " + endAngle + "X: " + dx + " " + "Y: " + dy);
		currentAngle = endAngle;
	}

	drawTitle(fcanvas,context);
}

function drawTitle(lcanvas,ctx) {
	
	ctx.fillStyle = "black";
	var toplabelx = lcanvas.width / 2;
	var toplabely = 15;
	ctx.textAlign = "center";
	ctx.beginPath()
	ctx.fillText(title, toplabelx, toplabely);
	ctx.textAlign = "start";

}

function drawBarChart() {

	var scanvas = document.getElementById("Second2");
	var context = scanvas.getContext("2d");
	//clear the canvas
	context.clearRect(0, 0, scanvas.width, scanvas.height);

	context.lineWidth = 3;
	context.font = "bold 11pt Arial";
	context.fillStyle = "#900"; //colour of the text
	context.textAlign = "center";
	//the percentage of each value will be used to determine the height of the bars.
	var graphHeight = 300; //bottom edge of the graph
	var offsetX = 10; //space away from left edge of canvas to start drawing.
	var barWidth = 30; //width of each bar in the graph
	var spaceBetweenPoints = 20; //how far apart to make each x value.
	//start at values[1].
	var x = offsetX + 20; //left edge of first rectangle

	for (let data of browserData) {
		var pct = data.value / totDataV;
		var barHeight = (graphHeight * pct);

		context.fillStyle = data.color;

		barHeight = data.value >= max ? (INCRATE / 100) * barHeight + 50 : data.value <= min ? (DECRATE / 100) * barHeight : barHeight;;

		context.rect(x, graphHeight - 1, barWidth, -1 * barHeight);
		context.stroke(); //draw lines around bars
		context.fill(); //fill colours inside the bars

		context.closePath();
		var lbl = Math.round(pct * 100).toString();
		context.beginPath();
		context.fillText(lbl, x + barWidth / 2, graphHeight - barHeight - 30 - 1);

		context.save();
		let tx = x + barWidth / 2;
		let ty = graphHeight + 10 + 1;
		context.translate(tx, ty);
		context.rotate(Math.PI / 2);
		context.textAlign = "start";
		context.fillText(data.label, 0, 0);
		context.restore();

		x = x + barWidth + spaceBetweenPoints;
		//move the x value for the next point
	}

	context.strokeStyle = "#999";
	context.lineWidth = 1;
	context.beginPath();
	context.moveTo(offsetX, scanvas.height - graphHeight);
	context.lineTo(offsetX, graphHeight);
	context.lineTo(scanvas.width - offsetX, graphHeight);
	context.stroke();
	
	drawTitle(scanvas,context);
}
document.addEventListener("DOMContentLoaded", function () {

	var s = document.createElement("script");
	s.addEventListener('load', getJSON);
	s.src = "browsers.js";
	document.body.appendChild(s);

});

function getMinMaxTot() {
	for (var i = 0, num = browserData.length; i < num; i++) {
		if (browserData[i].value < min) {
			min = browserData[i].value;
		}
		if (browserData[i].value > max) {
			max = browserData[i].value;
		}
		totDataV += browserData[i].value;
	}
	console.log("TOT :" + totDataV + " " + "MIN : " + min + " " + "MAX: " + max);

}
