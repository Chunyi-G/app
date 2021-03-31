@extends('layouts.app')

@section('content')
    <div class="container">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                {!! \Session::get('success') !!}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <label for="url" class="form-label mb-0">Generate Short Url</label>
            </div>

            <div class="card-body">
                <form method="post">
                    @csrf

                    <div class="mb-3">
                        <input type="text" class="form-control" name="url" id="url" aria-describedby="longUrl">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Generate</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <label for="url" class="form-label mb-0">Url List</label>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Url</th>
                        <th>Short Url</th>
                        <th>Number clicked</th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type='text/javascript'>
    get_urls();

    function get_urls() {
        $.ajax({
            url: 'get-urls',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                for (var i = 0; i < response.length; i++) {
                    var id = response[i].id;
                    var url = response[i].url;
                    var short_url = response[i].short_url;
                    var full_short_url = response[i].full_short_url;
                    var no_clicked = response[i].no_clicked;

                    var html = "<tr>" +
                        "<td>" + id + "</td>" +
                        "<td>" + url + "</td>" +
                        "<td><a href='" + full_short_url + "' id='" + short_url + "' class='url' target='_blank'>" + full_short_url + "</td>" +
                        "<td>" + no_clicked + "</td>" +
                        "</tr>";

                    $("#tbody").append(html);
                }
            }
        });
    }

    $(document).ready(function () {
        $('body').on('click', '.url', function () {

            var url = $(this).attr('id');
            $.ajax({
                url: '/click-track',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data: {
                    url: url,
                }
            });
            $('#tbody').empty();
            get_urls();
        });

    });
</script>
