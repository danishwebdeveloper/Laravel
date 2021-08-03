@if (count($data) > 0)
<table class="table tbl-border tbl-dark my-4">
    <tr>
      @if ($data['black_heading'] !="")
             <td class="bg-dark"><h3>{{ $data['black_heading'] }}</h3></td>
      @endif
    </tr>
    <tr>
      <td class="box-content">
       @if ($data['black_body'] !="")
         {!! $data['black_body'] !!}
       @endif
      </td>
    </tr>
</table>
@endif

