$(document).ready(function() {
    function parseData( data ) {
        var searchDOM = [];
        
        $.each( data.items, function( i, item ) {
            if(item.total >= 1){
                var percent = (item.got / item.total) * 100;
            } else {
                var percent = 0;
            }
            var percent = percent.toFixed(2);
            if(percent == 100) {
                var colour = "bg-success";
            } else if (percent < 100 && percent > 50) {
                var colour = "bg-warning";
            } else {
                var colour = "bg-danger";
            }
            searchDOM.push("<tr>");
            searchDOM.push("    <td>" + item.title + "</td>");
            searchDOM.push("    <td>");
            searchDOM.push("        <div class=\"progress episode-progress\">");
            searchDOM.push("            <span class=\"progressbar-back-text\">"+ item.got + " / " + item.total + "</span>");
            searchDOM.push("            <div class=\"progress-bar " + colour + "\" role=\"progressbar\" style=\"width:" + percent + "%\" aria-valuenow=\"" + percent + "\" aria-valuemin=\"0\" aria-valuemax=\"100\">");
            searchDOM.push("                <span class=\"progressbar-front-text\">"+ item.got + " / " + item.total + "</span>");
            searchDOM.push("            </div>");
            searchDOM.push("        </div>");
            searchDOM.push("    </td>");
            searchDOM.push("    <td>" + percent + "%</td>");
            searchDOM.push("</tr>");
        });
        return searchDOM;
    };
    function initJSON( query ) {
        $.getJSON("api.php", {type: "tv", "q": query})
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
        initJSON( this.value );
    });
    initJSON("");
});