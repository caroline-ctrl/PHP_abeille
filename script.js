let test = document.getElementById('but')
 
test.addEventListener('mousedown', function (){
   document.getElementById('motPasse').setAttribute('type', 'text');
});

test.addEventListener('mouseup', function (){
   document.getElementById('motPasse').setAttribute('type', 'password');
});