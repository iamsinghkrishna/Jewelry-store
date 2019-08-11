/* =*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*

	#Jewelry | Coming Soon Template HTML5 BY QAWBA.COM
	@Author		   qawba
	@Type          Javascript

	TABLE OF CONTENTS
	---------------------------
	
		01. Countdown

=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=* */
/* ================================= */
/* ::::::::: 1. Countdown :::::::::: */
/* ================================= */
$('#countdown_dashboard').countDown({
		targetDate: {
			'day': 		30,
			'month': 	12,
			'year': 	2017,
			'hour': 	11,
			'min': 		13,
			'sec': 		0
		},
		omitWeeks: true
});