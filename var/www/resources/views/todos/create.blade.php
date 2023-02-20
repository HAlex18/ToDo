<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
  <title>ToDo App</title>
</head>

<body>
  @include('header')
  <main>
    <div class="container">
      <div class="row">
        <div class="col col-md-offset-3 col-md-6">
          <nav class="panel panel-default">
            <div class="panel-heading">タスク追加</div>
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

              <form action="{{ route('todos_create', $current_folder_id)}}" method="post">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $current_folder_id }}">
                <div class="form-group">
                  <label for="content">内容</label>
                  <input type="text" class="form-control" name="content" id="content" value="{{ old('content') }}">
                </div>
                <div class="form-group">
                  <label for="due_date">期限</label>
                  <input type="date" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') }}">
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

  <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
  <script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
  <script>
    flatpickr(document.getElementById('due_date'), {
      locale: 'ja',
      dateFormat: "Y/m/d",
      minDate: new Date()
    });
  </script>

</body>

</html>