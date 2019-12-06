<html> 

<body>
  <p><strong>Click on button to view users</strong></p> 
  <div id = "container" > 
  <div> 
      Keresett felhasználó családi vagy keresztneve (részlet) <br/>
      <input type="text" id="nev" name="nev" onkeyup="getUsers(this.value)">
  </div> 
  <br/><br/>
  <b>Találatok</b> <br/>
  <div id="talalatok">

  </div> 
</div> 

<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
 
<script type="text/javascript"> 

  function getUsers(szoveg) {
      console.log(szoveg);

    $.ajax({
      type: "POST",
      url: "getrecords.php",
      data: {szoveg: szoveg},
      success: function( data ) {
        var text="";
        data.forEach(function(object, index) {
        text= text+"<p>"+object.csaladi_nev+" "+object.uto_nev+"</p>";          
       });
       $("#talalatok").html(text);
      },
      dataType: "json"
    }).fail(() => {
      alert( "Hiba lépett fel a kérés közben " );
    });
}
    

</script> 

</body>

</html>