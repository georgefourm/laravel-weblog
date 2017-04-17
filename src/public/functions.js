/* global $*/
var sort_order = "desc", sort_field="last_modified",page = 1,page_size = 5;

function sort(field){
    field = $(field);
    field.toggleClass("mdl-data-table__header--sorted-descending");
    field.toggleClass("mdl-data-table__header--sorted-ascending");
    
    sort_order = field.hasClass("mdl-data-table__header--sorted-ascending")? "asc" : "desc";
    sort_field = field.data('sort');
    
    fetch();
}

function change_page(){
    if ($('#page_size').val() != "") {
        page_size = $('#page_size').val();
        fetch();
    }
}

function next(){
	page = parseInt($('#current').text()) + 1;
    fetch();
}

function previous(){
	page = parseInt($('#current').text()) - 1;
    fetch();
}

function fetch(){
    $('#progress').toggleClass('hidden');
    var params = {
    	page : page,
    	page_size : page_size,
    	sort_field : sort_field,
    	sort_order : sort_order
    };
    
    $.get(window.location+'/fetch',params)
    .done(function(data){
		paginate(data);
        populate(data);
        $('#progress').toggleClass('hidden');
    })
    .fail(function(error){
        $('#progress').toggleClass('hidden');
        toast("Error fetching logs");
    }); 
}

function populate(data){
    data = data.files.map(function(row){
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
}

function paginate(data){
	$('#current').text(data.current_page);
    var total_pages = Math.ceil(data.total/data.per_page);
    $('#total').text(total_pages);
    
    if (data.current_page == total_pages) {
    	$('#next').prop('disabled',true);
    }else{
    	$('#next').prop('disabled',false);
    }
    if (data.current_page == 1) {
    	$('#previous').prop('disabled',true);
    }else{
    	$('#previous').prop('disabled',false);
    }
}

function localize(unix){
    return (new Date(unix * 1000)).toLocaleString();
}

function humanize(bytes){
    var sizes = ['B','KB','MB','GB','TB'];
    var order = Math.floor(((bytes+"").length - 1) / 3);
    var size = order >= sizes.length ? ">1024TB" : sizes[order];
    var rounded = (bytes/Math.pow(1024,order)).toFixed(2)/1;
    return rounded+" "+size;
}

function remove(button){
    var button = $(button);
    button.prop('disabled',true);
    
    $('#progress').toggleClass('hidden');
    $.post(window.location+'/delete',{
        file:button.data('file')
    }).done(function(){
        $('#progress').toggleClass('hidden');
		fetch();
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