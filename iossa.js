var iosSA;
if (!iosSA) {
	iosSA = jQuery(document).ready( function() {
		function fullscreen() {
			var a = document.getElementsByTagName("a");
			for (var i=0; i<a.length; i++) {
					if (!a[i].hasAttribute("href")) {
						console.log(a[i]);
					}
				if (a[i].className.match("noeffect") || (a[i].hasAttribute("href") && a[i].getAttribute("href").substring(0, 11) == "javascript:")) {
				} else {
					a[i].onclick = function() {
							window.location = this.getAttribute("href");
							return false;
						};
				}
			}
		}

		iosSA.startX = 0;
		iosSA.startY = 0;
		iosSA.fingerCount = 0;
		iosSA.curX = 0;
		iosSA.curY = 0;
		iosSA.swipe = 0;

		iosSA.touchStart = function (event) {
			// disable the standard ability to select the touched object
//			event.preventDefault();
			// get the total number of fingers touching the screen
			iosSA.fingerCount = event.touches.length;
			// since we are looking for a swipe (single finger) and not a gesture (multiple fingers),
			// check that only one finger was used
			if ( iosSA.fingerCount == 1 ) {
				// get the coordinates of the touch
				iosSA.startX = event.touches[0].pageX;
				iosSA.startY = event.touches[0].pageY;
			} else {
				// more than one finger touched so cancel
				iosSA.touchCancel(event);
			}
		};

		iosSA.touchEnd = function (event) {
//			event.preventDefault();
			// check to see if more than one finger was used and that there is an ending coordinate
			if (iosSA.fingerCount == 1 && iosSA.curX !== 0) {
				var xD = iosSA.curX - iosSA.startX;
				var absY = Math.abs(iosSA.curY - iosSA.startY);
				if (!absY) absY = 1; 
				var dXY = xD / absY;
				if (dXY > 4 && xD > 300) {
					//document.getElementById("system-message-container").innerHTML = "RIGHT";
					window.history.back();
				} else if (dXY < 4 && xD < 300) {
					//document.getElementById("system-message-container").innerHTML = "LEFT";
					window.history.forward();
				}
			} else {
				iosSA.touchCancel(event);
			}
		};

		iosSA.touchMove = function (event) {
//			event.preventDefault();
			if (event.touches.length == 1) {
				iosSA.curX = event.touches[0].pageX;
				iosSA.curY = event.touches[0].pageY;
			} else {
				iosSA.touchCancel(event);
			}
		};

		iosSA.touchCancel = function (event) {
			iosSA.startX = 0;
			iosSA.startY = 0;
			iosSA.fingerCount = 0;
			iosSA.curX = 0;
			iosSA.curY = 0;
			iosSA.swipe = 0;
		};

		iosSA.init = function () {
				fullscreen();
				if (window.navigator.standalone) {
					window.addEventListener("touchstart", function(){ iosSA.touchStart(event); });
					window.addEventListener("touchend", function(){ iosSA.touchEnd(event); });
					window.addEventListener("touchmove", function(){ iosSA.touchMove(event); });
					window.addEventListener("touchcancel", function(){ iosSA.touchCancel(event); });
				}
			};

		iosSA.init();
	});
}