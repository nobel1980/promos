<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Md. Hafijur Rahman">
    <!--<link rel="icon" href="http://getbootstrap.com/favicon.ico">-->

    <title>গনপ্রজাতন্ত্রী বাংলাদেশ সরকারের উন্নয়নমূলক কার্যক্রম পরিবীক্ষণ সিস্টেম</title>


    {{ stylesheet_link('css/bootstrap.css') }}
    {{ stylesheet_link('css/jquery-ui.css') }}
    {{ stylesheet_link('css/datepicker.css') }}
    {{ stylesheet_link('css/color.min.css') }}
    {{ stylesheet_link('css/style_front.css') }}

    {{ javascript_include("js/jquery-1.10.2.min.js") }}
    {{ javascript_include("js/dpim_custom.js") }}
    {{ javascript_include("js/bootstrap.min.js") }}
    {{ javascript_include("js/jquery-ui.js") }}
    {{ javascript_include("js/datePicker/bootstrap-datepicker.js") }}
    {{ javascript_include("js/datePicker/datePicker.js") }}

    <!--{{ javascript_include("js/jchart.js") }}-->

    {{ javascript_include("js/ie-emulation-modes-warning.js") }}
	

	
	</head>
	<body>

		{{ content() }}

</body>

    <script>
    /*
        function bodyHeight(){
            var body = document.getElementById('body-height');
            var body_height = window.innerHeight;
            //alert(body_height);
            body.style.height = (body_height-90)+"px";
        }
        window.addEventListener("load", bodyHeight, false);
    */
    </script>
</html>