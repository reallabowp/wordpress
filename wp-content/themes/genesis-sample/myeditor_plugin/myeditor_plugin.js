(function( $, document, window ){
	tinymce.create(
		'tinymce.plugins.MyButtons', {
			init: function( ed, url ) {
				ed.addButton (
					'blockquote_link', {
						title: '画像の引用',
						image: url + "/image/ico.png",
						cmd: 'blockquote_cmd'
					}
				);

				ed.addCommand('blockquote_cmd', function() {
					ed.windowManager.open ({
						url: url + "/myeditor.html",
						width: 480,
						height: 360,
						title: '画像の引用'
					},{
						custom_param: 1
					});

				});
			},

			createControl: function(n,cm) {
				return null;
			}
		}
	);
	tinymce.PluginManager.add(
		'custom_button_script',
		tinymce.plugins.MyButtons
	);
})(jQuery, document, window);
