@while(have_rows('landing_page_modules')) @php(the_row())
  @includeIf('modules.' . get_row_layout(), array('fields' => $landing_page_modules[get_row_index()]))
@endwhile
