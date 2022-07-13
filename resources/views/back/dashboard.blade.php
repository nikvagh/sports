@extends('layouts.dash')
@section('content')
<div class="row">
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow">{{ $totalGames }}</h4>
                        <h6 class="text-muted m-b-0">Total Games</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="fas fa-baseball-ball f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-yellow p-0">
                <a href="{{ url(admin().'/games') }}" class="d-block py-2 px-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">View All</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-green">{{ $totalEvents }}</h4>
                        <h6 class="text-muted m-b-0">Total Events</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="fas fa-trophy f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-green p-0">
                <a href="{{ url(admin().'/events') }}" class="d-block py-2 px-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">View All</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-red">{{ $totalPlayers }}</h4>
                        <h6 class="text-muted m-b-0">Total Players</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-users f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-red p-0">
                <a href="{{ url(admin().'/players') }}" class="d-block py-2 px-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">View All</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-down text-white f-16"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-blue">{{ $totalStadiums }}</h4>
                        <h6 class="text-muted m-b-0">Total Stadiums</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-map-pin f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-blue p-0">
                <a href="{{ url(admin().'/stadiums') }}" class="d-block py-2 px-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">View All</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-down text-white f-16"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @if(!empty($events))
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Events</h5>
            </div>
        </div>

        <div class="row">
        @foreach($events as $event)

            @if($event->eventTeams && count($event->eventTeams) > 0)
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $event->name }}</h5>
                        <div class="btn-group card-option">
                            <a class="btn btn-warning btn-sm" href="{{ url(admin().'/events/'.$event->id.'/eventPointTables_edit') }}" target="_blank">Point Table</a>
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card table-card m-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <!-- <th>Name</th>
                                            <th>Due Date</th> -->
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($event->eventTeams as $eventTeam)
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle">
                                                        <div class="d-inline-block">
                                                            <h6>{{ $eventTeam->team->name }}</h6>
                                                            @foreach($eventTeam->eventTeamPlayers as $eventTeamPlayers)
                                                                <p class="text-muted m-b-0"><a target="_blank" href="{{ url(admin().'/events/'.$event->id.'/eventTeams/'.$eventTeam->id.'/eventTeamPlayers/'.$eventTeamPlayers->id.'/edit') }}">{{ $eventTeamPlayers->player->name }}</a></p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- <td>Able Pro</td>
                                                <td>Jun, 26</td> -->
                                                <td class="text-right"><a target="_blank" class="badge badge-light-primary" href="{{ url(admin().'/events/'.$event->id.'/eventTeams/'.$eventTeam->id.'/edit') }}">Edit</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        @endforeach
        </div>


    </div>
    @endif

</div>
@endsection