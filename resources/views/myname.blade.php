<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Include any necessary meta tags or link to external stylesheets here -->
</head>

<body>

    <h1>Rian Aldba</h1>
    <form>
    <label for= "name">Name</label>
           <input type= "text" id= "name" name= "name">
    </form>
      <form>
    <label for= "address">Address</label>
           <input type= "text" id= "address" name= "address">
    </form>
      <form>
    <label for= "age">Age</label>
        <input type= "int" id= "age" name= "age">
        
    <button type = "button" onclick ="submitForm()">Submit</button>
    </form>
    
</body>
<script src= "https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    public function submitForm(){
        $.ajax({
            type:'POST',
            url: /my-name,
            data: $('#myname').serialize(),
            success: function (response){
                alert(response);
            }
        })
error: function(error){
    console.log(error);
}
        ;
    }
</>
</html>