<!DOCTYPE html>  
<html>
<head>
<title>Registration form</title>
</head>
 
<body>
	

<form action="<?= site_url('crud/update') ?>" method="post">
    <?= csrf_field() ?> <!-- Include CSRF token for security -->

    <input type="hidden" name="id" value="<?= $record['id'] ?>">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= old('name', $record['name']) ?>"><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= old('email', $record['email']) ?>"><br><br>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?= old('city', $record['city']) ?>"><br><br>

    <input type="submit" value="Update">
</form>
</body>
</html>
