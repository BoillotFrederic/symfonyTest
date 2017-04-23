var flash = document.getElementById('flash') ? document.getElementById('flash') : '';

if (flash)
setTimeout(function(){flash.style.display='none';}, 5000);
