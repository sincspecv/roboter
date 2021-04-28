@while(have_rows(get_post_type() . '_modules')) @php(the_row())
  @includeIf('modules.' . get_row_layout(), array('fields' => $$modules_slug[get_row_index()]))
@endwhile

