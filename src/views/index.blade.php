@extends('weblog::layout')

@section('content')
<div class="md-cell mdl-cell--6-col mdl-cell--3-offset">
    <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp full-width">
      <thead>
        <tr>
          <th class="mdl-data-table__header--sorted-descending" data-sort = "filename">Filename</th>
          <th class="mdl-data-table__header--sorted-descending" data-sort = "size">Size</th>
          <th class="mdl-data-table__header--sorted-descending" data-sort = "updated">Last Modified</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($files as $file)
            <tr class="data-row">
                <td class="mdl-data-table__cell--non-numeric">
                    <a href="logs/show?file={{$file['filename']}}" class="link">
                        {{$file['filename']}}
                    </a>
                </td>
                <td>{{$file['size']}}</td>
                <td class="timestamp">{{$file['updated']}}</td>
                <td>
                    <a class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent"
                        href="logs/download?file={{$file['filename']}}">
                        Download
                    </a>
                </td>
                <td>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent delete"
                            data-file="{{$file['filename']}}">
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
<div id="toast" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
@endsection
@push('scripts')
    <script>
    /* global $*/
        $(document).ready(function(){
            $('.timestamp').each(function(el){
                el = $(this);
                el.text((new Date(el.text() * 1000)).toLocaleString());
            });
            $('.delete').on('click',function(el){
                var button = $(this);
                button.prop('disabled',true);
                $.post(window.location+'/delete',{
                    file:button.data()
                }).done(function(){
                    button.closest('.data-row').remove();
                    var data = {message: 'Log Deleted'};
                    document.querySelector('#toast').MaterialSnackbar.showSnackbar(data);
                }).fail(function(error){
                    button.prop('disabled',false);
                    var data = {message: 'Error deleting log'};
                    document.querySelector('#toast').MaterialSnackbar.showSnackbar(data);
                });
            });
        });
    </script>
@endpush