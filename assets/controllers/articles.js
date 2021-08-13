$(function () {
    const articles = $("#articles");

    if(articles){
        articles.on("click",(e)=>{
            if(e.target.className === "btn btn-danger delete-article"){
                const article_id = e.target.getAttribute("data-article-id");

                //fetch request to BE
                fetch(`/article/delete/${article_id}`,{
                    method:'DELETE'
                }).then(res => window.location.reload());
            }
        });
    }
});