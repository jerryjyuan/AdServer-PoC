function toggleDisp() {
	for (var i=0;i<arguments.length;i++){
		var d = $(arguments[i]);
		if (d.style.display == 'none')
			d.style.display = 'block';
		else
			d.style.display = 'none';
	}
}
function toggleTab(num,numelems,opennum,animate) {
	if ($('tabContent'+num).style.display == 'none'){
		for (var i=1;i<=numelems;i++){
			if ((opennum == null) || (opennum != i)){
				var temph = 'tabHeader'+i;
				var h = $(temph);
				if (!h){
					var h = $('tabHeaderActive');
					h.id = temph;
				}
				var tempc = 'tabContent'+i;
				var c = $(tempc);
				if(c.style.display != 'none'){
					if (animate || typeof animate == 'undefined')
						Effect.toggle(tempc,'blind',{duration:0.0, queue:{scope:'menus', limit: 0}});
					else
						toggleDisp(tempc);
				}
			}
		}
		var h = $('tabHeader'+num);
		if (h)
			h.id = 'tabHeaderActive';
		h.blur();
		var c = $('tabContent'+num);
		c.style.marginTop = '2px';
		if (animate || typeof animate == 'undefined'){
			Effect.toggle('tabContent'+num,'blind',{duration:0.0, queue:{scope:'menus', position:'end', limit: 3}});
		}else{
			toggleDisp('tabContent'+num);
		}
	}
}