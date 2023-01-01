@extends('pages.layouts.app')

@section('title')
<title>Nhiệm vụ - {{config('app.name')}}</title>
@endsection

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Trang chủ</h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Order History - With Action</h4>
                            <p>The following table can be use for <strong class="text-primary">order
                                    history, invoice listing</strong> related transaction.</p>
                        </div>
                    </div>
                    <div class="card card-preview">
                        <table class="table table-orders">
                            <thead class="tb-odr-head">
                                <tr class="tb-odr-item">
                                    <th class="tb-odr-info">
                                        <span class="tb-odr-id">Order ID</span>
                                        <span
                                            class="tb-odr-date d-none d-md-inline-block">Date</span>
                                    </th>
                                    <th class="tb-odr-amount">
                                        <span class="tb-odr-total">Amount</span>
                                        <span
                                            class="tb-odr-status d-none d-md-inline-block">Status</span>
                                    </th>
                                    <th class="tb-odr-action">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody class="tb-odr-body">
                                <tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-id"><a href="#">#746F5K2</a></span>
                                        <span class="tb-odr-date">23 Jan 2019, 10:45pm</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">$2300.00</span>
                                        </span>
                                        <span class="tb-odr-status">
                                            <span class="badge badge-dot bg-success">Complete</span>
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                        </div>
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                    class="icon ni ni-more-h"></em></a>
                                            <div
                                                class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li><a href="#" class="text-primary">Edit</a>
                                                    </li>
                                                    <li><a href="#" class="text-primary">View</a>
                                                    </li>
                                                    <li><a href="#" class="text-danger">Remove</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-id"><a href="#">#546H74W</a></span>
                                        <span class="tb-odr-date">12 Jan 2020, 10:45pm</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">$120.00</span>
                                        </span>
                                        <span class="tb-odr-status">
                                            <span class="badge badge-dot bg-warning">Pending</span>
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                        </div>
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                    class="icon ni ni-more-h"></em></a>
                                            <div
                                                class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li><a href="#" class="text-primary">Edit</a>
                                                    </li>
                                                    <li><a href="#" class="text-primary">View</a>
                                                    </li>
                                                    <li><a href="#" class="text-danger">Remove</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-id"><a href="#">#87X6A44</a></span>
                                        <span class="tb-odr-date">26 Dec 2019, 12:15 pm</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">$560.00</span>
                                        </span>
                                        <span class="tb-odr-status">
                                            <span class="badge badge-dot bg-success">Complete</span>
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                        </div>
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                    class="icon ni ni-more-h"></em></a>
                                            <div
                                                class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li><a href="#" class="text-primary">Edit</a>
                                                    </li>
                                                    <li><a href="#" class="text-primary">View</a>
                                                    </li>
                                                    <li><a href="#" class="text-danger">Remove</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-id"><a href="#">#986G531</a></span>
                                        <span class="tb-odr-date">21 Jan 2019, 6 :12 am</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">$3654.00</span>
                                        </span>
                                        <span class="tb-odr-status">
                                            <span class="badge badge-dot bg-danger">Cancelled</span>
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                        </div>
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                    class="icon ni ni-more-h"></em></a>
                                            <div
                                                class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li><a href="#" class="text-primary">Edit</a>
                                                    </li>
                                                    <li><a href="#" class="text-primary">View</a>
                                                    </li>
                                                    <li><a href="#" class="text-danger">Remove</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-id"><a href="#">#326T4M9</a></span>
                                        <span class="tb-odr-date">21 Jan 2019, 6 :12 am</span>
                                    </td>
                                    <td class="tb-odr-amount">
                                        <span class="tb-odr-total">
                                            <span class="amount">$200.00</span>
                                        </span>
                                        <span class="tb-odr-status">
                                            <span class="badge badge-dot bg-success">Complete</span>
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                        </div>
                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown" data-offset="-8,0"><em
                                                    class="icon ni ni-more-h"></em></a>
                                            <div
                                                class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                <ul class="link-list-plain">
                                                    <li><a href="#" class="text-primary">Edit</a>
                                                    </li>
                                                    <li><a href="#" class="text-primary">View</a>
                                                    </li>
                                                    <li><a href="#" class="text-danger">Remove</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- .card -->
                </div><!-- nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection
