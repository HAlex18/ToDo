<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <title>ToDo Application</title>
</head>

<body>
  @include('header')
  <main>
    <div class="homeContainer">
      <div class="row">
        @if (session('folders_flash_message'))
        <div class="alert alert-secondary" role="alert" width="80%" margin="auto">
          {{ session('folders_flash_message') }}
        </div>
        @endif
        <nav class="panel panel-default">
          <div class="panel-heading">フォルダ</div>
          <div class="panel-body">
            <a href="{{ route('create_form', ['user' => Auth::user()->id]) }}" class="btn btn-default btn-block">フォルダを追加する</a>
          </div>
          <div class="list-group">
            @foreach ($folders as $folder)
            <div class="icon list-group-item">
              <a href="{{ route('select_folders', ['id' => $folder->id] ) }}">
                {{ $folder->title}}
              </a>

              <form action="{{ route('folders_delete', ['user' => Auth::user()->id, 'id' => $folder->id])}}" method="post">
                @csrf
                <button class="button" type="submit" onclick="return confirm('ファイルを削除すると、タスクも全て削除されます。\n本当に削除しますか?')"><img src="{{ asset('../img/trash.png')}}"></button>
              </form>

            </div>
            @endforeach
          </div>
        </nav>
      </div>
      <!-- タスク表示 -->
      <div class="colum col-md-8">
        @if (session('flash_message'))
        <div class="alert alert-secondary" role="alert" width="80%">
          {{ session('flash_message') }}
        </div>
        @endif
        <div class="panel panel-default">
          <div class="panel-heading">タスク</div>
          <div class="panel-body">
            @isset($current_folder_id)
            <div class="text-right">
              <a href="{{ route('todos_create_form', $current_folder_id)}}" class="btn btn-default btn-block">タスクを追加する</a>
            </div>
            @else
            <div class="text-right">
              <a href="/" class="btn btn-default btn-block">タスクを追加する</a>
            </div>
            @endisset
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>タスク内容</th>
                <th>状態</th>
                <th>期限</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @if(isset($todos))
              @foreach ($todos as $todo)
              <tr>
                <td>{{ $todo->content }}</td>
                <td><span class="label {{$todo->getStatusClass()}}">{{ $todo->getStatusLabel()}}</span></td>
                @if(isset($todo->due_date))
                <td>{{ $todo->formatted_due_date }}</td>
                @else
                <td></td>
                @endif
                <td><a class="btn btn-primary btn-sm" href="{{ route('todos_edit_form', $todo->id) }}">編集</a></td>
                <td>
                  <form action="{{ route('todos_delete', $todo->id)}}" method="post">
                    @csrf
                    <button class="delete-action btn btn-danger btn-sm" type="submit" onclick="return confirm('削除しますか?')">削除</button>
                  </form>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

</body>

</html>