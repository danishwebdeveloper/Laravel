@if (count($data) > 0)
<table class="table tbl-border tbl-green my-4">
    <tr>
      @if ($data['gr_heading'] !="")
             <td class="bg-green text-light"><h3>{{ $data['gr_heading'] }}</h3></td>
      @endif
    </tr>
    <tr>
      <td class="box-content">
       @if ($data['gr_body'] !="")
         {!! $data['gr_body'] !!}
       @endif
      </td>
    </tr>
</table>
@endif

