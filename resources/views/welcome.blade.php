<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel || Ajax || CRUD</title>
        <link rel="stylesheet" href="https://bootswatch.com/solar/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    </head>
    <body>
      <div class="container">
        <div class="page-header">
          <p>Add Contacts</p>
        </div>
          <div class="form-group">
            <label for="first_name">First Name: </label>
            <input type="text" name="first_name" id="first_name" class="form-control">
          </div>
          <div class="form-group">
            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" id="last_name" class="form-control">
          </div>
          <div class="form-group">
            <label for="phone">Phone: </label>
            <input type="text" name="phone" id="phone" class="form-control">
          </div>
          <div id="actionButton">
            <button class="btn btn-md btn-success" onclick="saveContact()" id="saveContact">Save</button><br /><br />
          </div>
      </div>
      <div class="container" id="contacts">

      </div>
    </body>
    <script>
    $( document ).ready(function() {
        $.ajax({
          url: "http://localhost:8000/api/contact",
          method: "get",
          success: function(res){
            var html = "";
            for(i = 0; i < res.length; i++){
                html += "<div id='contactSingle_"+ res[i].id +"'><div class='col-md-2'>"+ res[i].first_name +"</div><div class='col-md-2'>" + res[i].last_name + "</div><div class='col-md-2'>" + res[i].phone + "</div><div class='col-md-2'><button class='btn btn-primary' onclick='editContact("+res[i].id+")'>Edit</button></div><div class='col-md-2'><button class='btn btn-danger' onclick='deleteContact("+res[i].id+")' > Delete </button></div><br /><br /></div>";
            }
            $('#contacts').append(html);
          }
        });
    });
    function saveContact(){
      var first_name = $('#first_name').val(),
      last_name = $('#last_name').val(),
      phone = $('#phone').val();
      $.ajax({
        url: "http://localhost:8000/api/contact",
        method: 'post',
        data: {
          first_name: first_name,
          last_name: last_name,
          phone: phone
        },
        success: function(res){
          var html = "";
          html = "<div id='contactSingle_"+ res.id + "'><div class='col-md-2'>"+ res.first_name +"</div><div class='col-md-2'>" + res.last_name + "</div><div class='col-md-2'>" + res.phone + "</div><div class='col-md-2'><button class='btn btn-primary' onclick='editContact("+res.id+")'>Edit</button></div><div class='col-md-2'><button class='btn btn-danger' data-id='"+res.id+"' onclick='deleteContact("+res.id+")'>Delete</button></div><br /><br /></div>";
          $('#contacts').prepend(html);
          $('#first_name').val('');
          $('#last_name').val('');
          $('#phone').val('');
        }
      });
    }

    function deleteContact(id){
      var divC = $("#contactSingle_"+id);
      $.ajax({
        url: "http://localhost:8000/api/contact/"+id,
        method: "delete",
        success: function(res){
          divC.fadeOut(2000, function(){
            divC.remove();
          })
        }
      });
    }
    function editContact(id){
      //configure html
      var addBtn = $("#saveContact"), actionBtnDiv = $("#actionButton"), fName = $("#first_name"), lName = $("#last_name"), phoneInput = $("#phone");
      var html = "<button class='btn btn-default' onclick='cancelBTN()' id='cancelButton'>Cancel</button><button class='btn btn-warning' onclick='updateContact()' id='updateContact'>Update</button>";
      $.ajax({
        url: "http://localhost:8000/api/contact/"+id+"/edit",
        method: "get",
        success: function(res){
          addBtn.fadeOut(1000, function(){
            addBtn.remove();
          });
          html += "<input type='hidden' id='hiddenID' name='hidden_id' value="+res.id+">";
          actionBtnDiv.prepend(html);
          fName.val(res.first_name);
          lName.val(res.last_name);
          phoneInput.val(res.phone);
        }
      });
    }
    function cancelBTN(){
      console.log('clicckkeeeeeddddddddddddddd');
      var actionBtnDiv = $("#actionButton"), fName = $("#first_name"), lName = $("#last_name"), phoneInput = $("#phone"), hiddenID = $("#hiddenID");
      var cancelBtn = $("#cancelButton"), updateBtn = $("#updateContact");
      var html = "<button class='btn btn-md btn-success' onclick='saveContact()' id='saveContact'>Save</button>";
      hiddenID.remove();
      fName.val('');
      lName.val('');
      phoneInput.val('');
      cancelBtn.fadeOut(1000, function(){
        cancelBtn.remove();
      });
      updateBtn.fadeOut(1000, function(){
        updateBtn.remove();
      });
      actionBtnDiv.prepend(html);
    }

    function updateContact(){
      var first_name = $('#first_name').val(), last_name = $('#last_name').val(), phone = $('#phone').val(), cID = $("#hiddenID").val();
      var singleWalaDiv = $("#contactSingle_"+cID);
      var actionBtnDiv = $("#actionButton");
      $.ajax({
        url: "http://localhost:8000/api/contact/"+cID,
        method: "put",
        data: {
          first_name: first_name,
          last_name: last_name,
          phone: phone,
          id: cID
        },
        success: function(res){
          // remove data from div and add data to div, ghazab mast
          var html = "<div class='col-md-2'>"+ res.first_name +"</div><div class='col-md-2'>" + res.last_name + "</div><div class='col-md-2'>" + res.phone + "</div><div class='col-md-2'><button class='btn btn-primary' onclick='editContact("+res.id+")'>Edit</button></div><div class='col-md-2'><button class='btn btn-danger' data-id='"+res.id+"' onclick='deleteContact("+res.id+")'>Delete</button></div><br /><br />";
          singleWalaDiv.html(html);
          $("#first_name").val('');
          $("#last_name").val('');
          $("#phone").val('');
          actionBtnDiv.html("<button class='btn btn-md btn-success' onclick='saveContact()' id='saveContact'>Save</button><br /></br />");
        }
      });
    }
    </script>
</html>
