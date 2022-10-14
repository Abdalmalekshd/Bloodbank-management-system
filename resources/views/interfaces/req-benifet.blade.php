@extends('layout.admin')
<link rel="stylesheet" href="{{ asset('reqdonor.css') }}">
@section('Title', 'benifet')

@section('content')

    <section class="contain">
        <div class="con">

            <h3>طلبات الاستفادة</h3>
            <div class="divcon">
                <table class="table">
                    <tr>
                        <th class="id">ID</th>
                        <th>اسم المستفيد كامل</th>
                        <th>اسم المستلم كامل</th>
                        <th>معلومات اضافية </th>

                        <th>نوع الدم</th>
                        <th>الكمية المطلوبة</th>
                        <th>الوقت</th>

                        {{-- <th colspan=3></th> --}}
                    </tr>
                    @if (isset($orders) && $orders->count() > 0)
                        @foreach ($orders as $ord)
                            <tr>
                            <tr class="DonRow{{ $ord->id }}">
                                <td class="id">{{ $ord->order->id }}</td>
                                <td>{{ $ord->order->name }}</td>
                                <td>{{ $ord->recipient_name }}</td>
                                <td> {{ $ord->order->id_num }} <br> {{ $ord->order->phone }}</td>
                                <td>
                                    @foreach ($bloods as $item)
                                        @if ($ord->order->blood_id == $item->id)
                                            {{ $item->blood_group }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $ord->required_amount }}</td>
                                <td>{{ $ord->order->date }}</td>





                                <td colspan=3 class="w-25">
                                    <a href="{{ route('Delete.benifet', $ord->order->id) }}"
                                        class="delete_btn fa-solid fa-xmark
                        btn btn-danger rounded-pill border border-0 ps-2">حذف</a>

                                    <a href="{{ route('benifet.edit', $ord->id) }}"
                                        class="fa-solid fa-user-pen
                                            btn btn-primary rounded-pill border border-0 ">تعديل</a>

                                    <a id="open-ben1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#ben1"></a>

                                    <a href="{{ route('order.ben.approved', $ord->order->id) }}"
                                        class="fa-solid fa-check
                        btn btn-success rounded-pill border border-0 "
                                        style="color: white">تأكيد</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </table>
            </div>
        </div>
    </section>



    <!-- MODAL New Beneficiary-->
    @if ($benifet)
        <div class="modal fade border border-3 shadow-lg" id="ben1" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="header col-sm-12">
                        <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal"></button>
                        <label for="">
                            <h3 class="ms-3 mt-3">New Beneficiary</h3>
                        </label>
                        <hr width=100% color=#898585>
                    </div>

                    <div class="modal-body col-sm-12">

                        <form id="benform" method="POST" action="{{ route('order.ben.update') }}">
                            @csrf

                            <div class="form-group ">
                                <input type="hidden" name="id" value="{{ $benifet->id }}" class="d-none" />

                                <label for="" class="control-label ps-3">اسم المستفيد كامل</label><br>
                                <input class="form-control ms-1" type="text" placeholder="Enter Beneficiary Name"
                                    name='name' value="{{ $benifet->order->name }}">
                            </div>


                            <div class="form-group">
                                <label for="" class="control-label  ps-3">اسم المستلم</label><br>
                                <input class="form-control ms-1" type="text" placeholder="Enter Recipient Name"
                                    name='rename' value="{{ $benifet->recipient_name }}">
                            </div>

                            <div class="form-group ">
                                <label for="" class="control-label ps-3">الرقم الوطني</label><br>
                                <input class="form-control ms-1" type="text" placeholder="Enter id num" name='id_num'
                                    value="{{ $benifet->order->id_num }}">
                            </div>


                            <div class="form-group">
                                <label for="" class="control-label ps-3">رقم الجوال</label><br>
                                <input type="text" value="{{ $benifet->order->phone }}" class="form-control"
                                    placeholder="Enter your Phone Number" name="phone">
                            </div>




                            <div class="form-group">
                                <label for="" class="control-label ps-3">الكمية المطلوبة</label><br>
                                <input type="text" name="rq" placeholder="Enter Required Quantity"
                                    class="form-control ms-1" value="{{ $benifet->required_amount }}">
                            </div>

                            <div class="form-group col-12">
                                <label for="" class="control-label ps-3">نوع الدم </label><br>
                                <select class="custom-select" name='blood_id'>
                                    @foreach ($bloods as $item)
                                        @if ($item->id == $benifet->order->blood_id)
                                            <option selected value="{{ $item->id }}">
                                                {{ $item->blood_group }}
                                            </option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->blood_group }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>



                                <div class="modal-footer col-sm-12">

                                    <button type="submit" id='update_ben'
                                        class="btn btn-outline-danger float-end me-3">Save</button>

                                    <button type="reset" class="btn btn-outline-primary float-end"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif



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
