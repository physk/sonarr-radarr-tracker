$(document).ready(function() {
    function parseData( data ) {
        var searchDOM = [];
        
        $.each( data.items, function( i, item ) {
            if(item.got == true){
                var colour = "bg-success";
                var quality = item.quality;
            }
            else {
                if(item.grabbed == true){
                    var colour = "bg-warning";
                    var quality = "In Download Queue";
                }
                else {
                    var colour = "bg-danger";
                    var quality = "Not Found Download/Not Available Yet";
                }
            }
            searchDOM.push("<tr>");
            searchDOM.push("    <td>" + item.title + "</td>");
            searchDOM.push("    <td>");
            searchDOM.push("        <div class=\"progress episode-progress\">");
            searchDOM.push("            <span class=\"progressbar-back-text " + colour + "\">"+ quality + "</span>");
            searchDOM.push("        </div>");
            searchDOM.push("    </td>");
            searchDOM.push("</tr>");
        });
        return searchDOM;
    };
    function initJSON() {
        $.getJSON("api.php", {type: "movies", "q": this.val()})
        .done(function( data ) {
            if(data.return == true){
                var domArray = parseData( data );
                var bodyContent = domArray.join( "\n" );
                $("#content").find('tbody').empty().append(bodyContent);
            }
            else if(data.return && data.items == null)
            {
                $("#content").find('tbody').empty().append("<tr class=\"search-sf\"><td class=\"text-muted\" colspan=\"6\">No entries found.</td></tr>");
            }
            else {
                $("#content").find('tbody').empty().append("<tr class=\"search-sf\"><td class=\"text-muted\" colspan=\"6\">An Error occurred.</td></tr>");
            }
        });
    }
    //something is entered in search form
    $('#system-search').keyup( function() {
        initJSON();
    });
    initJSON();
});