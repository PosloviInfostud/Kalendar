$(".tag-buttons").click(function(e){
    e.preventDefault();
    tagId = e.target.id;
    $.ajax({
        method: "POST",
        url: "/tags/"+tagId,
        // data: {id: tagId}
    })
    .done(function(data) {
        $("#posts").empty();
        let response = JSON.parse(data);
        response.posts.forEach(function(entry) {
            $("#posts").append('<li><a href="/posts/'+entry.id+'">'+entry.title+'</a></li>');
        });
    })
})