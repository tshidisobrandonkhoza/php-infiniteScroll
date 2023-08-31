<?php
session_start();

$_SESSION['favorites'] = [];
if (!isset($_SESSION['favorites']))
{
    $_SESSION['favorites'] = [];
}

function is_favorite($id)
{
    return in_array($id, $_SESSION['favorites']);
}
?>
<!DOCTYPE html> 
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
                <!--<script id="thisSrc" type="text/javascript" src="like.js"></script>-->
        <style>
            *{
                margin: 0;
                padding: 0;
            }
            .blog-post{
                margin: auto;
                position: relative;
                width: 70%;
                height: auto;
                border-bottom: 2px solid #666666;
            }

            .blog-post h2{
                display: block;
                margin: 1rem;
            }

            .blog-post p{
                display: block;
                margin: 1rem;
            }

            .blog-post .click-button{
                display: block;
                margin: 1rem;
                padding: .5rem  1rem;
                border-radius: 2rem;
                background-color: #ff6666;
                color: #fff; 
            }
            .click-button span{
                pointer-events: none;
                width: 100%;
                height: 100%;
            }
            .click-button span{
                display: block;
            }
            .click-button span:last-child{
                display: none;
            }
            .cbLike span:first-child{
                display: none;
            }
            .cbLike span:last-child{
                display: block;
            }
            /*           
            */

            .unlike{
                position: absolute;
                right: 2rem;
                width: 2rem;

                height: 2rem; 
            }

            .liked svg{
                position: absolute;
                right: 2rem;
                width: 2rem;

                height: 2rem;
                fill: red;
                color: red;
            } 

            #spinners {
                display: none;
                margin: 2rem auto;
                text-align: center;
            }
            #spinners img{

                width: 1rem;
                animation:  anime 4s infinite; 
                transition: all .1s linear;
            }
            @keyframes anime{
                to{
                    transform: rotate(3600deg);
                }
            }

            #load_more{
                /*display: none;*/
            }
            .load_more{

                margin: 2em auto;
                text-align: center; 
                background-color: #ff6666;
                width: 6rem;
                padding: 1rem .5rem;
                color: #fff;
                border-radius: 1rem;
            }
        </style>
    </head>

    <body>   
        <div id="blog-posts">




        </div>
        <div id="spinners">
            <img src="icon-spinner.png">
        </div>
        <div id="load_more"  data-page="0" class="load_more">
            Load More
        </div>
        <!--<script id="my-element" type="text/javascript" src="like.js"></script>-->
        <script type="text/javascript">
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


                reloadJs("like.js");
            }


            function reloadJs(src) {

                var cButt = document.querySelectorAll('.click-button');


                var myEle = document.querySelector("#my-element");
                if (myEle == null) {
                    console.log('like dont exist');

                    var head = document.getElementsByTagName('body')[0];
                    var scrip = document.createElement('script');
                    scrip.setAttribute('id', 'my-element');
                    scrip.src = src;
                    head.appendChild(scrip);
                } else {

                    myEle.remove();

                    var leng = cButt.length;
                    console.log(leng);
                    for (i = 0; i < leng; i++) {
                        //    console.log(cButton.item(i));
                        let c = cButt.item(i);
                   
                        c.removeEventListener("click", (e) => {
     console.log('event gone' + i);
                            //       blogId = e.target.parentElement.id;
                            //favoriteBlog(blogId);
                        });
                    }


                    console.log('liked added');
                }

                if (myEle == null) {
                    console.log('like dont exist double check'+ myEle);

                } else {
                    console.log('dlike added');


                }







//  src = $('script[src$="' + src + '"]').attr("src");
                //  $('script[src$="' + src + '"]').remove();
                //   $('<script/>').attr('src', src).appendTo('head');
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
                        //   console.log('Results : ' + contResults);
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
//                console.log("Blog Post Offset Height : " + container.offsetHeight);
                let contentY = window.innerHeight + window.pageYOffset;
                let scrollY = load_more.offsetTop;
                //       console.log("Inner Height + Page Y Offset : " + contentY);
                //       console.log("Page Y Offset :  " + window.pageYOffset);
                //         console.log(" Load More Offset Top : " + (scrollY));

                if (contentY >= contentHeight) {
                    loadMore();
                }

            }


            window.onscroll = () => {
                scrollReact();
            }



        </script>

    </body>
</html>
