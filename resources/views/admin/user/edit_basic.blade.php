<div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1-tab" tabindex="0">
    <div class="dashboard-tab-conTent">
        <div class="row mb-3">
            <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span class="text-danger ms-1">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="name" class="form-control ol-form-control" id="user-name" @isset($user->name) value="{{ $user->name }}" @endisset required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="role-id" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Role') }}<span class="text-danger ms-1">*</span></label>
            <div class="col-sm-8">
                <select name="role_id" class="form-control ol-form-control" id="role-id" required onchange="updateRoleName()">
                    <option value="">{{ get_phrase('Select Role') }}</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" data-role="{{ $role->name }}" @if(isset($user->role_id) && $user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="role" id="role-input" @isset($user->role) value="{{ $user->role }}" @endisset>
            </div>
        </div>

        <div class="row mb-3">
            <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Phone') }}</label>
            <div class="col-sm-8">
                <input type="text" name="phone" class="form-control ol-form-control" id="user-phone" @isset($user->phone) value="{{ $user->phone }}" @endisset>
            </div>
        </div>

        <div class="row mb-3">
            <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Address') }}</label>
            <div class="col-sm-8">
                <input type="text" name="address" class="form-control ol-form-control" id="user-address" @isset($user->address) value="{{ $user->address }}" @endisset>
            </div>
        </div>

        <div class="row mb-3">
            <label for="revenue" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Revenue') }}</label>
            <div class="col-sm-8">
                <div class="input-group">
                    <input type="number" name = "revenue" id = "revenue" class="form-control ol-form-control"
                        onkeyup="calculateAdminRevenue(this.value)" min="0" max="100">
                    <div class="input-group-append">
                        <span class="input-group-text ol-form-control">%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="photo" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('User Image') }}</label>
            <div class="col-sm-8">
                <input type="file" name="photo" class="form-control ol-form-control" id="photo">
            </div>
        </div>
    </div>
</div>

<script>
    function updateRoleName() {
    // Get the selected option
    const selectElement = document.getElementById('role-id');
    const selectedOption = selectElement.options[selectElement.selectedIndex];

    // Set the hidden input value
    document.getElementById('role-input').value = selectedOption.dataset.role;

    // Get the role name
    const roleName = selectedOption.dataset.role ? selectedOption.dataset.role.toLowerCase() : '';

    // Get the revenue field row
    const revenueRow = document.getElementById('revenue').closest('.row');

    // Check if the role is teamleader, supervisor, or agent
    if (roleName === 'teamleader' || roleName === 'supervisor' || roleName === 'agent') {
        // Show the revenue field
        revenueRow.style.display = 'flex';
    } else {
        // Hide the revenue field
        revenueRow.style.display = 'none';
    }
}

// Initialize the function when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Hide the revenue field by default
    const revenueRow = document.getElementById('revenue').closest('.row');
    revenueRow.style.display = 'none';

    // Call the function if there's already a selected value
    updateRoleName();
});
</script>
