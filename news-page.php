<?php
session_start();
require_once './connect/connect.php';
include './utill/Class.tour.php';
include './utill/Class.address.php';
include './utill/Class.type.php';
include './utill/Image.php';
?>
<?php $title = 'News' ?>
<?php include 'inc/header.php'; ?>
<section class="news">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 news-highlight">
                <?php
                $check = 0;
                if (isset($_GET['addressId'])) {
                    $list = Address::find($_GET['addressId']);
                    $check = 1;
                    $category = $list->name;
                    $list = new Address($list);
                    $tours = $list->getTour();
                } else if (isset($_GET['typeId'])) {
                    $list = Type::find($_GET['typeId']);
                    $category = $list->name;
                    $list = new Type($list);
                    $tours = $list->getTour();
                    $check = 1;
                } else if (isset($_GET['dayTour'])) {
                    $check = 1;
                    $tours = Tour::findByDay($_GET['dayTour']);
                    $category = $_GET['dayTour'] . " days";
                }
                if (check == 0) {
                    include './_content.php';
                } else {
                    ?>

                    <div class="row center">
                        <div class="col-lg-12">
                            <div class="new-title-bar center">
                                <div class="title-bar">
                                    <span style="text-transform: uppercase;"><?php echo "TAG: " . $category; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                        foreach ($tours as $tour) {
                            $tour = new Tour($tour);

                            $url = "tour.php?tourId=" . $tour->id;
                            $img = Image::getImage($tour->image);
                            ?>
                            <div class="new-single col-lg-12">
                                <div class="new-single-image">
                                    <a href="<?php echo $url; ?>">
                                        <img src="<?php echo $img; ?>" class="image-responsive" alt="">
                                    </a>
                                </div>
                                <div class="new-single-header">
                                    <h2 class="main-title">
                                        <a href="<?php echo $url; ?>" class=""><?php echo $tour->name; ?></a>
                                    </h2>
                                    <div class="time-new-single">
                                        <span class="price">FROM: <span><?php echo $tour->price->f1t2 . "$  "; ?></span> </span><br>  
                                        <i class="fa fa-clock-o"></i> <a href="news-page.php?dayTour=?<?php echo $tour->dayTour; ?>"><?php echo $tour->dayTour; ?> Days</a> &nbsp;&nbsp;
                                        <i class="fa fa-map-marker"></i>
                                        <?php
                                        $addressList = $tour->getAddress();
                                        foreach ($addressList as $address) {
                                            ?>
                                            <a href="news-page.php?addressId=<?php echo $address->id ?>"><?php echo $address->name . ", " ?></a>
                                        <?php } ?>


                                    </div>
                                    <div class="new-single-content">
                                        <?php echo $tour->info; ?>
                                    </div>
                                    <div class="new-single-more">
                                        <a href="<?php echo $url ?>">continue reading</a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                     ?>
                </div>
                <?php }?>

            </div>
            <div class="col-lg-4 col-md-4 slide-right">
                <h4 class="new-recent-title" style="margin-bottom: 1.5em;">
                    <span>RECENT SEARCH</span>
                </h4>
                <div class="new-right">
                    <div id="block-views-recent-news-block" class="block block-views box_skin">
                        <div class="content">
                            <div class="view-recent-survey block clearfix center">
                                <div class="view-header">
                                    <h2>Destination</h2>
                                    <div class="menu-tag">
                                        <ul>
                                            <?php
                                            $addressList = Address::findAll();
                                            foreach ($addressList as $address) {
                                                ?>
                                                <li><a href="news-page.php?addressId=<?php echo $address->id; ?>" class="menu-tag-item"><?php echo $address->name; ?></a></li>
                                            <?php } ?>

                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class=" new-right">
                    <div id="block-views-recent-news-block" class="block block-views box_skin">
                        <div class="content">
                            <div class="view-recent-survey block clearfix center">
                                <div class="view-header">
                                    <h2>Type</h2>
                                    <div class="menu-tag">
                                        <ul>
                                            <?php
                                            $typeList = Type::findAll();

                                            foreach ($typeList as $type) {
                                                ?>
                                                <li><a href="news-page.php?typeId=<?php echo $type->id; ?>" class="menu-tag-item"><?php echo $type->name; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class=" new-right">
                    <div id="block-views-recent-news-block" class="block block-views box_skin">
                        <div class="content">
                            <div class="view-recent-survey block clearfix center">
                                <div class="view-header">
                                    <h2>DayTour</h2>
                                    <div class="menu-tag">
                                        <ul>
                                            <?php
                                            foreach ($tours as $tour) {
                                                ?>
                                                <li><a href="news-page.php?dayTour=<?php echo $tour->dayTour; ?>" class="menu-tag-item"><?php echo $tour->dayTour; ?> days</a></li>
                                                <?php } ?>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php include 'inc/footer.php'; ?>