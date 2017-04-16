@extends('weblog::layout')

@section('content')
<div class="md-cell mdl-cell--6-col mdl-cell--3-offset">
    <div id="progress" class="mdl-progress mdl-js-progress mdl-progress__indeterminate full-width hidden"></div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
      <thead>
        <tr>
          <th class="mdl-data-table__header--sorted-descending" data-sort = "filename" onclick="sort(this)">Filename</th>
          <th class="mdl-data-table__header--sorted-descending" data-sort = "size" onclick="sort(this)">Size</th>
          <th class="mdl-data-table__header--sorted-descending" data-sort = "last_modified" onclick="sort(this)">Last Modified</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
</div>
<div id="toast" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button">OK</button>
</div>
@endsection
@push('scripts')
    <script>
    /* global $*/
        $(document).ready(function(){
            fetch();
        });
        
        function sort(field){
            field = $(field);
            field.toggleClass("mdl-data-table__header--sorted-descending");
            field.toggleClass("mdl-data-table__header--sorted-ascending");
            
            var order = field.hasClass("mdl-data-table__header--sorted-ascending")? "asc" : "desc";
            fetch({
                sort_field : field.data('sort'),
                sort_order : order
            });
        }
        
        function fetch(params){
            $('#progress').toggleClass('hidden');
            $.get(window.location+'/fetch',params || {})
            .done(function(data){
                data = data.map(function(row){
                    return {
                        filename : row.filename,
                        last_modified : localize(row.last_modified),
                        size : humanize(row.size)
                    };
                });
                
                var template = $.templates("#row-template");
                template = template.render(data);
                $('tbody').empty();
                $('tbody').append(template);
                
                $('#progress').toggleClass('hidden');
            })
            .fail(function(error){
                $('#progress').toggleClass('hidden');
                toast("Error fetching logs");
            }); 
        }
        
        function localize(unix){
            return (new Date(unix * 1000)).toLocaleString();
        }
        
        function humanize(bytes){
            var sizes = ['B','KB','MB','GB','TB'];
            var order = Math.floor(((bytes+"").length - 1) / 3);
            var size = order >= sizes.length ? ">1024TB" : sizes[order];
            var rounded = (bytes/Math.pow(1024,order)).toFixed(2);
            return rounded+""+size;
        }
        
        function remove(button){
            var button = $(button);
            button.prop('disabled',true);
            
            $('#progress').toggleClass('hidden');
            $.post(window.location+'/delete',{
                file:button.data('file')
            }).done(function(){
                button.closest('.data-row').remove();
                $('#progress').toggleClass('hidden');
                toast("Log deleted");
            }).fail(function(error){
                button.prop('disabled',false);
                $('#progress').toggleClass('hidden');
                toast("Error deleting file");
            });
        }
        function toast(message){
            var data = {message: message};
            document.querySelector('#toast').MaterialSnackbar.showSnackbar(data);
        }
    </script>
    
    <script id="row-template" type="text/x-jsrender">
        <tr class="data-row">
            <td class="mdl-data-table__cell--non-numeric">
                <a href="logs/show?file=@{{:filename}}" class="link">
                    @{{:filename}}
                </a>
            </td>
            <td>@{{:size}}</td>
            <td class="timestamp">@{{: last_modified}}</td>
            <td>
                <a class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent"
                    href="logs/download?file=@{{:filename}}">
                    Download
                </a>
            </td>
            <td>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent delete"
                        data-file="@{{:filename}}" onclick="remove(this)">
                    Delete
                </button>
            </td>
        </tr>
    </script>
@endpush