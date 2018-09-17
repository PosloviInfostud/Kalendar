$(".tag-buttons").click(function(e){
    e.preventDefault();
    tagId = e.target.id;
    $.ajax({
        method: "POST",
        url: "/tags/"+tagId,
        // data: {id: tagId}
    })
    .done(function(data) {
        let response = JSON.parse(data);
        response.posts.forEach(function(entry) {
            $("#posts").append("<li>"+entry.title+"</li>");
            console.log(entry);
        });
        // console.log(response.posts);
    })
})
