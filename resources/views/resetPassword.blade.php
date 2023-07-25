
@if($errors->any())

    @foreach ($errors->all() as $error)

        <li>{{$error}}</li>
        
    @endforeach

@endif


    <form method="POST">
     @csrf
    <input type="hidden" name="id" value="{{$client[0]['id']}}">
    <input type="password" name="password" placeholder="new password">
    <br>
    <br>
    <input type="submit">
    </form>
