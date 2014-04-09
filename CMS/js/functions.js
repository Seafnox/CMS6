/**
 * Получение выделенной области
 */

function getSelectionText()  
{
   
    var txt = '';
    if (window.getSelection) {
        txt = window.getSelection();
    } else if (document.getSelection) {
        txt = document.getSelection();
    } else if (document.selection) {
        txt = document.selection.createRange().text;
    }

    return txt;

}

/**
 * Добавление текста в выделенную область
 */

function insTxt(id, txt)
{

var obj = document.getElementById(id);

var pos = 0;

var txt = txt;

 obj.focus();
 
  if(obj.selectionStart) //Gecko
  {
   pos = obj.selectionStart;
  }  
  else if (document.selection) // IE
  { 
    var sel = document.selection.createRange();
    var clone = sel.duplicate();
    sel.collapse(true);
    clone.moveToElementText(obj);
    clone.setEndPoint('EndToEnd', sel);
    pos = clone.text.length;
  }
  
  var len = obj.value.length;

  var txt1 = obj.value.substring(0, pos);

  var txt2 = obj.value.substring(pos, len);

  var text = txt1+txt+txt2;

  obj.value = text;

}

