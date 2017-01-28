<!-- Javascript file code downloadable link <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>  -->


<link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen" />
    <!--[if IE]>
	<link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen" />
	<script src="../js/html5.js" type="text/javascript"></script>
	<![endif]-->
	
	<link rel="shortcut icon" href="../images/favicon.ico" /><!-- inserting the favicon for the site -->
	
    <script src="../js/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="../js/hideshow.js" type="text/javascript"></script>
    <script src="../js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/jquery.equalHeight.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.8.20.min.js"></script><!-- for calendar -->
    
	<!------------------------------->
	<script type="text/javascript">
        $(document).ready(function () {
            $(".tablesorter").tablesorter();
        }
        );
        $(document).ready(function () {

            //When page loads...
            $(".tab_content").hide(); //Hide all content
            $("ul.tabs li:first").addClass("active").show(); //Activate first tab
            $(".tab_content:first").show(); //Show first tab content

            //On Click Event
            $("ul.tabs li").click(function () {

                $("ul.tabs li").removeClass("active"); //Remove any "active" class
                $(this).addClass("active"); //Add "active" class to selected tab
                $(".tab_content").hide(); //Hide all tab content

                var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                $(activeTab).fadeIn(); //Fade in the active ID content
                return false;
            });

        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('.column').equalHeight();
        });
    </script>

    <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
	 
	