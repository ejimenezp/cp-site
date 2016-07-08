(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

jQuery(document).ready(function ($) {

	var form_changed = false;

	$("#form_activity :input").change(function () {
		form_changed = true;
	});

	// check if window is a show details or a list of items

	var activity_id = $("#form_activity input[name='id']").val();

	if (activity_id != 0 && typeof activity_id !== "undefined") {
		// populate from database only if is show datails
		var cp_json_url = "/admin/json/activity/" + activity_id;

		$.getJSON(cp_json_url).success(function (json) {
			$("input[name='shortcode']").val(json.shortcode);
			$("input[name='atype']").val(json.atype);
		}).fail(function (jqxhr, textStatus, error) {
			var err = textStatus + ", " + error;
			console.log("Request Failed: " + err);
		});
	}

	// buttons

	$("#button_close").click(function () {
		if (form_changed) {
			$('#modal_activity_close').modal('show');
		} else {
			history.back();
		}
	});

	$("#button_save, #modal_button_save").click(function () {
		if (form_changed) {
			// if (!validate_admin_edit())
			// {
			// 	return false;
			// }

			var formdata = JSON.stringify($("#form_activity").serializeJSON());
			var url, method;
			if (activity_id == 0) {
				method = 'post';
				url = "/admin/json/activity";
			} else {
				method = 'patch';
				url = "/admin/json/activity/" + activity_id;
			}
			$.ajax({
				type: method,
				url: url,
				data: { form: formdata },
				accepts: {
					xml: 'text/xml',
					text: 'text/plain'
				},
				async: true,
				success: function success(msg) {
					alert(msg);
					window.location.href = '/admin/activity';
				}
			});
		}
	});

	$(".button_delete").click(function () {
		activity_id = $(this).data('activity_id');
		$(".modal-footer #activity_id").val(activity_id);
	});

	$("#modal_button_delete").click(function () {
		if (activity_id == null) {
			activity_id = $(this).val('activity_id');
		}

		$.ajax({
			type: 'delete',
			url: "/admin/json/activity/" + activity_id,
			accepts: {
				xml: 'text/xml',
				text: 'text/plain'
			},
			async: true,
			success: function success(msg) {
				alert(msg);
				window.location.href = '/admin/activity';
			}
		});
	});
});

},{}]},{},[1]);

//# sourceMappingURL=admin-activity.js.map
