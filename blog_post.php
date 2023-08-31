<?php
session_start();
sleep(1);
if (!isset($_SESSION['favorites']))
{
    $_SESSION['favorites'] = [];
}

function is_favorite($id)
{
    return in_array($id, $_SESSION['favorites']);
}

function is_ajax_request()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

function find_blog_posts($page = 1)
{
    $firstPost = 1;
    $perPage = 3;
    $offSet = (($page - 1) * $perPage ) + 1;

    $blog_posts = [];

    for ($index = 0; $index < $perPage; $index++)
    {
        $id = $firstPost - 1 + $offSet + $index;


        $blog_post = [
            'id' => $id,
            'title' => 'Blog Post',
            'content' => ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrs standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorems Ipsum'];

        $blog_posts[] = $blog_post;
    }
    return $blog_posts;
}

if (!is_ajax_request())
{
    exit;
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$blog_post = find_blog_posts($page);
$c = 1;
foreach ($blog_post as $blog)
{
    ?>

    <div id="blog-post-<?php echo $blog['id']; ?>" class="blog-post <?php is_favorite($blog['id']) ? 'liked' : ''; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="unlike ">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
        <h2>
    <?php echo $blog['title'] . ' ' . $blog['id']; ?>
        </h2>
        <p>
    <?php echo $blog['content']; ?>
        </p>
        <button  class="click-button  <?php is_favorite($blog['id']) ? cbLike : '' ?>"> 
            <span>Like</span> <span>UnLike</span>
        </button>
    </div>
    <?php
}
 

