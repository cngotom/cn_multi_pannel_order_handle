var defaultOpts = { interval: 5000, fadeInTime: 300, fadeOutTime: 200 };
//Iterate over the current set of matched elements
	var _titles = $("ul.foucs-txt li");
	var _titles_bg = $("ul.op li");
	var _bodies = $("ul.foucs-pic li");
	var _count = _titles.length;
	var _current = 0;
	var _intervalID = null;
	var stop = function() { window.clearInterval(_intervalID); };
	var foucs = function(opts) {
		if (opts) {
			_current = opts.current || 0;
		} else {
			_current = (_current >= (_count - 1)) ? 0 : (++_current);
		};
		_bodies.filter(":visible").fadeOut(defaultOpts.fadeOutTime, function() {
			_bodies.eq(_current).fadeIn(defaultOpts.fadeInTime);
			_bodies.removeClass("cur").eq(_current).addClass("cur");
		});
		_titles.removeClass("cur").eq(_current).addClass("cur");
		_titles_bg.removeClass("cur").eq(_current).addClass("cur");
	}; //endof foucs
	var go = function() {
		stop();
		_intervalID = window.setInterval(function() { foucs(); }, defaultOpts.interval);
	}; //endof go
	var itemMouseOver = function(target, items) {
		stop();
		var i = $.inArray(target, items);
		foucs({ current: i });
	}; //endof itemMouseOver
	_titles.hover(function() { if($(this).attr('class')!='cur'){itemMouseOver(this, _titles); }else{stop();}}, go);
	//_titles_bg.hover(function() { itemMouseOver(this, _titles_bg); }, go);
	_bodies.hover(stop, go);
	//trigger the foucsbox
	go();
	
var foucsX={
	_this:$('.catalog .imgbox'),
	_btnLeft:$('.catalog .left'),
	_btnRight:$('.catalog .right'),
	init:function(){
		foucsX._btnLeft.click(foucsX.foucsLeft);
		foucsX._btnRight.click(foucsX.foucsRight);
		},
	foucsLeft:function(){
		foucsX._btnLeft.unbind('click',foucsX.foucsLeft);
		for(i=0;i<4;i++){
			foucsX._this.find('li:last').prependTo(foucsX._this);
			}
		foucsX._this.css('marginLeft',-224);
		foucsX._this.animate({'marginLeft':0},500,function(){
			foucsX._btnLeft.bind('click',foucsX.foucsLeft);
			});
		return false;
		},
	foucsRight:function(){
		foucsX._btnRight.unbind('click',foucsX.foucsRight);
		foucsX._this.animate({'marginLeft':-224},500,function(){
			foucsX._this.css('marginLeft','0');
			for(i=0;i<4;i++){
				foucsX._this.find('li:first').appendTo(foucsX._this)
				}
			foucsX._btnRight.bind('click',foucsX.foucsRight);
			});
		return false;
		}
	}
	$(document).ready(function() {
	    foucsX.init();
	});






function c1() {
    //alert("ok");
    $("ul.tab li.tab_01").show();
    $("ul.tab li.tab_02").hide();
    $("ul.tit li.T1").addClass("login_tab_bg");
    $("ul.tit li.T2").removeClass("login_tab_bg");
    $("ul.tit li.T1").css({ color: "#fff" });
    $("ul.tit li.T2").css({ color: "#bf0405" });
}
function c2() {
    //	alert("ok");
    $("ul.tab li.tab_01").hide();
    $("ul.tab li.tab_02").show();
    $("ul.tit li.T2").addClass("login_tab_bg");
    $("ul.tit li.T1").removeClass("login_tab_bg");
    $("ul.tit li.T2").css({ color: "#fff" });
    $("ul.tit li.T1").css({ color: "#bf0405" });

}

