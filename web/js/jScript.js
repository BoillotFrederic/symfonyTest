var flash = document.getElementById('flash') ? document.getElementById('flash') : '';

if (flash)
setTimeout(function(){flash.style.display='none';}, 5000);

function resize(){
  if(document.getElementsByTagName('body')[0].clientHeight <= document.getElementById('content').children[0].clientHeight + 40){
    document.getElementsByTagName('html')[0].style.height = (document.getElementById('content').clientHeight + 200) + 'px';
    document.getElementsByTagName('body')[0].style.height = (document.getElementById('content').clientHeight + 200) + 'px';
  }
  else
  document.getElementsByTagName('body')[0].style.height = '100%';
}

resize();

window.onresize = function(){
  resize();
}

function del(id, url){
  $.ajax({
    method:'DELETE',
    url: url + '.json'
  }).done(function(){
    $('#product'+id).fadeOut();
  });
}
