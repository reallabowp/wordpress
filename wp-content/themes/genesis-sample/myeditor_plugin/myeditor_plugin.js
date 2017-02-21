(function( $, document, window ){
	tinymce.create(
		'tinymce.plugins.MyButtons', {
			init: function( ed, url ) {
				//画像引用ボタン
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

				//文章引用ボタン
				ed.addButton (
					'blockquote_val', {
						title: '文章の引用',
						image: url + "/image/quote.png",
						cmd: 'blockquote_val_cmd'
					}
				);

				ed.addCommand ('blockquote_val_cmd', function() {
					ed.windowManager.open ({
						url: url + "/blockquote.html",
						width: 480,
						height: 360,
						title: '文章の引用'
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
