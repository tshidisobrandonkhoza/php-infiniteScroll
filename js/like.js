var cButton = document.querySelectorAll('.click-button');
var like_req_in_progress = false;

function favoriteBlog(blogId = '') {

    if (like_req_in_progress) {
        return;
    }
    like_req_in_progress = true;
    var req = new XMLHttpRequest();
    var url = `favorite.php`;
    req.open('POST', url, true);
    //post request
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    req.onload = () => {
        if (req.readyState === 4 && req.status === 200) {
            like_req_in_progress = false;
            var res = req.responseText;
            var bId = document.getElementById(blogId);
            if (res === 'added') {
                bId.classList.add("liked");
                // console.log(); here find the items svg and add class like
                bId.children[3].classList.add('cbLike');
            }
            if (res === 'removed') {
                bId.classList.remove("liked");
                bId.children[3].classList.remove('cbLike');
            }

        }
    };
    req.send("id=" + blogId);
}



var leng = cButton.length;

for (i = 0; i < leng; i++) {
    let c = cButton.item(i);
    c.addEventListener("click", (e) => {
        e.preventDefault();
        blogId = e.target.parentElement.id;
        favoriteBlog(blogId);
    });
}





