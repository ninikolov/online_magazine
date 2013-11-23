/**
 * 
 */

$(function() {
	var title = $("#title"), body = $("#body"), image = $("#file"), allFields = $(
			[]).add(title).add(body).add(image), tips = $(".validateTips");

	$("#article-form").dialog({
		autoOpen : false,
		height : 700,
		width : 900,
		modal : true,
		buttons : {
			"Submit article" : function() {
				var bValid = true;
				allFields.removeClass("ui-state-error");

				bValid = bValid && checkWordsCount(title, "Title", 1, 20);
				bValid = bValid && checkImage(image);
				bValid = bValid && checkWordsCount(body, "Body", 1, 2000);

				if (bValid) {
					$("#submitform").submit();
					$(this).dialog("close");
				}
			},
			Cancel : function() {
				$(this).dialog("close");
			}
		},
		close : function() {
			allFields.val("").removeClass("ui-state-error");
		}
	});

	$("#create-article").button().click(function() {
		$("#article-form").dialog("open");
	});

	$("#column_article").change(function() {
		if (this.value == "column_article") {
			$(".column_select").show();
			$(".rating_select").hide();
		} else if (this.value == "review") {
			$(".column_select").hide();
			$(".rating_select").show();
		} else {
			$(".column_select").hide();
			$(".rating_select").hide();
		}
	});
	$(".column_select").hide();
	$(".rating_select").hide();
});