@extends('layout.admin')
<link rel="stylesheet" href="{{ asset('reqdonor.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('Title', 'donotion')

@section('content')

    <section class="contain">
        <div class="con">

            <h3>طلبات التبرع</h3>
            <div class="divcon">
                <table class='table'>
                    <P id="result-count"></P>
                    <tr>
                        <th class="id">ID</th>
                        <th>اسم المتبرع كامل</th>
                        <th>نوع الدم</th>
                        <th>معلومات اضافية</th>
                        <th>سبب التبرع</th>
                        <th>الكمية المتبرع بها</th>
                        <th>الوقت</th>


                        <th colspan="3"></th>
                    </tr>
                    @if (isset($orders) && $orders->count() > 0)
                        @foreach ($orders as $ord)
                            <tr>
                            <tr class="DonRow{{ $ord->id }}">
                                <td class="id">{{ $ord->id }}</td>
                                <td>{{ $ord->order->name }}</td>
                                <td>
                                    @foreach ($bloods as $item)
                                        @if ($ord->order->blood_id == $item->id)
                                            {{ $item->blood_group }}
                                        @endif
                                    @endforeach
                                </td>

                                <td> {{ $ord->order->id_num }} <br> {{ $ord->order->phone }}</td>

                                <td>{{ $ord->reason }}</td>

                                <td>{{ $ord->don_amount }}</td>

                                <td>{{ $ord->order->date }}</td>




                                <td colspan="3" class="w-25">
                                    <a href="{{ route('Delete.order', $ord->order->id) }}"
                                        class="delete_btn fa-solid fa-xmark
                        btn btn-danger rounded-pill border border-0 ps-2">حذف</a>

                                    <a href="{{ route('donor.edit', $ord->id) }}"
                                        class="fa-solid fa-user-pen
                                        btn btn-primary rounded-pill border border-0 ">تعديل</a>

                                    <a id="open-ben1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#ben1"></a>



                                    <a href="{{ route('order.don.approved', $ord->order->id) }}"
                                        class="fa-solid fa-check
                        btn btn-success rounded-pill border border-0 "
                                        style="color: white">تأكيد</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tbody id="content"></tbody>

                </table>
            </div>
        </div>
    </section>



    <!-- MODAL New Donation-->

    @if ($donor)
        <div class="modal
                                fade border border-3 shadow-lg" id="ben1"
            aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="hedar">
                        {{-- <a href="{{ route('reqdonationsorder') }}" class="btn-close float-end m-2"
                            data-bs-dismiss="modal"></a> --}}
                        <label class="ms-3 mt-3">
                            <h3>New Donation</h3>
                        </label>
                        <hr width=100% color=#898585>
                    </div>



                    <div class="modal-body col-sm-12">
                        <form id="FormUpdate" method="POST" action="{{ route('order.don.update') }}">
                            @csrf

                            <input type="hidden" name="id" value="{{ $donor->id }}" class="d-none" />
                            <div class="form-group">
                                <label for="" class="control-label ps-3">الاسم كامل</label><br>
                                <input type="text" id="order_id" value="{{ $donor->order->name }}"
                                    class="form-control ms-1" name='name' placeholder="Enter your Name">
                            </div>


                            <div class="form-group">
                                <label class="control-label ps-3">الرقم الوطني</label><br>
                                <input type="text" value="{{ $donor->order->id_num }}" class="form-control"
                                    placeholder="Enter your Id-Number" name="id_num">
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label ps-3">الكمية</label><br>
                                <input type="text" class="form-control ms-1" name='don_amount'
                                    placeholder="Enter quantity" value="{{ $donor->don_amount }}">
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label ps-3">رقم الجوال</label><br>
                                <input type="text" value="{{ $donor->order->phone }}" class="form-control"
                                    placeholder="Enter your Phone Number" name="phone">
                            </div>


                            <div class="form-group">
                                <label for="" class="control-label col-12 ps-3">سبب
                                    التبرع</label><br>
                                <select name="reason" class="custom-select ms-2" value='{{ $reasons }}'>

                                    <option>اجازة سوق</option>
                                    <option>دفتر خدمة العلم</option>


                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-header">{{ __('Dashboard') }}</div>

                                                    <div class="card-body">
                                                        @if (session('status'))
                                                            <div class="alert alert-success" role="alert">
                                                                {{ session('status') }}
                                                            </div>
                                                        @endif

                                                        @section('content')
                                                            <div class="container">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-8">
                                                                        <div class="card">
                                                                            <div class="card-header">{{ __('Dashboard') }}
                                                                            </div>

                                                                            <div class="card-body">
                                                                                @if (session('status'))
                                                                                    <div class="alert alert-success"
                                                                                        role="alert">
                                                                                        {{ session('status') }}
                                                                                    </div>
                                                                                @endif

                                                                                <option>تطوع في الجيش</option>
                                                                                <option>تخرج</option>
                                                                                <option>عمل جديد</option>
                                                                                <option>وسيط</option>
                                                                                <option>طوعي</option>
                                                                                <option>اشياء اخرى</option>



                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label for="" class="control-label ps-2 ms-1">زمرة
                                        الدم</label><br>
                                    <select name="blood_id" class="custom-select ms-2">
                                        @foreach ($bloods as $item)
                                            @if ($item->id == $donor->order->blood_id)
                                                <option selected value="{{ $item->id }}">
                                                    {{ $item->blood_group }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">
                                                    {{ $item->blood_group }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-footer col-sm-12">

                                    <button type="submit" id='update_don'
                                        class="btn btn-outline-danger float-end me-3 mt-2">
                                        Save</button>


                                    <button type="reset" id='res_don' class="btn btn-outline-primary float-end mt-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <script type="text/javascript">
            $(document).ready(function() {
                $("#search").keyup(function() {
                    var filter = $(this).val(),
                        count = 0;
                    $(".table tr").each(function() {
                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                            $(this).fadeOut();
                        } else {
                            $(this).show();
                            count++;
                        }
                    });

                    var numberItems = count;
                    $("#result-count").text("Number of Results = " + count);
                });
            });
        </script>

    @endsection


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>



    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('open-ben1-btn').click()
        });
    </script>


    <script>
        $(document).ready(function() {

            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
