/*
 * 
 */

/**
 * 
 * @param t
 */
function updateTips(t) {
	tips.text(t).addClass("ui-state-highlight");
	setTimeout(function() {
		tips.removeClass("ui-state-highlight", 1500);
	}, 500);
}

/**
 * 
 * @param target
 * @param name
 * @param min
 * @param max
 * @returns {Boolean}
 */
function checkWordsCount(target, name, min, max) {
	var text = target.val().trim();
	var highlight = false;
	if (target.val().trim() == "") {
		highlight = true;
	} else {
		var count = text.split(' ').length;
		if (count < min || count > max) {
			highlight = true;
		}
	}
	if (highlight) {
		target.addClass("ui-state-error");
		updateTips("Length of " + name + " must be between " + min + " and "
				+ max + ".");
		return false;
	} else {
		return true;
	}
}

/**
 * 
 * @param o
 * @param n
 * @param min
 * @param max
 * @returns {Boolean}
 */
function checkLength(o, n, min, max) {
	if (o.val().length > max || o.val().length < min) {
		o.addClass("ui-state-error");
		updateTips("Length of " + n + " must be between " + min + " and " + max
				+ ".");
		return false;
	} else {
		return true;
	}
}

/**
 * 
 * @param o
 * @returns {Boolean}
 */
function checkImage(o) {
	if (o.val() == "") {
		o.addClass("ui-state-error");
		updateTips("You must select a cover image for the article.");
		return false;
	} else {
		return true;
	}
}

function alert_error_message(message) {
	$('#messages')
			.append(
					'<div id="error-widget" style="display:none">\
		<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">\
			<p>\
				<span class="ui-icon ui-icon-alert"\
					style="float: left; margin-right: .3em;"></span> <strong>Alert:</strong>\
				'
							+ message + '.\
			</p>\
		</div>\
	</div>');
	$('#error-widget').show().delay(2000).fadeOut();
}

function alert_success_message(message) {
	$('#messages')
			.append(
					'<div id="error-widget" style="display:none">\
		<div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">\
			<p>\
				<span class="ui-icon ui-icon-info"\
					style="float: left; margin-right: .3em;"></span> <strong>Alert:</strong>\
				'
							+ message + '.\
			</p>\
		</div>\
	</div>');
	$('#error-widget').show().delay(2000).fadeOut();
}