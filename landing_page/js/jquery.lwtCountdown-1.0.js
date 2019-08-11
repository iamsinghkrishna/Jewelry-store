(function ( $ ) {
	function pad(n) {
	    return (n < 10) ? ("0" + n) : n;
	}

	$.fn.showclock = function() {
	    
	    var currentDate=new Date();
	    var fieldDate=$(this).data('date').split('-');
	    var futureDate=new Date(fieldDate[0],fieldDate[1]-1,fieldDate[2]);
	    var seconds=futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

	    if(seconds<=0 || isNaN(seconds)){
	    	this.hide();
	    	return this;
	    }

	    var days=Math.floor(seconds/86400);
	    seconds=seconds%86400;
	    
	    var hours=Math.floor(seconds/3600);
	    seconds=seconds%3600;

	    var minutes=Math.floor(seconds/60);
	    seconds=Math.floor(seconds%60);
	    
	    var html="";

	    if(days!=0){
		    html+="<div class='countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob days'>"
		    	html+="<div class='dash days_dash'>"
		    	
		    	html+="<span class='countdown-heading days-top top dash_title'>Days</span>";
		    	html+="<span class='countdown-value days-bottom bottom digit'>"+pad(days)+"</span>";
		    html+="</div>";
		    html+="</div>";
		}

	    html+="<div class='countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob hours'>"
	    	html+="<div class='dash days_dash'>"
		   
	    	html+="<span class='countdown-heading hours-top top dash_title'>Hours</span>";
	    	html+="<span class='countdown-value hours-bottom bottom digit'>"+pad(hours)+"</span>";
	    	html+="</div>";
		    html+="</div>";
		    

	    html+="<div class='countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob minutes'>"
	    	html+="<div class='dash days_dash'>"
		    
	    	html+="<span class='countdown-heading minutes-top top dash_title'>Minutes</span>";
	    	html+="<span class='countdown-value minutes-bottom bottom digit'>"+pad(minutes)+"</span>";
	    	html+="</div>";
		    html+="</div>";
		   

	    html+="<div class='countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob seconds'>"
	    	html+="<div class='dash days_dash'>"
		    
	    	html+="<span class='countdown-heading seconds-top top dash_title'>Seconds</span>";
	    	html+="<span class='countdown-value seconds-bottom bottom digit'>"+pad(seconds)+"</span>";
	    	html+="</div>";
		    html+="</div>";
		    

	    this.html(html);
	};

	$.fn.countdown = function() {
		var el=$(this);
		el.showclock();
		setInterval(function(){
			el.showclock();	
		},1000);
		
	}

}(jQuery));

jQuery(document).ready(function(){
	if(jQuery(".countdown").length>0)
		jQuery(".countdown").countdown();
})