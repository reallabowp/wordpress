var insertLabels;

( function( $ ) {
  var editor,

  insertLabels = {

    init: function(){
      $(document).on('click', '.button-insert-labels', function(e){
        e.preventDefault();
        insertLabels.get_label_list();
        insertLabels.open();
      });

      $(window).resize(function(){
        insertLabels.positionTop();
      });

      $('.close').click(function(e){
        e.preventDefault();
        insertLabels.close();
      });

      $('#insert-labels-backdrop').click(function(e){
        e.preventDefault();
        insertLabels.close();
      });

      $('#insert-labels-insert').click(function(e){
        e.preventDefault();
        if ($(this).attr('disabled')){
          return false;
        }
        insertLabels.insert();
        insertLabels.close();
      });

      $('#insert-labels-list').bind('change', function(){
        insertLabels.set_content();
      });
    },

    insert: function(){
      insertLabels.label_type = $('#label-type-list').val();
      insertLabels.label_text = $('#label-text').val();
      var custom_title = $('#label-title').val();

      if( custom_title !== "" ){
        insertLabels.title = custom_title;
      }

      var insert_html = '';
      var insert_url = '<a href="' + insertLabels.url + '?post=' + insert_labels_post_id + '&n=' + insertLabels.label_count + '" target="_brank" rel="nofollow">';

      if( insertLabels.label_type == 'detail'){
        insert_html = '<div class="label_wrap">';
        insert_html += '<div class="label_image">'+ insert_url + insertLabels.image + '</a></div>';
        insert_html += '<div class="label_info">';
        insert_html += '<div class="label_title">' + insert_url + insertLabels.title + '</a></div>';
        insert_html += '<div class="label_button">' + insert_url + insertLabels.label_text + '</a></div></div></div>';
      }else if( insertLabels.label_type == 'button'){
        insert_html = '<div class="label_button lable_button_only">' + insert_url + insertLabels.label_text + '</a></div>';
      }else if( insertLabels.label_type == 'text'){
        insert_html = insert_url + insertLabels.label_text + '</a>';
      }

      wp.media.editor.insert(insert_html);

      var args = $.extend({}, insert_labels_list_args);
      args['count_label'] = insertLabels.label_count + 1;
      args['post_id'] = insert_labels_post_id;
      $.ajax({
        url: insert_labels_list_uri,
        async: true,
        type: 'GET',
        dataType: 'json',
        data: args
      });
    },


    get_label_list: function(){
      var args = $.extend({}, insert_labels_list_args);
      $.ajax({
        url: insert_labels_list_uri,
        async: true,
        type: 'GET',
        dataType: 'json',
        data: args
      }).done(function(data){
        $.each(data, function(key, tpl){
          var option = $('<option />');
          $(option).attr('value', key);
          $(option).text(tpl.title);
          $('#insert-labels-list').append(option);

          insertLabels.title = tpl.title;
        });

        insertLabels.set_content();
      });
    },

    set_content: function(){
      $('#insert-labels-insert').attr('disabled', true);

      if (!$('#insert-labels-list').val()){
        return;
      }

      insertLabels.label_id = $('#insert-labels-list').val();

      var args = $.extend({}, insert_labels_list_args);
      args['label_id'] = insertLabels.label_id;
      args['post_id'] = insert_labels_post_id;

      $.ajax({
        url: insert_labels_list_uri,
        async: true,
        type: 'GET',
        dataType: 'json',
        data: args
      }).done(function(data){
        //var styles = insert_labels_editor_stylesheets;

        /*var html = '<!DOCTYPE html><html><head>';
        html += '<style>body{ padding: 0 !important; margin: 20px !important; }</style>';

        html += '</head><body class="mceContentBody">';
        html += data.preview;
        html += '</body></html>';

        var iframe = document.getElementById('insert-labels-preview');
        var doc = iframe.contentWindow.document;
        doc.open();
        doc.write(html);
        doc.close();*/

        insertLabels.url = data.url;
        insertLabels.label_count = data.label_count;
        insertLabels.image = data.preview;

        $('#insert-labels-insert').attr('disabled', false);
      });
    },

    open: function( editorId ) {
      $('#insert-labels-list').html('');
      /*var iframe = document.getElementById('insert-labels-preview');
      var doc = iframe.contentWindow.document;
      doc.open();
      doc.write('');
      doc.close();*/

      insertLabels.positionTop();

      $( document.body ).addClass( 'modal-open' );
      $('#insert-labels-wrap').show();
      $('#insert-labels-backdrop').show();
    },

    close: function() {
      $(document.body).removeClass('modal-open');
      $('#insert-labels-wrap').hide();
      $('#insert-labels-backdrop').hide();
      $('#insert-labels-insert').attr('disabled', true);
    },

    positionTop: function() {
      var windowHeight = $(document.body).height();
       //$('#insert-labels-preview').css('height', windowHeight * 0.5);

       var height = $('#insert-labels-wrap').height();
       var top = (windowHeight / 2) - (height / 2) - ($('#wpadminbar').height() / 2);

       if(top < 16){
         top = 16;
       }else if(top > 100){
         top = 100;
       }

       $('#insert-labels-wrap').css('top', top);
    },
  };

  $(document).ready(insertLabels.init);
})( jQuery );
