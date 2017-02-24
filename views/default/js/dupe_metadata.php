//<script>
<?php
/**
 * Database validator JavaScript
 */
?>

elgg.provide('elgg.dbvalidate');

elgg.dbvalidate.init = function() {
	$("a.dupe-metadata").click(elgg.dbvalidate.validate);
	$(document).on('click', "a.dupe-metadata-fix", elgg.dbvalidate.dupeFix);
};

elgg.dbvalidate.validate = function(event) {
	event.preventDefault();
	
	$(this).hide();
	var $spinner = $(this).parents('.elgg-module').first().find('.elgg-ajax-loader');
	var $results = $(this).parents('.results').first();
	var url = $(this).attr('data-href');
	$spinner.show();
	
	// actions in Elgg send back json so we use $.ajax
	$.ajax({
		type: "GET",
		timeout: 3600000,
		url: url,
		dataType: "html",
		success: function(htmlData) {
			$spinner.hide();

			if (htmlData.length > 0) {
				$results.html(htmlData);
			}
		},
		error: function(jqXHR, textStatus, error) {
			$spinner.hide();
			$results.html(textStatus);
		}
	});

};

elgg.dbvalidate.dupeFix = function(event) {
	event.preventDefault();
	
	if ($(this).attr('disabled')) {
		return;
	}
	
	var confirm_text = $(this).attr('data-confirmText');
	if (!confirm(confirm_text)) {
		return false;
	}
	
	var url = $(this).attr('data-href');
	var $button = $(this);
	var $container = $button.parents('div').first();
	var original_text = $button.text();
	
	$(this).attr('disabled', true).text('Working...');
	
	$.ajax({
		type: "GET",
		timeout: 3600000,
		url: url,
		dataType: "html",
		success: function(htmlData) {
			elgg.system_message(htmlData);
			$container.slideUp();
		},
		error: function(jqXHR, textStatus, error) {
			$button.attr('disabled', false);
			$button.text(original_text);
			elgg.register_error(textStatus);
		}
	});
};

elgg.register_hook_handler('init', 'system', elgg.dbvalidate.init);
