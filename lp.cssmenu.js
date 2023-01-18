sfHover = function() {
	var sfEls = document.getElementById("head_menu").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			var sfEls = document.getElementById("head_menu").getElementsByTagName("LI");
			for (var i=0; i<sfEls.length; i++)
				sfEls[i].className=sfEls[i].className.replace(new RegExp(" sfhover\\b"), "");
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);