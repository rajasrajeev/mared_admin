<!-- Updated form controller logic -->
<?php
// At the top of your controller method
$loggedInUserRole = auth()->user()->role;
$allowedRolesToCreate = [];

// Define which roles each user type can create
switch($loggedInUserRole) {
    case 'admin':
        // Admin can create all roles
        $allowedRolesToCreate = $roles; // All roles
        break;
    case 'supervisor':
        // Supervisor can create teamleader and agent
        $allowedRolesToCreate = $roles->filter(function($role) {
            return in_array($role->name, ['teamleader', 'agent']);
        });
        break;
    case 'teamleader':
        // Teamleader can create only agents
        $allowedRolesToCreate = $roles->filter(function($role) {
            return $role->name == 'agent';
        });
        break;
    case 'agent':
        // Agent can create only students
        $allowedRolesToCreate = $roles->filter(function($role) {
            return $role->name == 'student';
        });
        break;
    default:
        // No permissions for others
        $allowedRolesToCreate = collect();
}

$roles = $allowedRolesToCreate;
?>

<div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1-tab" tabindex="0">
    <div class="dashboard-tab-conTent">
        <div class="row mb-3">
            <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span class="text-danger ms-1">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="name" class="form-control ol-form-control" id="user-name" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="role-id" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Role') }}<span class="text-danger ms-1">*</span></label>
            <div class="col-sm-8">
                <select name="role_id" class="form-control ol-form-control" id="role-id" required onchange="updateRoleName()">
                    <option value="">{{ get_phrase('Select Role') }}</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" data-role="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="role" id="role-input">
            </div>
        </div>

        <div class="row mb-3">
            <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Phone') }}</label>
            <div class="col-sm-8">
                <input type="text" name="phone" class="form-control ol-form-control" id="user-phone">
            </div>
        </div>

        <div class="row mb-3">
            <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Address') }}</label>
            <div class="col-sm-8">
                <input type="text" name="address" class="form-control ol-form-control" id="user-address">
            </div>
        </div>

        <div class="row mb-3" id="revenue-row">
            <label for="revenue" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Revenue') }}</label>
            <div class="col-sm-8">
                <div class="input-group">
                    <input type="number" name="revenue" id="revenue" class="form-control ol-form-control" onkeyup="calculateAdminRevenue(this.value)" min="0" max="100">
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

        <div class="row mb-3" id="teacher-details-row">
            <label for="teacher-details" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Additional Details') }}</label>
            <div class="col-sm-8">
                <textarea name="teacher_details" class="form-control ol-form-control" id="teacher-details" rows="3"></textarea>
            </div>
        </div>

        <div class="row mb-3" id="teacher-pdf-row">
            <label for="teacher-pdf" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Profile PDF') }}</label>
            <div class="col-sm-8">
                <input type="file" name="teacher_pdf" class="form-control ol-form-control" id="teacher-pdf" accept="application/pdf">
            </div>
        </div>
    </div>
</div>

<script>
    function updateRoleName() {
        const selectElement = document.getElementById('role-id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        document.getElementById('role-input').value = selectedOption.dataset.role;
        const roleName = selectedOption.dataset.role ? selectedOption.dataset.role.toLowerCase() : '';

        const revenueRow = document.getElementById('revenue-row');
        const teacherDetailsRow = document.getElementById('teacher-details-row');
        const teacherPdfRow = document.getElementById('teacher-pdf-row');

        if (roleName === 'teamleader' || roleName === 'supervisor' || roleName === 'agent') {
            revenueRow.style.display = 'flex';
        } else {
            revenueRow.style.display = 'none';
        }

        if (roleName === 'teacher') {
            teacherDetailsRow.style.display = 'flex';
            teacherPdfRow.style.display = 'flex';
        } else {
            teacherDetailsRow.style.display = 'none';
            teacherPdfRow.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('revenue-row').style.display = 'none';
        document.getElementById('teacher-details-row').style.display = 'none';
        document.getElementById('teacher-pdf-row').style.display = 'none';
        updateRoleName();
    });
</script>
