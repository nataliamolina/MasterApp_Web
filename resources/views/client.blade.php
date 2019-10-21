<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('/oauth/clients')}}" method="POST">
        {{csrf_field()}}
        <p>
            <input type="text" name="name">
        </p>
        <p>
            <input type="text" name="redirect">
        </p>
        <p>
            <button type="submit">Enviar</button>
        </p>
    </form>
    
    <table border="1">
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Redirect</td>
                <td>Secret</td>
            </tr>
        </thead>

        <tbody>
            @foreach($clients as $val)
            <tr>
                <td>{{$val->id}}</td>
                <td>{{$val->name}}</td>
                <td>{{$val->redirect}}</td>
                <td>{{$val->secret}}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
</body>
</html>