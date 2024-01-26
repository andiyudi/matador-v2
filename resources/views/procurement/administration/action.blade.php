<div class="table-actions">
    <a href="{{ route($route.'.edit', ($procurement->id)) }}" class="btn btn-sm btn-warning action">Update</a>
    @if($procurement->status == '1' || $procurement->status == '2')
    <a href="{{ route($route.'.change', ($procurement->id)) }}" class="btn btn-sm btn-secondary action">Monitoring</a>
    <a href="{{ route($route.'.show', ($procurement->id)) }}" class="btn btn-sm btn-primary action" target="_blank">Upload</a>
    @endif
</div>
