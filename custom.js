function changePasswordMy(id) {

  var haslo = prompt('Wpisz nowe hasło');

  if(haslo != null && haslo != ''){
  $.ajax({
    url: "adminPanelChange.php",
    type: "POST",
    data: 'password='+haslo+'&ID='+id+'&moje',
    success: function(data){
      alert (data);
    },
    error: function(data){
      alert (data);
    },
  });

}
}
