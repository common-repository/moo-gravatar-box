window.addEvent('domready', function() {
	function gravatar(email){
		return 'http://www.gravatar.com/avatar/' + email.toMD5();
	}

	$('email').addEvent('blur', function(){		
		var size = "96";
		var defimg = "mm";
		var email = this.get('value');
		//var loweremail = email.toLowerCase();
		this.set('value', email.toLowerCase());
		if (email.indexOf('@') == -1) {
			//defimg = "404";
			return;
		}
		var img = new Image();
		var FadeImg = new Fx.Tween($('gravbox'), {
			wait: false,
			duration:400
		});
		$(img).addEvents({
			load:function(){
				FadeImg.start('opacity',1,0).chain(function() {
				  $('gravbox').set('html',"<div class='gravatar_frame'><img class='gravatar' src='"+gravatar(email)+"?s="+size+"&d="+defimg+"' /></div>");
				  FadeImg.start('opacity',0,1);
				});
			},
			error:function(){
			  	FadeImg.start('opacity',1,0).chain(function() {
				  $('gravbox').set('html',"<p class='nogravatar'>No gravatar? <a href='http://en.gravatar.com/site/signup/"+email+"'>Get one!</a></p>");
				  FadeImg.start('opacity',0,1);
				});
			}
		});
		//$(img).setProperty('src',gravatar(email)+"?s="+size+"&d=404");
		$(img).setProperty('src',gravatar(email)+"?s="+size+"&d="+defimg);
	});

	
});
