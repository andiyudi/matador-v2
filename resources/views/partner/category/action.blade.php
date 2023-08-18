<div class="table-actions">
    @if($data->is_blacklist == 0)
        <a href="{{ route($route.'.edit', $data->id) }}" class="btn btn-sm btn-dark action">Blacklist</a>
    @else
        @if(now() > $data->can_whitelist_at)
            <a href="{{ route($route.'.edit', $data->id) }}" class="btn btn-sm btn-light action">Whitelist</a>
        @else
            <button class="btn btn-sm btn-light action" disabled>Whitelist</button>
        @endif
    @endif
    <a href="{{ route($route.'.show', $data->id) }}" class="btn btn-sm btn-primary action" target="_blank">Document</a>
</div>
