<!doctype html>

<html lang="en">

<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="" name="description">
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <!-- Bootstrap Css -->
    <link id="style" href="/plugins/bootstrap-5/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Dashboard Css -->
    <link href="/css/style.css" rel="stylesheet" />

    <!-- Font-awesome  Css -->
    <link href="/css/icons.css" rel="stylesheet" />

    <!--Select2 Plugin -->
    <link href="/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- p-scroll bar css-->
    <link href="/plugins/pscrollbar/pscrollbar.css" rel="stylesheet" />

    <!-- Owl Theme css-->
    <link href="/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />

    <!-- video css-->
    <link href="/plugins/video/insideElementDemo.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.2/main.min.css">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

    @inertiaHead
</head>

<body class="main-body">


    @inertia


    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fa fa-rocket"></i></a>
    <!-- JQuery js-->
    <script src="/js/vendors/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap js -->
    <script src="/plugins/bootstrap-5/popper.min.js"></script>
    <script src="/plugins/bootstrap-5/js/bootstrap.min.js"></script>

    <!--JQuery RealEstaterkline Js-->
    <script src="/js/vendors/jquery.sparkline.min.js"></script>

    <!-- Circle Progress Js-->
    <script src="/js/vendors/circle-progress.min.js"></script>

    <!-- Star Rating Js-->
    <script src="/plugins/rating/jquery.rating-stars.js"></script>

    <!--Counters -->
    <script src="/plugins/counters/counterup.min.js"></script>
    <script src="/plugins/counters/waypoints.min.js"></script>
    <script src="/plugins/counters/numeric-counter.js"></script>

    <!--Owl Carousel js -->
    <script src="/plugins/owl-carousel/owl.carousel.js"></script>

    <!--Horizontal Menu-->
    <script src="/plugins/horizontal-menu/horizontal.js"></script>

    <!--JQuery TouchSwipe js-->
    <script src="/js/jquery.touchSwipe.min.js"></script>

    <!--Select2 js -->


    <!-- sticky Js-->
    <script src="/js/sticky.js"></script>

    <!-- Cookie js -->
    {{-- <script src="/plugins/cookie/jquery.ihavecookies.js"></script>
    <script src="/plugins/cookie/cookie.js"></script> --}}

    <!-- p-scroll bar Js-->
    <script src="/plugins/pscrollbar/pscrollbar.js"></script>

    <!--Showmore Js-->
    <script src="/js/jquery.showmore.js"></script>
    <script src="/js/showmore.js"></script>

    <!-- Swipe Js-->
    <script src="/js/swipe.js"></script>

    <!-- video -->
    <script src="/plugins/video/jquery.vide.js"></script>

    <!-- sticky Js-->
    <script src="/js/sticky.js"></script>

    <!-- Scripts Js-->
    <script src="/js/owl-carousel.js"></script>

    <!-- themecolor Js-->
    <script src="/js/themeColors.js"></script>

    <!-- Custom Js-->
    <script src="/js/custom.js"></script>

    <!-- Custom-switcher Js-->
    <script src="/js/custom-switcher.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.2/main.min.js">
    </script>
    </script>


    <script src="{{ mix('/js/app.js') }}" defer></script>



</body>

</html>