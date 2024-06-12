<div class="d-grid gap-2 mx-auto">
    @if($procurement->is_done == 0)
    <a href="{{ route($route.'.edit', ($procurement->id)) }}" class="btn btn-sm btn-outline-pink">Matrikulasi</a>
    @if($procurement->status == '1' || $procurement->status == '2')
    <a href="{{ route($route.'.change', ($procurement->id)) }}" class="btn btn-sm btn-outline-purple">Monitoring</a>
    <a href="{{ route($route.'.show', ($procurement->id)) }}" class="btn btn-sm btn-outline-indigo" target="_blank">Document</a>
    <a href="{{ route($route.'.done', ($procurement->id)) }}" class="btn btn-sm btn-outline-teal">Done</a>
    @endif
    @else
    <a href="{{ route($route.'.back', ($procurement->id)) }}" class="btn btn-sm btn-outline-orange">Rollback</a>
    @endif
</div>
