/* OT Document JAVASCRIPT for MENU DROPDOWN */
if (typeof(MooTools) != 'undefined') {
	var subnav = new Array();
	
	Element.implement(
	{
		hide: function(timeout)
		{
			this.status = 'hide';
			clearTimeout(this.timeout);
			if (timeout) {
				this.timeout = setTimeout(this.anim.bind(this), timeout);
			} else {
				this.anim();
			}
		},
		
		show: function(timeout)
		{
			this.status = 'show';
			clearTimeout(this.timeout);
			if (timeout) {
				this.timeout = setTimeout(this.anim.bind(this), timeout);
			} else {
				this.anim();
			}
		},
		
		set_Active: function()
		{
			this.className += ' sfhover';
		},
		
		setDeactive: function() {
			this.className = this.className.replace(new RegExp(' sfhover\\b'), '');
		},
		
		anim: function()
		{
			if ((this.status == 'hide' && this.style.left != 'auto') || (this.status == 'show' && this.style.left == 'auto' && !this.hidding)) return;
			this.setStyle('overflow', 'hidden');
			if (this.status == 'show') {
				this.hidding = 0;
				this.hideAll();
			}
			
			if (this.status == 'hide') {
				this.hidding = 1;
				this.myFx2.cancel();
				if (this.parent._id) {
					this.myFx2.start('width', this.offsetWidth, 0);
				} else {
					this.myFx2.start('height', this.offsetHeight, 0);
				}
			} else {
				this.setStyle('left', 'auto');
				this.myFx2.cancel();
				if (this.parent._id) this.myFx2.start('width', 0, '205px');
					else this.myFx2.start('height', 0, this.mh);
			}
		},
		init: function()
		{
			this.mw = this.clientWidth;
		   	this.mh = this.clientHeight;
			if (this.parent._id) {
				this.myFx2 = new Fx.Tween(this, {
					duration: 400,
					link: 'cancel'
				});
				this.myFx2.set('width',0);
			} else {
				this.myFx2 = new Fx.Tween(this, {
					duration: 400,
					link: 'cancel'
				});
				this.myFx2.set('height',0);
			}
			
			this.setStyle('left', '-999em');
			
			animComp = function()
			{
				if (this.status == 'hide') {
					this.setStyle('left', '-999em');
					this.hidding = 0;
				}
				
				this.setStyle('overflow', '');
			}
			this.myFx2.addEvent('onComplete', animComp.bind(this));
		},
		
		hideAll: function()
		{
			for (var i = 0; i < subnav.length; i++) {
				if (!this.isChild(subnav[i])) {
					subnav[i].hide(0);
				}
			}
		},
		
		isChild: function(_obj)
		{
			obj = this;
			while (obj.parent) {
				if (obj._id == _obj._id) {
					return true;
				}
				obj = obj.parent;
			}
			return false;
		}
	});
	
	var DropdownMenu = new Class({
		
		initialize: function(element)
		{
			if(element.className == 'menu_round')
			{
				$A($(element).childNodes).each(function(el){
					if(el.className == 'menu_mid'){
						$A($(el).childNodes).each(function(el_1){
							if(el_1.nodeName.toLowerCase() == 'ul'){
								elm = $(el_1);
							}
						});
					}
				});
			}
			else
			{
				elm = $(element);
			}
			$A($(elm).childNodes).each(function(el_2){
				if (el_2.nodeName.toLowerCase() == 'li') {
					$A($(el_2).childNodes).each(function(el_3) {
						if (el_3.className == 'menu_round') {
							$(el_3)._id = subnav.length + 1;
							$(el_3).parent = $(element);
							subnav.push($(el_3));
							el_3.init();
							
							el_2.addEvent('mouseenter', function() {
								el_2.set_Active();
								el_3.show(0);
								return false;
								
							});
							
							el_2.addEvent('mouseleave', function() {
								el_2.setDeactive();
								el_3.hide(20);
							});
							
							new DropdownMenu(el_3);
							el_2.hasSub = 1;
						}
					});
					if (!el_2.hasSub) {
						el_2.addEvent('mouseenter', function() {
							el_2.set_Active();
							return false;
						});
						
						el_2.addEvent('mouseleave', function() {
							el_2.setDeactive();
						});
					}
				}
			});
			return this;
		}
	});
		window.addEvent('domready', function() {
			new DropdownMenu(document.getElement('#ot-mainmenu ul.level0'));
		});
} else {
	sfHover = function()
	{
		var sfEls = document.getElementById("ot-mainmenu").getElementsByTagName("li");
		for (var i = 0; i<sfEls.length; ++i) {
			sfEls[i].onmouseover = function() {
				this.className += " sfhover";
			}
			sfEls[i].onmouseout = function() {
				this.className = this.className.replace(new RegExp(" sfhover\\b"), "");
			}
		}
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);
}
/* +++++++++++++++ End +++++++++++++++++++ */