<html>
   <head>
      <title>Student Management | Add</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   </head>

   <body>
      @include('flash::message')
      <form action = "/loginUser" method = "post">
         <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
         <table>
            <tr>
               <td>Username</td>
               <td><input type='text' name='username' /></td>
            </tr>
            <tr>
               <td>Password</td>
               <td><input type='password' name='password' /></td>
            </tr>
            <tr>
               <td colspan = '2'>
                  <input type = 'submit' value = "Login"/>
               </td>
            </tr>
         </table>
      </form>
      
   </body>
   <script
  src="https://code.jquery.com/jquery-3.5.0.js"
  integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc="
  crossorigin="anonymous"></script>
   <script>
        jQuery('div.alert').not('.alert-important').delay(5000).fadeOut(500);
      </script>    
</html>