/*
$(document).ready(function() {

});
*/
var tms_url = "/promos/";
function showZilla(select,zilla)
{
    if (select=="")
    {
        return;
    }
    else{
        var url = tms_url+"informations/getzilla?ld="+select;
        get_select_data(select,url,zilla);
    }
}

function showElectionarea(select,electionarea)
{
    if (select=="")
    {
        return;
    }
    else{
        var url = tms_url+"informations/getelectionarea?ld="+select;
        get_select_data(select,url,electionarea);
    }
}

function get_select_data(select,url,ID)
{
    $.post(url, function(data) {
    })
        .success(function(data) {
            if(data.length>0)
            {
                build_select_list(select, data,ID);
            }else{
                empty_select_list(select,ID);
            }
        })
        .error(function() {
        })
        .complete(function() {
        });
}

function build_select_list(select, data,ID){
    var sel_id = "#" + ID;
    $(sel_id).find("option:gt(0)").remove();
    $(sel_id).find("option:first").text("Loading...");

    $(sel_id).find("option:first").text("বাছাই করুন...");


    for (var i = 0; i < data.length; i++) {
        {
            $("<option/>").attr("value", data[i].id).text(data[i].name).appendTo($(sel_id));
        }

    }
}

function empty_select_list(select,ID){
    var sel_id = "#" + ID;

    $(sel_id).find("option:gt(0)").remove();
    $(sel_id).find("option:first").text("Loading...");

    $(sel_id).find("option:first").text("বাছাই করুন...");
}

function print_report()
{
    //alert("PRINT Here...");
    var html_content = $("#printable_area").html();
    html_content += '<link rel="stylesheet" href="'+tms_url+'css/bootstrap.min.css" type="text/css" />';
    html_content += '<link rel="stylesheet" href="'+tms_url+'css/style_back.css" type="text/css" />';
    html_content += ' <style>body {background-color: white;margin: 10px auto 0;width: 90%;}</style>';

    newwindow = window.open();
    newdocument = newwindow.document;
    newdocument.write(html_content);
    newdocument.close();

    newwindow.print();

    return false;
}


/////////////////////////////////////////////////////////////

function load_recinfo(sel)
{
    if($(sel).val() == "")
    {
        $("#div_recinfo").html("");
    }
    else
    {
        var url = tms_url+"inforeceive/getrecinfo?idate="+$(sel).val();
        $.post(url, function(data) {
        $("#div_recinfo").html("");
        })
    .success(function(data) {
        })
    .error(function(data) {
        })
    .complete(function(data) {
            $("#div_recinfo").html(data.responseText);
        });
    }
}
function load_analysis()
{
    if(!validate_entry())
    {
        $("#div_report").html("");
    }
    else
    {
        var eareas = $("#earea").val();
        var datefirst = $("#datefirst").val();
        var subdomain = $("#subdomain").val();
        var url = tms_url+"analysis/getreports?datefirst="+datefirst+"&subdomain="+subdomain+"&eareas="+eareas;
        //alert(url);
        $.post(url, function(data) {
            $("#analysis_report_div").html("");
        })
            .success(function(data) {
            //alert(data);
            })
            .error(function(data) {

            })
            .complete(function(data) {
                //console.log(data);
                //alert(data.responseText);
                $("#analysis_report_div").html(data.responseText);
            });
    }
}
function load_report()
{
    var datefirst = $("#datefirst").val();
    var datesecond = $("#datesecond").val();
    var division = $("#division").val();
    var district = $("#district").val();
    var electionarea = $("#electionarea").val();
    /*
     var domain = $("#domain").val();
     var subdomain = $("#subdomain").val();
     */
    if(!validate_entry())
    {
        $("#div_report").html("");
    }
    else
    {
        var url = tms_url+"reports/getreports?datefirst="+datefirst+"&datesecond="+datesecond+"&division="+division+"&district="+district+"&electionarea="+electionarea;

        $.post(url, function(data) {
            $("#div_report").html("");
        })
            .success(function(data) {

            })
            .error(function(data) {

            })
            .complete(function(data) {
                //console.log(data);
                //alert(data.responseText);
                $("#div_report").html(data.responseText);
            });
    }
}

function infoback(sel_val) {
            var comment = $.trim(prompt($(sel_val).attr('data-msg')+"\n পুনরায় পাঠানোর কারন উল্লেখ করুন। ", ""));
            var id= $(sel_val).attr('data-id');
            var object = $(sel_val);
            if(comment)
            {
                var url = tms_url+"inforeceive/infoback?id=" + id + "&comment=" + comment;

                $.post(url, function (data) {

                })
                        .success(function (data) {
                            if(data == "success")
                            {
                                //object.parent().html("");
                                alert("প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করা হয়েছে");
                                /*
                                object.html("");
                                object.siblings( ".confirmation-received" ).html("");
                                object.html("<i class='flaticon-share10' title='প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করা হয়েছে '></i>");
                                */
                                object.parent().html("<input class='btn btn-primary' type='button' value='প্রিন্ট' onclick='print_report();'>");
                                $(".highlight_div").hide();
                            }
                            else
                            {
                                alert("ত্রুটি পাওয়া গেছে, প্রতিবেদনটি পুনরায় প্রেরণ করা সম্ভব হয়নি।");
                            }
                        })
                        .error(function (data) {
                        })
                        .complete(function (data) {
                        });
            }
            else
            {
                alert("পুনরায় পাঠানোর কারন উল্লেখ করুন।");
            }
}

function inforec(sel_val) {	
//alert($(sel_val).attr('data-id'));
	if(confirm( $(sel_val).attr('data-msg')))
	{
		var id= $(sel_val).attr('data-id');
        var object = $(sel_val);
        var url = tms_url+"inforeceive/inforeceived?id=" + id;
		//alert(id);
		
		$.post(url, function (data) {
		})
		.success(function (data) {
			if(data == "success")
			{
                /*
				object.html("");
                object.siblings( ".confirmation-resend" ).html("");
				object.html("<i title='প্রতিবেদন গ্রহণ করা হয়েছে' class='flaticon-affirmative1'></i>");
				*/
				alert("তথ্যটি সফলভাবে গৃহীত হয়েছে। ");
                object.parent().html("<input class='btn btn-primary' type='button' value='প্রিন্ট' onclick='print_report();'>");
                $(".highlight_div").hide();
			}
			else
			{
				alert("ত্রুটি পাওয়া গেছে, প্রতিবেদনটি গ্রহণ করা সম্ভব হয়নি।");
			}
		})
		.error(function (data) {
		})
		.complete(function (data) {
		});
	}
}