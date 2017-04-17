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
      <tfoot>
        <tr>
            <td>
                Page Size:
                <select>
                    <option value="10">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <button class="mdl-button mdl-js-button" onclick="previous()" id="previous">
                  <i class="material-icons">keyboard_arrow_left</i>
              </button>
                Page <span id="current">0</span>/<span id="total">0</span>
              <button class="mdl-button mdl-js-button" onclick="next()" id="next">
                  <i class="material-icons">keyboard_arrow_right</i>
              </button>
            </td>
        </tr>
      </tfoot>
    </table>
</div>
<div id="toast" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button">OK</button>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="/vendor/weblog/functions.js"></script>
<script>
  $(document).ready(function(){ fetch(); });
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
            </td>
            <td>
                <a class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent"
                    href="logs/download?file=@{{:filename}}">
                    Download
                </a>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent delete"
                        data-file="@{{:filename}}" onclick="remove(this)">
                    Delete
                </button>
            </td>
        </tr>
    </script>
@endpush