$("#new-category").change(function(){
    $newCategory = $( "#new-category option:selected" ).text();
    if($newCategory=="Koszulki"){
        $("#form-sizes").removeClass("hide");
    }else{
        $("#form-sizes").addClass("hide");
    }
});

$('#date-checkbox').change(function() {
    $('#news-date').toggleClass('hide');
});