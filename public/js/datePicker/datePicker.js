/**
 * Created by DOEL PC on 1/28/14.
 */

$(function(){

    $('#sdate').datepicker({
        format: 'yyyy-mm-dd'
    });


    $('#dp1').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#date').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#date2').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#sdate').datepicker()
        .on('changeDate', function(ev){
            $('#sdate').datepicker('hide');
        });

    $('#dp1').datepicker()
        .on('changeDate', function(ev){
            $('#dp1').datepicker('hide');
        });
    $('#date').datepicker()
        .on('changeDate', function(ev){
            $('#date').datepicker('hide');
        });

    $('#date2').datepicker()
        .on('changeDate', function(ev){
            $('#date2').datepicker('hide');
        });

    $('#dp2').datepicker();
    $('#dp3').datepicker();
    $('#dpYears').datepicker();
    $('#dpMonths').datepicker();


    var startDate = new Date(2012,1,20);
    var endDate = new Date(2012,1,25);
    $('#from_date').datepicker()
        .on('changeDate', function(ev){
            if (ev.date.valueOf() > endDate.valueOf()){
                $('#alert').show().find('strong').text('The start date can not be greater then the end date');
            } else {
                $('#alert').hide();
                startDate = new Date(ev.date);
                $('#startDate').text($('#dp4').data('date'));
            }
            $('#from_date').datepicker('hide');
        });
    $('#to_date').datepicker()
        .on('changeDate', function(ev){
            if (ev.date.valueOf() < startDate.valueOf()){
                $('#alert').show().find('strong').text('The end date can not be less then the start date');
            } else {
                $('#alert').hide();
                endDate = new Date(ev.date);
                $('#endDate').text($('#dp5').data('date'));
            }
            $('#to_date').datepicker('hide');
        });

    // disabling dates
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var checkin = $('#dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('#dpd2')[0].focus();
        }).data('datepicker');
    var checkout = $('#dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');

});