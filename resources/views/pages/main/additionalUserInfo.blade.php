<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body>
    <form action="{{route('user.store-addn-info')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">Document type</label>
            <select name="document_type" class="form-control">
                <option value="Citizenship">Citizenship</option>
                <option value="Driving license">Driving license</option>
                <option value="Voters card">Voters card</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Document image</label>
            <input type="file" name="document_image" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Document number</label>
            <input type="text" name="document_number" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Date of Birth</label>
            <input type="date" name="dob" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-sm">Submit</button>
    </form>
</body>
</html>