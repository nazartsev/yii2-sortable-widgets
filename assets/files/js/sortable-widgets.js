function initSortableWidgets() {
	$('[data-sortable-widget=1] > table > tbody').sortable({
		animation: 300,
		handle: '.sortable-widget-handler',
		dataIdAttr: 'data-id',
		stop: function (evt, ui) {
			var self = this;
			$.post($(self).parents('[data-sortable-widget=1]').data('sortable-url'), {
				sorting: $(self).sortable( "toArray", { attribute: "data-key" } )
			});
		}
	});
}