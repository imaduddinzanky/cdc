<nav class="navbar navbar-static-top navbar-default navbar-header-full navbar-inverse" role="navigation" id="header">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand hidden-lg hidden-md hidden-sm active" href="index.html">Artificial <span>Reason</span></a>
        </div> <!-- navbar-header -->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="pull-right">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <a href="javascript:void(0);" class="sb-icon-navbar sb-toggle-right"><i class="fa fa-bars"></i></a>
                <ul class="nav navbar-nav">
                    <li>
                        <?php echo anchor('admin/home','Home') ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/users','Users') ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/trainings','Trainings') ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/articles','Articles') ?>
                    </li>
                 </ul>
            </div><!-- navbar-collapse -->
        </div>
    </div><!-- container -->
</nav>