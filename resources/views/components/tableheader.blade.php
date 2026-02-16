<thead>
    <tr>
        @if($bulkSelect ?? true)
            <th>
                <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
            </th>
        @endif

        @foreach($columns as $column)
            <th>
                @if($column['orderable'] ?? false)
                    <a href="#" 
                       class="sortable-header"
                       hx-get="{{ $endpoint }}"
                       hx-target="{{ $target ?? '#table-container' }}"
                       hx-include="[name='search']"
                       hx-vals='{"sort_field": "{{ $column['field'] }}", "sort_direction": "{{ ($currentSortField ?? 'id') === $column['field'] && ($currentSortDirection ?? 'asc') === 'asc' ? 'desc' : 'asc' }}"}'
                       style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                        
                        <span>{{ $column['label'] }}</span>
                        
                        <span class="sort-arrows">
                            @if(($currentSortField ?? 'id') === $column['field'])
                                @if(($currentSortDirection ?? 'asc') === 'asc')
                                    <i class="fas fa-arrow-up text-primary"></i>
                                @else
                                    <i class="fas fa-arrow-down text-primary"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-muted" style="opacity: 0.3;"></i>
                            @endif
                        </span>
                    </a>
                @else
                    {{ $column['label'] }}
                @endif
            </th>
        @endforeach
    </tr>
</thead>

