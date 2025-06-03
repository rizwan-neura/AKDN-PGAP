<select name="sub_type_id" id="sub_type_id" class="form-control">
        <option value="">Select Sub-type</option>
        @foreach($buildingSubTypes as $id => $sub_type_name)
            <option value="{{ $id }}">{{ $sub_type_name }}</option>
        @endforeach
</select>