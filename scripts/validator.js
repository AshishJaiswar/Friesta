$(document).ready(function(){
      $("form").submit(function(event){
            var username = $("#username").val();
            var password = $("#password").val();
            var email = $("#email").val();
            event.preventDefault();
            var data = "username=" + username + "&password=" + password + "&email=" + email;
            console.log(data);
            $.ajax({
                  method: "post",
                  url: "create-account.php",
                  data: data,
                  success: function(data){
                        $("#error_message").html(data);
                  }
            })
      });
});
