<div class="table-actions">
    <a href="{{ route($route.'.edit', ($procurement->id)) }}" class="btn btn-sm btn-outline-pink">Matrikulasi</a>
    @if($procurement->status == '1' || $procurement->status == '2')
    <a href="{{ route($route.'.change', ($procurement->id)) }}" class="btn btn-sm btn-outline-purple">Monitoring</a>
    <a href="{{ route($route.'.show', ($procurement->id)) }}" class="btn btn-sm btn-outline-indigo" target="_blank">Document</a>
    @endif
</div>
