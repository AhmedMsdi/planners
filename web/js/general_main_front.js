$(document).ready(function () {
    $('body').on('click','.search_categ',function(){
        var idcateg=$(this).attr('idcateg');
        $('#search_categ').val(idcateg);
        $(".search_categ").each(function(){
            $(this).removeClass('active');
        });
    });

    $('body').on('change','#liste_trie',function(){
        search_ajax_event();
    });
    $('body').on('keyup','#search_prix ,#search_ville',function(){
        search_ajax_event();
    });
    $('body').on('click','.search_categ',function(){
        var idcateg=$(this).attr('idcateg');
        $('#search_categ').val(idcateg);
        $(".search_categ").each(function(){
            $(this).removeClass('active');
        });
        $(this).addClass('active');
        search_ajax_event()
    });
});
function search_ajax_event(){
    var search_categ=$('#search_categ').val();
    var search_ville=$('#search_ville').val();
    var search_prix=$('#search_prix').val();
    var liste_trie=$('#liste_trie').val();
    var url=$('#element_search').attr('searchurl');
    $.ajax({
        url: url,
        type: 'GET',
        data:"search_ville="+search_ville+"&search_prix="+search_prix+"&search_categ="+search_categ+"&liste_trie="+liste_trie,
        beforeSend: function (xhr) {
        },
        success: function (html) {
            $('#div_all_event').html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}
function load_menu_event(url){
    $.ajax({
        url: url,
        type: 'GET',
        success: function (html) {
            $('#list_menu_event').html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}