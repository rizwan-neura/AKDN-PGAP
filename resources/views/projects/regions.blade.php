<select name="region_code" id="region_code" class="form-control">
    <option value="">-Select Region-</option>
    @foreach($regions as $id => $region_name)
        <option value="{{ $id }}">{{ $region_name }}</option>
    @endforeach
</select>