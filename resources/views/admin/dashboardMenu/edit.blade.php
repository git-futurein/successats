<form action="{{ route('menu.update', $menu->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="menu_group">Group name</label>
    <input type="text" class="form-control mb-3" placeholder="Group name" name="menu_group"
        value="{{ $menu->menu_group }}">
    <label for="menu_icon">Menu icon</label>
    <input type="text" class="form-control mb-3" placeholder="Menu Icon" name="menu_icon"
        value="{{ $menu->menu_icon }}">
    <label for="menu_perent">Choose Group</label>
    <select name="menu_perent" class="form-control">
        <option value="0">Select One</option>
        @foreach ($perents as $perent)
            <option value="{{ $perent->id }}" {{ old('menu_perent', $menu->menu_perent) == $perent->id ? 'selected' : '' }}> {{ $perent->menu_group }} </option>
        @endforeach
    </select>
    <label for="menu_name">Menu name</label>
    <input type="text" class="form-control mb-3" placeholder="Menu name" name="menu_name"
        value="{{ $menu->menu_name }}">
    <label for="menu_path">Menu path</label>
    <input type="text" class="form-control mb-3" placeholder="Menu path" name="menu_path"
        value="{{ $menu->menu_path }}">
    <label for="menu_status">Menu Status</label>
        <select name="menu_status" id="menu_status" class="form-control">
            <option value="1" {{$menu->menu_status == 1 ? 'selected' : ''}}>Active</option>
            <option value="0" {{$menu->menu_status == 0 ? 'selected' : ''}}>In-Active</option>
        </select>
    <button type="submit" class="btn btn-sm btn-info mt-3">Submit</button>
</form>
