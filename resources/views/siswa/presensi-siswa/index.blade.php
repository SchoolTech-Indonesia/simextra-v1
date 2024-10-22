@extends('layouts.app')
@section('content')
    <div class="container">
        <section class="section">
            <div class="section-header">
                <h1>Presensi Menu</h1>
            </div>
            <div class="alert alert-info text-left" style="background-color: #6A7BFF; color: white;">
                <strong>No Today Record</strong><br>
                You haven't checked in today!
                <br>
                <button class="btn btn-light mt-3" data-toggle="modal" data-target="#checkInModal">Check In Now</button>
            </div>
        </section>

        <!-- Check In Modal -->
        <div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkInModalLabel">Check In Station</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('siswa.presensi-siswa.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="status">Choose Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="" disabled selected>Choose Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->uuid }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
