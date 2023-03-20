{{ content() }}

<script type="text/javascript" src="js/jchart.js" ></script>

<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>

    <div class="center scaffold">

        <h3>তথ্যের তুলনামূলক বিশ্লেষণ</h3>
        <div class="highlight_div" >
            <div class="row">
                <div class="span6">
                    <div class="clearfix">
                        <label for="name"> তারিখ &nbsp;<span class="req">*</span></label>
                        {{ form.render("datefirst") }}
                    </div>
                </div>
                <div class="span5">
                    <div class="clearfix">
                        <label for="name">খাত<span class="req">*</span></label>
                        {{ form.render("subdomain") }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="span5">
                    <div class="clearfix">
                       <label for="name">নির্বাচনী এলাকা <span class="req">*</span></label>
                       {{ form.render("electionarea") }}
                   </div>
                </div>
            </div>

            <div class="clearfix" style="margin-top: 10px;">
                <input type="hidden" value="" name="earea" id="earea" />
                <input type="button" onclick="load_analysis();" value="প্রতিবেদন" class="btn btn-primary">
            </div>


        </div>
        <div id='analysis_report_div'>
        </div>

    </div>
</form>
<!--
<select id="example-multiple-optgroups">
    <optgroup label="Group 1">
        <option value="1-1">Option 1.1</option>
        <option value="1-2" selected="selected">Option 1.2</option>
        <option value="1-3" selected="selected">Option 1.3</option>
    </optgroup>
    <optgroup label="Group 2">
        <option value="2-1">Option 2.1</option>
        <option value="2-2">Option 2.2</option>
        <option value="2-3">Option 2.3</option>
    </optgroup>
</select>
-->
<script type="text/javascript">
    $(document).ready(function() {


    $('#electionarea').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,


        onChange: function(option, checked, select) {
        var sel_val = [];
        var selectedOptions = $('#electionarea option:selected');
         selectedOptions.each(function() {
            sel_val.push($(this).val());
        });
        //alert(sel_val.join());
        $("#earea").val(sel_val.join());
        },

         buttonText: function(options) {
            if (options.length === 0) {
                return 'নির্বাচনী এলাকা বাছাই করুন ';
            }
            else if (options.length > 4) {
                return options.length + ' selected ';
            }
            else {
                var selected = [];
                options.each(function() {
                selected.push([$(this).text(), $(this).data('order')]);
                });

                selected.sort(function(a, b) {
                return a[1] - b[1];
                });

                var text = '';
                for (var i = 0; i < selected.length; i++) {
                text += selected[i][0] + ', ';
                }
                return text.substr(0, text.length -2) + ' ';
            }



        },
        buttonWidth: '280px',
        maxHeight: 200

    });
    });
</script>

<script>
function validate_entry()
{
    var datefirst = $("#datefirst").val();
    var electionarea = $("#electionarea").val();
    var subdomain = $("#subdomain").val();

    if(datefirst=="" || electionarea=="" || subdomain=="")
    {
        alert("সকল আবশ্যকীয় তথ্য প্রদান করুন");
        return false;
    }

    return true;
}
</script>
<style>
span.req
{
    color: red;
}


.chart-container {
	position: relative;
	display: inline-block;
	height: 100%;
	padding-top: 15px;
	padding-bottom: 25px;
}
.chart {
	float: left;
	z-index:1;
	display: inline-block;
	position: relative;
	padding-bottom: 10px;
	padding-top: 10px;
	border-left: thin solid #cccccc;
	border-bottom: thin solid #cccccc;
}
.chart-row {
	height: 25px;
}
.bar {
	position: relative;
	background-color: #6b9bd6;
	height: 25px;
	margin-top: 6px;
	margin-bottom: 6px;
	border-radius: 0 2px 2px 0;
}
.bar:hover {
	border-top: 2px solid black;
	border-bottom: 2px solid black;
	border-right: 2px solid black;
}
.legend-left {
	clear: both;
	display: inline-block;
	position: relative;
	margin-top: 17px;
	float: left;
}
.heading {
	font-size: 8pt;
	font-weight: bold;
	color: #aaaaaa;
	height: 19px;
}
.heading-left {
	text-align: right;
	line-height: 5px;
	position: relative;
	max-width: 200px;
	margin-top: 6px;
	margin-bottom: 6px;
	margin-right: 7px;
}
.data-point {
	height: 25px;
	width: 25px;
	position: relative;
	float: left;
	margin-left: -13px;
}
.legend-bottom {
	position: absolute;
	bottom: -10px;
}
.chart-label {
	font-size: 7pt;
	font-weight: bold;
	color: #aaaaaa;
	position: absolute;
	bottom: -10px;
	z-index:0;
	float: left;
}
.chart-label-hr {
	position: absolute;
	bottom: 0;
	z-index:-1;
	background-color: #cccccc;
	width: 1px;
	height: 4px;
}
.chart-title {
	text-align: center;
	font-size: 10pt;
	font-weight: bold;
}
.chart-x-label {
  display: block;
  text-align: center;
  top: 30px;
	position: relative;
	font-size: 10pt;
	font-weight: bold;
	color: #aaaaaa;
}

.chart-title
{
    font-family: nikoshBan !important;
        font-size: 24px !important;
}
.heading-left, .chart-label-bottom
{
    font-family: nikoshBan !important;
    font-size: 20px !important;
}
</style>