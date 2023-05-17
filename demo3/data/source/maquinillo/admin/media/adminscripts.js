

function insertTag(v) {
  if (!document.selection) return;
  var str = document.selection.createRange().text;
  if (!str) return;
  var sel = document.selection.createRange();
  sel.text = "<" + v + ">" + str + "</" + v + ">";
  return;
}

function insertLink() {
  if (!document.selection) return;
  var str = document.selection.createRange().text;
  if (!str) return;
  var my_link = prompt("Dirección URL:","http://");
  if (my_link != null) {
    var sel = document.selection.createRange();
	sel.text = "<a href=\"" + my_link + "\">" + str + "</a>";
  }
  return;
}