$(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($('#accordion'), false);
});

function myFunction() {
	var x = document.getElementById("Demo");
	if (x.className.indexOf("w3-show") == -1) {
	  x.className += " w3-show";
	} else { 
	  x.className = x.className.replace(" w3-show", "");
	}
  }

var sidebar = document.getElementById('sidebar');
var main_panelNew = document.getElementById('main_panelNew');
var closeMenuIdNew = document.getElementById('closeMenuIdNew');
var openSideBar_Li = document.getElementById('openSideBar_Li');
var openSideBarId = document.getElementById('openSideBarId');
//alert(openSideBar_Li);

closeMenuIdNew.onclick = function(){
	sidebar.style.marginLeft = '-255px';
	main_panelNew.style.width = '100%';
	openSideBar_Li.style.display = 'inline-block';
	
}

openSideBarId.onclick = function(){
	sidebar.style.marginLeft = '0';
	main_panelNew.style.width = '100%';
	openSideBar_Li.style.display = 'none';
	
}













