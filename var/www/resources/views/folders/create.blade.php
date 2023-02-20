<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/style.css')}}">
  <title>ToDo App</title>
</head>

<body>
  @include('header')
  <main>
    <div class="container">
      <div class="row">
        <div class="col col-md-offset-3 col-md-6">
          <nav class="panel panel-default">
            <div class="panel-heading">フォルダを作成する</div>
            <div class="panel-body">
              @if($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $message)
                  <li>{{ $message }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <form action="{{ route('folders_create', [ 'user' => $user->id]) }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="form-group">
                  <label for="title">フォルダ名</label>
                  <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-secondary">送信</button>
                </div>
              </form>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </main>
</body>

</html>