var jsPost = function(action, values) {
    var id = Math.random();
    document.write('<form id="post' + id + '" name="post'+ id +'" action="' + action + '" method="post">');
    for (var key in values) {
        document.write('<input type="hidden" name="' + key + '" value="' + values[key] + '" />');
    }
    document.write('</form>');    
    document.getElementById('post' + id).submit();
}

/*
    Iframe名字放进target中
 */
var jsPostForIframe = function(action, values) {
    var id = Math.random();
    document.write('<form id="post' + id + '" name="post'+ id +'" action="' + action + '" method="post" target = "frame">');
    for (var key in values) {
        document.write('<input type="hidden" name="' + key + '" value="' + values[key] + '" />');
    }
    document.write('</form>');
    document.getElementById('post' + id).submit();
}