<?php
session_start();
include_once 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIU PSP</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/problem_panel.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Concert One' rel='stylesheet'>
</head>

<body>
    <div class="profile">
        <div class="profile-container">
            <div class="back-page">
                <a href="index.php"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="card-body">

                <?php
                $getPblmPostSql = mysqli_query($connection, "SELECT * FROM problem_asked WHERE problem_id = '{$_GET['post_id']}'");
                $pblmPostInfo = mysqli_fetch_assoc($getPblmPostSql);
                $pCourseTitle = mysqli_fetch_assoc(mysqli_query($connection, "SELECT course_title FROM course WHERE course.course_code = '{$pblmPostInfo['course_code']}'"));
                ?>

                <div class="problem-details">
                    <h4 class="card-title"><?php echo $pblmPostInfo['title'] ?></h4>
                    <p class="card-text"><?php echo $pblmPostInfo['description'] ?></p>
                    <div class="images">
                        <?php
                        $pblm_imgSql = mysqli_query($connection, "SELECT * FROM pblm_img WHERE pblm_img.problem_id  = '{$_GET['post_id']}'");
                        while ($piRow = mysqli_fetch_assoc($pblm_imgSql)) {
                            echo '<img class="img-fluid" src="resources/pblm-imgs/' . $piRow['img_name'] . '" alt="">';
                        }

                        ?>
                    </div>
                </div>
                <div class="related-topics">
                    <ul class="nav nav-pills nav-fill">
                        <li>Related:</li>
                        <li class="course"><?php echo $pCourseTitle['course_title'] ?></li>
                        <li class="arrow"><i class="fa fa-long-arrow-right"></i></li>
                        <li class="topic"><?php echo $pblmPostInfo['topic_name'] ?></li>
                    </ul>
                    <div class="menu">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#delete">Delete</button>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#edit">Edit</button>
                    </div>

                    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body" style="color: #000;">
                                    Are you sure, you want to delete it?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="count-bar">
                    <ul class="">
                        <li class="like">
                            <i class="fa fa-thumbs-o-up"></i>
                            19
                        </li>
                        <li class="dislike">
                            <i class="fa fa-thumbs-o-down"></i>
                            08
                        </li>
                        <li>Views: <?php echo $pblmPostInfo['views'] ?></li>
                        <li>Solutions: 03</li>
                    </ul>
                    <p><small class="text-muted">Posted by <a href="#">
                                <?php
                                $userName = mysqli_fetch_assoc(mysqli_query($connection, "SELECT name FROM users WHERE users.student_id   = '{$pblmPostInfo['student_id']}'"));

                                echo $userName['name'] . " </a>";
                                $ftime = mysqli_fetch_assoc(mysqli_query($connection, "SELECT TIMEDIFF(CURRENT_TIMESTAMP(),'{$pblmPostInfo['last_modified']}') as difTime"));
                                $splitedTime = explode(":", $ftime['difTime']);
                                if ($splitedTime[0] == "00" && $splitedTime[1] == "00") {
                                    echo intval($splitedTime[2]) . "sec ago";
                                } else if ($splitedTime[0] == "00" && $splitedTime[1] != "00") {
                                    echo intval($splitedTime[1]) . "min ago";
                                } else if (intval($splitedTime[0]) < 24) {
                                    echo intval($splitedTime[0]) . "h ago";
                                } else {
                                    echo intval($splitedTime[0]) / 24 . "days ago";
                                }
                                // echo $ftime['difTime'] . "mins ago";
                                
                                ?>
                        </small></p>
                </div>
                <div class="comment-section">
                    <div class="comment-texts">
                        <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want to
                            use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">erutcerituhurghdfugchfdiugchsriugcthcwerigthrsughsiu ugcroigurgb
                            grfgvrhtgvurtg rgvnfgthvjvrpogi sog jewsrgiweoig w wtweigtweorgt ijs oigjsdpofgjspoigjsoidg
                            sg gsdgisd sdgisdjsb srbjsogihjs bfgbfsdgobhfgo hsoifdbjfsoib jsfi sghsjb Yeah! To use this
                            cheat sheet, simply find the icon you want to use <small class="commented-by"> - <a
                                    href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want to
                            use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want to
                            use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want to
                            use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want to
                            use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want to
                            use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you want
                            to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                        <p class="individual-comment">this cheat to use this cheat sheet, simply find the icon you want
                            to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                    </div>
                    <div class="comment-input">
                        <input type="text" class="form-control" id="problem-comment"
                            placeholder="Write a comment here...">
                        <button type="btn submit"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>



            <!-- ===================== ANSWER ======================================================================= -->


            <div class="card-body answer-section">
                <div class="post-answer">
                    <h2 class="card-title">Answers</h2>
                    <button type="button" class="btn post-ans" data-bs-toggle="modal" data-bs-target="#postAnswer">Post
                        Your Answer</button>

                    <div class="modal fade" id="postAnswer" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Post Your Answer</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="answer_post_form" enctype="multipart/form-data" action="#"
                                        autocomplete="off">
                                        <?php
                                        echo '<input class="visually-hidden" type="text" name="problem_id"
                                        value="' . $_GET['post_id'] . '">';
                                        ?>
                                        <div class="form-floating" style="overflow: hidden;">
                                            <div class="cover"
                                                style="border-radius: 5px;position: absolute; top: 0px; height: 25px; width: calc(100% - 2px); margin: 1px 1px 0; background-color: #fff; z-index: 10;">
                                            </div>
                                            <textarea class="form-control" name="description"
                                                placeholder="Leave a comment here" id="floatingTextarea2"
                                                style="min-height: 150px;"></textarea>
                                            <label for="floatingTextarea2" style="z-index: 100;">Write you answer
                                                here...</label>
                                        </div>
                                        <div class="mt-2">
                                            <label class="form-label text-dark" style="margin:0 0 0 1px;"
                                                for="profilePic">Select the pictures/screenshots (only png, jpg,
                                                jpeg)</label>
                                            <input type="file" multiple name="solution_img[]" class="form-control"
                                                id="profilePic" placeholder="">
                                        </div>
                                        <br>

                                        <!-- <div class="buttons">
                                            <button type="submit" class="btn btn-primary">Sign up</button>
                                            <a href="/Student_Hub/login.php" class="btn btn-success">Go back to Login</a>
                                        </div> -->

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn custom-btn-sec"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn custom-btn answer-post-btn">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="card-body individual-solution">
                    <h4 style="border-bottom: 1px solid #333; padding: 0 0 5px 10px;">#1</h4>
                    <div class="Solution-details">
                        <p class="card-text">As effective as content marketing is, it can be tricky. Content marketing
                            writers need to be able to rank highly in search engine results while also engaging people
                            who will read the material, share it, and interact further with the brand. When the content
                            is relevant, it can establish strong relationships throughout the pipeline.

                            To create effective content that’s highly relevant and engaging, it’s important to identify
                            your audience. Who are you ultimately trying to reach with your content marketing efforts?
                            Once you have a better grasp of your audience, you can determine the type of content you'll
                            create. You can use many formats of content in your content marketing, including videos,
                            blog posts, printable worksheets, and more.

                            Regardless of which content you create, it’s a good idea to follow content marketing best
                            practices. This means making content that’s grammatically correct, free of errors, easy to
                            understand, relevant, and interesting. Your content should also funnel readers to the next
                            stage in the pipeline, whether that’s a free consultation with a sales representative or a
                            signup page.
                        </p>
                        <div class="images visually-hidden">
                            <img src="resources/prob-img/prob-img-1.png" alt="">
                            <img src="resources/prob-img/prob-img-2.png" alt="">
                            <img src="resources/prob-img/prob-img-3.png" alt="">
                        </div>
                    </div>
                    <div class="related-topics">
                        <div class="reward-option">
                            <ul class="nav nav-pills nav-fill">
                                <li class="reward">
                                    <p>If your problem is solved by this answer, then you are requested to reward him by
                                        giving a star</p>
                                </li>
                                <li class="arrow"><i class="fa fa-long-arrow-right"></i></li>
                                <li class="star"><i class="fa fa-star-o"></i></li>
                            </ul>
                        </div>
                        <div class="menu">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#AnswerDelete">Delete</button>
                            <button type="button" class="btn btn-outline-primary visually-" data-bs-toggle="modal"
                                data-bs-target="#AnswerEdit">Edit</button>
                        </div>

                        <div class="modal fade" id="AnswerDelete" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body" style="color: #000;">
                                        Are you sure, you want to delete it?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="AnswerEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Your Answer</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="signup_form" action="#" autocomplete="off">


                                            <div class="form-floating mb-3">
                                                <input type="text" name="title" class="form-control" id="problemTitle"
                                                    placeholder="Name" required>
                                                <label for="problemTitle">Title</label>
                                            </div>
                                            <div class="form-floating" style="overflow: hidden;">
                                                <div class="cover"
                                                    style="border-radius: 5px;position: absolute; top: 0px; height: 20px; width: calc(100% - 2px); margin: 1px 1px 0; background-color: #fff; z-index: 10;">
                                                </div>
                                                <textarea class="form-control" placeholder="Leave a comment here"
                                                    id="floatingTextarea2" style="min-height: 100px;"></textarea>
                                                <label for="floatingTextarea2" style="z-index: 100;">Description</label>
                                            </div>




                                            <div class="mt-2">
                                                <label class="form-label text-dark" style="margin:0 0 0 1px;"
                                                    for="profilePic">Select the pictures/screenshots (only png, jpg,
                                                    jpeg)</label>
                                                <input type="file" multiple class="form-control" id="profilePic"
                                                    placeholder="">
                                            </div>
                                            <br>

                                            <!-- <div class="buttons">
                                            <button type="submit" class="btn btn-primary">Sign up</button>
                                            <a href="/Student_Hub/login.php" class="btn btn-success">Go back to Login</a>
                                        </div> -->

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn custom-btn-sec"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn custom-btn">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="count-bar">
                        <ul class="">
                            <li class="like">
                                <i class="fa fa-thumbs-o-up"></i>
                                19
                            </li>
                            <li class="dislike">
                                <i class="fa fa-thumbs-o-down"></i>
                                08
                            </li>
                        </ul>
                        <p><small class="text-muted">answered by <a href="#">username</a> 3 mins ago</small></p>
                    </div>
                    <div class="comment-section">
                        <div class="comment-texts">
                            <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want
                                to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">this cheat to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                        </div>
                        <div class="comment-input">
                            <input type="text" class="form-control" id="problem-comment"
                                placeholder="Write a comment here...">
                            <button type="btn submit"><i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>


                </div>

                <div class="card-body individual-solution">
                    <h4 style="border-bottom: 1px solid #333; padding: 0 0 5px 10px;">#2</h4>

                    <div class="Solution-details">
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to additional content. This content is a little bit longer. This is a
                            wider card with
                            supporting text below as a natural
                            lead-in to additional content. This content is a little bit longer.
                        </p>
                        <div class="images">
                            <img class="img-fluid" src="resources/prob-img/prob-img-1.png" alt="">
                            <img class="img-fluid" src="resources/prob-img/prob-img-2.png" alt="">
                            <img class="img-fluid" src="resources/prob-img/prob-img-3.png" alt="">
                        </div>
                    </div>
                    <div class="related-topics">
                        <ul class="nav nav-pills nav-fill">
                            <li class="reward">
                                <p>If your problem is solved by this answer, then you are requested to reward him by
                                    giving a star</p>
                            </li>
                            <li class="arrow"><i class="fa fa-long-arrow-right"></i></li>
                            <li class="star"><i class="fa fa-star-o"></i></li>
                        </ul>
                        <div class="menu">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#AnswerDelete">Delete</button>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#AnswerEdit">Edit</button>
                        </div>

                        <!-- <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body" style="color: #000;">
                                        Are you sure, you want to delete it?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->



                    </div>
                    <div class="count-bar">
                        <ul class="">
                            <li class="like">
                                <i class="fa fa-thumbs-o-up"></i>
                                19
                            </li>
                            <li class="dislike">
                                <i class="fa fa-thumbs-o-down"></i>
                                08
                            </li>
                        </ul>
                        <p><small class="text-muted">answered by <a href="#">username</a> 3 mins ago</small></p>
                    </div>
                    <div class="comment-section">
                        <div class="comment-texts">
                            <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want
                                to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">this cheat to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                        </div>
                        <div class="comment-input">
                            <input type="text" class="form-control" id="problem-comment"
                                placeholder="Write a comment here...">
                            <button type="btn submit"><i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>


                </div>
                <div class="card-body individual-solution">
                    <h4 style="border-bottom: 1px solid #333; padding: 0 0 5px 10px;">#3</h4>

                    <div class="Solution-details">
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to additional content. This content is a little bit longer. This is a
                            wider card with
                            supporting text below as a natural
                            lead-in to additional content. This content is a little bit longer.
                        </p>
                        <div class="images visually-hidden">
                            <img src="resources/prob-img/prob-img-1.png" alt="">
                            <img src="resources/prob-img/prob-img-2.png" alt="">
                            <img src="resources/prob-img/prob-img-3.png" alt="">
                        </div>
                    </div>
                    <div class="related-topics">
                        <ul class="nav nav-pills nav-fill">
                            <li class="reward">
                                <p>If your problem is solved by this answer, then you are requested to reward him by
                                    giving a star</p>
                            </li>
                            <li class="arrow"><i class="fa fa-long-arrow-right"></i></li>
                            <li class="star"><i class="fa fa-star-o"></i></li>
                        </ul>
                        <div class="menu">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#AnswerDelete">Delete</button>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#AnswerEdit">Edit</button>
                        </div>

                        <!-- <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body" style="color: #000;">
                                        Are you sure, you want to delete it?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->



                    </div>
                    <div class="count-bar">
                        <ul class="">
                            <li class="like">
                                <i class="fa fa-thumbs-o-up"></i>
                                19
                            </li>
                            <li class="dislike">
                                <i class="fa fa-thumbs-o-down"></i>
                                08
                            </li>
                        </ul>
                        <p><small class="text-muted">answered by <a href="#">username</a> 3 mins ago</small></p>
                    </div>
                    <div class="comment-section">
                        <div class="comment-texts">
                            <p class="individual-comment">Yeah! To use this cheat sheet, simply find the icon you want
                                to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small></p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">simply find to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                            <p class="individual-comment">this cheat to use this cheat sheet, simply find the icon you
                                want to use <small class="commented-by"> - <a href="#">username</a> 2 min ago</small>
                            </p>
                        </div>
                        <div class="comment-input">
                            <input type="text" class="form-control" id="problem-comment"
                                placeholder="Write a comment here...">
                            <button type="btn submit"><i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>


                </div>


            </div>



        </div>
    </div>



    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="javascript/problem_panel.js"></script>
</body>

</html>