@extends('layouts.admin')
@push('title', 'Teamleader Setting')
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    Team Leader Settings
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">Team Leader Settings</h3>
                <div class="ol-card-body">
                    <form action="{{ route('admin.teamleader.setting.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="first" value="item_1">
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Allow public teamleader') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="allow_teamleader" required>
                                <option value="1" @if ($allow_teamleader->description == 1) selected @endif>
                                    {{ get_phrase('Yes') }}</option>
                                <option value="0" @if ($allow_teamleader->description == 0) selected @endif>
                                    {{ get_phrase('No') }}</option>
                            </select>
                        </div>
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="teamleader_application_note">{{ get_phrase('teamleader application note') }}</label>

                            <textarea class="form-control ol-form-control" name="teamleader_application_note" rows="8" cols="80">{{ $application_note->description }}</textarea>
                        </div>

                        <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Update settings') }}</button>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-xl-6">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('Revenue settings') }}</h3>
                <div class="ol-card-body">
                    <form action="{{ route('admin.teamleader.setting.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="second" value="item_2">
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="teamleader_revenue">{{ get_phrase('teamleader revenue percentage') }}</label>
                            <div class="input-group">
                                <input type="number" name = "teamleader_revenue" id = "teamleader_revenue" class="form-control ol-form-control"
                                    onkeyup="calculateAdminRevenue(this.value)" min="0" max="100" value="{{ $teamleader_revenue->description }}">
                                <div class="input-group-append">
                                    <span class="input-group-text ol-form-control">%</span>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="admin_revenue">{{ get_phrase('Admin revenue percentage') }}</label>
                            <div class="input-group">
                                <input type="number" name = "admin_revenue" id = "admin_revenue" class="form-control ol-form-control" value="0" disabled>
                                <div class="input-group-append">
                                    <span class="input-group-text ol-form-control">%</span>
                                </div>
                            </div>
                        </div> -->
                        <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Update settings') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        "use strict";

        $(document).ready(function() {
            var teamleader_revenue = $('#teamleader_revenue').val();
            calculateAdminRevenue(teamleader_revenue);
        });

        function calculateAdminRevenue(teamleader_revenue) {
            if (teamleader_revenue <= 100) {
                var admin_revenue = 100 - teamleader_revenue;
                $('#admin_revenue').val(admin_revenue);
            } else {
                $('#admin_revenue').val(0);
            }
        }
    </script>
@endpush
