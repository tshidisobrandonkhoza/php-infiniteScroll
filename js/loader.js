var container = document.querySelector('#blog-posts');
var load_more = document.querySelector('#load_more');
var spinners = document.querySelector('#spinners');
var req_in_progress = false;
function appendDiv(blogC, blogResults) {



    var temp = document.createElement('div');
    temp.innerHTML = blogResults;

    //find the class name
    var class_Name = temp.firstElementChild.className;
    var class_N = '.' + class_Name;
    //find the elements that have that class name       
    var items = temp.querySelectorAll(class_N);


    var len = items.length;

    for (i = 0; i < len; i++) {
        blogC.appendChild(items[i]);
    }


    reloadJs("js/like.js");
}
function reloadJs(src) {

    var cButt = document.querySelectorAll('.click-button');


    var myEle = document.querySelector("#myElement");
    if (myEle == null) {
        console.log('like dont exist');

        var head = document.getElementsByTagName('body')[0];
        var scrip = document.createElement('script');
        scrip.setAttribute('id', 'myElement');
        scrip.src = src;
        head.appendChild(scrip);
    } else {

        myEle.remove();



        var head = document.getElementsByTagName('body')[0];
        var scrip = document.createElement('script');
        scrip.setAttribute('id', 'myElement');
        scrip.src = src;
        head.appendChild(scrip);
    }


}
function  loadMore() {
    if (req_in_progress) {
        return;
    }
    req_in_progress = true;
    var cont = document.querySelector('#blog-posts');
    spinners.style.display = 'block';
    load_more.style.display = 'none';

    var page = parseInt(load_more.getAttribute('data-page'));
    var npage = page + 1;
    var xhr = new XMLHttpRequest();
    var url = 'blog_post.php?page=' + npage;
    xhr.open('GET', url, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var contResults = xhr.responseText;
            spinners.style.display = 'none';
            //append results
            load_more.setAttribute('data-page', npage);
            appendDiv(cont, contResults);

            load_more.style.display = 'block';
            req_in_progress = false;
        }
    };
    xhr.send();
}

load_more.addEventListener('click', loadMore);

//on scroll load
function scrollReact() {
    let contentHeight = container.offsetHeight;
    let contentY = window.innerHeight + window.pageYOffset;
    let scrollY = load_more.offsetTop;

    if (contentY >= contentHeight) {
        loadMore();
    }
}
window.onscroll = () => scrollReact();

