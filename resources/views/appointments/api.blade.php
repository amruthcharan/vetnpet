<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>API TESTING</title>
	<link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css" /><script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script><script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
</head>
<body autocomplete="off">
<div class="container-fluid">
<h3 class="text-center" id="book">Book Appointment</h3>

<div class="container mx-auto">
    <div id="show-buttons">
        <a class="btn btn-primary btn-block my-3" href="#" onclick="show('#showfindid')">
            Click here to find the patient ID
        </a>
        <a class="btn btn-danger btn-block my-3" href="#" onclick="show('#showpatid')">
            Click here if you know the Patient ID
        </a>
        <a class="btn btn-warning btn-block my-3" href="#" onclick="show('#new')">
            Click here if you are a new customer
        </a>
    </div>
    <div id="showfindid">
        <div class="form-group">
            <label for="name">Enter your mobile number</label>
            <input type="text" class="form-control" name="mobile" id="mobile">
            <span id="paterror" class="text-danger" style="display: none">Couldn't able to find any Records</span>
        </div>
        <a class="btn btn-warning btn-block my-3" href="#" onclick="findid()">
            Find My ID
        </a>
        <center><a href="#" onclick="show('#show-buttons')">
            go back
        </a></center>
    </div>
    <div id="showpatid">
        <div class="form-group">
            <label for="patid">Patient ID:</label> 
            <input type="text" class="form-control" id="patid" name="patid">
        </div>
        </span>
        <div class="form-group">
            <label for="date">Appointment Date:</label> 
            <input type="text" class="form-control" id="date" name="date" required>
        </div>
        <div id="dayform" class="form-group">
            <label for="time">Select Time</label>
            <select class="form-control" id="time" name="time"></select>
        </div>
        <a class="btn btn-warning btn-block my-3" href="#" onclick="bookapp()">
            Book Appointment
        </a>
        <center><a href="#" onclick="show('#show-buttons')">
            go back
        </a></center>
    </div>
    <div id="new">
        <span id="newapperror" class="text-danger" style="display: none">Please fill all fields</span>
        <div class="form-group">
            <label for="name">Pet Name:</label> 
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="ownername">Owner's Name:</label> 
            <input type="text" class="form-control" id="ownername" name="ownername" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile Number:</label> 
            <input type="number" class="form-control" id="mobile2" name="mobile" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address:</label> 
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="date">Appointment Date:</label> 
            <input type="text" class="form-control" id="date2" name="date" required>
        </div>
        <div id="dayform2" class="form-group">
            <label for="time">Select Time</label>
            <select class="form-control" id="time2" name="time"></select>
        </div>
        <a class="btn btn-warning btn-block my-3" href="#" onclick="booknewapp()">
            Book Appointment
        </a>
        <center>
            <a href="#" onclick="show('#show-buttons')">
                go back
            </a>
        </center>
    </div>
    <div id="success">
        <h4 class="text-center" style="margin-top: 30%">Your appointment has been Booked successfully!</h4>
    </div>
    <div id="showdet">
        <div class="card sticky-top">
            <div class="card-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td class="text-left">Patient ID</td>
                        <td>:</td>
                        <td class="text-left patientid"></td>
                    </tr>
                    <tr>
                        <td class="text-left">Name</td>
                        <td>:</td>
                        <td class="text-left name"></td>
                    </tr>
                    <tr>
                        <td class="text-left">Owners Name</td>
                        <td>:</td>
                        <td class="text-left ownername"></td>
                    </tr>
                    <tr>
                        <td class="text-left">Mobile</td>
                        <td>:</td>
                        <td class="text-left mobile"></td>
                    </tr>
                    <tr>
                        <td class="text-left">Breed</td>
                        <td>:</td>
                        <td class="text-left breed"></td>
                    </tr>
                    <tr>
                        <td class="text-left">Color</td>
                        <td>:</td>
                        <td class="text-left color"></td>
                    </tr>
                    <tr>
                        <td class="text-left">Email</td>
                        <td>:</td>
                        <td class="text-left email"></td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <a class="btn btn-primary btn-block" href="#" onclick="show('#showpatid')">Continue to Appointment</a>
                <center><a href="#" onclick="show('#show-buttons')">
                    go back
                </a></center>
            </div>
        </div>
    </div>
</div>
<script>
	$('#showpatid').hide();
    $('#shownew').hide();
	$('#showfindid').hide();
    $('#dayform').hide();
    $('#showdet').hide();
    $('#success').hide();
    $('#new').hide();
    $('#dayform2').hide();
    function showfindid() {
        hideall()
        $('#showfindid').show();
    }
    function findid() {
        $.ajax({
            method: 'GET',
            url: '/findid/' + $('#mobile').val(),
            success: function (res) {
                console.log($.isEmptyObject(res));
                if (!$.isEmptyObject(res)) {
                    $('.ownername').text(res.ownername);
                    $('.patientid').text(res.id);
                    $('.name').text(res.name);
                    $('.mobile').text(res.mobile);
                    $('.breed').text(res.breed);
                    $('.color').text(res.color);
                    $('.email').text(res.email);
                    $('.gender').text(res.gender);
                    $('#patid').val(res.id);
                    show('#showdet');
                } else {
                    $('#paterror').show();
                }
            }
        });
    }
    function bookapp() {
        var token = '{{csrf_token()}}';
        var url = '/createapp' ;
        let d = new Date($('#date').val());
        let formattedDate = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + " 00:00:00"; 
        $.ajax({
            method: 'POST',
            url: url,
            data:{patient_id : $('#patid').val(), doctor_id : 2, date : formattedDate, _token: token},
            success: function (res) {
                $('#book').hide();
                show('#success');
            }
        });
    }
    function booknewapp() {
        var token = '{{csrf_token()}}';
        var url = '/createnewapp' ;
        let d = new Date($('#date2').val());
        let patname = $('#name').val();
        let ownname = $('#ownername').val();
        let mobile = $('#mobile2').val();
        let email = $('#email').val();
        let today = new Date();
        if (d < today || !patname || !ownname || !mobile || !email) {
            $('#newapperror').show();
            return;
        }
        let formattedDate = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + " 00:00:00"; 
        $.ajax({
            method: 'POST',
            url: url,
            data: {
                patient_name : patname, 
                owner_name : ownname, 
                mobile : mobile, 
                email : email, 
                date : formattedDate, 
                _token: token
            },
            success: function (res) {
                $('#book').hide();
                show('#success');
            }
        });
    }
    function show(id) {
        hideall();
        $(id).show();
    }
    function hideall() {
        $('#showpatid').hide();
        $('#shownew').hide();
        $('#showfindid').hide();
        $('#dayform').hide();
        $('#showdet').hide();
        $('#showfindid').hide();
        $('#show-buttons').hide();
        $('#success').hide();
        $('#new').hide();
    }
	$(document).ready(function () {		
		var today = new Date();
		var dd = today.getDate()+1;
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		
		var today = mm + '/' + dd + '/' + yyyy;
		$('#date').datepicker({
			minDate: today,
        });
        $('#date2').datepicker({
			minDate: today,
		});
	});
	
	$('#date').change(function(){
	    var bla = $('#date').val();
	    var date = new Date(bla).getDay();
	    $('#dayform').show();
	    if(date==0){
	        $('#time').find('option').remove();
	        var x = document.getElementById("time");
            var option = document.createElement("option");
            option.text = "10AM to 1PM";
            x.add(option);
	    } else {
	        $('#time').find('option').remove();
	        var x = document.getElementById("time");
            var option = document.createElement("option");
            option.text = "10AM to 2PM";
            x.add(option);
            var option = document.createElement("option");
            option.text = "4PM to 8PM";
            x.add(option);
	    }
    });
    
    $('#date2').change(function(){
	    var bla = $('#date2').val();
	    var date = new Date(bla).getDay();
	    $('#dayform2').show();
	    if(date==0){
	        $('#time2').find('option').remove();
	        var x = document.getElementById("time2");
            var option = document.createElement("option");
            option.text = "10AM to 1PM";
            x.add(option);
	    } else {
	        $('#time2').find('option').remove();
	        var x = document.getElementById("time2");
            var option = document.createElement("option");
            option.text = "10AM to 2PM";
            x.add(option);
            var option = document.createElement("option");
            option.text = "4PM to 8PM";
            x.add(option);
	    }
	});
</script></body>
</html>