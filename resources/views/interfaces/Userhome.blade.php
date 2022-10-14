<!DOCTYPE html>
<html lang="en">

<head>
    <title>User</title>
    <link rel="stylesheet" href="{{ asset('css1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css1/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('userhomecss.css') }}">

</head>

<body>


    <!-- CONTAINER-->

    <div class="container-fluid">
        <div class="row">
            <div class="head col-12">
                <b>Welcome To</b>
                <img class="img-fluid float-end m-0" src=../s/logo.jpg>
                <div class="ff">
                    {{-- <button type="button" class="btn btn-primary position-relative float-end me-5">
                        <i class="fa-regular fa-bell"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">+99
                            <span class="visually-hidden">unread messages</span></span> --}}
                    </button><b>The Blood Bank</b>

                    <a href="{{ route('logout') }}">
                        <div class="fa fa-sign-out-alt"></div>
                    </a>

                </div>

            </div>

            <div class="col-sm-4 mt-5">
                <a href="order_donor.html" data-bs-toggle="modal" data-bs-target="#ben1">
                    <img src="../s/donor.jpg" class="img-fluid rounded">
                </a>
            </div>
            <div class="col-sm-4 mt-5">
                <a href="BeneficiariesOrder" data-bs-toggle="modal" data-bs-target="#ben">
                    <img src="../s/ben.jpg" class=" img-fluid rounded">
                </a>
            </div>
            <div class="col-sm-4 mt-5" data-bs-toggle="modal" data-bs-target="#ben2">
                <img src="../s/sur.jpg" class="img-fluid rounded">
            </div>

            <div class="col-sm-4 mt-5">

                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#ben1">تبرع</button>
            </div>
            <div class="col-sm-4 mt-5">
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#ben">إستفادة</button>
            </div>
            <div class="col-sm-4 mt-5">
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#ben2">إعفاء</button>
            </div>
        </div>
    </div>





    <!-- MODAL New Beneficiary-->
    <div class="modal fade border border-3 shadow-lg" id="ben" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="header col-sm-12">
                    <button type="reset" class="btn-close float-end m-2" data-bs-dismiss="modal"></button>
                    <label class="ms-3 mt-3">
                        <h3>New Beneficiary</h3>
                    </label>
                    <hr width=100% color=#898585>
                </div>
                <form method="POST" id="ben_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body col-sm-12">
                        <div class="form-group ">
                            <label for="" class="control-label ps-3">اسم المستفيد كامل</label><br>
                            <input class="form-control ms-1" type="text" placeholder="Enter Beneficiary Name"
                                name='name'>
                            <small id="name_err" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label  ps-3">اسم المستلم</label><br>
                            <input class="form-control ms-1" type="text" placeholder="Enter Recipient Name"
                                name='recipient_name'>
                            <small id="recipient_name_err" class="form-text text-danger"></small>

                        </div>

                        <div class="form-group ">
                            <label for="" class="control-label ps-3">الرقم الوطني</label><br>
                            <input class="form-control ms-1" type="text" placeholder="Enter id num" name='id_num'>
                            <small id="id_num_err" class="form-text text-danger"></small>

                        </div>

                        <div class="form-group ">
                            <label for="" class="control-label ps-3">رقم الهاتف</label><br>
                            <input class="form-control ms-1" type="text" placeholder="Enter phone number"
                                name='phone'>
                            <small id="phone_err" class="form-text text-danger"></small>

                        </div>



                        <div class="form-group">
                            <label for="" class="control-label ps-3">الكمية المطلوبة</label><br>
                            <input type="text" name="required_amount" placeholder="Enter Required Quantity"
                                class="form-control ms-1">
                            <small id="required_amount_err" class="form-text text-danger"></small>

                        </div>

                        <div class="form-group col-12">
                            <label for="" class="control-label ps-3">نوع الدم </label><br>
                            <select class="custom-select" name='blood_id'>
                                @foreach ($bloods as $item)
                                    <option value="{{ $item->id }}">{{ $item->blood_group }}</option>
                                @endforeach
                            </select>



                            <div class="modal-footer col-sm-12">

                                <button id='add_ben' class="btn btn-outline-danger float-end me-3">Save</button>
                                <button type="reset" class="btn btn-outline-primary float-end"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                            <div class="alert alert-success" id="success_msg">
                                يرجى إحضار طلب مصدق من المشفى.
                            </div>

                            <div class="alert alert-danger" id="ben_msg">
                                الكمية المطلوبة غير متاحة
                            </div>
                            {{-- @if (Session::has('true'))
                                <div class="alert danger">{{ Session::get('true') }}</div>
                            @endif --}}
                        </div>
                    </div>




            </div>
        </div>
        </form>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        // Benifet
        $(document).on('click', '#add_ben', function(e) {
            e.preventDefault();

            $('#name_err').text('');
            $('#id_num_err').text('');
            $('#phone_err').text('');
            $('#recipient_name_err').text('');
            $('#required_amount_err').text('');


            var form = new FormData($('#ben_form')[0]);

            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('ben') }}",
                data: form,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $('#ben_msg').hide();
                    $('#success_msg').html("يرجى إحضار طلب مصدق من المشفى. " + data)
                    $('#success_msg').show();
                },

                error: function(reject) {
                    $('#success_msg').hide();
                    $('#ben_msg').show();


                    var res = $.parseJSON(reject.responseText);
                    $.each(res.errors, function(key, val) {
                        $("#" + key + "_err").text(val[0]);
                    });
                }
            });
        });



        // Exemption
        $(document).on('click', '#save_ex', function(e) {
            e.preventDefault();

            $('#name_erro').text('');
            $('#id_num_erro').text('');
            $('#phone_erro').text('');

            var formdata = new FormData($('#exm_form')[0]);




            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('exem') }}",
                data: formdata,

                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {

                    $('#exm_success').html("تم الحجز في" + data)
                    $('#exm_success').show();

                },

                error: function(reject) {


                    // $('#err_msg').show();

                    var resp = $.parseJSON(reject.responseText);
                    $.each(resp.errors, function(key, val) {
                        $("#" + key + "_erro").text(val[0]);
                    });
                }

            });
        });

        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}

        // donotion
        $(document).on('click', '#save_don', function(e) {
            e.preventDefault();
            $('#name_error').text('');
            $('#id_num_error').text('');
            $('#phone_error').text('');
            $('#amount_error').text('');

            var formdata = new FormData($('#add_form')[0]);



            // donor
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('don') }}",
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $('#success_msg2').html(data == 1 ?
                        "لا يمكنك التبرع قبل مرور ثلاث اشهر على اخر تبرع" : "تم الحجز في" + data)
                    $('#success_msg2').show();

                },

                error: function(reject) {

                    // $('#success_msg').hide();

                    // console.log($msg)
                    // $('#don_msg').html($msg);

                    // $('#don_msg').show();

                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0])
                    });


                    // })
                }

            });
        });
    </script>









    <!-- MODAL New Donation-->

    <div class="modal fade border border-3 shadow-lg" id="ben1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="hedar">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal"></button>
                    <h3 class="ms-3 mt-3">New Donation</h3>
                    <hr width=100% color=#898585>
                </div>

                <form method="POST" id="add_form" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body col-sm-12">
                        <div class="form-group">
                            <label for="" class="control-label ps-3">الاسم كامل</label><br>
                            <input type="text" class="form-control ms-1" name='name'
                                placeholder="Enter your Name">
                            <small id="name_error" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label ps-3">الرقم الوطني</label><br>
                            <input type="text" class="form-control" placeholder="Enter your Id-Number"
                                name="id_num">
                            <small id="id_num_error" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label ps-3">رقم الجوال</label><br>
                            <input type="text" class="form-control" placeholder="Enter your Phone Number"
                                name="phone">
                            <small id="phone_error" class="form-text text-danger"></small>

                        </div>

                        <div class="form-group">
                            <label for="" class="control-label ps-3">الكمية</label><br>
                            <input type="text" class="form-control ms-1" name='amount'
                                placeholder="Enter amount">
                            <small id="amount_error" class="form-text text-danger"></small>

                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-12 ps-3">سبب التبرع</label><br>
                            <select name="reason" class="custom-select ms-2">
                                <option>اجازة سوق</option>
                                <option>دفتر خدمة العلم</option>
                                <option>تطوع في الجيش</option>
                                <option>تخرج</option>
                                <option>عمل جديد</option>
                                <option>وسيط</option>
                                <option>طوعي</option>
                                <option>اشياء اخرى</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label for="" class="control-label ps-2 ms-1">Blood Type</label><br>
                            <select name="blood_id" class="custom-select ms-2">
                                @foreach ($bloods as $item)
                                    <option value="{{ $item->id }}">{{ $item->blood_group }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="modal-footer col-sm-12">

                            <button id='save_don' class="btn btn-outline-danger float-end me-3 mt-2">Save</button>
                            <button type="reset" id='res_don' class="btn btn-outline-primary float-end mt-2"
                                data-bs-dismiss="modal">Cancel</button>

                            <div class="alert alert-success" id="success_msg2">
                                تم الحجز في
                            </div>


                        </div>

                    </div>

            </div>

            </form>
        </div>
    </div>
    </div>




    <!-- MODAL New Exemption-->

    <div class="modal fade border border-3 shadow-lg" id="ben2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="hedar">
                    <button type="button" name='' class="btn-close float-end m-2"
                        data-bs-dismiss="modal"></button>
                    <h3 class="ms-3 mt-3">New Exemption</h3>
                    <hr width=100% color=#898585>
                </div>
                <form method="POST" id="exm_form" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label ps-3">الاسم كامل</label><br>
                            <input type="text" class="form-control ms-1" placeholder="Enter Your Name"
                                name="name">
                            <small id="name_erro" class="form-text text-danger"></small>

                        </div>

                        {{-- <div class="form-group">
			<label for="" class="control-label ps-3">العنوان</label><br>
			<textarea class="form-control ms-1" name='add' placeholder="Enter Your Address"></textarea>
		</div> --}}


                        <div class="form-group">
                            <label for="" class="control-label ps-3">الرقم الوطني</label><br>
                            <input type="text" class="form-control ms-1" placeholder="Enter Your Id-Number"
                                name="id_num">
                            <small id="id_num_erro" class="form-text text-danger"></small>

                        </div>

                        <div class="form-group">
                            <label for="" class="control-label ps-3">رقم الجوال</label><br>
                            <input type="text" class="form-control ms-1" name='phone'
                                placeholder="Enter Your Phone-Number">
                            <small id="phone_erro" class="form-text text-danger"></small>

                        </div>



                        <div class="form-group">
                            <label for="" class="control-label ps-3">سبب التبرع</label><br>
                            <select class="custom-select m-1" name='reason_for_don'>
                                <option>اجازة سوق</option>
                                <option>دفتر خدمة العلم</option>
                                <option>تطوع في الجيش</option>
                                <option>تخرج</option>
                                <option>عمل جديد</option>
                                <option>طوعي</option>
                                <option>اشياء اخرى</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label ps-3 ">سبب الاعفاء</label>
                            <select class="custom-select m-1" name='reason_for_exe'>
                                <option>مرض</option>
                                <option>وزن اقل من 50</option>
                                <option>خضاب قليل</option>
                                <option>اشياء اخرى</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label ps-3">Blood Type</label><br>
                            <select name="blood_id" id="" class="custom-select m-1">
                                @foreach ($bloods as $item)
                                    <option value="{{ $item->id }}">{{ $item->blood_group }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id='save_ex' class="btn btn-outline-danger float-end me-3 mt-2">Save</button>
                        <button type="reset" class="btn btn-outline-primary float-end mt-2 ms-5"
                            data-bs-dismiss="modal">Cancel</button>

                    </div>
                    <div class="alert alert-success" id="exm_success">
                        تم الحفظ بنجاح
                    </div>

                    {{-- <div class="alert alert-danger" id="err_msg">
                        يرجى ادخال البيانات بشكل صحيح
                    </div> --}}
            </div>

        </div>
    </div>





    <script src={{ asset('js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('js/all.min.js') }}></script>


    <script type="text/javascript">
        $('#btn').on('click', function() {
            $('#ben').modal('show');
        });
    </script>
    <script type="text/javascript">
        $('#bt1').on('click', function() {
            $('#ben1').modal('show');
        });
    </script>
    <script type="text/javascript">
        $('#btn2').on('click', function() {
            $('#ben2').modal('show');
        });
    </script>

</body>

</html>
