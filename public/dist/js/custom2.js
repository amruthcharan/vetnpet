function getdetails(){
    var url = 'http://api.vetnpet.in/apps/read.php';
    $(document).ajaxStart(function(){
        $(".preloader").show();
    }).ajaxStop(function(){
        $(".preloader").fadeOut();
    });
    let pcount=0;
    let acount=0;
    $.ajax({
        url: url,
        success:function(d){
            $('.tbody').empty();
            $('error').empty();
            $.each(d.records, function(k,v){
                if(v.patid==0){
                    var name = v.name;
                    var oname = v.ownername;
                    var mobile = v.mobile;
                    var email = v.email;
                    var id = $(this).closest('tr').find('.id').html();
                    var token = '{{ Session::token() }}';
                    var patid = null;
                    var pat = {name:name,ownername:oname,mobile:mobile,email:email,_token:token};
                    $.ajax({
                        url:'/createpat',
                        async:false,
                        type:"POST",
                        data: pat,
                        success:function (d) {
                            patid=d.id;
                            pcount++;
                            createAjaxApp(patid,v);
                        }
                    });
                } else {
                    patid = v.patid;
                    createAjaxApp(patid,v);
                }
            });
        },

    });
    toastr.success(pcount + " Patients created and " + acount + " Appointments added!");
}
function createAjaxApp(pid,v){
    var token = '{{csrf_token()}}';
    var date = v.date;
    var doctorid = 2;
    var apiid = v.id;
    var app = {patient_id:pid,doctor_id:doctorid,date:date,_token:token};
    $.ajax({
        url:'/createapp',
        async:false,
        type:"POST",
        data: app,
        success:function (d) {
            patid = d.patient_id;
            date=d.date;
            appid=d.id;
            doctor=d.doctor.name;
            petname=d.patient.name;
            mobile=d.patient.mobile;
            //console.log(d);
        }
    });
    var det = {patid:patid,status:'Appointment Booked',appid:appid,doctor:doctor,petname:petname,date:date,id:apiid};
    var json = JSON.stringify(det);
    //console.log(json);
    $.ajax({
        url: 'http://api.vetnpet.in/apps/update.php',
        async: false,
        type: "POST",
        data: json,
        dataType: "json",
        success: function (d) {
            //toastr.success("Appointment has been created", "Success");
            acount++;
        }
    });
}