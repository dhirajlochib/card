
<table class="custom-table user-search-table" id="myTable"> 
    <thead>
        <tr>
            <th></th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Kyc Status</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users ?? [] as $key => $item)
            <tr>
                <td>
                    <ul class="user-list">
                        <li><img src="{{ $item->userImage }}" alt="user"></li>
                    </ul>
                </td>
                <td><span>{{ $item->fullname }}</span></td>
                <td>{{ $item->email }}</td>
                <td>
                    <span class="{{ $item->kycStringStatus->class }}">{{ $item->kycStringStatus->value }}</span>
                </td>
                <td>
                    <span class="{{ $item->stringStatus->class }}">{{ $item->stringStatus->value }}</span>
                </td>
                <td>
                    @if (Route::currentRouteName() == "admin.users.kyc.unverified")
                        @include('admin.components.link.info-default',[
                            'href'          => setRoute('admin.users.kyc.details', $item->username),
                            'permission'    => "admin.users.kyc.details",
                        ])
                    @else
                        @include('admin.components.link.info-default',[
                            'href'          => setRoute('admin.users.details', $item->username),
                            'permission'    => "admin.users.details",
                        ])
                    @endif
                </td>
            </tr>
        @empty
            @include('admin.components.alerts.empty',['colspan' => 7])
        @endforelse
    </tbody>
</table>
