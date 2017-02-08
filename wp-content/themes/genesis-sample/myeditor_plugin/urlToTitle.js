function urlToTitle(externalUrl, target){
  console.log('test');
  $.ajax({
    url: "http://hairlly.local/wp-content/themes/genesis-sample/myeditor_plugin/urlToTitle.php"
    async: true,
    dataType: 'json',
    data:{'url:externalUrl'},
    success: function(data) {
      target.val(data.title);
    }
  });
}
