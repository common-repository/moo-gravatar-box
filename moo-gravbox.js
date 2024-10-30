window.addEvent('domready', function() {
	function gravatar(email){
		if (MooGravBoxParams.secure == 1)
			return 'https://secure.gravatar.com/avatar/' + email.toMD5();
		else
			return 'http://www.gravatar.com/avatar/' + email.toMD5();
	}
    if ($('email')){
	$('email').addEvent('blur', function(){
		var size = MooGravBoxParams.size;
		var defimg = MooGravBoxParams.default_image;
		var rating = MooGravBoxParams.rating;
		if (MooGravBoxParams.force_default == 1)
			var forcedef = "&forcedefault=y";
		else
			var forcedef = "";
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
			duration:MooGravBoxParams.fx_duration
		});
		$(img).addEvents({
			load:function(){
				FadeImg.start('opacity',1,0).chain(function() {
				  $('gravbox').set('html',"<div class='gravatar_frame'><img class='gravatar' src='"+gravatar(email)+"?s="+size+"&d="+defimg+"&r="+rating+"' /></div>");
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
		$(img).setProperty('src',gravatar(email)+"?s="+size+"&d="+defimg+"&r="+rating+forcedef);
	});
    }
});