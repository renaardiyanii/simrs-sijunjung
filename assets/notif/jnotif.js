// console.log('sini');
setInterval(function () {
	var getJmlNotif = $('#tnotif-nav').text();
	if (getJmlNotif > 0) {
		$("#sound_notif").get(0).play();
	}
}, 300000);

setInterval(function () {
	if($('#general-notif').find('#no-notif-allowed').html()===undefined){
		$.ajax({
			type: 'POST',
			url: baseurl + "notif/arnotif",
			dataType: 'json',
			success: function (rsnotif) {
				if (rsnotif['stsn'] === 1) {
					for (i = 0; i < rsnotif['data'].length; i++) {
						var nmid = '#nid' + rsnotif['data'][i].nid + 'ar';
						$(nmid).text(rsnotif['data'][i].countn);
					}
					$('#tnotif-nav').text(rsnotif['totn']);
					if (rsnotif['totn'] > 0) {
						// setInterval(function() {
						// 	$("#sound_notif").get(0).play();
						// }, 300000);
						$("#sound_notif").get(0).play();
					} else {
						$("#sound_notif").get(0).pause();
					}
				}
			}
		});
	}
	return false;
}, 300000);

// setInterval(function () {
// 	var getJmlNotif = $('#tnotif-nav').text();
// 	if (getJmlNotif > 0) {
// 		$("#sound_notif").get(0).play();
// 	}
// }, 300000);
