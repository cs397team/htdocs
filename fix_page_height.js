var isIE5=navigator.userAgent.toUpperCase().indexOf("MSIE 5")!=-1;

var targetElementID="wrap", targetElementStyleOffset=10;

function adjustHeight() {
  if (document.getElementById) {
    var targetElement=document.getElementById(targetElementID),
        documentHeight, totalOffset;

    if (targetElement) {
      documentHeight=document.documentElement.offsetHeight;
      if (targetElement.offsetHeight<documentHeight-targetElement.offsetTop) {
        if (isIE5)
          totalOffset=targetElement.offsetTop;
          else totalOffset=targetElement.offsetTop+targetElementStyleOffset;
        targetElement.style.height=String(documentHeight-totalOffset)+'px';
      }
    }
  }
}

window.onresize=adjustHeight;
window.onload=adjustHeight;