<?php require_once 'sections/header.php';check_login() ?>
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div class="row flex-grow-1">
            <div class="col-lg-2 col-md-3 sidebar">
                <h2 class="logo">یادداشت ها</h2>
                <div class="devider"></div>
                <div class="searchbox">
                    <form action="">
                        <a href="#"><i class="fas fa-magnifying-glass"></i></a>
                        <input type="text" placeholder="جستجو">
                    </form>
                </div>
                <?php require_once 'sections/sidebar-menu.php' ?>

                <div class="upgrade">
                    <a href="#" class=""><i class="fas fa-trophy"></i>خرید نسخه کامل</a>
                </div>
            </div>
            <div class="col-lg-10 col-md-9 content g-0">
                <div class="bg">
                    <a class="profile"><i class="fas fa-user"></i>مشاهده پروفایل</a>
                    <div class="titles">
                        <h1 class="title">سلام <?php echo getDisplay_name() ?></h1>
                        <h2 class="title">روزتو برنامه ریزی کن لذت ببر...</h2>
                    </div>
                </div>

                <div class="row mycards mx-auto">
                    <div class="col-8">
                        <div class="box notes shadow-md">
                            <h2><i class="fas fa-calendar-day"></i>خلاصه امروز</h2>
                            <ul class="list">
                                <?php
                                $notes = getUserNotes(3);
                                foreach ($notes as $note) { ?>
                                    <li><?php echo $note[1] ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="box quick-access shadow-md">
                            <h2><i class="fas fa-circle-plus"></i>یادداشت سریع</h2>
                            <form action="inc/function.php" method="POST">
                                <input name="user-note" id="" class="note" placeholder="بنویسید و enter بزنید ..."/>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
<?php require_once 'sections/footer.php' ?>